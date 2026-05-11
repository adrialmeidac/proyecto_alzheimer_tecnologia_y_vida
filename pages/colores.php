<?php require_once "../middleware/session.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secuencia de Colores</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/colores.css">
    <link rel="stylesheet" href="/assets/css/timer.css">
</head>

<body>

    
    <?php include "../includes/header.php"; ?>

    
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    
    <?php include "../includes/private-menu.php"; ?>

    
    <?php include "../includes/responsive-menu.php"; ?>

    
    <?php include "../includes/private-banner.php"; ?>

    <p class="subtitle">Observa y repite la secuencia</p>

    
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

    
    <main class="colors-container">

        <section class="panel">
            <div class="color rojo" data-color="rojo" role="button" tabindex="0" aria-label="Color rojo"></div>
            <div class="color azul" data-color="azul" role="button" tabindex="0" aria-label="Color azul"></div>
            <div class="color verde" data-color="verde" role="button" tabindex="0" aria-label="Color verde"></div>
            <div class="color amarillo" data-color="amarillo" role="button" tabindex="0" aria-label="Color amarillo"></div>
        </section>

        <br>

        
        <button class="main-btn" id="startBtn">Iniciar juego</button>

    </main>

    
    <div class="text-center mt-4">
        <button id="resetBtn" class="btn btn-warning px-4 py-2">Reiniciar</button>
        <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/juegos.php'">Volver</button>
    </div>

    
    <?php include "../includes/footer.php"; ?>

    
    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/colores.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
