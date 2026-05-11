<?php
header("Content-Type: application/json");
require_once "../middleware/admin.php";
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$action = $_GET["action"] ?? ($_POST["action"] ?? null);

if (!$action) {
    echo json_encode(["success" => false, "error" => "Acción no especificada"]);
    exit;
}

try {

    
    
    
    if ($action === "get") {

        $id = $_GET["id"] ?? null;

        if (!$id) {
            echo json_encode(["success" => false, "error" => "ID no especificado"]);
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM profesionales WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            echo json_encode(["success" => false, "error" => "Profesional no encontrado"]);
            exit;
        }

        echo json_encode(["success" => true, "profesional" => $data]);
        exit;
    }

    
    
    
    if ($action === "listar") {

        $stmt = $conn->prepare("
            SELECT *
            FROM profesionales
            ORDER BY nombre ASC
        ");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "profesionales" => $data]);
        exit;
    }

    
    
    
    if ($action === "crear") {

        
        $servicios = isset($_POST["servicios"])
            ? implode(", ", $_POST["servicios"])
            : null;

        
        $fotoFinal = null;

        if (!empty($_FILES["foto"]["name"])) {
            $uploadDir = "../uploads/profesionales/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $nombreFoto = time() . "-" . basename($_FILES["foto"]["name"]);
            $rutaFoto = $uploadDir . $nombreFoto;

            move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaFoto);

            $fotoFinal = "/uploads/profesionales/" . $nombreFoto;
        }

        $sql = $conn->prepare("
            INSERT INTO profesionales 
            (nombre, especialidad, direccion, servicios,
             horario_lunes, horario_martes, horario_miercoles,
             horario_jueves, horario_viernes, foto)
            VALUES
            (:nombre, :especialidad, :direccion, :servicios,
             :lunes, :martes, :miercoles, :jueves, :viernes, :foto)
        ");

        $sql->execute([
            ":nombre" => $_POST["nombre"],
            ":especialidad" => $_POST["especialidad"],
            ":direccion" => $_POST["direccion"],
            ":servicios" => $servicios,
            ":lunes" => $_POST["horario_lunes"] ?? null,
            ":martes" => $_POST["horario_martes"] ?? null,
            ":miercoles" => $_POST["horario_miercoles"] ?? null,
            ":jueves" => $_POST["horario_jueves"] ?? null,
            ":viernes" => $_POST["horario_viernes"] ?? null,
            ":foto" => $fotoFinal
        ]);

        echo json_encode(["success" => true, "message" => "Profesional creado"]);
        exit;
    }

    
    
    
    if ($action === "editar") {

        $id = $_POST["id"];

        
        $stmt = $conn->prepare("SELECT foto FROM profesionales WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $actual = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$actual) {
            echo json_encode(["success" => false, "error" => "Profesional no encontrado"]);
            exit;
        }

        
        $servicios = isset($_POST["servicios"])
            ? implode(", ", $_POST["servicios"])
            : null;

        
        $fotoFinal = $actual["foto"];

        if (!empty($_FILES["foto"]["name"])) {

            
            if ($fotoFinal && file_exists(".." . $fotoFinal)) {
                unlink(".." . $fotoFinal);
            }

            $uploadDir = "../uploads/profesionales/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $nombreFoto = time() . "-" . basename($_FILES["foto"]["name"]);
            $rutaFoto = $uploadDir . $nombreFoto;

            move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaFoto);

            $fotoFinal = "/uploads/profesionales/" . $nombreFoto;
        }

        $sql = $conn->prepare("
            UPDATE profesionales SET
                nombre = :nombre,
                especialidad = :especialidad,
                direccion = :direccion,
                servicios = :servicios,
                horario_lunes = :lunes,
                horario_martes = :martes,
                horario_miercoles = :miercoles,
                horario_jueves = :jueves,
                horario_viernes = :viernes,
                foto = :foto
            WHERE id = :id
        ");

        $sql->execute([
            ":id" => $id,
            ":nombre" => $_POST["nombre"],
            ":especialidad" => $_POST["especialidad"],
            ":direccion" => $_POST["direccion"],
            ":servicios" => $servicios,
            ":lunes" => $_POST["horario_lunes"] ?? null,
            ":martes" => $_POST["horario_martes"] ?? null,
            ":miercoles" => $_POST["horario_miercoles"] ?? null,
            ":jueves" => $_POST["horario_jueves"] ?? null,
            ":viernes" => $_POST["horario_viernes"] ?? null,
            ":foto" => $fotoFinal
        ]);

        echo json_encode(["success" => true, "message" => "Profesional actualizado"]);
        exit;
    }

    
    
    
    if ($action === "eliminar") {

        $id = $_GET["id"] ?? $_POST["id"];

        
        $stmt = $conn->prepare("SELECT foto FROM profesionales WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data && $data["foto"] && file_exists(".." . $data["foto"])) {
            unlink(".." . $data["foto"]);
        }

        $sql = $conn->prepare("DELETE FROM profesionales WHERE id = :id");
        $sql->execute([":id" => $id]);

        echo json_encode(["success" => true, "message" => "Profesional eliminado"]);
        exit;
    }

    echo json_encode(["success" => false, "error" => "Acción no válida"]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
