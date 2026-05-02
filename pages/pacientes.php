<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// SOLO familiares/cuidadores pueden entrar aquí
if (!in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /pages/dashboard.php");
    exit();
}

require_once __DIR__ . "/../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$familiar_id = $_SESSION['user_id'];

// Obtener pacientes vinculados
$sql = $conn->prepare("
    SELECT u.id, u.nombre, u.apellido, rf.tipo_relacion
    FROM relaciones_paciente_familiar rf
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
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>

<body>

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-familiar.php"; ?>
    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<div class="contenedor-notificaciones">
    <h1 class="titulo-notificaciones">👨‍⚕️ Mis Pacientes</h1>

    <?php if (empty($pacientes)): ?>
        <p>No tienes pacientes vinculados.</p>
    <?php else: ?>
        <?php foreach ($pacientes as $p): ?>
            <div class="notificacion leida">
                <p><strong><?php echo $p['nombre'] . " " . $p['apellido']; ?></strong></p>
                <p>Relación: <?php echo $p['tipo_relacion']; ?></p>

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
