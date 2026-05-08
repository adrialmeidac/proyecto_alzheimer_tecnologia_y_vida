<?php
require_once "../middleware/session.php"; // Sesión obligatoria
require_once "../models/bbdd.php";

// Solo familiares o cuidadores pueden eliminar actividades
if (!isset($_SESSION["rol"]) || !in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /pages/dashboard.php");
    exit();
}

$id = $_GET["id"] ?? null;

// Validación básica
if (!$id || !is_numeric($id)) {
    header("Location: /pages/dashboard.php");
    exit();
}

$db = new Database();
$conn = $db->connect();

// Verificar que la actividad pertenece a un paciente vinculado al familiar/cuidador
$sql = $conn->prepare("
    SELECT ap.paciente_id
    FROM actividades_paciente ap
    INNER JOIN relaciones_paciente_familiar r
        ON r.paciente_id = ap.paciente_id
    WHERE ap.id = :id AND r.familiar_id = :familiar
");
$sql->execute([
    ':id' => $id,
    ':familiar' => $_SESSION["user_id"]
]);

$actividad = $sql->fetch(PDO::FETCH_ASSOC);

if (!$actividad) {
    // Intento de borrar actividad que no pertenece al familiar/cuidador
    header("Location: /pages/dashboard.php?error=permiso");
    exit();
}

// Eliminar actividad
$sql = $conn->prepare("DELETE FROM actividades_paciente WHERE id = :id");
$sql->execute([':id' => $id]);

// Volver a la página anterior
header("Location: " . ($_SERVER["HTTP_REFERER"] ?? "/pages/dashboard.php"));
exit();
