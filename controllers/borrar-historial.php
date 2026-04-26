<?php
header("Content-Type: application/json");
session_start();
require_once "../models/bbdd.php";

// Conexión
$db = new Database();
$conn = $db->connect();

// Solo permitir POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "error" => "Método no permitido"
    ]);
    exit;
}

// Verificar sesión
if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "error" => "No autorizado"
    ]);
    exit;
}

$user_id = $_SESSION["user_id"];

try {
    // Borrar historial
    $stmt = $conn->prepare("DELETE FROM resultados WHERE user_id = :user_id");
    $stmt->execute([":user_id" => $user_id]);

    echo json_encode([
        "success" => true,
        "message" => "Historial borrado correctamente",
        "deleted" => $stmt->rowCount()
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Error interno del servidor"
    ]);
}
