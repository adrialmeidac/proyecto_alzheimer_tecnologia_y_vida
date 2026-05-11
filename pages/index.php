<?php require_once "../middleware/session-public.php"?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alzheimer, tecnología y vida</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/cookies.css">
    <link rel="stylesheet" href="/assets/css/index.css">
    


    
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400&display=swap" rel="stylesheet">
</head>

<body>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/header.php'; ?>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/public-menu.php'; ?>

    
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/responsive-menu.php'; ?>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/public-banner.php'; ?>

    
    <main class="index-container container">

        <h1>Alzheimer, tecnología y vida</h1>
        <p class="subtitle">Un espacio digital para aprender, conectar y avanzar</p>

        <section class="intro row justify-content-center text-center">
            <div class="col-12 col-md-8">
                <p>
                    Esta plataforma ofrece juegos cognitivos, actividades diarias, un foro de apoyo,
                    información útil y evaluaciones para ayudar a pacientes, familiares y cuidadores.
                </p>
            </div>
        </section>

        <div class="index-buttons d-flex flex-column flex-md-row justify-content-center gap-3 mt-4">
            <button class="main-btn" onclick="location.href='/pages/login.php'">Iniciar Sesión</button>
            <button class="secondary-btn" onclick="location.href='/pages/informacion.php'">Documentación</button>
        </div>

    </main>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'; ?>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/cookies-banner.php'; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/cookies-settings.php'; ?>

    
    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/cookies.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
