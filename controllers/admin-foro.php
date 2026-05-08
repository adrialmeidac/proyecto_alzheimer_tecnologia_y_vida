<?php
header("Content-Type: application/json");

require_once "../middleware/admin.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/models/bbdd.php";

// Leer acción desde GET o JSON
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

        // ============================================================
        // GET_TEMAS
        // ============================================================
        case "get_temas":

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


        // ============================================================
        // GET_TEMA
        // ============================================================
        case "get_tema":

            $id = $_GET["id"] ?? null;

            if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
                http_response_code(400);
                echo json_encode(["success" => false, "error" => "ID inválido"]);
                exit;
            }

            $id = (int)$id;

            // Tema
            $stmt = $conn->prepare("
                SELECT t.*, u.nombre, u.apellido
                FROM foro_temas t
                JOIN usuarios u ON t.usuario_id = u.id
                WHERE t.id = :id
            ");
            $stmt->execute([":id" => $id]);
            $tema = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$tema) {
                http_response_code(404);
                echo json_encode(["success" => false, "error" => "Tema no encontrado"]);
                exit;
            }

            // Respuestas
            $stmt = $conn->prepare("
                SELECT r.*, u.nombre, u.apellido
                FROM foro_respuestas r
                JOIN usuarios u ON r.usuario_id = u.id
                WHERE r.tema_id = :id
                ORDER BY r.fecha ASC
            ");
            $stmt->execute([":id" => $id]);
            $respuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                "success" => true,
                "tema" => $tema,
                "respuestas" => $respuestas
            ]);
            exit;


        // ============================================================
        // DELETE_TEMA
        // ============================================================
        case "delete_tema":

            $id = $input["id"] ?? null;

            if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
                http_response_code(400);
                echo json_encode(["success" => false, "error" => "ID inválido"]);
                exit;
            }

            $id = (int)$id;

            // Verificar existencia
            $stmt = $conn->prepare("SELECT id FROM foro_temas WHERE id = :id");
            $stmt->execute([":id" => $id]);

            if (!$stmt->fetch()) {
                http_response_code(404);
                echo json_encode(["success" => false, "error" => "Tema no encontrado"]);
                exit;
            }

            // Borrar respuestas
            $stmt = $conn->prepare("DELETE FROM foro_respuestas WHERE tema_id = :id");
            $stmt->execute([":id" => $id]);

            // Borrar tema
            $stmt = $conn->prepare("DELETE FROM foro_temas WHERE id = :id");
            $stmt->execute([":id" => $id]);

            echo json_encode(["success" => true, "message" => "Tema y respuestas eliminados"]);
            exit;


        // ============================================================
        // DELETE_RESPUESTA
        // ============================================================
        case "delete_respuesta":

            $id = $input["id"] ?? null;

            if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
                http_response_code(400);
                echo json_encode(["success" => false, "error" => "ID inválido"]);
                exit;
            }

            $id = (int)$id;

            $stmt = $conn->prepare("DELETE FROM foro_respuestas WHERE id = :id");
            $stmt->execute([":id" => $id]);

            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(["success" => false, "error" => "Respuesta no encontrada"]);
                exit;
            }

            echo json_encode(["success" => true, "message" => "Respuesta eliminada"]);
            exit;


        // ============================================================
        // CREATE_TEMA
        // ============================================================
        case "create_tema":

            $titulo = trim($input["titulo"] ?? "");
            $contenido = trim($input["contenido"] ?? "");

            if (!$titulo || !$contenido) {
                http_response_code(400);
                echo json_encode(["success" => false, "error" => "Faltan datos"]);
                exit;
            }

            $stmt = $conn->prepare("
                INSERT INTO foro_temas (usuario_id, titulo, contenido, fecha)
                VALUES (:usuario_id, :titulo, :contenido, NOW())
            ");

            $stmt->execute([
                ":usuario_id" => $_SESSION["user_id"],
                ":titulo" => $titulo,
                ":contenido" => $contenido
            ]);

            echo json_encode(["success" => true, "message" => "Tema creado correctamente"]);
            exit;


        // ============================================================
        // ACCIÓN NO VÁLIDA
        // ============================================================
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
