<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();

require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$email = $data["email"] ?? null;

if (!$email) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Debes introducir un email"]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Email no válido"]);
    exit;
}

try {
    // Verificar si el usuario existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch();

    if (!$user) {
        // MODO PRODUCCIÓN: no revelar si existe o no
        echo json_encode([
            "success" => true,
            "message" => "Si el correo está registrado, recibirás un enlace para restablecer tu contraseña."
        ]);
        exit;
    }

    // Generar token
    $token = bin2hex(random_bytes(32));
    $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Guardar token en la BD
    $update = $conn->prepare("
        UPDATE usuarios 
        SET token_recuperacion = :token, token_expira = :expira 
        WHERE email = :email
    ");
    $update->execute([
        ":token" => $token,
        ":expira" => $expira,
        ":email" => $email
    ]);

    // Enlace de recuperación
    $link = "http://localhost/pages/restablecer-password.php?token=" . $token;

    // RESPUESTA FINAL (sin mostrar el enlace)
    echo json_encode([
        "success" => true,
        "message" => "Si el correo está registrado, recibirás un enlace para restablecer tu contraseña."
        // "debug_link" => $link // ← Descomenta solo si quieres verlo en desarrollo
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Error interno del servidor"]);
}
