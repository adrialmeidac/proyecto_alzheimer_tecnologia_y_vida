<?php
header("Content-Type: application/json");
session_start();
require_once "../models/bbdd.php";

// Solo admin
if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

$db = new Database();
$conn = $db->connect();

$action = $_GET["action"] ?? null;

switch ($action) {

    // ---------------------------------------------------------
    // LISTAR NOTIFICACIONES (con filtros)
    // ---------------------------------------------------------
    case "listar":

        $usuario = $_GET["usuario_id"] ?? null;
        $fecha = $_GET["fecha"] ?? null;
        $estado = $_GET["estado"] ?? null;

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

        $sql = $conn->prepare($query);
        $sql->execute($params);

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "notificaciones" => $data]);
        break;


    // ---------------------------------------------------------
    // ELIMINAR NOTIFICACIÓN
    // ---------------------------------------------------------
    case "eliminar":

        if (!isset($_POST["id"])) {
            echo json_encode(["success" => false, "error" => "ID no recibido"]);
            exit;
        }

        $sql = $conn->prepare("DELETE FROM notificaciones WHERE id = :id");
        $sql->execute([":id" => $_POST["id"]]);

        echo json_encode(["success" => true, "message" => "Notificación eliminada"]);
        break;


    default:
        echo json_encode(["success" => false, "error" => "Acción no válida"]);
}
