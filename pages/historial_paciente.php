<?php
require_once "../middleware/session.php";

// SOLO familiares/cuidadores
if (!in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /pages/dashboard.php");
    exit();
}

require_once "../models/bbdd.php";
$db = new Database();
$conn = $db->connect();

$familiar_id = $_SESSION["user_id"];

// OBTENER PACIENTES VINCULADOS
$sql = $conn->prepare("
    SELECT u.id, u.nombre, u.apellido
    FROM usuarios u
    INNER JOIN relaciones_paciente_familiar r
        ON r.paciente_id = u.id
    WHERE r.familiar_id = ?
");
$sql->execute([$familiar_id]);
$pacientes = $sql->fetchAll(PDO::FETCH_ASSOC);

// SI NO TIENE PACIENTES VINCULADOS
if (!$pacientes) {
    header("Location: /pages/registro_familiar.php");
    exit();
}

// PACIENTE SELECCIONADO
$paciente_id = $_GET["paciente"] ?? $pacientes[0]["id"];

// OBTENER HISTORIAL DEL PACIENTE
$sql = $conn->prepare("
    SELECT descripcion, fecha, completada
    FROM actividades_paciente
    WHERE paciente_id = ?
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
    <link rel="stylesheet" href="/assets/css/menu.css">
</head>

<body>

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-familiar.php"; ?>
    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

<div class="container mt-4">

    <h2 class="mb-3">Historial del Paciente</h2>

    <!-- Selector de paciente -->
    <form method="GET" class="mb-4">
        <label class="form-label">Seleccionar paciente</label>
        <select name="paciente" class="form-select" onchange="this.form.submit()">
            <?php foreach ($pacientes as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $p['id'] == $paciente_id ? 'selected' : '' ?>>
                    <?= $p['nombre'] . " " . $p['apellido'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- HISTORIAL -->
    <?php if (!$historial): ?>
        <p>No hay historial registrado para este paciente.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($historial as $h): ?>
                <li class="list-group-item">
                    <strong><?= $h["descripcion"] ?></strong><br>
                    <small><?= $h["fecha"] ?></small><br>

                    <?php if ($h["completada"]): ?>
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
