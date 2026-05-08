<?php
require_once "../middleware/session.php"; // requiere sesión iniciada
require_once "../models/bbdd.php";

// Solo usuarios loggeados pueden publicar
if (!isset($_SESSION["user_id"])) {
    header("Location: /pages/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titulo = trim($_POST["titulo"] ?? "");
    $contenido = trim($_POST["contenido"] ?? "");
    $usuario_id = $_SESSION["user_id"];

    // Validaciones
    if ($titulo === "" || strlen($titulo) < 3) {
        die("El título debe tener al menos 3 caracteres.");
    }

    if ($contenido === "" || strlen($contenido) < 5) {
        die("El contenido debe tener al menos 5 caracteres.");
    }

    $db = new Database();
    $conn = $db->connect();

    try {
        $sql = $conn->prepare("
            INSERT INTO foro_temas (usuario_id, titulo, contenido)
            VALUES (:usuario_id, :titulo, :contenido)
        ");

        $sql->execute([
            ":usuario_id" => $usuario_id,
            ":titulo" => $titulo,
            ":contenido" => $contenido
        ]);

        header("Location: ../pages/foro.php?publicado=1");
        exit();

    } catch (Exception $e) {
        // Error controlado
        header("Location: ../pages/nuevo-post.php?error=1");
        exit();
    }
}
?>
