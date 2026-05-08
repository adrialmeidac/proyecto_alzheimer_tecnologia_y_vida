<?php
session_start();
require_once "../models/bbdd.php";

// Solo familiares/cuidadores
if (!in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /pages/dashboard.php");
    exit();
}

// Solo aceptar POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /pages/dashboard.php");
    exit();
}

$paciente_id = $_POST["paciente_id"] ?? null;
$descripcion = trim($_POST["descripcion"] ?? "");
$fecha = $_POST["fecha"] ?? "";
$hora = $_POST["hora"] ?? null;
$familiar_id = $_SESSION["user_id"];

// Validaciones
if (!$paciente_id || $descripcion === "" || !$fecha) {
    header("Location: /pages/actividades_paciente.php?error=1");
    exit();
}

$db = new Database();
$conn = $db->connect();

// Validar que el paciente pertenece al familiar/cuidador
$sqlCheck = $conn->prepare("
    SELECT 1 
    FROM relaciones_paciente_familiar
    WHERE familiar_id = :familiar
      AND paciente_id = :paciente
    LIMIT 1
");
$sqlCheck->execute([
    ":familiar" => $familiar_id,
    ":paciente" => $paciente_id
]);

if (!$sqlCheck->fetch()) {
    die("No tienes permiso para crear actividades para este paciente.");
}

// Insertar actividad en la tabla correcta
$sql = $conn->prepare("
    INSERT INTO actividades_usuario 
    (usuario_id, familiar_id, texto, fecha, hora_limite, realizada, notificada, notificar)
    VALUES (:usuario_id, :familiar_id, :texto, :fecha, :hora_limite, 0, 0, 1)
");

$sql->execute([
    ":usuario_id" => $paciente_id,
    ":familiar_id" => $familiar_id,
    ":texto" => $descripcion,
    ":fecha" => $fecha,
    ":hora_limite" => $hora
]);

header("Location: /pages/actividades_paciente.php?paciente=$paciente_id&ok=1");
exit();
