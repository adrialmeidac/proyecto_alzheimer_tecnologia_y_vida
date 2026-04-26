<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . "/../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

// Solo familiares pueden añadir pacientes
if ($_SESSION['rol'] !== 'familiar') {
    echo "No tienes permisos para añadir pacientes.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Paciente</title>

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
</head>

<body>

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu.php"; ?>
    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<div class="contenedor-notificaciones">
    <h1 class="titulo-notificaciones">➕ Añadir paciente</h1>

    <form action="../controllers/guardar_relacion.php" method="POST">
        <label for="email">Email del paciente:</label>
        <input type="email" name="email" required>

        <label for="tipo_relacion">Relación:</label>
        <input type="text" name="tipo_relacion" placeholder="hijo, hija, cuidador, etc.">

        <button type="submit" class="btn-leida">Añadir paciente</button>
    </form>
</div>

</body>
</html>
