<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colaborativos</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
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

    
    <?php include '../includes/header.php'; ?>

    
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    
    <?php include '../includes/public-menu.php'; ?>

    
    <?php include '../includes/responsive-menu.php'; ?>

    
    <?php include '../includes/public-banner.php'; ?>

    <main class="container mt-4">

        <p class="subtitle">Cuidados colaborativos</p>

        <section class="content-block">
            <p>Compartir responsabilidades y apoyarse mutuamente es fundamental para el bienestar de los cuidadores y las personas con demencia.</p>
            <h3>Importancia de la colaboración</h3>
            <ul>
                <li>Reduce la carga emocional y física del cuidador principal</li>
                <li>Mejora la calidad de vida de la persona con demencia</li>
                <li>Fomenta un ambiente de apoyo y comprensión</li>
            </ul>
            <h3>Formas de colaborar</h3>
            <ul>
                <li>Compartir tareas de cuidado entre familiares y amigos</li>
                <li>Buscar ayuda profesional cuando sea necesario</li>
                <li>Participar en grupos de apoyo para cuidadores</li>
                <li>Fomentar la comunicación abierta entre todos los involucrados</li>
            </ul>
        </section>

    </main>

    
    <?php include '../includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
