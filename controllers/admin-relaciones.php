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
    // LISTAR RELACIONES
    // ============================================
    case "listar":
        $stmt = $conn->query("
            SELECT r.id, r.parentesco,
                   p.nombre AS paciente_nombre,
                   f.nombre AS familiar_nombre,
                   p.id AS paciente_id,
                   f.id AS familiar_id
            FROM relaciones_familiares r
            INNER JOIN usuarios p ON p.id = r.paciente_id
            INNER JOIN usuarios f ON f.id = r.familiar_id
            ORDER BY r.id DESC
        ");
        echo json_encode(["success" => true, "relaciones" => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        break;

    // ============================================
    // CREAR RELACIÓN
    // ============================================
    case "crear":
        $stmt = $conn->prepare("
            INSERT INTO relaciones_familiares (paciente_id, familiar_id, parentesco)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([
            $data["paciente_id"],
            $data["familiar_id"],
            $data["parentesco"]
        ]);

        echo json_encode(["success" => true, "message" => "Relación creada"]);
        break;

    // ============================================
    // OBTENER RELACIÓN
    // ============================================
    case "obtener":
        $stmt = $conn->prepare("SELECT * FROM relaciones_familiares WHERE id = ?");
        $stmt->execute([$data["id"]]);
        echo json_encode(["success" => true, "relacion" => $stmt->fetch(PDO::FETCH_ASSOC)]);
        break;

    // ============================================
    // EDITAR RELACIÓN
    // ============================================
    case "editar":
        $stmt = $conn->prepare("
            UPDATE relaciones_familiares
            SET paciente_id=?, familiar_id=?, parentesco=?
            WHERE id=?
        ");
        $stmt->execute([
            $data["paciente_id"],
            $data["familiar_id"],
            $data["parentesco"],
            $data["id"]
        ]);

        echo json_encode(["success" => true, "message" => "Relación actualizada"]);
        break;

    // ============================================
    // ELIMINAR RELACIÓN
    // ============================================
    case "eliminar":
        $stmt = $conn->prepare("DELETE FROM relaciones_familiares WHERE id = ?");
        $stmt->execute([$data["id"]]);

        echo json_encode(["success" => true, "message" => "Relación eliminada"]);
        break;

    default:
        echo json_encode(["success" => false, "error" => "Acción no válida"]);
}
