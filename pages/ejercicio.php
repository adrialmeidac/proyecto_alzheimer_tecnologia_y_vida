<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios para pacientes</title>

    
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

        <p class="subtitle">Ejercicios para pacientes</p>

        <section class="content-block">
            <p>Es importante realizar ejercicios regulares para mantener la salud física
                 y mental de los pacientes con demencia.</p>
                 <h3>Ejercicios recomendados</h3>
                    <ul>
                        <li>Ejercicios aeróbicos: caminar, nadar, bailar</li>
                        <li>Ejercicios de fuerza: levantamiento de pesas, yoga</li>
                        <li>Ejercicios de equilibrio: tai chi, ejercicios de pie</li>
                        <li>Ejercicios mentales: rompecabezas, juegos de memoria</li>
                    </ul>
                    <h3>Beneficios de los ejercicios</h3>
                    <ul>
                        <li>Mejora la función cognitiva</li>
                        <li>Reduce el riesgo de caídas</li>
                        <li>Mejora el estado de ánimo</li>
                        <li>Mejora la calidad de vida</li>
                    </ul>
        </section>

    </main>

    
    <?php include '../includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
