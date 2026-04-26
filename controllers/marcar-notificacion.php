<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

if (!isset($_POST['id'])) {
    header("Location: ../pages/notificaciones.php");
    exit();
}

require_once __DIR__ . "/../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$notificacion_id = $_POST['id'];
$user_id = $_SESSION['user_id'];
$rol = $_SESSION['rol'];

// 1. Obtener la notificación
$sql = $conn->prepare("
    SELECT id, user_id 
    FROM notificaciones 
    WHERE id = :id
    LIMIT 1
");
$sql->execute([':id' => $notificacion_id]);
$notificacion = $sql->fetch(PDO::FETCH_ASSOC);

if (!$notificacion) {
    die("La notificación no existe.");
}

$paciente_id = $notificacion['user_id'];

// 2. Validar permisos según el rol
if ($rol === 'paciente') {

    // El paciente solo puede marcar sus propias notificaciones
    if ($paciente_id != $user_id) {
        die("No tienes permiso para marcar esta notificación.");
    }

} elseif ($rol === 'familiar') {

    // El familiar solo puede marcar notificaciones de pacientes vinculados
    $sqlCheck = $conn->prepare("
        SELECT 1 
         FROM relaciones_paciente_familiar
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

// 3. Marcar como leída
$sqlUpdate = $conn->prepare("
    UPDATE notificaciones
    SET leida = 1
    WHERE id = :id
");
$sqlUpdate->execute([':id' => $notificacion_id]);

// 4. Redirigir según el rol
if ($rol === 'familiar') {
    header("Location: ../pages/notificaciones_familiar.php");
} else {
    header("Location: ../pages/notificaciones.php");
}

exit();
