<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sueño de las Personas con Demencia</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/public-page.css">

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400&display=swap" rel="stylesheet">
</head>

<body>

    <!-- HEADER -->
    <?php include '../includes/header.php'; ?>

    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <!-- MENÚ PÚBLICO -->
    <?php include '../includes/public-menu.php'; ?>

    <!-- MENÚ RESPONSIVE -->
    <?php include '../includes/responsive-menu.php'; ?>

    <!-- BANNER PÚBLICO -->
    <?php include '../includes/public-banner.php'; ?>

    <main class="container mt-4">

        <p class="subtitle">Sueño y descanso</p>

        <section class="content-block">
            <p>El sueño es una necesidad fundamental para el bienestar físico y mental
                de las personas, especialmente aquellas con demencia.</p>
            <h3>Problemas de sueño comunes en la demencia</h3>
            <ul>
                <li>Insomnio</li>
                <li>Despertares nocturnos</li>
                <li>Somnolencia diurna</li>
                <li>Alteraciones del ritmo circadiano</li>
            </ul>
            <h3>Consejos para mejorar el sueño</h3>
            <ul>
                <li>Establecer una rutina de sueño regular</li>
                <li>Crear un ambiente de sueño cómodo y tranquilo</li>
                <li>Limitar el consumo de cafeína y alcohol</li>
                <li>Realizar actividad física durante el día</li>
                <li>Evitar el uso de dispositivos electrónicos antes de dormir</li>
                <li>Consultar con un profesional de la salud para tratar problemas de sueño</li>
            </ul>
        </section>

    </main>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
