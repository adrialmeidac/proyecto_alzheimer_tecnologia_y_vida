<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /pages/login.php");
    exit();
}

if (!isset($_POST['id'])) {
    header("Location: /pages/notificaciones.php");
    exit();
}

require_once __DIR__ . "/../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$notificacion_id = intval($_POST['id']);
$user_id = $_SESSION['user_id'];
$rol = $_SESSION['rol'];


$sql = $conn->prepare("
    SELECT id, usuario_id 
    FROM notificaciones 
    WHERE id = :id
    LIMIT 1
");
$sql->execute([':id' => $notificacion_id]);
$notificacion = $sql->fetch(PDO::FETCH_ASSOC);

if (!$notificacion) {
    die("La notificación no existe.");
}

$paciente_id = $notificacion['usuario_id'];


if ($rol === 'paciente') {

    
    if ($paciente_id != $user_id) {
        die("No tienes permiso para marcar esta notificación.");
    }

} elseif (in_array($rol, ['familiar', 'cuidador'])) {

    
    $sqlCheck = $conn->prepare("
        SELECT 1 
        FROM relaciones_familiares
        WHERE familiar_id = :familiar
          AND paciente_id = :paciente
        LIMIT 1
    ");
    $sqlCheck->execute([
        ':familiar' => $user_id,
        ':paciente' => $paciente_id
    ]);

    if (!$sqlCheck->fetch()) {
        die("No tienes permiso para marcar esta notificación.");
    }

} else {
    die("Rol no autorizado.");
}


$sqlUpdate = $conn->prepare("
    UPDATE notificaciones
    SET leida = 1
    WHERE id = :id
");
$sqlUpdate->execute([':id' => $notificacion_id]);


if (in_array($rol, ['familiar', 'cuidador'])) {
    header("Location: /pages/notificaciones-familiar.php");
} else {
    header("Location: /pages/notificaciones.php");
}

exit();
