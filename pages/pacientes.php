<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /pages/login.php");
    exit();
}


if (!in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /pages/dashboardFamiliar.php");
    exit();
}

require_once __DIR__ . "/../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$familiar_id = $_SESSION['user_id'];


$sql = $conn->prepare("
    SELECT u.id, u.nombre, u.apellidos, rf.parentesco
    FROM relaciones_familiares rf
    INNER JOIN usuarios u ON u.id = rf.paciente_id
    WHERE rf.familiar_id = :id
");
$sql->execute([':id' => $familiar_id]);
$pacientes = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Pacientes</title>

    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/panel-familiar.css">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include "../includes/header.php"; ?>


<button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<?php include "../includes/menu-familiar.php"; ?>


<?php include "../includes/responsive-menu.php"; ?>


<?php include "../includes/private-banner.php"; ?>

<div class="panel-familiar-container">

    <?php if (isset($_GET['vinculado'])): ?>
        <div class="alerta-exito">
            Paciente vinculado correctamente.
        </div>
    <?php endif; ?>

    <h1 class="titulo-notificaciones">👨‍⚕️ Mis Pacientes</h1>

    <div class="acciones-pacientes">
        <a href="/pages/registro_familiar.php" class="btn-agregar-paciente">
            + Vincular nuevo paciente
        </a>
    </div>

    <?php if (empty($pacientes)): ?>
        <p>No tienes pacientes vinculados.</p>
    <?php else: ?>
        <?php foreach ($pacientes as $p): ?>
            <div class="notificacion leida">
                <p><strong><?php echo $p['nombre'] . " " . $p['apellidos']; ?></strong></p>
                <p>Relación: <?php echo $p['parentesco']; ?></p>

                <a href="actividades_pacientes.php?paciente=<?php echo $p['id']; ?>" class="btn-leida">
                    Ver actividades
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

<script src="/assets/js/theme.js"></script>

</body>
</html>
