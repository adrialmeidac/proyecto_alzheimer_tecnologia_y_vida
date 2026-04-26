<?php
header("Content-Type: application/json");
session_start();
require_once "../models/bbdd.php";

// Conexión
$db = new Database();
$conn = $db->connect();

// Solo admin
if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    http_response_code(401);
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

// Leer JSON
$data = json_decode(file_get_contents("php://input"), true);
$id = $data["id"] ?? null;

// Validar ID
if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "ID inválido"]);
    exit;
}

// Evitar que un admin se elimine a sí mismo
if ($id == $_SESSION["user_id"]) {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "No puedes eliminar tu propio usuario"]);
    exit;
}

try {
    // Verificar si el usuario existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE id = :id");
    $stmt->execute([":id" => $id]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Usuario no encontrado"]);
        exit;
    }

    // Eliminar historial del usuario
    $stmt = $conn->prepare("DELETE FROM resultados WHERE user_id = :id");
    $stmt->execute([":id" => $id]);

    // Eliminar usuario
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->execute([":id" => $id]);

    echo json_encode([
        "success" => true,
        "message" => "Usuario y su historial eliminados correctamente"
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Error interno del servidor"
    ]);
}
