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
$password = $data["password"] ?? null;


if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Debes completar todos los campos"]);
    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Email no válido"]);
    exit;
}

try {
    
    $stmt = $conn->prepare("SELECT id, nombre, email, password, rol, perfil_completado 
                        FROM usuarios 
                        WHERE email = :email 
                        LIMIT 1");
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(["success" => false, "error" => "El usuario no existe"]);
        exit;
    }

    
    if (!password_verify($password, $user["password"])) {
        http_response_code(401);
        echo json_encode(["success" => false, "error" => "Contraseña incorrecta"]);
        exit;
    }


$_SESSION["user_id"] = $user["id"];
$_SESSION["nombre"] = $user["nombre"];
$_SESSION["email"] = $user["email"];
$_SESSION["rol"] = $user["rol"];
$_SESSION["perfil_completado"] = $user["perfil_completado"];

    

if ($user["rol"] === "paciente") {

    
    if (!empty($user["perfil_completado"]) && $user["perfil_completado"] == 1) {
        $redirect = "/pages/dashboard.php";
    } 
    
    else {
        $redirect = "/pages/datos-personales.php";
    }
}

if ($user["rol"] === "familiar" || $user["rol"] === "cuidador") {
    $redirect = "/pages/dashboardFamiliar.php";
}

if ($user["rol"] === "admin") {
    $redirect = "/admin/index.php";
}

    echo json_encode([
        "success" => true,
        "message" => "Inicio de sesión exitoso",
        "redirect" => $redirect,
        "data" => [
            "id" => $user["id"],
            "nombre" => $user["nombre"],
            "email" => $user["email"],
            "rol" => $user["rol"]
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Error interno del servidor"]);
}
