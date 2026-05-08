<?php
session_start();

// SOLO familiares/cuidadores
if (!in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /login.php");
    exit();
}

require_once __DIR__ . "./controllers/obtener-notificaciones-familiar.php";

// Obtener todas las notificaciones de los pacientes vinculados
$notificaciones = obtenerNotificacionesFamiliar($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones de mis pacientes</title>

    <!-- CSS globales -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/notificaciones.css">
    <link rel="stylesheet" href="/assets/css/panel-familiar.css">
</head>

<body>

<!-- HEADER -->
<?php include "../includes/header.php"; ?>

<!-- BOTÓN MODO OSCURO -->
<button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

<!-- MENÚ FAMILIAR -->
<?php include "../includes/menu-familiar.php"; ?>

<!-- MENÚ RESPONSIVE -->
<?php include "../includes/responsive-menu.php"; ?>

<!-- BANNER PRIVADO -->
<?php include "../includes/private-banner.php"; ?>

<div class="panel-familiar-container contenedor-notificaciones">

    <h1 class="titulo-notificaciones">🔔 Notificaciones de mis pacientes</h1>

    <?php if (empty($notificaciones)): ?>
        <p class="sin-notificaciones">No hay notificaciones disponibles.</p>

    <?php else: ?>
        <?php foreach ($notificaciones as $n): ?>
            <div class="notificacion <?php echo $n['leida'] ? 'leida' : 'no-leida'; ?>">

                <p class="paciente">
                    👤 <strong><?php echo $n['paciente_nombre']; ?></strong>
                </p>

                <p class="tipo">
                    <?php echo ucfirst(str_replace("_", " ", $n['tipo'])); ?>
                </p>

                <p class="mensaje">
                    <?php echo $n['mensaje']; ?>
                </p>

                <p class="fecha">
                    <?php echo $n['fecha']; ?>
                </p>

                <?php if (!$n['leida']): ?>
                    <form action="/controllers/marcar-notificacion.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $n['id']; ?>">
                        <button type="submit" class="btn-leida">Marcar como leída</button>
                    </form>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

<!-- FOOTER -->
<?php include "../includes/footer.php"; ?>

<script src="/assets/js/theme.js"></script>

</body>
</html>
