<?php require_once "../middleware/session-admin.php"; ?>
<?php require_once "../models/bbdd.php"; ?>

<?php
// Obtener médicos
$query = $conn->query("SELECT * FROM profesionales ORDER BY nombre ASC");
$medicos = $query->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Médicos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/menu.css">   
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/contactos-profesionales.css">
    <link rel="stylesheet" href="/assets/css/footer.css">

</head>

<body>

<?php include '../includes/header.php'; ?>
<?php include '../includes/menu-admin.php'; ?>
    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<div class="container mt-4">

    <h2 class="mb-4">Gestión de Profesionales Médicos</h2>

    <!-- BOTÓN AÑADIR -->
<button class="btn-add mb-3" data-bs-toggle="modal" data-bs-target="#modalCrear">
    Añadir médico
</button>   

    <!-- TABLA -->
<table class="table table-dashboard">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Especialidad</th>
            <th>Dirección</th>
            <th>Servicios</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($medicos as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['nombre']) ?></td>
            <td><?= htmlspecialchars($m['especialidad']) ?></td>
            <td><?= htmlspecialchars($m['direccion']) ?></td>
            <td><?= htmlspecialchars($m['servicios']) ?></td>

            <td>
                <!-- BOTÓN EDITAR -->
                <button class="btn btn-warning btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditar<?= $m['id'] ?>">
                    Editar
                </button>

                <!-- BOTÓN ELIMINAR -->
                <a href="/controllers/medicos.php?action=eliminar&id=<?= $m['id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('¿Eliminar este médico?')">
                    Eliminar
                </a>
            </td>
        </tr>

        <!-- MODAL EDITAR -->
        <div class="modal fade" id="modalEditar<?= $m['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="/controllers/medicos.php" method="POST">
                        <input type="hidden" name="action" value="editar">
                        <input type="hidden" name="id" value="<?= $m['id'] ?>">

                        <div class="modal-header">
                            <h5 class="modal-title">Editar Médico</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control mb-2"
                                   value="<?= htmlspecialchars($m['nombre']) ?>" required>

                            <label class="form-label">Especialidad</label>
                            <input type="text" name="especialidad" class="form-control mb-2"
                                   value="<?= htmlspecialchars($m['especialidad']) ?>" required>

                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion" class="form-control mb-2"
                                   value="<?= htmlspecialchars($m['direccion']) ?>" required>

                            <label class="form-label">Servicios</label>
                            <input type="text" name="servicios" class="form-control mb-2"
                                   value="<?= htmlspecialchars($m['servicios']) ?>" required>

                            <h6 class="mt-3">Horario</h6>

                            <input type="text" name="horario_lunes" class="form-control mb-2"
                                   placeholder="Lunes" value="<?= $m['horario_lunes'] ?>">

                            <input type="text" name="horario_martes" class="form-control mb-2"
                                   placeholder="Martes" value="<?= $m['horario_martes'] ?>">

                            <input type="text" name="horario_miercoles" class="form-control mb-2"
                                   placeholder="Miércoles" value="<?= $m['horario_miercoles'] ?>">

                            <input type="text" name="horario_jueves" class="form-control mb-2"
                                   placeholder="Jueves" value="<?= $m['horario_jueves'] ?>">

                            <input type="text" name="horario_viernes" class="form-control mb-2"
                                   placeholder="Viernes" value="<?= $m['horario_viernes'] ?>">

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <?php endforeach; ?>
    </tbody>
</table>

<!-- MODAL CREAR -->
<div class="modal fade" id="modalCrear" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="/controllers/medicos.php" method="POST">
                <input type="hidden" name="action" value="crear">

                <div class="modal-header">
                    <h5 class="modal-title">Añadir Médico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control mb-2" required>

                    <label class="form-label">Especialidad</label>
                    <input type="text" name="especialidad" class="form-control mb-2" required>

                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control mb-2" required>

                    <label class="form-label">Servicios</label>
                    <input type="text" name="servicios" class="form-control mb-2" required>

                    <h6 class="mt-3">Horario</h6>

                    <input type="text" name="horario_lunes" class="form-control mb-2" placeholder="Lunes">
                    <input type="text" name="horario_martes" class="form-control mb-2" placeholder="Martes">
                    <input type="text" name="horario_miercoles" class="form-control mb-2" placeholder="Miércoles">
                    <input type="text" name="horario_jueves" class="form-control mb-2" placeholder="Jueves">
                    <input type="text" name="horario_viernes" class="form-control mb-2" placeholder="Viernes">

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
