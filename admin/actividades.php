<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Actividades</title>

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

    <h1 class="text-center mb-4">Gestión de Actividades</h1>

    <div class="admin-table table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaActividades">
                <tr><td colspan="8" class="text-center">Cargando actividades...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-secondary" onclick="location.href='index.php'">Volver</button>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<!-- MODAL EDITAR -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditar">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">

                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" id="edit_titulo" class="form-control" required>

                    <label class="form-label mt-2">Descripción</label>
                    <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="3" required></textarea>

                    <label class="form-label mt-2">Fecha</label>
                    <input type="date" name="fecha" id="edit_fecha" class="form-control" required>

                    <label class="form-label mt-2">Hora</label>
                    <input type="time" name="hora" id="edit_hora" class="form-control" required>

                    <label class="form-label mt-2">Estado</label>
                    <select name="estado" id="edit_estado" class="form-control">
                        <option value="pendiente">Pendiente</option>
                        <option value="realizada">Realizada</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Guardar cambios</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ---------------------------------------------------------
// Cargar actividades
// ---------------------------------------------------------
function cargarActividades() {
    fetch("../controllers/admin-actividades.php?action=listar")
        .then(res => res.json())
        .then(data => {
            const tabla = document.getElementById("tablaActividades");

            if (!data.success) {
                tabla.innerHTML = `<tr><td colspan="8" class="text-danger text-center">${data.error}</td></tr>`;
                return;
            }

            tabla.innerHTML = "";

            data.actividades.forEach(a => {
                const tr = document.createElement("tr");

                tr.innerHTML = `
                    <td>${a.id}</td>
                    <td>${a.usuario}</td>
                    <td>${a.titulo}</td>
                    <td>${a.descripcion.substring(0, 50)}...</td>
                    <td>${a.fecha}</td>
                    <td>${a.hora}</td>
                    <td>${a.estado}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="abrirEditar(${a.id}, '${a.titulo}', \`${a.descripcion}\`, '${a.fecha}', '${a.hora}', '${a.estado}')">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="eliminar(${a.id})">Eliminar</button>
                    </td>
                `;

                tabla.appendChild(tr);
            });
        });
}

cargarActividades();

// ---------------------------------------------------------
// Abrir modal editar
// ---------------------------------------------------------
function abrirEditar(id, titulo, descripcion, fecha, hora, estado) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_titulo").value = titulo;
    document.getElementById("edit_descripcion").value = descripcion;
    document.getElementById("edit_fecha").value = fecha;
    document.getElementById("edit_hora").value = hora;
    document.getElementById("edit_estado").value = estado;

    new bootstrap.Modal(document.getElementById("modalEditar")).show();
}

// ---------------------------------------------------------
// Guardar edición
// ---------------------------------------------------------
document.getElementById("formEditar").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("../controllers/admin-actividades.php?action=editar", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);
        cargarActividades();
        bootstrap.Modal.getInstance(document.getElementById("modalEditar")).hide();
    });
});

// ---------------------------------------------------------
// Eliminar actividad
// ---------------------------------------------------------
function eliminar(id) {
    if (!confirm("¿Eliminar esta actividad?")) return;

    const formData = new FormData();
    formData.append("id", id);

    fetch("../controllers/admin-actividades.php?action=eliminar", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);
        cargarActividades();
    });
}
</script>

</body>
</html>
