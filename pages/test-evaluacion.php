<?php require_once "../middleware/session.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación Cognitiva</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/footer.css">

    
    <link rel="stylesheet" href="/assets/css/test.css">
</head>

<body>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/header.php'; ?>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/private-menu.php'; ?>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/responsive-menu.php'; ?>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/private-banner.php'; ?>

    
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <main class="container test-container">

        <div class="text-center mt-4">
            <h1 id="tituloTest" class="section-title">Test Cognitivo</h1>
            <p class="subtitle" id="descripcionTest">Cargando...</p>
        </div>

        
        <section id="estimulo" class="estimulo" style="display:none;"></section>

        
        <section id="pregunta" class="test-question"></section>

        
        <section id="opciones" class="test-options"></section>

        
        <div class="text-center">
            <button class="btn btn-primary mt-4 px-4 py-2" id="btnSiguiente" style="display:none;">
                Siguiente
            </button>
        </div>

        
        <div id="loader" class="text-center mt-4" style="display:none;">
            <div class="spinner-border text-primary"></div>
            <p class="mt-2">Cargando...</p>
        </div>

    </main>

    
    <div class="text-center mt-4 mb-5">
        <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/test.php'">
            Volver
        </button>
    </div>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/test-evaluacion.js"></script>

</body>

</html>
