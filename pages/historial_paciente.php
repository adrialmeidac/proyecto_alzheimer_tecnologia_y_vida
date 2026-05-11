<?php
require_once "../middleware/session.php";


if (!in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /pages/dashboard.php");
    exit();
}

require_once "../models/bbdd.php";
$db = new Database();
$conn = $db->connect();

$familiar_id = $_SESSION["user_id"];


$sql = $conn->prepare("
    SELECT u.id, u.nombre, u.apellidos
    FROM usuarios u
    INNER JOIN relaciones_familiares r
        ON r.paciente_id = u.id
    WHERE r.familiar_id = ?
");
$sql->execute([$familiar_id]);
$pacientes = $sql->fetchAll(PDO::FETCH_ASSOC);


if (!$pacientes) {
    header("Location: /pages/registro_familiar.php");
    exit();
}


$paciente_id = $_GET["paciente"] ?? $pacientes[0]["id"];


$sql = $conn->prepare("
    SELECT descripcion, fecha, estado
    FROM actividades
    WHERE usuario_id = ?
    ORDER BY fecha DESC
");
$sql->execute([$paciente_id]);
$historial = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial del Paciente</title>

    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/panel-familiar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">


</head>

<body>

<?php include "../includes/header.php"; ?>


<button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<?php include "../includes/menu-familiar.php"; ?>


<?php include "../includes/responsive-menu.php"; ?>


<?php include "../includes/private-banner.php"; ?>

<div class="panel-familiar-container">

    <h1 class="mb-3">Historial del Paciente</h1>

    
    <form method="GET" class="mb-4">
        <label class="form-label">Seleccionar paciente</label>
        <select name="paciente" class="form-select" onchange="this.form.submit()">
            <?php foreach ($pacientes as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $p['id'] == $paciente_id ? 'selected' : '' ?>>
                    <?= $p['nombre'] . " " . $p['apellidos'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    
    <?php if (!$historial): ?>
        <p>No hay historial registrado para este paciente.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($historial as $h): ?>
                <li class="list-group-item">
                    <strong><?= $h["descripcion"] ?></strong><br>
                    <small><?= $h["fecha"] ?></small><br>

                    <?php if ($h["estado"]): ?>
                        <span class="badge bg-success mt-1">Completada</span>
                    <?php else: ?>
                        <span class="badge bg-warning mt-1">Pendiente</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</div>

<script src="/assets/js/theme.js"></script>

</body>
</html>
