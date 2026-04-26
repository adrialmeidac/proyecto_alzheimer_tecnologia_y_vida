<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

require_once __DIR__ . "/../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$familiar_id = $_SESSION['user_id'];
$email = trim($_POST['email']);
$tipo_relacion = trim($_POST['tipo_relacion']);

// 1. Verificar que el paciente existe
$sql = $conn->prepare("SELECT id, rol FROM usuarios WHERE email = :email LIMIT 1");
$sql->execute([':email' => $email]);
$paciente = $sql->fetch(PDO::FETCH_ASSOC);

if (!$paciente) {
    die("No existe ningún usuario con ese email.");
}

if ($paciente['rol'] !== 'paciente') {
    die("El usuario encontrado no es un paciente.");
}

$paciente_id = $paciente['id'];

// 2. Verificar que la relación no exista ya
$sqlCheck = $conn->prepare("
    SELECT id FROM relaciones_familiares 
    WHERE paciente_id = :paciente AND familiar_id = :familiar
");
$sqlCheck->execute([
    ':paciente' => $paciente_id,
    ':familiar' => $familiar_id
]);

if ($sqlCheck->fetch()) {
    die("Este paciente ya está vinculado contigo.");
}

// 3. Insertar relación
$sqlInsert = $conn->prepare("
    INSERT INTO relaciones_familiares (paciente_id, familiar_id, tipo_relacion)
    VALUES (:paciente, :familiar, :tipo)
");

$sqlInsert->execute([
    ':paciente' => $paciente_id,
    ':familiar' => $familiar_id,
    ':tipo' => $tipo_relacion
]);

header("Location: ../pages/notificaciones.php");
exit();
