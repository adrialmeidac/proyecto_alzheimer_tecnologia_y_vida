<?php
header("Content-Type: application/json");
require_once "../middleware/session.php";
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$action = $_GET["action"] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

$userId = $_SESSION["user_id"];
$rol = $_SESSION["rol"];

if (!$action) {
    echo json_encode(["success" => false, "error" => "Acción no especificada"]);
    exit;
}

try {

    // ============================================================
    // 1. LISTAR ACTIVIDADES DEL USUARIO
    // ============================================================
    if ($action === "listar") {

        $stmt = $conn->prepare("
            SELECT id, titulo, descripcion, fecha, hora, estado
            FROM actividades
            WHERE usuario_id = ?
            ORDER BY fecha DESC, hora ASC
        ");
        $stmt->execute([$userId]);

        echo json_encode([
            "success" => true,
            "actividades" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ]);
        exit;
    }

    // ============================================================
    // 2. CREAR ACTIVIDAD
    // ============================================================
    if ($action === "crear") {

        $titulo = $data["titulo"] ?? "";
        $descripcion = $data["descripcion"] ?? "";
        $fecha = $data["fecha"] ?? date("Y-m-d");
        $hora = $data["hora"] ?? null;

        if (strlen($titulo) < 3) {
            echo json_encode(["success" => false, "error" => "El título es demasiado corto"]);
            exit;
        }

        $stmt = $conn->prepare("
            INSERT INTO actividades (usuario_id, titulo, descripcion, fecha, hora, estado)
            VALUES (?, ?, ?, ?, ?, 'pendiente')
        ");
        $stmt->execute([$userId, $titulo, $descripcion, $fecha, $hora]);

        echo json_encode(["success" => true]);
        exit;
    }

    // ============================================================
    // 3. ACTUALIZAR ACTIVIDAD
    // ============================================================
    if ($action === "actualizar") {

        $id = $data["id"] ?? null;
        $titulo = $data["titulo"] ?? "";
        $descripcion = $data["descripcion"] ?? "";
        $hora = $data["hora"] ?? null;

        if (!$id) {
            echo json_encode(["success" => false, "error" => "ID no proporcionado"]);
            exit;
        }

        // Verificar que pertenece al usuario
        $stmt = $conn->prepare("SELECT usuario_id FROM actividades WHERE id = ?");
        $stmt->execute([$id]);
        $act = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$act || $act["usuario_id"] != $userId) {
            echo json_encode(["success" => false, "error" => "No puedes editar esta actividad"]);
            exit;
        }

        $stmt = $conn->prepare("
            UPDATE actividades
            SET titulo = ?, descripcion = ?, hora = ?
            WHERE id = ? AND usuario_id = ?
        ");
        $stmt->execute([$titulo, $descripcion, $hora, $id, $userId]);

        echo json_encode(["success" => true]);
        exit;
    }
// ============================================================
// 4. MARCAR COMO REALIZADA
// ============================================================
if ($action === "marcar_realizada") {

    $id = $data["id"] ?? null;

    if (!$id) {
        echo json_encode(["success" => false, "error" => "ID no proporcionado"]);
        exit;
    }

    // Verificar dueño
    $stmt = $conn->prepare("SELECT usuario_id, titulo FROM actividades WHERE id = ?");
    $stmt->execute([$id]);
    $act = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$act || $act["usuario_id"] != $userId) {
        echo json_encode(["success" => false, "error" => "No puedes modificar esta actividad"]);
        exit;
    }

    // Marcar como realizada
    $stmt = $conn->prepare("
        UPDATE actividades
        SET estado = 'realizada'
        WHERE id = ? AND usuario_id = ?
    ");
    $stmt->execute([$id, $userId]);

    // ============================================
    // GUARDAR EN HISTORIAL
    // ============================================
    $detalle = "Actividad realizada: " . $act["titulo"];

    $stmt = $conn->prepare("
        INSERT INTO resultados (usuario_id, juego, puntaje, fecha, detalle)
        VALUES (?, 'actividad', NULL, NOW(), ?)
    ");
    $stmt->execute([$userId, $detalle]);

    echo json_encode(["success" => true]);
    exit;
}


    // ============================================================
    // 5. ELIMINAR ACTIVIDAD
    // ============================================================
    if ($action === "eliminar") {

        $id = $data["id"] ?? null;

        if (!$id) {
            echo json_encode(["success" => false, "error" => "ID no proporcionado"]);
            exit;
        }

        // Verificar dueño
        $stmt = $conn->prepare("SELECT usuario_id FROM actividades WHERE id = ?");
        $stmt->execute([$id]);
        $act = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$act || $act["usuario_id"] != $userId) {
            echo json_encode(["success" => false, "error" => "No puedes eliminar esta actividad"]);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM actividades WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$id, $userId]);

        echo json_encode(["success" => true]);
        exit;
    }

    // ============================================================
    // 6. LISTAR HISTORIAL
    // ============================================================
    if ($action === "listar_historial") {

        $stmt = $conn->prepare("
            SELECT fecha, detalle
            FROM resultados
            WHERE usuario_id = ?
            ORDER BY fecha DESC
        ");
        $stmt->execute([$userId]);

        echo json_encode([
            "success" => true,
            "historial" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ]);
        exit;
    }

    // ============================================================
    // 7. BORRAR HISTORIAL
    // ============================================================
    if ($action === "borrar_historial") {

        $stmt = $conn->prepare("DELETE FROM resultados WHERE usuario_id = ?");
        $stmt->execute([$userId]);

        echo json_encode(["success" => true]);
        exit;
    }

    // ============================================================
    // ACCIÓN INVÁLIDA
    // ============================================================
    echo json_encode(["success" => false, "error" => "Acción inválida"]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "error" => "Error interno del servidor",
        "detalle" => $e->getMessage()
    ]);
}
