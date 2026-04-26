<?php 
require_once "../middleware/session-public.php";
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

// Obtener contenido dinámico
$sql = $conn->query("SELECT * FROM contenido ORDER BY fecha DESC");
$documentos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información sobre el Alzheimer</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/informacion.css">
</head>

<body>

    <!-- HEADER -->
    <?php include '../includes/header.php'; ?>

    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <!-- MENÚ SEGÚN SESIÓN -->
    <?php
    if (!isset($_SESSION["user_id"])) {
        include '../includes/public-menu.php';
    } elseif ($_SESSION["rol"] === "admin") {
        include '../includes/menu-admin.php';
    } else {
        include '../includes/private-menu.php';
    }
    ?>

    <!-- MENÚ RESPONSIVE -->
    <?php include '../includes/responsive-menu.php'; ?>

    <!-- BANNER PÚBLICO -->
    <?php include '../includes/public-banner.php'; ?>

    <h1>Información sobre el Alzheimer</h1>
    <p class="subtitle">Documentos y recursos para pacientes y cuidadores</p>

    <!-- CONTENIDO DINÁMICO -->
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

        <!-- BOTONES -->
        <div class="text-center mt-4">
            <button class="btn btn-primary px-4 py-2" onclick="location.href='/pages/index.php'">Inicio</button>

            <?php if (isset($_SESSION["user_id"])): ?>
                <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/dashboard.php'">Volver</button>
            <?php endif; ?>
        </div>

    </main>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>

</body>
</html>
