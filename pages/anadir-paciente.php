<?php
require_once "../middleware/session.php";

// Solo familiares o cuidadores
if (!isset($_SESSION["rol"]) || !in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /pages/dashboard.php");
    exit();
}

require_once __DIR__ . "/../models/bbdd.php";

$db = new Database();
$conn = $db->connect();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir paciente</title>

    <!-- CSS globales -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/panel-familiar.css">
</head>

<body>

<?php include "../includes/header.php"; ?>

<!-- MENÚ FAMILIAR -->
<?php include "../includes/menu-familiar.php"; ?>
<?php include "../includes/responsive-menu.php"; ?>
<?php include "../includes/private-banner.php"; ?>

<button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

<div class="panel-familiar-container form-container">
    <h2 class="text-center">Añadir paciente</h2>

    <form action="/pages/registro_familiar.php" method="GET">
        <p class="text-center">
            Para vincular un paciente, usa el formulario de <strong>“Vincular Paciente”</strong>.
        </p>
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary w-100">
                Ir a vincular paciente
            </button>
        </div>
    </form>
</div>

<?php include "../includes/footer.php"; ?>

<script src="/assets/js/theme.js"></script>

</body>
</html>
