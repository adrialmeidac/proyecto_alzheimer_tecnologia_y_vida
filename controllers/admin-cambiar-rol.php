<?php
header("Content-Type: application/json");

require_once "../middleware/admin.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/models/bbdd.php";


$input = json_decode(file_get_contents("php://input"), true);

$id = $input["id"] ?? null;
$nuevoRol = $input["rol"] ?? null;


if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "ID inválido"]);
    exit;
}

$id = (int)$id;


$nuevoRol = strtolower(trim($nuevoRol));


$rolesPermitidos = ["paciente", "familiar", "cuidador", "admin"];

if (!in_array($nuevoRol, $rolesPermitidos)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Rol no permitido"]);
    exit;
}


if ($id === $_SESSION["user_id"]) {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "No puedes cambiar tu propio rol"]);
    exit;
}

try {
    $db = new Database();
    $conn = $db->connect();

    
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE id = :id");
    $stmt->execute([":id" => $id]);

    if (!$stmt->fetch()) {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Usuario no encontrado"]);
        exit;
    }

    
    $stmt = $conn->prepare("UPDATE usuarios SET rol = :rol WHERE id = :id");
    $stmt->execute([
        ":rol" => $nuevoRol,
        ":id" => $id
    ]);

    http_response_code(200);
    echo json_encode([
        "success" => true,
        "message" => "Rol actualizado correctamente",
        "new_role" => $nuevoRol
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Error interno del servidor"]);
}
