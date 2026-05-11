<?php
require_once "../middleware/session.php"; 
require_once "../models/bbdd.php";


if (!isset($_SESSION["rol"]) || !in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /pages/dashboard.php");
    exit();
}

$id = $_GET["id"] ?? null;


if (!$id || !is_numeric($id)) {
    header("Location: /pages/dashboard.php");
    exit();
}

$db = new Database();
$conn = $db->connect();


$sql = $conn->prepare("
    SELECT ap.usuario_id
    FROM actividades ap
    INNER JOIN relaciones_familiares r
        ON r.paciente_id = ap.usuario_id
    WHERE ap.id = :id AND r.familiar_id = :familiar
");
$sql->execute([
    ':id' => $id,
    ':familiar' => $_SESSION["user_id"]
]);

$actividad = $sql->fetch(PDO::FETCH_ASSOC);

if (!$actividad) {
    
    header("Location: /pages/dashboard.php?error=permiso");
    exit();
}


$sql = $conn->prepare("DELETE FROM actividades WHERE id = :id");
$sql->execute([':id' => $id]);


header("Location: " . ($_SERVER["HTTP_REFERER"] ?? "/pages/dashboard.php"));
exit();
