<?php
header("Content-Type: application/json");

require_once "../middleware/admin.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/models/bbdd.php";

// Leer JSON
$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Solicitud inválida"]);
    exit;
}

$id = $input["id"] ?? null;

// Validar ID
if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "ID inválido"]);
    exit;
}

$id = (int)$id;

try {
    $db = new Database();
    $conn = $db->connect();

    // Eliminar resultado
    $stmt = $conn->prepare("DELETE FROM resultados WHERE id = :id");
    $stmt->execute([":id" => $id]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Resultado no encontrado"]);
        exit;
    }

    http_response_code(200);
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
