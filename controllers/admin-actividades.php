<?php
header("Content-Type: application/json");
session_start();

require_once "../models/bbdd.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

$db = new Database();
$conn = $db->connect();

$action = $_GET["action"] ?? null;

switch ($action) {

    case "listar":
        $stmt = $conn->query("
            SELECT a.*, u.nombre AS usuario_nombre
            FROM actividades a
            INNER JOIN usuarios u ON u.id = a.usuario_id
            ORDER BY a.fecha ASC, a.hora ASC
        ");

        echo json_encode([
            "success" => true,
            "actividades" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ]);
        break;

    case "crear":

        $stmt = $conn->prepare("
            INSERT INTO actividades (usuario_id, titulo, descripcion, fecha, hora)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $_POST["usuario_id"],
            $_POST["titulo"],
            $_POST["descripcion"],
            $_POST["fecha"],
            $_POST["hora"]
        ]);

        echo json_encode(["success" => true, "message" => "Actividad creada"]);
        break;


    case "obtener":

        $stmt = $conn->prepare("SELECT * FROM actividades WHERE id = ?");
        $stmt->execute([$_POST["id"]]);

        echo json_encode([
            "success" => true,
            "actividad" => $stmt->fetch(PDO::FETCH_ASSOC)
        ]);
        break;


    case "editar":

        $stmt = $conn->prepare("
            UPDATE actividades 
            SET usuario_id=?, titulo=?, descripcion=?, fecha=?, hora=?, estado=?
            WHERE id=?
        ");

        $stmt->execute([
            $_POST["usuario_id"],
            $_POST["titulo"],
            $_POST["descripcion"],
            $_POST["fecha"],
            $_POST["hora"],
            $_POST["estado"],
            $_POST["id"]
        ]);

        echo json_encode(["success" => true, "message" => "Actividad actualizada"]);
        break;


    case "eliminar":

        $stmt = $conn->prepare("DELETE FROM actividades WHERE id = ?");
        $stmt->execute([$_POST["id"]]);

        echo json_encode(["success" => true, "message" => "Actividad eliminada"]);
        break;
    default:
        echo json_encode(["success" => false, "error" => "Acción no válida"]);
}
