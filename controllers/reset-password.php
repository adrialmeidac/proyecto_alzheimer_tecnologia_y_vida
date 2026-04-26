<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();

require_once "../models/bbdd.php";

// Conexión
$db = new Database();
$conn = $db->connect();

// Solo aceptar POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
    exit;
}

// Obtener datos enviados por fetch()
$data = json_decode(file_get_contents("php://input"), true);

$token = $data["token"] ?? null;
$password = $data["password"] ?? null;

// Validación básica
if (!$token || !$password) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Datos incompletos"]);
    exit;
}

try {
    // Buscar usuario por token
    $stmt = $conn->prepare("
        SELECT id, token_expira 
        FROM usuarios 
        WHERE token_recuperacion = :token 
        LIMIT 1
    ");
    $stmt->execute([":token" => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Token inválido"]);
        exit;
    }

    // Verificar expiración del token
    $expira = strtotime($user["token_expira"]);
    $ahora = time();

    if ($ahora > $expira) {
        http_response_code(410);
        echo json_encode(["success" => false, "error" => "El enlace ha expirado. Solicita uno nuevo."]);
        exit;
    }

    // Encriptar nueva contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Actualizar contraseña y eliminar token
    $update = $conn->prepare("
        UPDATE usuarios 
        SET password = :password, token_recuperacion = NULL, token_expira = NULL
        WHERE id = :id
    ");
    $update->execute([
        ":password" => $passwordHash,
        ":id" => $user["id"]
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Contraseña actualizada correctamente"
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Error interno del servidor"]);
}
