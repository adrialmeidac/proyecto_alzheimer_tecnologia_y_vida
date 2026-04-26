<?php
session_start();

// Solo usuarios loggeados
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Solo familiares pueden ver esta página
if ($_SESSION['rol'] !== 'familiar') {
    echo "No tienes permiso para ver esta página.";
    exit();
}

require_once __DIR__ . "/../includes/obtener_notificaciones_familiar.php";

// Obtener todas las notificaciones de los pacientes vinculados
$notificaciones = obtenerNotificacionesFamiliar($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones de mis pacientes</title>

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/notificaciones.css">
</head>

<body>

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-familiar.php"; ?>
    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<div class="contenedor-notificaciones">
    <h1 class="titulo-notificaciones">🔔 Notificaciones de mis pacientes</h1>

    <?php if (empty($notificaciones)): ?>
        <p class="sin-notificaciones">No hay notificaciones disponibles.</p>

    <?php else: ?>
        <?php foreach ($notificaciones as $n): ?>
            <div class="notificacion <?php echo $n['leida'] ? 'leida' : 'no-leida'; ?>">

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
                    <form action="../controllers/marcar-notificacion.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $n['id']; ?>">
                        <button type="submit" class="btn-leida">Marcar como leída</button>
                    </form>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

</body>
</html>
