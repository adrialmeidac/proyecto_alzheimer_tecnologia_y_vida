<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estimulación cognitiva</title>

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

        <p class="subtitle">Estimulación cognitiva</p>

        <section class="content-block">
            <p>Es necesario realizar actividades de estimulación cognitiva 
                para mantener la salud mental y el bienestar de las personas 
                con demencia.</p>
                <h3>Actividades recomendadas</h3>
                <ul>
                    <li>Juegos de memoria</li>
                    <li>Rompecabezas</li>
                    <li>Lectura de libros o revistas</li>
                    <li>Escuchar música</li>
                    <li>Realizar manualidades</li>
                    <li>Participar en actividades sociales</li>
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
