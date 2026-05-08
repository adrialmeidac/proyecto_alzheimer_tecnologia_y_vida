<?php
require_once "../middleware/session.php"; // requiere sesión iniciada
require_once "../models/bbdd.php";

// Solo usuarios loggeados pueden responder
if (!isset($_SESSION["user_id"])) {
    header("Location: /pages/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $tema_id = $_POST["tema_id"] ?? null;
    $respuesta = trim($_POST["respuesta"] ?? "");
    $usuario_id = $_SESSION["user_id"];

    // Validaciones
    if (!$tema_id) {
        die("ID de tema inválido.");
    }

    if ($respuesta === "" || strlen($respuesta) < 2) {
        die("La respuesta no puede estar vacía.");
    }

    $db = new Database();
    $conn = $db->connect();

    try {
        $sql = $conn->prepare("
            INSERT INTO foro_respuestas (tema_id, usuario_id, respuesta, fecha)
            VALUES (:tema_id, :usuario_id, :respuesta, NOW())
        ");

        $sql->execute([
            ":tema_id" => $tema_id,
            ":usuario_id" => $usuario_id,
            ":respuesta" => $respuesta
        ]);

        header("Location: ../pages/post.php?id=" . $tema_id);
        exit();

    } catch (Exception $e) {
        die("Error al guardar la respuesta.");
    }
}
?>
