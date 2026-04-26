<?php require_once "../middleware/session-public.php"?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Políticas de Cookies</title>

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

    <h2 class="text-center mt-5">Políticas de Cookies</h2>

    <div class="container mt-4">

        <h2>Políticas de Cookies - Alzheimer, tecnología y vida</h2>

        <p><strong>Política de Cookies – Alzheimer, Tecnología y Vida</strong></p>

        <p><strong>1. ¿Qué son las cookies?</strong><br>
        Las cookies son pequeños archivos que se almacenan en el dispositivo del usuario al visitar una página web. Sirven para mejorar la experiencia de navegación y obtener información sobre el uso del sitio.</p>

        <p><strong>2. Tipos de cookies utilizadas en este sitio web</strong><br>
        <strong>Cookies técnicas:</strong> necesarias para el funcionamiento correcto del sitio web.<br>
        <strong>Cookies de análisis:</strong> permiten conocer cómo los usuarios interactúan con la web para mejorar los contenidos.<br>
        <strong>Cookies de personalización:</strong> recuerdan preferencias del usuario (idioma, configuración, etc.).</p>

        <p><strong>3. Consentimiento y gestión de cookies</strong><br>
        El usuario puede aceptar, rechazar o configurar el uso de cookies en cualquier momento a través del banner de cookies o desde su navegador.<br>
        También puede eliminar las cookies almacenadas en su dispositivo desde la configuración del navegador.</p>

        <p><strong>4. Cookies de terceros</strong><br>
        Este sitio web puede utilizar servicios de terceros (por ejemplo, herramientas de análisis) que instalan cookies en el dispositivo del usuario.</p>

        <p><strong>5. Más información</strong><br>
        Para más información sobre el tratamiento de datos personales, consulte nuestra Política de Privacidad.</p>

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
