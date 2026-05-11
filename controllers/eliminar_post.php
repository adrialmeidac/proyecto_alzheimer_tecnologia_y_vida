<?php
require_once "../middleware/admin.php";
require_once "../models/bbdd.php";

header("Content-Type: application/json");

$id = $_GET["id"] ?? null;

if (!$id || !is_numeric($id)) {
    echo json_encode([
        "success" => false,
        "error" => "ID inválido"
    ]);
    exit;
}

$db = new Database();
$conn = $db->connect();

try {

    
    $stmt = $conn->prepare("SELECT id FROM foro_temas WHERE id = ?");
    $stmt->execute([$id]);

    if (!$stmt->fetch()) {
        echo json_encode([
            "success" => false,
            "error" => "El tema no existe"
        ]);
        exit;
    }

    
    $delResp = $conn->prepare("DELETE FROM foro_respuestas WHERE tema_id = ?");
    $delResp->execute([$id]);

    
    $delTema = $conn->prepare("DELETE FROM foro_temas WHERE id = ?");
    $delTema->execute([$id]);

    echo json_encode([
        "success" => true,
        "message" => "Tema y respuestas eliminados correctamente"
    ]);
    exit;

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "error" => "Error interno del servidor",
        "detalle" => $e->getMessage()
    ]);
    exit;
}
