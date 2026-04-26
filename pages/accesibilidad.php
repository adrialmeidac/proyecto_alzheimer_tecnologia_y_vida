<?php require_once "../middleware/session-public.php"?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesibilidad</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/politicas.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
</head>

<body>

    <!-- HEADER -->
    <?php include '../includes/header.php'; ?>

    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <!-- MENÚ SEGÚN SESIÓN -->
    <?php
    if (!isset($_SESSION["user_id"])) {
        include '../includes/public-menu.php';
    } elseif ($_SESSION["rol"] === "admin") {
        include '../includes/menu-admin.php';
    } else {
        include '../includes/private-menu.php';
    }
    ?>

    <!-- MENÚ RESPONSIVE -->
    <?php include '../includes/responsive-menu.php'; ?>

    <!-- BANNER PÚBLICO -->
    <?php include '../includes/public-banner.php'; ?>

    <h2 class="text-center mt-5">Accesibilidad</h2>

    <div class="container mt-4">

        <h2>Políticas de Accesibilidad - Alzheimer, tecnología y vida</h2>

        <p><strong>Política de Accesibilidad – Alzheimer, Tecnología y Vida</strong></p>

        <p><strong>1. Compromiso de accesibilidad</strong><br>
        Este sitio web se compromete a garantizar la accesibilidad de sus contenidos para todas las personas, independientemente de sus capacidades o del dispositivo utilizado.</p>

        <p><strong>2. Medidas adoptadas</strong><br>
        Este sitio web:<br>
        • Utiliza una estructura clara y navegación sencilla<br>
        • Incluye textos alternativos en imágenes cuando es posible<br>
        • Mantiene un diseño adaptable a distintos dispositivos (responsive)<br>
        • Procura un contraste adecuado entre texto y fondo</p>

        <p><strong>3. Limitaciones</strong><br>
        A pesar de nuestros esfuerzos, algunos contenidos pueden no ser completamente accesibles. Trabajamos continuamente para mejorar la experiencia de todos los usuarios.</p>

        <p><strong>4. Contacto</strong><br>
        Si encuentras dificultades de acceso o deseas hacer alguna sugerencia, puedes ponerte en contacto con nosotros a través del correo electrónico indicado en el sitio web.</p>

        <p><strong>5. Actualización</strong><br>
        La presente política de accesibilidad puede ser actualizada para reflejar mejoras o cambios en el sitio web.</p>

        <!-- BOTÓN VOLVER -->
        <div class="text-center mt-4">
            <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/index.php'">
                Volver
            </button>
        </div>

    </div>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>

</body>
</html>
