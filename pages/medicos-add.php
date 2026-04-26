<?php require_once "../../middleware/session-admin.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Médico</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/global.css">
</head>

<body>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/menu-admin.php'; ?>
    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<div class="container mt-4">
    <h2 class="mb-4">Añadir nuevo profesional médico</h2>

    <form action="/controllers/medicos.php" method="POST">

        <input type="hidden" name="action" value="crear">

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

        <div class="mb-3">
            <label class="form-label">Servicios</label>
            <input type="text" name="servicios" class="form-control" placeholder="Ej: Primera visita Neurología" required>
        </div>

        <h5 class="mt-4">Horario de trabajo</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Lunes</label>
                <input type="text" name="horario_lunes" class="form-control" placeholder="Ej: 9:00 - 14:00">
            </div>
            <div class="col-md-6 mb-3">
                <label>Martes</label>
                <input type="text" name="horario_martes" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Miércoles</label>
                <input type="text" name="horario_miercoles" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Jueves</label>
                <input type="text" name="horario_jueves" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Viernes</label>
                <input type="text" name="horario_viernes" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary px-4">Guardar</button>
        <a href="/pages/admin/medicos-list.php" class="btn btn-secondary">Cancelar</a>

    </form>
</div>

</body>
</html>
