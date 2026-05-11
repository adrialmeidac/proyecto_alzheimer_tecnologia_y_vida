<?php require_once "../middleware/session-public.php"?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundaciones</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/menu.css">   
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
</head>

<body>

    
    <?php include '../includes/header.php'; ?>

    
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    
    <?php
    if (!isset($_SESSION["user_id"])) {
        include '../includes/public-menu.php';
    } elseif ($_SESSION["rol"] === "admin") {
        include '../includes/menu-admin.php';
    } else {
        include '../includes/private-menu.php';
    }
    ?>

    
    <?php include '../includes/responsive-menu.php'; ?>

    
    <?php include '../includes/public-banner.php'; ?>

    <h2 class="text-center mt-5">Fundaciones</h2>

    <div class="container mt-4">

        <h2>Fundaciones de apoyo para personas con Alzheimer</h2>

        <p><strong>Fundación Alzheimer España ALZFAE</strong></p>

        <p>Contacto: Telef. 913.431 165</p><br>
        <p>Dirección: Av. Daroca, 80. Madrid, España.</p><br>

                <p><strong>Fundación Pasqual Maragall</strong></p>

        <p>Contacto: Telef. 933.263 190</p><br>
        <p>Dirección: Wellington, 30. Barcelona, España.</p><br>

                        <p><strong>Confederación Española de Alzheimer CEAFA</strong></p>

        <p>Contacto: Telef. 948.174 517</p><br>
        <p>Dirección: Calle Pedro Alcatarena, 3 Bajo. Pamplona, España.</p><br>


        
        <div class="text-center mt-4">
            <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/index.php'">
                Volver
            </button>
        </div>

    </div>

    
    <?php include '../includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>

</body>
</html>
