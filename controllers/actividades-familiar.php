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

    // ============================
    // 1. LISTAR ACTIVIDADES DEL PACIENTE
    // ============================
    case "listar":
        $paciente_id = $_GET["paciente_id"] ?? null;

        // Validar relación
        $sql = $conn->prepare("
            SELECT id FROM relaciones_paciente_familiar
            WHERE paciente_id = ? AND familiar_id = ?
        ");
        $sql->execute([$paciente_id, $familiar_id]);

        if (!$sql->fetch()) {
            echo json_encode(["success" => false, "error" => "No tienes permiso"]);
            exit;
        }

        // Listar actividades creadas por el familiar
        $sql = $conn->prepare("
            SELECT *
            FROM actividades_paciente
            WHERE paciente_id = ?
            ORDER BY id DESC
        ");
        $sql->execute([$paciente_id]);

        echo json_encode([
            "success" => true,
            "actividades" => $sql->fetchAll(PDO::FETCH_ASSOC)
        ]);
        break;


    // ============================
    // 2. CREAR ACTIVIDAD PARA EL PACIENTE
    // ============================
    case "crear":
        $data = json_decode(file_get_contents("php://input"), true);

        $paciente_id = $data["paciente_id"] ?? null;
        $texto = $data["texto"] ?? "";

        // Validar relación
        $sql = $conn->prepare("
            SELECT id FROM relaciones_paciente_familiar
            WHERE paciente_id = ? AND familiar_id = ?
        ");
        $sql->execute([$paciente_id, $familiar_id]);

        if (!$sql->fetch()) {
            echo json_encode(["success" => false, "error" => "No tienes permiso"]);
            exit;
        }

        // Crear actividad
        $sql = $conn->prepare("
            INSERT INTO actividades_paciente (paciente_id, descripcion, completada, fecha)
            VALUES (?, ?, 0, CURDATE())
        ");
        $sql->execute([$paciente_id, $texto]);

        echo json_encode(["success" => true]);
        break;


    default:
        echo json_encode(["success" => false, "error" => "Acción inválida"]);
}
