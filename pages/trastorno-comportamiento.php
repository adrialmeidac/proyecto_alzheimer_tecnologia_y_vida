<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trastornos del Comportamiento</title>

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

        <p class="subtitle">Trastornos del Comportamientol</p>

        <section class="content-block">
<p>Los trastornos del comportamiento son una parte común de la demencia, 
    afectando la calidad de vida tanto de los pacientes como de sus cuidadores.</p>
<h3>Cambios frecuentes</h3>
<ul>
    <li>Agitación</li>
    <li>Depresión</li>
    <li>Ansiedad</li>
    <li>Alucinaciones</li>
    <li>Comportamiento agresivo</li>
    <li>Repeticiones de preguntas</li>
</ul>
<h3>¿Cómo manejar estos trastornos?</h3>
<p>Es importante abordar estos trastornos con empatía y comprensión, 
    buscando estrategias de manejo que mejoren la calidad de vida del paciente y 
    reduzcan el estrés del cuidador.</p>
<ul>
    <li>Crear un ambiente tranquilo y seguro</li>
    <li>Establecer rutinas diarias</li>
    <li>Utilizar técnicas de distracción</li>
    <li>Buscar apoyo profesional</li>
</ul>
        </section>

    </main>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
