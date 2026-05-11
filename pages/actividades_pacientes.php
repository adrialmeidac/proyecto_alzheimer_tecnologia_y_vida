<?php
require_once "../middleware/session.php";


if (!in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /pages/dashboardFamiliar.php");
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
    SELECT *
    FROM actividades
    WHERE usuario_id = ?
    ORDER BY fecha DESC, hora ASC
");
$sql->execute([$paciente_id]);
$actividades = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actividades del Paciente</title>

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

    <h1 class="mb-3">Actividades del Paciente</h1>

    
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

    
    <div class="card p-4 mb-4 shadow-sm">
        <h4 class="mb-3">Crear nueva actividad</h4>

<form action="/controllers/actividades-familiar.php?action=crear" method="POST">
    <input type="hidden" name="paciente_id" value="<?= $paciente_id ?>">

    <label class="form-label">Descripción</label>
    <input type="text" name="texto" class="form-control" required>

    <label class="form-label mt-3">Fecha</label>
    <input type="date" name="fecha" class="form-control" required>

    <label class="form-label mt-3">Hora límite</label>
    <input type="time" name="hora" class="form-control" required>

    <button type="submit" class="btn btn-primary mt-4 w-100">Guardar actividad</button>
</form>
    </div>

    
    <h4 class="mb-3">Actividades registradas</h4>

    <?php if (!$actividades): ?>
        <p class="text-muted">No hay actividades registradas.</p>
    <?php else: ?>

        <div class="row g-3">
            <?php foreach ($actividades as $a): ?>
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm p-3">

                        <div class="card-body">

                            <h5 class="card-title mb-2">
                                <?= htmlspecialchars($a["descripcion"]) ?>
                            </h5>

                            <p class="card-text text-muted mb-3">
                                <strong>Fecha:</strong> <?= $a["fecha"] ?><br>
                                <strong>Hora límite:</strong> <?= $a["hora"] ?>
                            </p>

                            <div class="d-flex justify-content-between">

                                <?php if ($a["estado"] == 0): ?>
                                    <a href="/controllers/completar-actividad.php?id=<?= $a['id'] ?>"
                                       class="btn btn-success btn-sm">
                                        Completar
                                    </a>
                                <?php else: ?>
                                    <span class="badge bg-success align-self-center">Completada</span>
                                <?php endif; ?>

                                <a href="/controllers/eliminar-actividad-paciente.php?id=<?= $a['id'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Seguro que deseas eliminar esta actividad?')">
                                    Eliminar
                                </a>

                            </div>

                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

<script src="/assets/js/theme.js"></script>
<script src="/assets/js/familiar.js"></script>


</body>
</html>
