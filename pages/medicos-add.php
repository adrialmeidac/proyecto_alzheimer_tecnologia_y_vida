<?php require_once "../../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Profesional Médico</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
</head>

<body>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/menu-admin.php'; ?>

<button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

<div class="container mt-4">
    <h2 class="mb-4">Añadir nuevo profesional médico</h2>

    <form action="/controllers/profesionales.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="action" value="crear">

        <!-- DATOS BÁSICOS -->
        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Especialidad</label>
            <input type="text" name="especialidad" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" required>
        </div>

        <!-- SERVICIOS -->
        <h5 class="mt-4">Servicios ofrecidos</h5>

        <div class="row">
            <?php 
            $servicios = ["Fisioterapia", "Rehabilitación", "Masajes", "Terapia deportiva", "Podología", "Nutrición"];
            foreach ($servicios as $s): ?>
                <div class="col-md-4 mb-2">
                    <label>
                        <input type="checkbox" name="servicios[]" value="<?= $s ?>"> <?= $s ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- HORARIOS -->
        <h5 class="mt-4">Horario de trabajo</h5>

        <?php 
        $dias = [
            "lunes" => "Lunes",
            "martes" => "Martes",
            "miercoles" => "Miércoles",
            "jueves" => "Jueves",
            "viernes" => "Viernes"
        ];

        $opciones = [
            "Cerrado",
            "Mañana (08:00–14:00)",
            "Tarde (16:00–20:00)",
            "Completo (08:00–20:00)"
        ];
        ?>

        <div class="row">
            <?php foreach ($dias as $campo => $label): ?>
                <div class="col-md-6 mb-3">
                    <label><?= $label ?></label>
                    <select name="horario_<?= $campo ?>" class="form-control">
                        <option value="">Seleccionar...</option>
                        <?php foreach ($opciones as $op): ?>
                            <option value="<?= $op ?>"><?= $op ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- FOTO -->
        <div class="mb-3">
            <label class="form-label">Foto del profesional (opcional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>

        <!-- BOTONES -->
        <button type="submit" class="btn btn-primary px-4">Guardar</button>
        <a href="/pages/admin-profesionales.php" class="btn btn-secondary">Cancelar</a>

    </form>
</div>

</body>
</html>
