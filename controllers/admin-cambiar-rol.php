<?php
header("Content-Type: application/json");
session_start();
require_once "../models/bbdd.php";

// Solo admin
if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    http_response_code(401);
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

$db = new Database();
$conn = $db->connect();

// Leer JSON
$data = json_decode(file_get_contents("php://input"), true);
$id = $data["id"] ?? null;
$nuevoRol = $data["rol"] ?? null;

// Validar ID
if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "ID inválido"]);
    exit;
}

// Validar rol permitido
$rolesPermitidos = ["paciente", "familiar", "cuidador", "admin"];

if (!in_array($nuevoRol, $rolesPermitidos)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Rol no permitido"]);
    exit;
}

// Evitar que un admin se cambie su propio rol
if ($id == $_SESSION["user_id"]) {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "No puedes cambiar tu propio rol"]);
    exit;
}

try {
    // Verificar que el usuario existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE id = :id");
    $stmt->execute([":id" => $id]);

    if (!$stmt->fetch()) {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Usuario no encontrado"]);
        exit;
    }

    // Actualizar rol
    $stmt = $conn->prepare("UPDATE usuarios SET rol = :rol WHERE id = :id");
    $stmt->execute([
        ":rol" => $nuevoRol,
        ":id" => $id
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Rol actualizado correctamente",
        "new_role" => $nuevoRol
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Error interno del servidor"]);
}
