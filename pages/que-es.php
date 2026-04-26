<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Qué es el Alzheimer?</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
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

    <!-- HEADER -->
    <?php include '../includes/header.php'; ?>

    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <!-- MENÚ PÚBLICO -->
    <?php include '../includes/public-menu.php'; ?>

    <!-- MENÚ RESPONSIVE -->
    <?php include '../includes/responsive-menu.php'; ?>

    <!-- BANNER PÚBLICO -->
    <?php include '../includes/public-banner.php'; ?>

    <main class="container mt-4">

        <p class="subtitle">¿Qué es el Alzheimer?</p>

        <!-- AQUÍ VA TU CONTENIDO -->
        <section class="content-block">
            <p>El Alzheimer es una enfermedad neurodegenerativa que afecta principalmente a la memoria, 
                el pensamiento y la conducta. Su avance es progresivo, lo que significa que los síntomas
                 empeoran con el tiempo.</p>
                 <h3>Sintomas más frecuentes</h3>
                 <ul>
                    <li>Dificultad para recordar eventos recientes</li>
                    <li>Confusión con el tiempo o el lugar</li>
                    <li>Cambios en el lenguaje y la comunicación</li>
                    <li>Dificultad para realizar tareas cotidianas</li>
                    <li>Alteraciones en el juicio y la toma de decisiones</li>
                    <li>Cambios en el estado de ánimo y la personalidad</li>
                 </ul>
                <h3>¿A quién afecta?</h3>
                <p>El Alzheimer afecta principalmente a personas mayores de 65 años, aunque también puede
                     presentarse en personas más jóvenes. Es más común en mujeres que en hombres.</p>
                <h3>Impacto en la vida diaria</h3>
                <p>El Alzheimer puede afectar significativamente la calidad de vida de quienes lo padecen,
                     así como la de sus familiares y cuidadores. A medida que la enfermedad avanza,
                        las personas pueden necesitar asistencia para realizar actividades diarias, como vestirse, 
                        alimentarse o bañarse.</p>  
        </section>
</main>
            <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
