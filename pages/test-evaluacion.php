<?php require_once "../middleware/session.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación Cognitiva</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/test.css">
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

    <h1 id="tituloTest">Test Cognitivo</h1>
    <p class="subtitle" id="descripcionTest">Cargando...</p>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container test-container">

        <!-- Estímulo -->
        <section id="estimulo" class="estimulo" style="display:none;"></section>

        <!-- Pregunta -->
        <section id="pregunta" class="test-question"></section>

        <!-- Opciones -->
        <section id="opciones" class="test-options"></section>

        <!-- Botón siguiente -->
        <button class="btn btn-primary mt-4 px-4 py-2" id="btnSiguiente" style="display:none;">
            Siguiente
        </button>

    </main>

    <!-- BOTÓN VOLVER -->
    <div class="text-center mt-4">
        <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/test.php'">
            Volver
        </button>
    </div>

    <!-- FOOTER -->
    <?php include '../includes/footer.php' ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>
    <script src="../assets/js/test-evaluacion.js"></script>

</body>

</html>
