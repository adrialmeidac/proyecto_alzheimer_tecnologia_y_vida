<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riegos del Alzheimer</title>

    
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

        <p class="subtitle">Riesgos del cuidador</p>

        <section class="content-block">
            <p>Los riesgos asociados a la demencia incluyen la pérdida de independencia, 
                la necesidad de cuidado constante y el impacto emocional en los familiares 
                y cuidadores.   </p>
            <h3>Riesgos para la persona con demencia</h3>
            <ul>
                <li>Caídas y accidentes</li>
                <li>Desnutrición e hidratación insuficiente</li>
                <li>Infecciones</li>
                <li>Abandono y aislamiento social</li>
            </ul>
            <h3>Riesgos para los cuidadores</h3>
            <ul>
                <li>Estrés y agotamiento emocional</li>
                <li>Problemas de salud física y mental</li> 
                <li>Impacto en la vida social y laboral</li>
            </ul>
            <h3>Prevención y manejo de riesgos</h3>
            <ul>
                <li>Adaptar el entorno para reducir riesgos de caídas</li>
                <li>Fomentar una alimentación equilibrada y adecuada</li>
                <li>Promover la actividad física y mental</li>
                <li>Buscar apoyo y recursos para cuidadores</li>
            </ul>
        </section>

    </main>

    
    <?php include '../includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
