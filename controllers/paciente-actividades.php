<?php
header("Content-Type: application/json");
session_start();

require_once "../models/bbdd.php";

if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "paciente") {
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

$db = new Database();
$conn = $db->connect();

$action = $_GET["action"] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

switch ($action) {

    
    
    
    case "listar":
        $stmt = $conn->prepare("
            SELECT * FROM actividades
            WHERE usuario_id = ?
            ORDER BY fecha ASC, hora ASC
        ");
        $stmt->execute([$_SESSION["id"]]);

        echo json_encode([
            "success" => true,
            "actividades" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ]);
        break;

    
    
    
    case "realizar":
        $stmt = $conn->prepare("
            UPDATE actividades
            SET estado = 'realizada'
            WHERE id = ? AND usuario_id = ?
        ");
        $stmt->execute([
            $data["id"],
            $_SESSION["id"]
        ]);

        echo json_encode(["success" => true, "message" => "Actividad marcada como realizada"]);
        break;

    default:
        echo json_encode(["success" => false, "error" => "Acción no válida"]);
}
