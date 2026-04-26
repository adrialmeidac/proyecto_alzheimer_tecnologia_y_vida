<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Profesionales</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/color.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">

    <style>
        .admin-table {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow);
        }
    </style>
</head>

<body>

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-admin.php"; ?>

<main class="admin-content flex-grow-1">
    <h1 class="text-center mb-4">Gestión de Profesionales</h1>

    <div class="text-end mb-3">
        <button class="btn btn-primary" onclick="location.href='profesionales-nuevo.php'">Añadir Profesional</button>
    </div>

    <div class="admin-table table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
<th>Nombre</th>
<th>Especialidad</th>
<th>Dirección</th>
<th>Servicios</th>
<th>Lunes</th>
<th>Martes</th>
<th>Miércoles</th>
<th>Jueves</th>
<th>Viernes</th>
<th>Acciones</th>

                </tr>
            </thead>
            <tbody id="tablaProfesionales">
                <tr><td colspan="6" class="text-center">Cargando profesionales...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-secondary" onclick="location.href='index.php'">Volver</button>
    </div>
</main>

<?php include "../includes/footer.php"; ?>
</body>
</html>

<script>
// Cargar profesionales desde backend
fetch("../controllers/admin-profesionales.php?action=get")
    .then(res => res.json())
    .then(data => {
        const tabla = document.getElementById("tablaProfesionales");

        if (!data.success) {
            tabla.innerHTML = `<tr><td colspan="6" class="text-danger text-center">${data.error}</td></tr>`;
            return;
        }

        tabla.innerHTML = "";

        data.profesionales.forEach(p => {
            const tr = document.createElement("tr");

tr.innerHTML = `
    <td>${p.id}</td>
    <td>${p.nombre}</td>
    <td>${p.especialidad}</td>
    <td>${p.direccion}</td>
    <td>${p.servicios ?? ""}</td>
    <td>${p.horario_lunes ?? ""}</td>
    <td>${p.horario_martes ?? ""}</td>
    <td>${p.horario_miercoles ?? ""}</td>
    <td>${p.horario_jueves ?? ""}</td>
    <td>${p.horario_viernes ?? ""}</td>
    <td>
        <button class="btn btn-sm btn-warning" onclick="editar(${p.id})">Editar</button>
        <button class="btn btn-sm btn-danger" onclick="eliminar(${p.id})">Eliminar</button>
    </td>

            `;

            tabla.appendChild(tr);
        });
    })
    .catch(err => {
        console.error(err);
        document.getElementById("tablaProfesionales").innerHTML =
            `<tr><td colspan="6" class="text-danger text-center">Error al cargar profesionales</td></tr>`;
    });

function editar(id) {
    location.href = `profesionales-editar.php?id=${id}`;
}

function eliminar(id) {
    if (!confirm("¿Eliminar este profesional?")) return;

    fetch("../controllers/admin-profesionales.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            action: "delete",
            id: id
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);
        location.reload();
    });
}
</script>


