<?php
require_once "../models/bbdd.php";
session_start();

header("Content-Type: application/json");

// Verificar sesión
if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

// ID del usuario
$userId = $_SESSION["user_id"];

// ID REAL del paciente (si existe)
$pacienteId = $_SESSION["paciente_id"] ?? $userId;

$db = new Database();
$conn = $db->connect();

$action = $_GET["action"] ?? null;

switch ($action) {

    // ============================
    // 1. LISTAR ACTIVIDADES (PACIENTE + FAMILIAR)
    // ============================
    case "listar":

        // 1) Actividades creadas por el paciente
        $sql1 = $conn->prepare("
            SELECT 
                id,
                texto,
                realizada,
                hora_limite,
                notificar,
                fecha,
                'paciente' AS origen
            FROM actividades_usuario
            WHERE user_id = ?
            ORDER BY id DESC
        ");
        $sql1->execute([$userId]);
        $actividades_paciente = $sql1->fetchAll(PDO::FETCH_ASSOC);

        // 2) Actividades creadas por el familiar
        $sql2 = $conn->prepare("
            SELECT 
                id,
                descripcion AS texto,
                completada AS realizada,
                hora AS hora_limite,
                0 AS notificar,
                fecha,
                'familiar' AS origen
            FROM actividades_paciente
            WHERE paciente_id = ?
            ORDER BY id DESC
        ");
        $sql2->execute([$pacienteId]);
        $actividades_familiar = $sql2->fetchAll(PDO::FETCH_ASSOC);

        // Unir ambas listas
        $actividades = array_merge($actividades_paciente, $actividades_familiar);

        // Ordenar por fecha descendente
        usort($actividades, function($a, $b) {
            return strtotime($b["fecha"]) - strtotime($a["fecha"]);
        });

        echo json_encode([
            "success" => true,
            "actividades" => $actividades
        ]);
        break;


    // ============================
    // 2. CREAR ACTIVIDAD (CORREGIDO)
    // ============================
    case "crear":
        $data = json_decode(file_get_contents("php://input"), true);

        $texto = $data["texto"] ?? "";
        $hora = $data["hora_limite"] ?? null;
        $fecha = $data["fecha"] ?? date("Y-m-d");   // ← NUEVO
        $notificar = !empty($data["notificar"]) ? 1 : 0;

        if (strlen($texto) < 3) {
            echo json_encode(["success" => false, "error" => "El texto es demasiado corto"]);
            exit;
        }

        $sql = $conn->prepare("
            INSERT INTO actividades_usuario (user_id, texto, realizada, hora_limite, notificar, fecha)
            VALUES (?, ?, 0, ?, ?, ?)
        ");
        $sql->execute([$userId, $texto, $hora, $notificar, $fecha]);

        echo json_encode([
            "success" => true,
            "id" => $conn->lastInsertId()
        ]);
        break;


    // ============================
    // 3. ACTUALIZAR ACTIVIDAD
    // ============================
    case "actualizar":
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $data["id"] ?? null;
        $texto = $data["texto"] ?? "";
        $hora = $data["hora_limite"] ?? null;
        $notificar = !empty($data["notificar"]) ? 1 : 0;

        if (!$id) {
            echo json_encode(["success" => false, "error" => "ID no proporcionado"]);
            exit;
        }

        $sql = $conn->prepare("
            UPDATE actividades_usuario
            SET texto = ?, hora_limite = ?, notificar = ?
            WHERE id = ? AND user_id = ?
        ");
        $sql->execute([$texto, $hora, $notificar, $id, $userId]);

        echo json_encode(["success" => true]);
        break;


    // ============================
    // 4. ELIMINAR ACTIVIDAD
    // ============================
    case "eliminar":
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data["id"] ?? null;

        if (!$id) {
            echo json_encode(["success" => false, "error" => "ID no proporcionado"]);
            exit;
        }

        // Eliminar historial asociado
        $conn->prepare("
            DELETE FROM resultados 
            WHERE actividad_id = ? AND usuario_id = ?
        ")->execute([$id, $userId]);

        // Eliminar actividad
        $conn->prepare("
            DELETE FROM actividades_usuario 
            WHERE id = ? AND user_id = ?
        ")->execute([$id, $userId]);

        echo json_encode(["success" => true]);
        break;


    // ============================
    // 5. MARCAR COMO REALIZADA
    // ============================
    case "marcar_realizada":
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $data["id"] ?? null;
        $realizada = !empty($data["realizada"]) ? 1 : 0;

        if (!$id) {
            echo json_encode(["success" => false, "error" => "ID no proporcionado"]);
            exit;
        }

        // Obtener texto de la actividad
        $sql = $conn->prepare("
            SELECT texto 
            FROM actividades_usuario 
            WHERE id = ? AND user_id = ?
        ");
        $sql->execute([$id, $userId]);
        $actividad = $sql->fetch();

        if (!$actividad) {
            echo json_encode(["success" => false, "error" => "Actividad no encontrada"]);
            exit;
        }

        // Actualizar estado
        $fecha = $realizada ? date("Y-m-d H:i:s") : null;

        $sql = $conn->prepare("
            UPDATE actividades_usuario
            SET realizada = ?, fecha_complecion = ?
            WHERE id = ? AND user_id = ?
        ");
        $sql->execute([$realizada, $fecha, $id, $userId]);

        // Registrar en historial
        if ($realizada) {
            $sql = $conn->prepare("
                INSERT INTO resultados (usuario_id, tipo, fecha, detalle, actividad_id)
                VALUES (?, 'actividad', ?, ?, ?)
            ");
            $sql->execute([$userId, $fecha, $actividad["texto"], $id]);
        }

        echo json_encode(["success" => true]);
        break;


    // ============================
    // 6. LISTAR HISTORIAL
    // ============================
    case "listar_historial":
        $sql = $conn->prepare("
            SELECT *
            FROM resultados
            WHERE usuario_id = ?
            ORDER BY fecha DESC
        ");
        $sql->execute([$userId]);

        echo json_encode([
            "success" => true,
            "historial" => $sql->fetchAll(PDO::FETCH_ASSOC)
        ]);
        break;


    // ============================
    // 7. BORRAR HISTORIAL COMPLETO
    // ============================
    case "borrar_historial":
        $conn->prepare("
            DELETE FROM resultados 
            WHERE usuario_id = ?
        ")->execute([$userId]);

        echo json_encode(["success" => true]);
        break;


    // ============================
    // ACCIÓN INVÁLIDA
    // ============================
    default:
        echo json_encode(["success" => false, "error" => "Acción inválida"]);
}
