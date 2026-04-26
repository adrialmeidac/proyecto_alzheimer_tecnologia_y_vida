<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alimentación</title>

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

        <p class="subtitle">Aliimetación para pacientes</p>

        <section class="content-block">
            <p>La alimentación adecuada es fundamental para mantener la salud y el bienestar de 
                las personas con demencia.</p>
                <h3>Recomendaciones para una alimentación saludable</h3>
                <ul>
                    <li>Incluir una variedad de alimentos frescos y nutritivos</li>
                    <li>Evitar alimentos procesados y altos en azúcar</li>
                    <li>Fomentar la hidratación adecuada</li>
                    <li>Adaptar la textura de los alimentos según las necesidades del paciente</li>
                </ul>
                <h3>Consejos para facilitar la alimentación</h3>
                <ul>
                    <li>Crear un ambiente tranquilo y sin distracciones durante las comidas</li>
                    <li>Ofrecer comidas pequeñas y frecuentes en lugar de grandes porciones</li>
                    <li>Utilizar utensilios adaptados para facilitar la alimentación</li>
                    <li>Ser paciente y brindar apoyo emocional durante las comidas</li>
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
