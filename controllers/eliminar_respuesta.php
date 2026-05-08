<?php
require_once "../middleware/admin.php";
require_once "../models/bbdd.php";

header("Content-Type: application/json");

$id = $_GET["id"] ?? null;
$tema_id = $_GET["tema"] ?? null;

if (!$id || !is_numeric($id) || !$tema_id || !is_numeric($tema_id)) {
    echo json_encode([
        "success" => false,
        "error" => "Parámetros inválidos"
    ]);
    exit;
}

$db = new Database();
$conn = $db->connect();

try {

    // Verificar que la respuesta existe y pertenece al tema
    $stmt = $conn->prepare("
        SELECT id 
        FROM foro_respuestas 
        WHERE id = ? AND tema_id = ?
    ");
    $stmt->execute([$id, $tema_id]);

    if (!$stmt->fetch()) {
        echo json_encode([
            "success" => false,
            "error" => "La respuesta no existe o no pertenece al tema"
        ]);
        exit;
    }

    // Eliminar respuesta
    $del = $conn->prepare("DELETE FROM foro_respuestas WHERE id = ?");
    $del->execute([$id]);

    echo json_encode([
        "success" => true,
        "message" => "Respuesta eliminada correctamente",
        "redirect" => "../pages/post.php?id=" . $tema_id
    ]);
    exit;

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "error" => "Error interno del servidor",
        "detalle" => $e->getMessage()
    ]);
    exit;
}
