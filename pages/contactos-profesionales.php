<?php require_once "../middleware/session-public.php"; ?>
<?php require_once "../models/bbdd.php"; ?>

<?php
// Obtener profesionales desde la BD
$db = new Database();
$conn = $db->connect();

$stmt = $conn->query("SELECT * FROM profesionales ORDER BY nombre ASC");
$profesionales = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos Profesionales</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/contactos-profesionales.css">
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

    <h1 class="text-center mt-4">Listado de profesionales médicos</h1>
    <p class="subtitle text-center">Contacta a los expertos disponibles en Asturias</p>

    <div class="container mt-4">

        <?php if (!empty($profesionales)): ?>
            <?php foreach ($profesionales as $pro): ?>
                <div class="doctor-card">
                    <h3><?= htmlspecialchars($pro['nombre']) ?></h3>
                    <p class="specialty"><?= htmlspecialchars($pro['especialidad']) ?></p>
                    <p class="address"><?= htmlspecialchars($pro['direccion']) ?></p>

                    <?php if (!empty($pro['servicios'])): ?>
                        <p class="services">
                            <?= htmlspecialchars($pro['servicios']) ?>
                        </p>
                    <?php endif; ?>

                    <div class="working-hours">
                        <strong>Horario de trabajo:</strong>
                        <ul>
                            <li>Lunes: <?= $pro['horario_lunes'] ?: "—" ?></li>
                            <li>Martes: <?= $pro['horario_martes'] ?: "—" ?></li>
                            <li>Miércoles: <?= $pro['horario_miercoles'] ?: "—" ?></li>
                            <li>Jueves: <?= $pro['horario_jueves'] ?: "—" ?></li>
                            <li>Viernes: <?= $pro['horario_viernes'] ?: "—" ?></li>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center mt-4">No hay profesionales registrados por el momento.</p>
        <?php endif; ?>

        <!-- BOTÓN VOLVER -->
        <div class="text-center mt-4">
            <button class="btn btn-primary px-4 py-2" onclick="location.href='/pages/index.php'">
                Volver
            </button>
        </div>

    </div>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
