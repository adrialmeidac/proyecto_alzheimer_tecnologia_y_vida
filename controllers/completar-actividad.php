<?php
session_start();
require_once "../models/bbdd.php";

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

$sql = $conn->prepare("
    UPDATE actividades_paciente
    SET completada = 1
    WHERE id = ?
");
$sql->execute([$id]);

header("Location: " . $_SERVER["HTTP_REFERER"]);
exit();
