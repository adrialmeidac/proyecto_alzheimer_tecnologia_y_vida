<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estrés en el Cuidador</title>

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

        <p class="subtitle">Estrés emocional</p>

        <section class="content-block">
<h3>Señales de alerta en cuidadores</h3>
<ul>
    <li>Sentirse abrumado o agotado</li>
    <li>Perder interés en actividades que antes disfrutaba</li>
    <li>Sentirse irritable o frustrado con frecuencia</li>
    <li>Descuidar su propia salud física o mental</li>
    <li>Sentirse solo o aislado</li>
</ul>
<h3>Consejos para manejar el estrés</h3>
<ul>
    <li>Buscar apoyo en amigos, familiares o grupos de apoyo</li>
    <li>Tomarse tiempo para uno mismo y realizar actividades que disfrute</li>
    <li>Practicar técnicas de relajación como la meditación o el yoga</li>
    <li>Establecer límites claros y pedir ayuda cuando sea necesario</li>
    <li>Consultar a un profesional de la salud si el estrés se vuelve abrumador</li>
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
