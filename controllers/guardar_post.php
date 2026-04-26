<?php
require_once "../middleware/session.php"; // requiere sesión iniciada
require_once "../models/bbdd.php";

if (!isset($_SESSION["user_id"])) {
    die("No tienes permiso para publicar.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titulo = trim($_POST["titulo"] ?? "");
    $contenido = trim($_POST["contenido"] ?? "");
    $usuario_id = $_SESSION["user_id"];

    if ($titulo === "" || $contenido === "") {
        die("Todos los campos son obligatorios.");
    }

    $db = new Database();
    $conn = $db->connect();

    $sql = $conn->prepare("
        INSERT INTO foro_temas (usuario_id, titulo, contenido)
        VALUES (:usuario_id, :titulo, :contenido)
    ");

    $ok = $sql->execute([
        ":usuario_id" => $usuario_id,
        ":titulo" => $titulo,
        ":contenido" => $contenido
    ]);

    if ($ok) {
        header("Location: ../pages/foro.php?publicado=1");
        exit;
    } else {
        die("Error al guardar el post.");
    }
}
?>
