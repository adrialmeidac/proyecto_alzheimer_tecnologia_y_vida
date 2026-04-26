<?php require_once "../middleware/session-public.php"?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Políticas de Privacidad</title>

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

    <h2 class="text-center mt-5">Políticas de Privacidad</h2>

    <div class="container mt-4">

        <h2>Políticas de Privacidad - Alzheimer, tecnología y vida</h2>

        <p>
            En esta sección se detallan las políticas de privacidad de nuestro sitio web.  
            Nos comprometemos a proteger la información personal de nuestros usuarios y 
            a garantizar la seguridad de sus datos. A continuación, se describen los aspectos
            clave de nuestras políticas de privacidad:
        </p>

        <p><strong>1. Información que recopilamos</strong></p>
        <p>
            Recopilamos información personal únicamente cuando es proporcionada de forma voluntaria por los usuarios, como:
            <br>• Nombre y correo electrónico (formularios de contacto o suscripción)
            <br>• Información proporcionada en comentarios o mensajes
            <br>• Datos de navegación (dirección IP, tipo de navegador, páginas visitadas)
        </p>

        <p><strong>2. Uso de la información</strong></p>
        <p>
            La información recopilada se utiliza para:
            <br>• Responder consultas o solicitudes de los usuarios
            <br>• Mejorar el contenido y funcionamiento del sitio web
            <br>• Enviar información relevante relacionada con Alzheimer, tecnología y bienestar (solo si el usuario lo autoriza)
            <br>• Garantizar la seguridad y correcto funcionamiento del sitio
        </p>

        <p><strong>3. Protección de datos</strong></p>
        <p>
            Adoptamos medidas técnicas y organizativas adecuadas para proteger la información personal contra accesos no autorizados, pérdida o alteración.  
            Sin embargo, ningún sistema en Internet es completamente seguro, por lo que no podemos garantizar una seguridad absoluta.
        </p>

        <p><strong>4. Uso de cookies</strong></p>
        <p>
            Nuestro sitio web puede utilizar cookies para mejorar la experiencia del usuario. Estas cookies permiten:
            <br>• Recordar preferencias de navegación
            <br>• Analizar el uso del sitio
            <br>• Optimizar el rendimiento
            <br><br>
            El usuario puede configurar su navegador para rechazar las cookies si lo desea.
        </p>

        <p><strong>5. Compartición de la información</strong></p>
        <p>
            No vendemos ni compartimos la información personal de los usuarios con terceros, salvo en los siguientes casos:
            <br>• Cuando sea requerido por ley
            <br>• Para proteger los derechos y seguridad del sitio web
            <br>• Con proveedores de servicios que nos ayudan a operar el sitio (bajo acuerdos de confidencialidad)
        </p>

        <p><strong>6. Enlaces a terceros</strong></p>
        <p>
            Nuestro sitio puede contener enlaces a páginas externas.  
            No somos responsables de las políticas de privacidad ni del contenido de dichos sitios.
        </p>

        <p><strong>7. Derechos del usuario</strong></p>
        <p>
            Los usuarios tienen derecho a:
            <br>• Acceder a sus datos personales  
            <br>• Solicitar la corrección o eliminación de sus datos  
            <br>• Retirar su consentimiento en cualquier momento  
            <br><br>
            Para ejercer estos derechos, pueden contactarnos a través del correo electrónico proporcionado en el sitio.
        </p>

        <p><strong>8. Cambios en la política de privacidad</strong></p>
        <p>
            Nos reservamos el derecho de modificar estas políticas en cualquier momento.  
            Cualquier cambio será publicado en esta misma sección.
        </p>

        <p><strong>9. Contacto</strong></p>
        <p>
            Si tienes preguntas sobre estas políticas de privacidad, puedes ponerte en contacto con nosotros a través de los medios indicados en el sitio web.
        </p>

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
