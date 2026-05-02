<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tratamiento del Alzheimer</title>

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

        <p class="subtitle">Tratamiento</p>

        <section class="content-block">
            <p>No existe cura pero si tratamientos que aydan a mejorar la calidad de vida de los pacientes.</p>
       <h3>Tratamientos farmacológicos</h3>
       <p>Medicamentos para mejorar la función cognitiva, controlar síntomas conductuales y tratar condiciones médicas asociadas.</p>
       <ul>
        <li>Inhibidores de la colinesterasa (donepezilo, rivastigmina, galantamina)</li>
        <li>Memantina</li>
       </ul>
       <h3>Tratamientos no farmacológicos</h3>
       <p>Intervenciones como terapia ocupacional, estimulación cognitiva, ejercicio físico, terapia de reminiscencia y apoyo psicosocial.</p>
       <h3>Importancia del acompañamiento</h3>
         <p>El apoyo emocional, social y práctico es fundamental para mejorar la calidad de vida
        </section>

    </main>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
