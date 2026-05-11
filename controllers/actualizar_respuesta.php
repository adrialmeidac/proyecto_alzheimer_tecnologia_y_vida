<?php
require_once "../middleware/session-admin.php"; 
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();


$id = $_POST['id'] ?? null;
$tema_id = $_POST['tema_id'] ?? null;
$respuesta = trim($_POST['respuesta'] ?? "");


if (!$id || !$tema_id) {
    die("Datos incompletos.");
}

if ($respuesta === "") {
    die("La respuesta no puede estar vacía.");
}


$sql = $conn->prepare("
    UPDATE foro_respuestas
    SET respuesta = :respuesta
    WHERE id = :id
");

$sql->execute([
    ':respuesta' => $respuesta,
    ':id' => $id
]);


header("Location: ../pages/post.php?id=" . $tema_id);
exit();
