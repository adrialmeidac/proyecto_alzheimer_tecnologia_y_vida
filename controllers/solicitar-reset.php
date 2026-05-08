<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "../middleware/session-public.php"; 
require_once "../models/bbdd.php";

try {

    // Solo aceptar POST
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        echo json_encode(["success" => false, "error" => "Método no permitido"]);
        exit;
    }

    // Obtener datos enviados por fetch()
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data["email"] ?? null;

    // Validación básica
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

    // Conexión
    $db = new Database();
    $conn = $db->connect();

    // Verificar si el usuario existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Respuesta estándar (no revelar si existe o no)
    $respuestaSegura = [
        "success" => true,
        "message" => "Si el correo está registrado, recibirás un enlace para restablecer tu contraseña."
    ];

    if (!$user) {
        echo json_encode($respuestaSegura);
        exit;
    }

    // Generar token seguro
    $token = bin2hex(random_bytes(32));
    $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Guardar token en la BD
    $update = $conn->prepare("
        UPDATE usuarios 
        SET token_recuperacion = :token, token_expira = :expira 
        WHERE id = :id
    ");
    $update->execute([
        ":token" => $token,
        ":expira" => $expira,
        ":id" => $user["id"]
    ]);

    // Enlace de recuperación (solo para desarrollo)
    // $debug_link = "http://localhost/pages/restablecer-password.php?token=" . $token;

    echo json_encode($respuestaSegura);

} catch (Exception $e) {

    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Error interno del servidor"
    ]);
}
