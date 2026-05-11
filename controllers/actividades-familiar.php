<?php
require_once "../models/bbdd.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

$familiar_id = $_SESSION["user_id"];
$action = $_GET["action"] ?? null;

$db = new Database();
$conn = $db->connect();

switch ($action) {

    
    
    
    case "listar":
        $paciente_id = $_GET["paciente_id"] ?? null;

        
        $sql = $conn->prepare("
            SELECT id FROM relaciones_familiares
            WHERE paciente_id = ? AND familiar_id = ?
        ");
        $sql->execute([$paciente_id, $familiar_id]);

        if (!$sql->fetch()) {
            echo json_encode(["success" => false, "error" => "No tienes permiso"]);
            exit;
        }

        
        $sql = $conn->prepare("
            SELECT id, descripcion, fecha, hora, completada
            FROM actividades
            WHERE paciente_id = ?
            ORDER BY id DESC
        ");
        $sql->execute([$paciente_id]);

        echo json_encode([
            "success" => true,
            "actividades" => $sql->fetchAll(PDO::FETCH_ASSOC)
        ]);
        break;


    
    
    
case "crear":

    // Recibir datos del formulario (POST normal)
    $paciente_id = $_POST["paciente_id"] ?? null;
    $texto = trim($_POST["texto"] ?? "");
    $fecha = $_POST["fecha"] ?? date("Y-m-d");
    $hora = $_POST["hora"] ?? null;

    // Validar datos
    if (!$paciente_id || strlen($texto) < 3) {
        echo json_encode(["success" => false, "error" => "Datos inválidos"]);
        exit;
    }

    // Verificar relación familiar
    $sql = $conn->prepare("
        SELECT id FROM relaciones_familiares
        WHERE paciente_id = ? AND familiar_id = ?
    ");
    $sql->execute([$paciente_id, $familiar_id]);

    if (!$sql->fetch()) {
        echo json_encode(["success" => false, "error" => "No tienes permiso"]);
        exit;
    }

    // Insertar actividad (usando 'titulo' y 'descripcion' con el mismo texto)
    $sql = $conn->prepare("
        INSERT INTO actividades (usuario_id, titulo, descripcion, fecha, hora, estado)
        VALUES (?, ?, ?, ?, ?, 'pendiente')
    ");
    $sql->execute([$paciente_id, $texto, $texto, $fecha, $hora]);

    echo json_encode([
        "success" => true,
        "id" => $conn->lastInsertId()
    ]);
    break;

    default:
        echo json_encode(["success" => false, "error" => "Acción inválida"]);
}
