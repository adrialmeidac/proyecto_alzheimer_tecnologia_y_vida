<?php require_once "../middleware/session.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rompecabezas</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/rompecabezas.css">
    <link rel="stylesheet" href="/assets/css/timer.css">
</head>

<body>

    
    <?php include '../includes/header.php'; ?>

    
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    
    <?php include '../includes/private-menu.php'; ?>

    
    <?php include '../includes/responsive-menu.php'; ?>

    
    <?php include '../includes/private-banner.php'; ?>

    <p class="subtitle">Arrastra las piezas al lugar correcto</p>

    
    <p id="timer" class="timer">Tiempo: 0s</p>

    
    <div class="difficulty-row">
        <label class="difficulty-option">
            <input type="radio" name="difficulty" value="facil">
            Fácil
        </label>

        <label class="difficulty-option">
            <input type="radio" name="difficulty" value="medio" checked>
            Medio
        </label>

        <label class="difficulty-option">
            <input type="radio" name="difficulty" value="dificil">
            Difícil
        </label>
    </div>

    
    <main class="puzzle-layout">

        
        <section class="col reference-col">
            <h3>Imagen a armar:</h3>
            <img id="referenceImg" class="reference-img" src="/assets/images/perro.jpg" alt="Imagen de referencia">
        </section>

        
        <section class="col board-col">
            <div class="puzzle-board" id="dropzones"></div>
        </section>

        
        <section class="col pieces-col">
            <div class="pieces-container" id="pieces"></div>
        </section>

    </main>

    
    <div class="text-center mt-4">
        <button id="resetBtn" class="btn btn-warning px-4 py-2">Reiniciar</button>
        <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/juegos.php'">Volver</button>
    </div>

    
    <?php include '../includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>
    <script src="../assets/js/rompecabezas.js" defer></script>

</body>

</html>
