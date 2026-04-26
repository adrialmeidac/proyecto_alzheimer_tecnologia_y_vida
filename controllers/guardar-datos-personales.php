<?php
header("Content-Type: application/json");
session_start();
require_once "../models/bbdd.php";

// Verificar sesión
if (!isset($_SESSION["user_id"])) {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

// SOLO PACIENTES PUEDEN USAR ESTE CONTROLADOR
if ($_SESSION["rol"] !== "paciente") {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "Acceso no permitido"]);
    exit;
}

// Verificar método POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
    exit;
}

// Conexión
$db = new Database();
$conn = $db->connect();

// Recibir datos
$nombre = trim($_POST["nombre"] ?? "");
$apellido = trim($_POST["apellido"] ?? "");
$fecha = trim($_POST["fecha"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");

// Validaciones
$errores = [];

if ($nombre === "") $errores[] = "El nombre es obligatorio.";
if ($apellido === "") $errores[] = "El apellido es obligatorio.";
if ($fecha === "" || !strtotime($fecha)) $errores[] = "La fecha de nacimiento no es válida.";

if ($telefono !== "" && !preg_match("/^[0-9]{9}$/", $telefono)) {
    $errores[] = "El teléfono debe tener 9 dígitos.";
}

if (!empty($errores)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => implode("<br>", $errores)]);
    exit;
}

try {
    // Actualizar datos del paciente
    $sql = "UPDATE usuarios SET 
                nombre = :nombre,
                apellido = :apellido,
                fecha_nacimiento = :fecha,
                telefono = :telefono,
                perfil_completado = 1
            WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":fecha" => $fecha,
        ":telefono" => $telefono,
        ":id" => $_SESSION["user_id"]
    ]);

    // Actualizar sesión
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
