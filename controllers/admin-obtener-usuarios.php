<?php
header("Content-Type: application/json");
session_start();

require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();


if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "admin") {
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

try {
    $sql = "SELECT 
                id,
                nombre,
                email,
                rol,
                perfil_completado,
                fecha_registro
            FROM usuarios
            ORDER BY id ASC";

    $stmt = $conn->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "usuarios" => $usuarios
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => "Error interno del servidor"
    ]);
}
