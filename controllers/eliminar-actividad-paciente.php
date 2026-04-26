<?php
session_start();
require_once "../models/bbdd.php";

// Solo familiares/cuidadores
if (!in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /pages/dashboard.php");
    exit();
}

$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: /pages/dashboard.php");
    exit();
}

$db = new Database();
$conn = $db->connect();

// Verificar que la actividad pertenece a un paciente vinculado al familiar
$sql = $conn->prepare("
    SELECT ap.paciente_id
    FROM actividades_paciente ap
    INNER JOIN relaciones_paciente_familiar r
        ON r.paciente_id = ap.paciente_id
    WHERE ap.id = ? AND r.familiar_id = ?
");
$sql->execute([$id, $_SESSION["user_id"]]);
$actividad = $sql->fetch(PDO::FETCH_ASSOC);

if (!$actividad) {
    // Intento de borrar actividad que no pertenece al familiar
    header("Location: /pages/dashboard.php");
    exit();
}

// Eliminar actividad
$sql = $conn->prepare("DELETE FROM actividades_paciente WHERE id = ?");
$sql->execute([$id]);

// Volver a la página anterior
header("Location: " . $_SERVER["HTTP_REFERER"]);
exit();
