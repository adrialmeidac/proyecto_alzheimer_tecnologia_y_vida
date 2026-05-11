<?php require_once "../middleware/session.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juegos Cognitivos</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/juegos.css">
</head>

<body>

    
    <?php include "../includes/header.php"; ?>

    
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    
    <?php include "../includes/private-menu.php"; ?>

    
    <?php include "../includes/responsive-menu.php"; ?>

    
    <?php include "../includes/private-banner.php"; ?>

    <p class="subtitle">Selecciona un juego para comenzar</p>

    
    <main class="container mt-4">

        <div class="row g-4">

            
            <div class="col-12 col-md-6 col-lg-4">
                <section class="game-card" onclick="location.href='/pages/rompecabezas.php'">
                    <h3>🧩 Rompecabezas</h3>
                    <p>Arma las piezas y ejercita la lógica</p>
                </section>
            </div>

            
            <div class="col-12 col-md-6 col-lg-4">
                <section class="game-card" onclick="location.href='/pages/memoria.php'">
                    <h3>🧠 Memoria</h3>
                    <p>Encuentra las parejas iguales</p>
                </section>
            </div>

            
            <div class="col-12 col-md-6 col-lg-4">
                <section class="game-card" onclick="location.href='/pages/colores.php'">
                    <h3>🎨 Secuencia de Colores</h3>
                    <p>Repite la secuencia correctamente</p>
                </section>
            </div>

        </div>

    </main>

    
    <div class="text-center mt-4">
        <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/dashboard.php'">
            Volver
        </button>
    </div>

    
    <?php include "../includes/footer.php"; ?>

    
    <script src="/assets/js/theme.js"></script>

</body>

</html>
