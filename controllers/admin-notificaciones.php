<?php
header("Content-Type: application/json");

require_once "../middleware/admin.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/models/bbdd.php";


$input = json_decode(file_get_contents("php://input"), true);
$action = $_GET["action"] ?? ($input["action"] ?? null);

if (!$action) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Acción no especificada"]);
    exit;
}

try {
    $db = new Database();
    $conn = $db->connect();

    switch ($action) {

        
        
        
        case "listar":

            $usuario = $_GET["usuario_id"] ?? null;
            $fecha   = $_GET["fecha"] ?? null;
            $estado  = $_GET["estado"] ?? null;

            $query = "
                SELECT n.*, u.nombre AS usuario
                FROM notificaciones n
                INNER JOIN usuarios u ON u.id = n.usuario_id
                WHERE 1
            ";

            $params = [];

            if ($usuario) {
                $query .= " AND n.usuario_id = :usuario ";
                $params[":usuario"] = $usuario;
            }

            if ($fecha) {
                $query .= " AND DATE(n.fecha) = :fecha ";
                $params[":fecha"] = $fecha;
            }

            if ($estado !== null && $estado !== "") {
                $query .= " AND n.leida = :estado ";
                $params[":estado"] = $estado;
            }

            $query .= " ORDER BY n.fecha DESC";

            $stmt = $conn->prepare($query);
            $stmt->execute($params);

            echo json_encode([
                "success" => true,
                "notificaciones" => $stmt->fetchAll(PDO::FETCH_ASSOC)
            ]);
            exit;


        
        
        
        case "eliminar":

            $id = $input["id"] ?? null;

            if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
                http_response_code(400);
                echo json_encode(["success" => false, "error" => "ID inválido"]);
                exit;
            }

            $stmt = $conn->prepare("DELETE FROM notificaciones WHERE id = :id");
            $stmt->execute([":id" => $id]);

            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(["success" => false, "error" => "Notificación no encontrada"]);
                exit;
            }

            echo json_encode([
                "success" => true,
                "message" => "Notificación eliminada correctamente"
            ]);
            exit;


        
        
        
        default:
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Acción no válida"]);
            exit;
    }

} catch (Exception $e) {

    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Error interno del servidor"
    ]);
}
