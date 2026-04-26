<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    die("Acceso denegado.");
}

require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$id = $_POST['id'];
$tema_id = $_POST['tema_id'];
$contenido = trim($_POST['contenido']);

$sql = $conn->prepare("
    UPDATE foro_respuestas
    SET contenido = :contenido
    WHERE id = :id
");

$sql->execute([
    ':contenido' => $contenido,
    ':id' => $id
]);

header("Location: ../pages/post.php?id=" . $tema_id);
exit();
