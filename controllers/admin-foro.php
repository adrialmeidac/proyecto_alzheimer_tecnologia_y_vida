<?php
require_once __DIR__ . "/../middleware/admin.php";
require_once __DIR__ . "/../models/bbdd.php";
$db = new Database();
$conn = $db->connect();

header("Content-Type: application/json; charset=UTF-8");

$action = $_GET["action"] ?? null;

$input = json_decode(file_get_contents("php://input"), true) ?? [];

switch ($action) {

    case "get_temas":

        try {
            $sql = "
                SELECT 
                    t.id,
                    t.titulo,
                    t.fecha,
                    u.nombre,
                    u.apellidos,
                    COUNT(r.id) AS respuestas
                FROM foro_temas t
                JOIN usuarios u ON t.usuario_id = u.id
                LEFT JOIN foro_respuestas r ON r.tema_id = t.id
                GROUP BY t.id, t.titulo, t.fecha, u.nombre, u.apellidos
                ORDER BY t.fecha DESC
            ";

            $stmt = $conn->query($sql);
            $temas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(["success" => true, "temas" => $temas]);
            exit;

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["success" => false, "error" => "Error interno: " . $e->getMessage()]);
            exit;
        }


    case "get_tema":

        $id = $_GET["id"] ?? null;

        if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "ID inválido"]);
            exit;
        }

        $stmt = $conn->prepare("
            SELECT t.*, u.nombre, u.apellidos
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

        echo json_encode(["success" => true, "tema" => $tema]);
        exit;


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

  
    case "delete_tema":

        $id = $input["id"] ?? null;

        if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "ID inválido"]);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM foro_respuestas WHERE tema_id = :id");
        $stmt->execute([":id" => $id]);

  
        $stmt = $conn->prepare("DELETE FROM foro_temas WHERE id = :id");
        $stmt->execute([":id" => $id]);

        if ($stmt->rowCount() === 0) {
            http_response_code(404);
            echo json_encode(["success" => false, "error" => "Tema no encontrado"]);
            exit;
        }

        echo json_encode(["success" => true, "message" => "Tema eliminado correctamente"]);
        exit;

 
    case "delete_respuesta":

        $id = $input["id"] ?? null;

        if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "ID inválido"]);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM foro_respuestas WHERE id = :id");
        $stmt->execute([":id" => $id]);

        if ($stmt->rowCount() === 0) {
            http_response_code(404);
            echo json_encode(["success" => false, "error" => "Respuesta no encontrada"]);
            exit;
        }

        echo json_encode(["success" => true, "message" => "Respuesta eliminada"]);
        exit;

   
    default:
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "Acción no válida"]);
        exit;
}
