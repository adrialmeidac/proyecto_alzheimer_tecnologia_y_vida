<?php
header("Content-Type: application/json");
session_start();
require_once "../models/bbdd.php";

// Solo admin
if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

$db = new Database();
$conn = $db->connect();

$action = $_GET["action"] ?? null;

switch ($action) {

    // ---------------------------------------------------------
    // LISTAR CONTENIDO
    // ---------------------------------------------------------
    case "listar":
        $sql = $conn->query("SELECT * FROM contenido ORDER BY fecha DESC");
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

        $titulo = $_POST["titulo"];
        $descripcion = $_POST["descripcion"];

        // Subir PDF
        $file = $_FILES["archivo"];
        $nombrePDF = time() . "-" . basename($file["name"]);
        $rutaPDF = "../assets/pdf/" . $nombrePDF;

        if (!move_uploaded_file($file["tmp_name"], $rutaPDF)) {
            echo json_encode(["success" => false, "error" => "Error al subir el PDF"]);
            exit;
        }

        // Guardar en BD
        $sql = $conn->prepare("INSERT INTO contenido (titulo, descripcion, archivo) VALUES (:t, :d, :a)");
        $sql->execute([
            ":t" => $titulo,
            ":d" => $descripcion,
            ":a" => "/assets/pdf/" . $nombrePDF
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
        $titulo = $_POST["titulo"];
        $descripcion = $_POST["descripcion"];

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

            // Borrar PDF anterior
            $rutaAnterior = ".." . $actual["archivo"];
            if (file_exists($rutaAnterior)) unlink($rutaAnterior);

            // Subir nuevo PDF
            $file = $_FILES["archivo"];
            $nombrePDF = time() . "-" . basename($file["name"]);
            $rutaPDF = "../assets/pdf/" . $nombrePDF;

            move_uploaded_file($file["tmp_name"], $rutaPDF);

            $archivoFinal = "/assets/pdf/" . $nombrePDF;
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

    // ---------------------------------------------------------
    // ACCIÓN INVÁLIDA
    // ---------------------------------------------------------
    default:
        echo json_encode(["success" => false, "error" => "Acción no válida"]);
}
