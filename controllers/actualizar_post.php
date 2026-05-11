<?php
require_once "../middleware/session-admin.php"; 
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();


$id = $_POST['id'] ?? null;
$titulo = trim($_POST['titulo'] ?? "");
$contenido = trim($_POST['contenido'] ?? "");


if (!$id) {
    die("ID inválido.");
}

if ($titulo === "" || $contenido === "") {
    die("El título y el contenido no pueden estar vacíos.");
}


$sql = $conn->prepare("
    UPDATE foro_temas
    SET titulo = :titulo,
        contenido = :contenido
    WHERE id = :id
");

$sql->execute([
    ':titulo' => $titulo,
    ':contenido' => $contenido,
    ':id' => $id
]);


header("Location: ../pages/post.php?id=" . $id);
exit();
