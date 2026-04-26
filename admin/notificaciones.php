<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Notificaciones</title>

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
        .badge-leida {
            background: #28a745;
        }
        .badge-no-leida {
            background: #dc3545;
        }
    </style>
</head>

<body>

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-admin.php"; ?>

<main class="admin-content flex-grow-1">

    <h1 class="text-center mb-4">Gestión de Notificaciones</h1>

    <!-- FILTROS -->
    <div class="card p-3 mb-4">
        <h5>Filtros</h5>

        <div class="row g-3">

            <div class="col-md-4">
                <label class="form-label">Usuario</label>
                <select id="filtroUsuario" class="form-select">
                    <option value="">Todos</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Fecha</label>
                <input type="date" id="filtroFecha" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Estado</label>
                <select id="filtroEstado" class="form-select">
                    <option value="">Todos</option>
                    <option value="1">Leída</option>
                    <option value="0">No leída</option>
                </select>
            </div>

        </div>

        <div class="text-end mt-3">
            <button class="btn btn-primary" onclick="cargarNotificaciones()">Aplicar filtros</button>
            <button class="btn btn-secondary" onclick="limpiarFiltros()">Limpiar</button>
        </div>
    </div>

    <!-- TABLA -->
    <div class="admin-table table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaNotificaciones">
                <tr><td colspan="6" class="text-center">Cargando notificaciones...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-secondary" onclick="location.href='index.php'">Volver</button>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script>
// ---------------------------------------------------------
// Cargar notificaciones con filtros
// ---------------------------------------------------------
function cargarNotificaciones() {

    const usuario = document.getElementById("filtroUsuario").value;
    const fecha = document.getElementById("filtroFecha").value;
    const estado = document.getElementById("filtroEstado").value;

    const params = new URLSearchParams();

    if (usuario) params.append("usuario_id", usuario);
    if (fecha) params.append("fecha", fecha);
    if (estado !== "") params.append("estado", estado);

    fetch("../controllers/admin-notificaciones.php?action=listar&" + params.toString())
        .then(res => res.json())
        .then(data => {
            const tabla = document.getElementById("tablaNotificaciones");

            if (!data.success) {
                tabla.innerHTML = `<tr><td colspan="6" class="text-danger text-center">${data.error}</td></tr>`;
                return;
            }

            tabla.innerHTML = "";

            data.notificaciones.forEach(n => {
                const tr = document.createElement("tr");

                tr.innerHTML = `
                    <td>${n.id}</td>
                    <td>${n.usuario}</td>
                    <td>${n.mensaje}</td>
                    <td>${n.fecha}</td>
                    <td>
                        <span class="badge ${n.leida == 1 ? 'badge-leida' : 'badge-no-leida'}">
                            ${n.leida == 1 ? 'Leída' : 'No leída'}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="eliminar(${n.id})">Eliminar</button>
                    </td>
                `;

                tabla.appendChild(tr);
            });
        });
}

// ---------------------------------------------------------
// Limpiar filtros
// ---------------------------------------------------------
function limpiarFiltros() {
    document.getElementById("filtroUsuario").value = "";
    document.getElementById("filtroFecha").value = "";
    document.getElementById("filtroEstado").value = "";
    cargarNotificaciones();
}

// ---------------------------------------------------------
// Eliminar notificación
// ---------------------------------------------------------
function eliminar(id) {
    if (!confirm("¿Eliminar esta notificación?")) return;

    const formData = new FormData();
    formData.append("id", id);

    fetch("../controllers/admin-notificaciones.php?action=eliminar", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);
        cargarNotificaciones();
    });
}

// ---------------------------------------------------------
// Cargar usuarios para el filtro
// ---------------------------------------------------------
function cargarUsuariosFiltro() {
    fetch("../controllers/admin-obtener-usuario.php")
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;

            const select = document.getElementById("filtroUsuario");

            data.usuarios.forEach(u => {
                const opt = document.createElement("option");
                opt.value = u.id;
                opt.textContent = `${u.nombre} (${u.email})`;
                select.appendChild(opt);
            });
        });
}

// Inicializar
cargarUsuariosFiltro();
cargarNotificaciones();

</script>

</body>
</html>
