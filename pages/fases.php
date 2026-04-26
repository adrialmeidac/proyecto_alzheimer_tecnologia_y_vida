<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fases de la enfermedad</title>

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

        <p class="subtitle">Fases de la enfermedad</p>

        <section class="content-block">
            <h3>Fase leve</h3>
            <ul>
                <li>Dificultad para recordar eventos recientes</li>
                <li>Perdida de objetos</li>
                <li>Dificultad para realizar tareas cotidianas</li>
                <li>Alteraciones sutiles en la personalidad</li>
            </ul>
            <h3>Fase moderada</h3>
            <ul>
                <li>Aumento de la confusión y desorientación</li>
                <li>Dificultad para reconocer a familiares y amigos</li>
                <li>Alteraciones de sueño y comportamiento</li>
                <li>Necesidad de supervisión</li>
            </ul>
            <h3>Fase avanzada</h3>
            <ul>
                <li> Pérdida de memoria a largo plazo</li>
                <li>Dependencia total</li>
                <li>Dificultad para hablar o caminar</li>
                <li> Necesidad de asistencia constante</li>
                <li>Problemas para tragar </li>
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
