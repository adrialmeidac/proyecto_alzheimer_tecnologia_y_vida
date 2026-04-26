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
    $json = json_decode(file_get_contents("php://input"), true);
    $action = $json["action"] ?? null;
}

if (!$action) {
    echo json_encode(["success" => false, "error" => "Acción no especificada"]);
    exit;
}

try {

    // ============================================================
    // GET_TEMAS: listado de temas con nº de respuestas
    // ============================================================
    if ($action === "get_temas") {

        $sql = "
            SELECT 
                t.id,
                t.titulo,
                t.fecha,
                u.nombre,
                u.apellido,
                COUNT(r.id) AS respuestas
            FROM foro_temas t
            JOIN usuarios u ON t.usuario_id = u.id
            LEFT JOIN foro_respuestas r ON r.tema_id = t.id
            GROUP BY t.id
            ORDER BY t.fecha DESC
        ";

        $stmt = $conn->query($sql);
        $temas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "temas" => $temas]);
        exit;
    }

    // ============================================================
    // GET_TEMA: un tema + sus respuestas
    // ============================================================
    if ($action === "get_tema") {

        $id = $_GET["id"] ?? null;
        if (!$id) {
            echo json_encode(["success" => false, "error" => "ID de tema no especificado"]);
            exit;
        }

        // Tema
        $sqlTema = "
            SELECT 
                t.*,
                u.nombre,
                u.apellido
            FROM foro_temas t
            JOIN usuarios u ON t.usuario_id = u.id
            WHERE t.id = :id
        ";
        $stmt = $conn->prepare($sqlTema);
        $stmt->execute([":id" => $id]);
        $tema = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$tema) {
            echo json_encode(["success" => false, "error" => "Tema no encontrado"]);
            exit;
        }

        // Respuestas
        $sqlResp = "
            SELECT 
                r.*,
                u.nombre,
                u.apellido
            FROM foro_respuestas r
            JOIN usuarios u ON r.usuario_id = u.id
            WHERE r.tema_id = :id
            ORDER BY r.fecha ASC
        ";
        $stmt = $conn->prepare($sqlResp);
        $stmt->execute([":id" => $id]);
        $respuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "success" => true,
            "tema" => $tema,
            "respuestas" => $respuestas
        ]);
        exit;
    }

    // ============================================================
    // DELETE_TEMA: elimina tema + sus respuestas
    // ============================================================
    if ($action === "delete_tema") {

        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data["id"] ?? null;

        if (!$id) {
            echo json_encode(["success" => false, "error" => "ID de tema no especificado"]);
            exit;
        }

        // Primero borrar respuestas
        $sqlResp = "DELETE FROM foro_respuestas WHERE tema_id = :id";
        $stmt = $conn->prepare($sqlResp);
        $stmt->execute([":id" => $id]);

        // Luego borrar tema
        $sqlTema = "DELETE FROM foro_temas WHERE id = :id";
        $stmt = $conn->prepare($sqlTema);
        $stmt->execute([":id" => $id]);

        echo json_encode(["success" => true, "message" => "Tema y respuestas eliminados"]);
        exit;
    }

    // ============================================================
    // DELETE_RESPUESTA: elimina una respuesta concreta
    // ============================================================
    if ($action === "delete_respuesta") {

        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data["id"] ?? null;

        if (!$id) {
            echo json_encode(["success" => false, "error" => "ID de respuesta no especificado"]);
            exit;
        }

        $sql = "DELETE FROM foro_respuestas WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([":id" => $id]);

        echo json_encode(["success" => true, "message" => "Respuesta eliminada"]);
        exit;
    }
    // ============================================================
// CREATE_TEMA: crear un nuevo tema
// ============================================================
if ($action === "create_tema") {

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data["titulo"] || !$data["contenido"]) {
        echo json_encode(["success" => false, "error" => "Faltan datos"]);
        exit;
    }

    $sql = "INSERT INTO foro_temas (usuario_id, titulo, contenido, fecha)
            VALUES (:usuario_id, :titulo, :contenido, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":usuario_id" => $_SESSION["user_id"],
        ":titulo" => $data["titulo"],
        ":contenido" => $data["contenido"]
    ]);

    echo json_encode(["success" => true, "message" => "Tema creado correctamente"]);
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
