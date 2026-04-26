<?php
header("Content-Type: application/json");
session_start();
require_once "../models/bbdd.php";

// Conexión
$db = new Database();
$conn = $db->connect();

// Solo admin
if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    http_response_code(401);
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

try {
    // Obtener usuarios + total de actividades
    $sql = "SELECT 
                u.id, 
                u.email, 
                u.nombre, 
                u.rol,
                (SELECT COUNT(*) FROM resultados r WHERE r.usuario_id = u.id) AS total_actividades
            FROM usuarios u
            ORDER BY u.id ASC";

    $stmt = $conn->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "usuarios" => $usuarios
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Error interno del servidor"
    ]);
}
