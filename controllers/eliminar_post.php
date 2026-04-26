<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    die("Acceso denegado.");
}

require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$id = $_GET['id'] ?? null;

$sql = $conn->prepare("DELETE FROM foro_temas WHERE id = :id");
$sql->execute([':id' => $id]);

header("Location: ../pages/foro.php");
exit();
