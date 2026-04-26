<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    die("Acceso denegado.");
}

require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$id = $_GET['id'] ?? null;
$tema_id = $_GET['tema'] ?? null;

$sql = $conn->prepare("DELETE FROM foro_respuestas WHERE id = :id");
$sql->execute([':id' => $id]);

header("Location: ../pages/post.php?id=" . $tema_id);
exit();
