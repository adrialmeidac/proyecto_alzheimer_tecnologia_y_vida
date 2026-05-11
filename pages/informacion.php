<?php 
require_once "../middleware/session-public.php";
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();


$sql = $conn->query("
    SELECT id, titulo, descripcion, archivo, categoria, creado_en
    FROM contenido
    ORDER BY creado_en DESC
");
$documentos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información sobre el Alzheimer</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/informacion.css">
</head>

<body>

    
    <?php include '../includes/header.php'; ?>

    
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    
    <?php
    if (!isset($_SESSION["user_id"])) {
        include '../includes/public-menu.php';
    } elseif ($_SESSION["rol"] === "admin") {
        include '../includes/menu-admin.php';
    } elseif (in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
        include '../includes/menu-familiar.php';
    } else {
        include '../includes/private-menu.php'; 
    }
    ?>

    
    <?php include '../includes/responsive-menu.php'; ?>

    
    <?php include '../includes/public-banner.php'; ?>

    <h1>Información sobre el Alzheimer</h1>
    <p class="subtitle">Documentos y recursos para pacientes y cuidadores</p>

    
    <main class="container info-container">

        <?php if (empty($documentos)): ?>
            <p class="text-center mt-4">No hay documentos disponibles por el momento.</p>
        <?php else: ?>

            <?php foreach ($documentos as $doc): ?>
                <section class="info-section">
                    <h2><?= htmlspecialchars($doc["titulo"]) ?></h2>

                    <p><?= nl2br(htmlspecialchars($doc["descripcion"])) ?></p>

                    <a class="btn btn-info px-4 py-2" 
                       href="<?= htmlspecialchars($doc["archivo"]) ?>" 
                       target="_blank">
                        Descargar PDF
                    </a>
                </section>
            <?php endforeach; ?>

        <?php endif; ?>

        
        <div class="text-center mt-4">
            <button class="btn btn-primary px-4 py-2" onclick="location.href='/pages/index.php'">Inicio</button>

            <?php if (isset($_SESSION["user_id"])): ?>
                <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/dashboard.php'">Volver</button>
            <?php endif; ?>
        </div>

    </main>

    
    <?php include '../includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>

</body>
</html>
