<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    die("Acceso denegado.");
}

require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$id = $_POST['id'];
$titulo = trim($_POST['titulo']);
$contenido = trim($_POST['contenido']);

$sql = $conn->prepare("
    UPDATE foro_temas
    SET titulo = :titulo, contenido = :contenido
    WHERE id = :id
");

$sql->execute([
    ':titulo' => $titulo,
    ':contenido' => $contenido,
    ':id' => $id
]);

header("Location: ../pages/post.php?id=" . $id);
exit();
