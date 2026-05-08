<?php
header("Content-Type: application/json");
session_start();

require_once "../models/bbdd.php";

if (!isset($_SESSION["user_id"]) || !in_array($_SESSION["rol"], ["familiar","cuidador"])) {
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

$db = new Database();
$conn = $db->connect();

$action = $_GET["action"] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

switch ($action) {

    case "listar_pacientes":
        $stmt = $conn->prepare("
            SELECT u.id, u.nombre, u.email
            FROM relaciones_familiares r
            INNER JOIN usuarios u ON u.id = r.paciente_id
            WHERE r.familiar_id = ?
        ");
        $stmt->execute([$_SESSION["user_id"]]);

        echo json_encode(["success" => true, "pacientes" => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        break;

    case "vincular":
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? AND rol = 'paciente'");
        $stmt->execute([$data["email"]]);
        $paciente = $stmt->fetch();

        if (!$paciente) {
            echo json_encode(["success" => false, "error" => "No existe un paciente con ese email"]);
            exit;
        }

        $stmt = $conn->prepare("
            SELECT id FROM relaciones_familiares 
            WHERE paciente_id = ? AND familiar_id = ?
        ");
        $stmt->execute([$paciente["id"], $_SESSION["user_id"]]);

        if ($stmt->fetch()) {
            echo json_encode(["success" => false, "error" => "Ya estás vinculado a este paciente"]);
            exit;
        }

        $stmt = $conn->prepare("
            INSERT INTO relaciones_familiares (paciente_id, familiar_id, parentesco)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([
            $paciente["id"],
            $_SESSION["user_id"],
            $data["parentesco"]
        ]);

        echo json_encode(["success" => true, "message" => "Paciente vinculado correctamente"]);
        break;

    case "actividades_paciente":
        $stmt = $conn->prepare("
            SELECT * FROM actividades
            WHERE usuario_id = ?
            ORDER BY fecha ASC, hora ASC
        ");
        $stmt->execute([$data["paciente_id"]]);

        echo json_encode(["success" => true, "actividades" => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        break;

    case "historial_paciente":
        $stmt = $conn->prepare("
            SELECT * FROM actividades
            WHERE usuario_id = ? AND estado = 'realizada'
            ORDER BY fecha DESC, hora DESC
        ");
        $stmt->execute([$data["paciente_id"]]);

        echo json_encode(["success" => true, "historial" => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        break;

    case "crear_actividad":
        $stmt = $conn->prepare("
            INSERT INTO actividades (usuario_id, titulo, descripcion, fecha, hora)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data["paciente_id"],
            $data["titulo"],
            $data["descripcion"],
            $data["fecha"],
            $data["hora"]
        ]);

        echo json_encode(["success" => true, "message" => "Actividad creada"]);
        break;

    default:
        echo json_encode(["success" => false, "error" => "Acción no válida"]);
}
