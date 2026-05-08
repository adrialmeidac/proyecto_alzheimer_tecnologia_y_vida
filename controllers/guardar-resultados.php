<?php
header("Content-Type: application/json");
require_once "../middleware/session.php";
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$data = json_decode(file_get_contents("php://input"), true);

$userId = $_SESSION["user_id"] ?? null;

if (!$userId) {
    echo json_encode(["success" => false, "error" => "Usuario no autenticado"]);
    exit;
}

$tipo = $data["tipo"] ?? "";
$dificultad = $data["dificultad"] ?? "";
$tiempo = $data["tiempo"] ?? 0;
$puntuacion = $data["puntuacion"] ?? 0;

$esTest = in_array($tipo, ["memoria", "atencion", "orientacion"]);
$label = $esTest ? "Test" : "Juego";

$detalle = "$label: $tipo | Dificultad: $dificultad | Tiempo: {$tiempo}s | Puntuación: $puntuacion";

$stmt = $conn->prepare("
    INSERT INTO resultados (usuario_id, juego, puntaje, fecha, detalle)
    VALUES (?, ?, ?, NOW(), ?)
");
$stmt->execute([$userId, $tipo, $puntuacion, $detalle]);

echo json_encode(["success" => true]);
