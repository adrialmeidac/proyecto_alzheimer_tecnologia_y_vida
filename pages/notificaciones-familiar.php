<?php
session_start();


if (!in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /login.php");
    exit();
}

require_once __DIR__ . "/../controllers/obtener-notificaciones-familiar.php";


$notificaciones = obtenerNotificacionesFamiliar($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones de mis pacientes</title>

    
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


<?php include "../includes/header.php"; ?>


<button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<?php include "../includes/menu-familiar.php"; ?>


<?php include "../includes/responsive-menu.php"; ?>


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

                    <form method="POST" action="/controllers/eliminar_notificacion.php" class="mt-2">
                        <input type="hidden" name="id" value="<?= $n['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm px-3 py-1">
                        Eliminar
                        </button>
</form>            </div>
    </form>
        <?php endforeach; ?>
    <?php endif; ?>

</div>


<?php include "../includes/footer.php"; ?>

<script src="/assets/js/theme.js"></script>

</body>
</html>
