<?php require_once "../middleware/session.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Actividades</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/historial.css">
    <link rel="stylesheet" href="/assets/css/actividades.css">
    <link rel="stylesheet" href="/assets/css/timer.css">
</head>

<body>

    <!-- HEADER -->
    <?php include '../includes/header.php'; ?>

    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <!-- MENÚ PRIVADO -->
    <?php include '../includes/private-menu.php'; ?>

    <!-- MENÚ RESPONSIVE -->
    <?php include '../includes/responsive-menu.php'; ?>

    <!-- BANNER PRIVADO -->
    <?php include '../includes/private-banner.php'; ?>

    <p class="subtitle">Actividades completadas recientemente</p>

    <div class="filters">
        <label>Filtrar por:</label>
        <button class="filter-btn" data-filter="hoy">Hoy</button>
        <button class="filter-btn" data-filter="semana">Esta semana</button>
        <button class="filter-btn" data-filter="hora">Última hora</button>
        <button class="filter-btn" data-filter="todos">Todos</button>
    </div>

    <main class="activities-container">

        <button id="clearHistoryBtn" class="main-btn" style="margin-bottom:20px;">
            Borrar historial
        </button>

        <ul id="historialList" class="historial-list"></ul>

    </main>

    <div class="text-center mt-4">
        <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/dashboard.php'">
            Volver
        </button>
    </div>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/historial.js"></script>

</body>

</html>
