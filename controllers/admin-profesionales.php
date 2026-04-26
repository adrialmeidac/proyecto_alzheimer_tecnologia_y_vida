<?php
header("Content-Type: application/json");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../models/bbdd.php";

// Verificar si es admin
if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    http_response_code(401);
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

$db = new Database();
$conn = $db->connect();

// Obtener acción
$action = $_GET["action"] ?? null;

if (!$action) {
    // Si no viene por GET, intentamos leer JSON del body
    $json = json_decode(file_get_contents("php://input"), true);
    $action = $json["action"] ?? null;
}

if (!$action) {
    echo json_encode(["success" => false, "error" => "Acción no especificada"]);
    exit;
}

try {

    // ============================================================
    // GET
    // ============================================================
    if ($action === "get") {

        $sql = "SELECT 
                    id,
                    nombre,
                    especialidad,
                    direccion,
                    servicios,
                    horario_lunes,
                    horario_martes,
                    horario_miercoles,
                    horario_jueves,
                    horario_viernes
                FROM profesionales
                ORDER BY nombre ASC";

        $stmt = $conn->query($sql);
        $profesionales = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "profesionales" => $profesionales]);
        exit;
    }

    // ============================================================
    // CREATE
    // ============================================================
    if ($action === "create") {

        $data = json_decode(file_get_contents("php://input"), true);

        $sql = "INSERT INTO profesionales 
                (nombre, especialidad, direccion, servicios,
                 horario_lunes, horario_martes, horario_miercoles, horario_jueves, horario_viernes)
                VALUES 
                (:nombre, :especialidad, :direccion, :servicios,
                 :lunes, :martes, :miercoles, :jueves, :viernes)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":nombre" => $data["nombre"],
            ":especialidad" => $data["especialidad"],
            ":direccion" => $data["direccion"],
            ":servicios" => $data["servicios"] ?? null,
            ":lunes" => $data["lunes"] ?? null,
            ":martes" => $data["martes"] ?? null,
            ":miercoles" => $data["miercoles"] ?? null,
            ":jueves" => $data["jueves"] ?? null,
            ":viernes" => $data["viernes"] ?? null
        ]);

        echo json_encode(["success" => true, "message" => "Profesional creado"]);
        exit;
    }

    // ============================================================
    // UPDATE
    // ============================================================
    if ($action === "update") {

        $data = json_decode(file_get_contents("php://input"), true);

        $sql = "UPDATE profesionales SET
                    nombre = :nombre,
                    especialidad = :especialidad,
                    direccion = :direccion,
                    servicios = :servicios,
                    horario_lunes = :lunes,
                    horario_martes = :martes,
                    horario_miercoles = :miercoles,
                    horario_jueves = :jueves,
                    horario_viernes = :viernes
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":id" => $data["id"],
            ":nombre" => $data["nombre"],
            ":especialidad" => $data["especialidad"],
            ":direccion" => $data["direccion"],
            ":servicios" => $data["servicios"] ?? null,
            ":lunes" => $data["lunes"] ?? null,
            ":martes" => $data["martes"] ?? null,
            ":miercoles" => $data["miercoles"] ?? null,
            ":jueves" => $data["jueves"] ?? null,
            ":viernes" => $data["viernes"] ?? null
        ]);

        echo json_encode(["success" => true, "message" => "Profesional actualizado"]);
        exit;
    }

    // ============================================================
    // DELETE
    // ============================================================
    if ($action === "delete") {

        $data = json_decode(file_get_contents("php://input"), true);

        $sql = "DELETE FROM profesionales WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([":id" => $data["id"]]);

        echo json_encode(["success" => true, "message" => "Profesional eliminado"]);
        exit;
    }

    echo json_encode(["success" => false, "error" => "Acción no válida"]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage(),
        "trace" => $e->getTraceAsString()
    ]);
}
