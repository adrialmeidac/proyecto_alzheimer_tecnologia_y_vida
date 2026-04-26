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

try {
    // Eliminar resultado
    $stmt = $conn->prepare("DELETE FROM resultados WHERE id = :id");
    $stmt->execute([":id" => $id]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Resultado no encontrado"]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "message" => "Resultado eliminado correctamente"
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Error interno del servidor"
    ]);
}
