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

$email = $data["email"] ?? null;
$password = $data["password"] ?? null;

// Validación básica
if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Debes completar todos los campos"]);
    exit;
}

// Validar email real
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Email no válido"]);
    exit;
}

try {
    // Buscar usuario
    $stmt = $conn->prepare("SELECT id, nombre, email, password, rol, perfil_completado 
                            FROM usuarios 
                            WHERE email = :email LIMIT 1");
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "El usuario no existe"]);
        exit;
    }

    // Verificar contraseña
    if (!password_verify($password, $user["password"])) {
        http_response_code(401);
        echo json_encode(["success" => false, "error" => "Contraseña incorrecta"]);
        exit;
    }

    // Crear sesión
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["nombre"] = $user["nombre"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["rol"] = $user["rol"];
    $_SESSION["perfil_completado"] = $user["perfil_completado"];

    // ============================================
    // AÑADIDO: OBTENER EL PACIENTE_ID REAL
    // ============================================
    if ($user["rol"] === "paciente") {
        $sqlPaciente = $conn->prepare("SELECT id FROM pacientes WHERE usuario_id = ?");
        $sqlPaciente->execute([$user["id"]]);
        $paciente = $sqlPaciente->fetch(PDO::FETCH_ASSOC);

        if ($paciente) {
            $_SESSION["paciente_id"] = $paciente["id"];
        }
    }

    // REDIRECCIÓN SEGÚN ROL Y PERFIL COMPLETADO
    $redirect = "/pages/dashboard.php"; // fallback

    if ($user["rol"] === "admin") {
        $redirect = "/admin/index.php";

    } elseif ($user["rol"] === "paciente") {

        if ($user["perfil_completado"] == 0) {
            $redirect = "/pages/datos-personales.php";
        } else {
            $redirect = "/pages/dashboard.php";
        }

    } elseif ($user["rol"] === "familiar" || $user["rol"] === "cuidador") {

        if ($user["perfil_completado"] == 0) {
            $redirect = "/pages/registro_familiar.php";
        } else {
            $redirect = "/pages/dashboard.php";
        }
    }

    echo json_encode([
        "success" => true,
        "redirect" => $redirect
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Error interno del servidor"]);
}

