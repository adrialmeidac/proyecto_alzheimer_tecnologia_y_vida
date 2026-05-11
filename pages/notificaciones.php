<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

require_once __DIR__ . "/../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$user_id = $_SESSION['user_id'];


$sql_no_leidas = $conn->prepare("
    SELECT * FROM notificaciones 
    WHERE usuario_id = :user_id AND leida = 0
    ORDER BY fecha DESC
");
$sql_no_leidas->execute([':user_id' => $user_id]);
$no_leidas = $sql_no_leidas->fetchAll(PDO::FETCH_ASSOC);


$sql_leidas = $conn->prepare("
    SELECT * FROM notificaciones 
    WHERE usuario_id = :user_id AND leida = 1
    ORDER BY fecha DESC
");
$sql_leidas->execute([':user_id' => $user_id]);
$leidas = $sql_leidas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones</title>

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/notificaciones.css">
</head>

<body>


<?php include "../includes/header.php"; ?>


<?php include "../includes/private-menu.php"; ?>


<?php include "../includes/responsive-menu.php"; ?>


<?php include "../includes/private-banner.php"; ?>

<div class="contenedor-notificaciones">

    <h1 class="titulo-notificaciones">🔔 Notificaciones</h1>

    
    <h2 class="subtitulo-notificaciones">No leídas (<?php echo count($no_leidas); ?>)</h2>

    <?php if (count($no_leidas) === 0): ?>
        <p class="sin-notificaciones">No tienes notificaciones nuevas.</p>
    <?php else: ?>
        <?php foreach ($no_leidas as $n): ?>
            <div class="notificacion no-leida">
                <p class="tipo"><?php echo ucfirst(str_replace("_", " ", $n['tipo'])); ?></p>
                <p class="mensaje"><?php echo $n['mensaje']; ?></p>
                <small class="fecha"><?php echo $n['fecha']; ?></small>

                <form action="/controllers/marcar-notificacion.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $n['id']; ?>">
                    <button type="submit" class="btn-leida">Marcar como leída</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <hr>

    
    <h2 class="subtitulo-notificaciones">Leídas</h2>

    <?php if (count($leidas) === 0): ?>
        <p class="sin-notificaciones">No tienes notificaciones leídas.</p>
    <?php else: ?>
        <?php foreach ($leidas as $n): ?>
            <div class="notificacion leida">
                <p class="mensaje"><?php echo $n['mensaje']; ?></p>
                <small class="fecha"><?php echo $n['fecha']; ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>


<?php include "../includes/footer.php"; ?>

</body>
</html>
