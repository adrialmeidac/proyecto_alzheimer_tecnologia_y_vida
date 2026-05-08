<?php
header("Content-Type: application/json");
require_once "../middleware/admin.php"; // Seguridad unificada
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$action = $_GET["action"] ?? null;

switch ($action) {

    // ---------------------------------------------------------
    // LISTAR CONTENIDO
    // ---------------------------------------------------------
    case "listar":

        $sql = $conn->prepare("
            SELECT id, titulo, descripcion, archivo, categoria, creado_en
            FROM contenido
            ORDER BY creado_en DESC
        ");
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "contenido" => $data]);
        break;

    // ---------------------------------------------------------
    // CREAR CONTENIDO
    // ---------------------------------------------------------
    case "crear":

        if (!isset($_POST["titulo"], $_POST["descripcion"], $_FILES["archivo"])) {
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
            exit;
        }

        $titulo = trim($_POST["titulo"]);
        $descripcion = trim($_POST["descripcion"]);

        // Validar archivo
        $file = $_FILES["archivo"];

        if ($file["error"] !== 0) {
            echo json_encode(["success" => false, "error" => "Error al subir archivo"]);
            exit;
        }

        // Validar tipo MIME
        $mime = mime_content_type($file["tmp_name"]);
        if ($mime !== "application/pdf") {
            echo json_encode(["success" => false, "error" => "Solo se permiten archivos PDF"]);
            exit;
        }

        // Validar tamaño (máx 10MB)
        if ($file["size"] > 10 * 1024 * 1024) {
            echo json_encode(["success" => false, "error" => "El PDF es demasiado grande"]);
            exit;
        }

        // Carpeta segura
        $uploadDir = "../uploads/contenido/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        // Nombre seguro
        $nombrePDF = time() . "-" . preg_replace("/[^a-zA-Z0-9\.\-_]/", "", basename($file["name"]));
        $rutaPDF = $uploadDir . $nombrePDF;

        if (!move_uploaded_file($file["tmp_name"], $rutaPDF)) {
            echo json_encode(["success" => false, "error" => "Error al guardar PDF"]);
            exit;
        }

        // Guardar en BD
        $sql = $conn->prepare("
            INSERT INTO contenido (titulo, descripcion, archivo)
            VALUES (:t, :d, :a)
        ");
        $sql->execute([
            ":t" => $titulo,
            ":d" => $descripcion,
            ":a" => "/uploads/contenido/" . $nombrePDF
        ]);

        echo json_encode(["success" => true, "message" => "Contenido creado"]);
        break;

    // ---------------------------------------------------------
    // EDITAR CONTENIDO
    // ---------------------------------------------------------
    case "editar":

        if (!isset($_POST["id"], $_POST["titulo"], $_POST["descripcion"])) {
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
            exit;
        }

        $id = $_POST["id"];
        $titulo = trim($_POST["titulo"]);
        $descripcion = trim($_POST["descripcion"]);

        // Obtener registro actual
        $sql = $conn->prepare("SELECT archivo FROM contenido WHERE id = :id");
        $sql->execute([":id" => $id]);
        $actual = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$actual) {
            echo json_encode(["success" => false, "error" => "Contenido no encontrado"]);
            exit;
        }

        $archivoFinal = $actual["archivo"];

        // Si sube un nuevo PDF
        if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] === 0) {

            // Validar tipo MIME
            $mime = mime_content_type($_FILES["archivo"]["tmp_name"]);
            if ($mime !== "application/pdf") {
                echo json_encode(["success" => false, "error" => "Solo se permiten archivos PDF"]);
                exit;
            }

            // Borrar PDF anterior
            $rutaAnterior = ".." . $actual["archivo"];
            if (file_exists($rutaAnterior)) unlink($rutaAnterior);

            // Subir nuevo PDF
            $uploadDir = "../uploads/contenido/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $nombrePDF = time() . "-" . preg_replace("/[^a-zA-Z0-9\.\-_]/", "", basename($_FILES["archivo"]["name"]));
            $rutaPDF = $uploadDir . $nombrePDF;

            move_uploaded_file($_FILES["archivo"]["tmp_name"], $rutaPDF);

            $archivoFinal = "/uploads/contenido/" . $nombrePDF;
        }

        // Actualizar BD
        $sql = $conn->prepare("
            UPDATE contenido 
            SET titulo = :t, descripcion = :d, archivo = :a 
            WHERE id = :id
        ");
        $sql->execute([
            ":t" => $titulo,
            ":d" => $descripcion,
            ":a" => $archivoFinal,
            ":id" => $id
        ]);

        echo json_encode(["success" => true, "message" => "Contenido actualizado"]);
        break;

    // ---------------------------------------------------------
    // ELIMINAR CONTENIDO
    // ---------------------------------------------------------
    case "eliminar":

        if (!isset($_POST["id"])) {
            echo json_encode(["success" => false, "error" => "ID no recibido"]);
            exit;
        }

        $id = $_POST["id"];

        // Obtener archivo
        $sql = $conn->prepare("SELECT archivo FROM contenido WHERE id = :id");
        $sql->execute([":id" => $id]);
        $data = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            echo json_encode(["success" => false, "error" => "Contenido no encontrado"]);
            exit;
        }

        // Borrar archivo físico
        $ruta = ".." . $data["archivo"];
        if (file_exists($ruta)) unlink($ruta);

        // Borrar BD
        $sql = $conn->prepare("DELETE FROM contenido WHERE id = :id");
        $sql->execute([":id" => $id]);

        echo json_encode(["success" => true, "message" => "Contenido eliminado"]);
        break;

    default:
        echo json_encode(["success" => false, "error" => "Acción no válida"]);
}
