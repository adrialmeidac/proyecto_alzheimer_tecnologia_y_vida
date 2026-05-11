<?php
require_once "../middleware/session.php";
require_once "../models/bbdd.php";


if (!isset($_SESSION["rol"]) || !in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    die("No tienes permisos para realizar esta acción.");
}

$db = new Database();
$conn = $db->connect();

$familiar_id = $_SESSION['user_id'];
$email = trim($_POST['email'] ?? "");
$tipo_relacion = trim($_POST['parentesco'] ?? "");


if ($email === "" || $tipo_relacion === "") {
    die("Todos los campos son obligatorios.");
}


$sql = $conn->prepare("SELECT id, rol FROM usuarios WHERE email = :email LIMIT 1");
$sql->execute([':email' => $email]);
$paciente = $sql->fetch(PDO::FETCH_ASSOC);

if (!$paciente) {
    die("No existe ningún usuario con ese email.");
}

if ($paciente['rol'] !== 'paciente') {
    die("El usuario encontrado no es un paciente.");
}

$paciente_id = $paciente['id'];


$sqlCheck = $conn->prepare("
    SELECT id FROM relaciones_familiares
    WHERE paciente_id = :paciente AND familiar_id = :familiar
");
$sqlCheck->execute([
    ':paciente' => $paciente_id,
    ':familiar' => $familiar_id
]);

if ($sqlCheck->fetch()) {
    die("Este paciente ya está vinculado contigo.");
}


$sqlInsert = $conn->prepare("
    INSERT INTO relaciones_familiares (paciente_id, familiar_id, parentesco)
    VALUES (:paciente, :familiar, :tipo)
");

$sqlInsert->execute([
    ':paciente' => $paciente_id,
    ':familiar' => $familiar_id,
    ':tipo' => $tipo_relacion
]);

header("Location: /pages/pacientes.php?vinculado=1");
exit();
