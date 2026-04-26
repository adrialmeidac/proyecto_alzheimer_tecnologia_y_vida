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
$familiar_id = $_SESSION["user_id"];
$hora = $_POST["hora"] ?? null;


// Validaciones
if (!$paciente_id || $descripcion === "" || !$fecha) {
    header("Location: /pages/actividades_pacientes.php?error=1");
    exit();
}

$db = new Database();
$conn = $db->connect();

// Insertar actividad
$sql = $conn->prepare("
INSERT INTO actividades_paciente (paciente_id, familiar_id, descripcion, fecha, hora)
VALUES (?, ?, ?, ?, ?)
");
$sql->execute([$paciente_id, $familiar_id, $descripcion, $fecha, $hora]);

header("Location: /pages/actividades_pacientes.php?paciente=$paciente_id&ok=1");
exit();
