<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amor Propio</title>

    
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

        <p class="subtitle">Amor propio</p>

        <section class="content-block">
            <p>Cuidar de uno mismo no es egoismo, es una necesidad</p>
            <h3>Importancia del amor propio</h3>
            <ul>
                <li>Mejora la salud mental y emocional</li>
                <li>Permite establecer límites saludables</li>
                <li>Fomenta una actitud positiva frente a los desafíos</li>
            </ul>
            <h3>Consejos para cultivar el amor propio</h3>
            <ul>
                <li>Practicar la autocompasión y el perdón</li>
                <li>Dedicar tiempo a actividades que te hagan feliz</li> 
                <li>Aceptar limites</li>
                <li>Buscar apoyo emocional cuando sea necesario</li>
            </ul>        
       
        </section>

    </main>

    
    <?php include '../includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
