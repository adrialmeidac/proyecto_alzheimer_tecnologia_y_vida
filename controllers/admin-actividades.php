<?php
header("Content-Type: application/json");
session_start();

require_once "../models/bbdd.php";

if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "admin") {
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

$db = new Database();
$conn = $db->connect();

$action = $_GET["action"] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

switch ($action) {

    // ============================================
    // LISTAR ACTIVIDADES
    // ============================================
    case "listar":
        $stmt = $conn->query("
            SELECT a.*, u.nombre AS usuario_nombre
            FROM actividades a
            INNER JOIN usuarios u ON u.id = a.usuario_id
            ORDER BY a.fecha ASC, a.hora ASC
        ");
        echo json_encode(["success" => true, "actividades" => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        break;

    // ============================================
    // CREAR ACTIVIDAD
    // ============================================
    case "crear":
        $stmt = $conn->prepare("
            INSERT INTO actividades (usuario_id, titulo, descripcion, fecha, hora)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data["usuario_id"],
            $data["titulo"],
            $data["descripcion"],
            $data["fecha"],
            $data["hora"]
        ]);

        echo json_encode(["success" => true, "message" => "Actividad creada"]);
        break;

    // ============================================
    // OBTENER ACTIVIDAD
    // ============================================
    case "obtener":
        $stmt = $conn->prepare("SELECT * FROM actividades WHERE id = ?");
        $stmt->execute([$data["id"]]);
        echo json_encode(["success" => true, "actividad" => $stmt->fetch(PDO::FETCH_ASSOC)]);
        break;

    // ============================================
    // EDITAR ACTIVIDAD
    // ============================================
    case "editar":
        $stmt = $conn->prepare("
            UPDATE actividades 
            SET usuario_id=?, titulo=?, descripcion=?, fecha=?, hora=?, estado=?
            WHERE id=?
        ");
        $stmt->execute([
            $data["usuario_id"],
            $data["titulo"],
            $data["descripcion"],
            $data["fecha"],
            $data["hora"],
            $data["estado"],
            $data["id"]
        ]);

        echo json_encode(["success" => true, "message" => "Actividad actualizada"]);
        break;

    // ============================================
    // ELIMINAR ACTIVIDAD
    // ============================================
    case "eliminar":
        $stmt = $conn->prepare("DELETE FROM actividades WHERE id = ?");
        $stmt->execute([$data["id"]]);

        echo json_encode(["success" => true, "message" => "Actividad eliminada"]);
        break;

    default:
        echo json_encode(["success" => false, "error" => "Acción no válida"]);
}
