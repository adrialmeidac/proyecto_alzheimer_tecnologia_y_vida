<?php
require_once "../middleware/session-admin.php"; // SOLO ADMIN
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

// Recibir datos
$id = $_POST['id'] ?? null;
$titulo = trim($_POST['titulo'] ?? "");
$contenido = trim($_POST['contenido'] ?? "");

// Validación
if (!$id) {
    die("ID inválido.");
}

if ($titulo === "" || $contenido === "") {
    die("El título y el contenido no pueden estar vacíos.");
}

// Actualizar post
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

// Redirigir al post actualizado
header("Location: ../pages/post.php?id=" . $id);
exit();
