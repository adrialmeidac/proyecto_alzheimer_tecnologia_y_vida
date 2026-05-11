<?php require_once "../middleware/session-public.php"?>;

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipos de Demencia</title>

    
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

        <p class="subtitle">Tipos de Demencia</p>

        <section class="content-block">
<h3>Demencia tipo Alzheimer</h3>
<p>Es la forma más común de demencia, caracterizada por la acumulación de placas amiloides
     y ovillos neurofibrilares en el cerebro, lo que conduce a la pérdida progresiva de 
     memoria y funciones cognitivas.</p>
     <h3>Demencia vascular</h3>
<p>Resulta de problemas en el suministro de sangre al cerebro, a menudo debido a accidentes
     cerebrovasculares. Los síntomas pueden variar según la ubicación y el tamaño de las áreas
     afectadas, pero comúnmente incluyen dificultades para planificar, organizar y tomar 
     decisiones.</p>
     <h3>Demencia con cuerpos de Lewy</h3>
<p>Caracterizada por la presencia de cuerpos de Lewy en el cerebro, esta forma de demencia 
    puede causar alucinaciones visuales, fluctuaciones en la atención y problemas de movimiento similares a los de la enfermedad de Parkinson.</p>
     <h3>Demencia frontotemporal</h3>
<p>Afecta principalmente los lóbulos frontal y temporal del cerebro, lo que conduce a cambios
     en la personalidad, el comportamiento y el lenguaje. Es más común en personas menores de
      65 años.</p>
     <h3>Demencia mixta</h3>
<p>Se refiere a la presencia de más de un tipo de demencia en el mismo individuo, como la 
    combinación de Alzheimer y demencia vascular. Los síntomas pueden ser una mezcla de los 
    asociados con cada tipo de demencia presente.</p>
     </section>

    </main>

    
    <?php include '../includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
