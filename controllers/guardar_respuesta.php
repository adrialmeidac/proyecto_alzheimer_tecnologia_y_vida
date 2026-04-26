<?php
require_once "../models/bbdd.php";
session_start();

$db = new Database();
$conn = $db->connect();

$tema_id = $_POST["tema_id"];
$respuesta = $_POST["respuesta"];
$usuario_id = $_SESSION["user_id"];

$sql = "INSERT INTO foro_respuestas (tema_id, usuario_id, respuesta, fecha)
        VALUES (:tema_id, :usuario_id, :respuesta, NOW())";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ":tema_id" => $tema_id,
    ":usuario_id" => $usuario_id,
    ":respuesta" => $respuesta
]);

header("Location: ../pages/post.php?id=" . $tema_id);
exit;
