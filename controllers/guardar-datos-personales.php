<?php
header("Content-Type: application/json");
session_start();
require_once "../models/bbdd.php";


if (!isset($_SESSION["user_id"])) {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}


if ($_SESSION["rol"] !== "paciente") {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "Acceso no permitido"]);
    exit;
}


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
    exit;
}

$db = new Database();
$conn = $db->connect();


$nombre   = trim($_POST["nombre"] ?? "");
$apellido = trim($_POST["apellido"] ?? "");
$fecha    = trim($_POST["fecha"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");


$errores = [];

if ($nombre === "" || !preg_match("/^[a-zA-ZÀ-ÿ\s]{2,40}$/", $nombre)) {
    $errores[] = "El nombre no es válido.";
}

if ($apellido === "" || !preg_match("/^[a-zA-ZÀ-ÿ\s]{2,60}$/", $apellido)) {
    $errores[] = "El apellido no es válido.";
}

if ($fecha === "" || !strtotime($fecha)) {
    $errores[] = "La fecha de nacimiento no es válida.";
} else {
    
    if ($fecha > date("Y-m-d")) {
        $errores[] = "La fecha de nacimiento no puede ser futura.";
    }
}

if ($telefono !== "" && !preg_match("/^[1-9][0-9]{8}$/", $telefono)) {
    $errores[] = "El teléfono debe tener 9 dígitos y no comenzar por 0.";
}

if (!empty($errores)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => implode("<br>", $errores)]);
    exit;
}

try {

    
    $sql = "UPDATE usuarios SET 
                nombre = :nombre,
                apellidos = :apellido,
                telefono = :telefono,
                perfil_completado = 1
            WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":nombre"   => $nombre,
        ":apellido" => $apellido,
        ":telefono" => $telefono,
        ":id"       => $_SESSION["user_id"]
    ]);

    
    $check = $conn->prepare("SELECT id FROM pacientes WHERE user_id = ?");
    $check->execute([$_SESSION["user_id"]]);
    $existe = $check->fetch(PDO::FETCH_ASSOC);

    if (!$existe) {
        
        $insert = $conn->prepare("
            INSERT INTO pacientes (user_id, fecha_nacimiento)
            VALUES (?, ?)
        ");
        $insert->execute([$_SESSION["user_id"], $fecha]);

    } else {
        
        $updatePaciente = $conn->prepare("
            UPDATE pacientes 
            SET fecha_nacimiento = :fecha
            WHERE user_id = :id
        ");
        $updatePaciente->execute([
            ":fecha" => $fecha,
            ":id"    => $_SESSION["user_id"]
        ]);
    }

    
    $_SESSION["nombre"] = $nombre;
    $_SESSION["apellido"] = $apellido;
    $_SESSION["perfil_completado"] = 1;

    echo json_encode([
        "success" => true,
        "redirect" => "/pages/dashboard.php"
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Error interno del servidor"]);
}
