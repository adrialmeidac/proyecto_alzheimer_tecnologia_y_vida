<?php require_once "../middleware/admin.php"; ?>
<?php require_once "../models/bbdd.php"; ?>

<?php
$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("SELECT * FROM profesionales ORDER BY nombre ASC");
$stmt->execute();
$medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Profesionales Médicos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/contactos-profesionales.css">

    <style>
        .doctor-photo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }
    </style>
</head>

<body>

<?php include '../includes/header.php'; ?>
<?php include '../includes/menu-admin.php'; ?>

<button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

<div class="container mt-4">

    <h2 class="mb-4">Gestión de Profesionales Médicos</h2>

    
    <a href="/pages/admin/medicos-add.php" class="btn btn-primary mb-3">➕ Añadir profesional</a>

    
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Foto</th>
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
                    <td>
                        <?php if (!empty($m['foto'])): ?>
                            <img src="<?= htmlspecialchars($m['foto']) ?>" class="doctor-photo">
                        <?php else: ?>
                            <img src="/assets/images/default-doctor.png" class="doctor-photo">
                        <?php endif; ?>
                    </td>

                    <td><?= htmlspecialchars($m['nombre']) ?></td>
                    <td><?= htmlspecialchars($m['especialidad']) ?></td>
                    <td><?= htmlspecialchars($m['direccion']) ?></td>
                    <td><?= htmlspecialchars($m['servicios']) ?></td>

                    <td>
                        <a href="/pages/admin/medicos-edit.php?id=<?= $m['id'] ?>" 
                           class="btn btn-warning btn-sm">Editar</a>

                        <a href="/controllers/profesionales.php?action=eliminar&id=<?= $m['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Eliminar este profesional?')">
                           Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="/pages/admin/index.php" class="btn btn-secondary">Volver</a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
