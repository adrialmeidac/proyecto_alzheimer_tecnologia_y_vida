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

// SOLO PACIENTES
if ($_SESSION["rol"] !== "paciente") {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "Acceso no permitido"]);
    exit;
}

// SOLO POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
    exit;
}

$db = new Database();
$conn = $db->connect();

// Recibir datos
$nombre   = trim($_POST["nombre"] ?? "");
$apellido = trim($_POST["apellido"] ?? "");
$fecha    = trim($_POST["fecha"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");

// Validaciones
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
    // No permitir fechas futuras
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

    // 1. Actualizar datos en usuarios
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

    // 2. Verificar si el paciente ya existe
    $check = $conn->prepare("SELECT id FROM pacientes WHERE user_id = ?");
    $check->execute([$_SESSION["user_id"]]);
    $existe = $check->fetch(PDO::FETCH_ASSOC);

    if (!$existe) {
        // 3. Crear registro en pacientes
        $insert = $conn->prepare("
            INSERT INTO pacientes (user_id, fecha_nacimiento)
            VALUES (?, ?)
        ");
        $insert->execute([$_SESSION["user_id"], $fecha]);

    } else {
        // 4. Actualizar fecha_nacimiento si ya existe
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

    // 5. Actualizar sesión
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
