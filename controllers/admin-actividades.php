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
    // LISTAR ACTIVIDADES
    // ---------------------------------------------------------
    case "listar":
        $sql = $conn->query("
            SELECT a.*, u.nombre AS usuario
            FROM actividades a
            INNER JOIN usuarios u ON u.id = a.usuario_id
            ORDER BY a.fecha DESC, a.hora DESC
        ");
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "actividades" => $data]);
        break;

    // ---------------------------------------------------------
    // EDITAR ACTIVIDAD
    // ---------------------------------------------------------
    case "editar":

        if (!isset($_POST["id"], $_POST["titulo"], $_POST["descripcion"], $_POST["fecha"], $_POST["hora"], $_POST["estado"])) {
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
            exit;
        }

        $sql = $conn->prepare("
            UPDATE actividades 
            SET titulo = :t, descripcion = :d, fecha = :f, hora = :h, estado = :e
            WHERE id = :id
        ");

        $sql->execute([
            ":t" => $_POST["titulo"],
            ":d" => $_POST["descripcion"],
            ":f" => $_POST["fecha"],
            ":h" => $_POST["hora"],
            ":e" => $_POST["estado"],
            ":id" => $_POST["id"]
        ]);

        echo json_encode(["success" => true, "message" => "Actividad actualizada"]);
        break;

    // ---------------------------------------------------------
    // ELIMINAR ACTIVIDAD
    // ---------------------------------------------------------
    case "eliminar":

        if (!isset($_POST["id"])) {
            echo json_encode(["success" => false, "error" => "ID no recibido"]);
            exit;
        }

        $sql = $conn->prepare("DELETE FROM actividades WHERE id = :id");
        $sql->execute([":id" => $_POST["id"]]);

        echo json_encode(["success" => true, "message" => "Actividad eliminada"]);
        break;

    default:
        echo json_encode(["success" => false, "error" => "Acción no válida"]);
}
