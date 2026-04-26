<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();

require_once "../models/bbdd.php";

// Solo aceptar POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
    exit;
}

// Obtener datos enviados por fetch()
$data = json_decode(file_get_contents("php://input"), true);

$nombre     = trim($data["nombre"] ?? "");
$email      = trim($data["email"] ?? "");
$password   = $data["password"] ?? "";
$password2  = $data["password2"] ?? "";
$rol        = trim($data["rol"] ?? "paciente"); // NUEVO
$recaptcha  = $data["recaptcha"] ?? "";

// ===============================
// VALIDAR RECAPTCHA
// ===============================
if (!$recaptcha) {
    echo json_encode(["success" => false, "error" => "Error de verificación reCAPTCHA"]);
    exit;
}

$secretKey = "6LcHlbgsAAAAAKF4z5w4nYQGEvpjq3pjeFwJP_9X"; 
$verifyURL = "https://www.google.com/recaptcha/api/siteverify";

$response = file_get_contents($verifyURL . "?secret=" . $secretKey . "&response=" . $recaptcha);
$responseKeys = json_decode($response, true);

if (!$responseKeys["success"]) {
    echo json_encode(["success" => false, "error" => "Verificación reCAPTCHA fallida"]);
    exit;
}

// ===============================
// VALIDACIONES DEL FORMULARIO
// ===============================
$errores = [];

if ($nombre === "" || !preg_match("/^[a-zA-ZÀ-ÿ\s]{2,40}$/", $nombre)) {
    $errores[] = "El nombre no es válido.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El email no es válido.";
}

if (strlen($password) < 6) {
    $errores[] = "La contraseña debe tener al menos 6 caracteres.";
}

if ($password !== $password2) {
    $errores[] = "Las contraseñas no coinciden.";
}

if (!in_array($rol, ["paciente", "familiar", "cuidador"])) {
    $errores[] = "El rol seleccionado no es válido.";
}

if (!empty($errores)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => implode("<br>", $errores)]);
    exit;
}

try {
    // Conexión
    $db = new Database();
    $conn = $db->connect();

    // Verificar si el email ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute([":email" => $email]);

    if ($stmt->rowCount() > 0) {
        http_response_code(409);
        echo json_encode(["success" => false, "error" => "El email ya está registrado"]);
        exit;
    }

    // Cifrar contraseña
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insertar usuario con el ROL REAL
    $insert = $conn->prepare("
        INSERT INTO usuarios (nombre, email, password, rol, perfil_completado, fecha_registro)
        VALUES (:nombre, :email, :password, :rol, 0, NOW())
    ");

    $insert->execute([
        ":nombre"   => $nombre,
        ":email"    => $email,
        ":password" => $hashedPassword,
        ":rol"      => $rol
    ]);

    // Obtener ID del nuevo usuario
    $user_id = $conn->lastInsertId();

    // ===============================
    // CREAR SESIÓN
    // ===============================
    $_SESSION["user_id"] = $user_id;
    $_SESSION["nombre"]  = $nombre;
    $_SESSION["email"]   = $email;
    $_SESSION["rol"]    = $rol;
    $_SESSION["perfil_completado"] = 0;

    // ===============================
    // REDIRECCIÓN SEGÚN EL ROL
    // ===============================
    if ($rol === "paciente") {
        $redirect = "/pages/datos-personales.php";
    } else {
        // familiar o cuidador
        $redirect = "/pages/registro_familiar.php";
    }

    echo json_encode([
        "success" => true,
        "redirect" => $redirect
    ]);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Error interno del servidor"]);
}
