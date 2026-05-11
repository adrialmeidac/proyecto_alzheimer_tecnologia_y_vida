<?php
header("Content-Type: application/json");
require_once "../middleware/admin.php";
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$action = $_GET["action"] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

if (!$action) {
    echo json_encode(["success" => false, "error" => "Acción no especificada"]);
    exit;
}

try {

    
    
    
    if ($action === "listar") {

        $stmt = $conn->prepare("SELECT id, nombre, email, rol FROM usuarios ORDER BY id ASC");
        $stmt->execute();

        echo json_encode([
            "success" => true,
            "usuarios" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ]);
        exit;
    }

    
    
    
    if ($action === "crear") {

        if (!isset($data["nombre"], $data["email"], $data["password"], $data["rol"])) {
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
            exit;
        }

        
        if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["success" => false, "error" => "Email inválido"]);
            exit;
        }

        
        $rolesValidos = ["paciente", "familiar", "cuidador", "admin"];
        if (!in_array($data["rol"], $rolesValidos)) {
            echo json_encode(["success" => false, "error" => "Rol inválido"]);
            exit;
        }

        
        if (strlen($data["password"]) < 6) {
            echo json_encode(["success" => false, "error" => "La contraseña debe tener al menos 6 caracteres"]);
            exit;
        }

        
        $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $check->execute([$data["email"]]);

        if ($check->fetch()) {
            echo json_encode(["success" => false, "error" => "El email ya está registrado"]);
            exit;
        }

        
        $stmt = $conn->prepare("
            INSERT INTO usuarios (nombre, email, password, rol)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $data["nombre"],
            $data["email"],
            password_hash($data["password"], PASSWORD_DEFAULT),
            $data["rol"]
        ]);

        echo json_encode(["success" => true, "message" => "Usuario creado"]);
        exit;
    }

    
    
    
    if ($action === "obtener") {

        $stmt = $conn->prepare("SELECT id, nombre, email, rol FROM usuarios WHERE id = ?");
        $stmt->execute([$data["id"]]);

        echo json_encode([
            "success" => true,
            "usuario" => $stmt->fetch(PDO::FETCH_ASSOC)
        ]);
        exit;
    }

    
    
    
    if ($action === "editar") {

        if (!isset($data["id"], $data["nombre"], $data["email"], $data["rol"])) {
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
            exit;
        }

        
        if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["success" => false, "error" => "Email inválido"]);
            exit;
        }

        
        $rolesValidos = ["paciente", "familiar", "cuidador", "admin"];
        if (!in_array($data["rol"], $rolesValidos)) {
            echo json_encode(["success" => false, "error" => "Rol inválido"]);
            exit;
        }

        
        $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
        $check->execute([$data["email"], $data["id"]]);

        if ($check->fetch()) {
            echo json_encode(["success" => false, "error" => "El email ya está registrado por otro usuario"]);
            exit;
        }

        $stmt = $conn->prepare("
            UPDATE usuarios 
            SET nombre = ?, email = ?, rol = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $data["nombre"],
            $data["email"],
            $data["rol"],
            $data["id"]
        ]);

        echo json_encode(["success" => true, "message" => "Usuario actualizado"]);
        exit;
    }

    
    
    
    if ($action === "eliminar") {

        if ($data["id"] == $_SESSION["user_id"]) {
            echo json_encode(["success" => false, "error" => "No puedes eliminar tu propia cuenta"]);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$data["id"]]);

        echo json_encode(["success" => true, "message" => "Usuario eliminado"]);
        exit;
    }

    echo json_encode(["success" => false, "error" => "Acción no válida"]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "error" => "Error interno del servidor",
        "detalle" => $e->getMessage()
    ]);
}
