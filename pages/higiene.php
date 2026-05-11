<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Higiene personal en la demencia</title>

    
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

        <p class="subtitle">Higiene en pacientes</p>

        <section class="content-block">
           <h3>Dificultades comunes</h3>
              <ul>
                <li>Olvidar cómo realizar tareas de higiene personal</li>
                <li>Resistencia a bañarse o cambiarse de ropa</li>
                <li>Dificultad para usar el baño</li>
                <li>Problemas para cepillarse los dientes</li>
              </ul>
                <h3>Consejos para facilitar la higiene</h3>
                <ul>
                    <li>Crear un ambiente tranquilo y sin distracciones durante las tareas de higiene</li>
                    <li>Establecer una rutina diaria para las actividades de higiene</li>
                    <li>Utilizar productos de higiene adecuados y cómodos</li>
                    <li>Brindar apoyo emocional y paciencia durante las tareas de higiene</li>
                </ul>

        </section>

    </main>

    
    <?php include '../includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
