<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Actividades</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/menu.css">


</head>

<body class="bg-light">

<div class="container py-4">

    <h2 class="mb-4">Gestión de Actividades</h2>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCrear">
        Crear Actividad
    </button>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaActividades"></tbody>
            </table>

        </div>
    </div>
</div>

<!-- ============================
     MODAL CREAR
============================= -->
<div class="modal fade" id="modalCrear">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formCrear">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Actividad</h5>
                </div>
                <div class="modal-body">

                    <select class="form-select mb-2" name="usuario_id" required>
                        <?php
                        require_once "../models/bbdd.php";
                        $db = new Database();
                        $conn = $db->connect();
                        $pacientes = $conn->query("SELECT id, nombre FROM usuarios WHERE rol='paciente'")->fetchAll();
                        foreach ($pacientes as $p) {
                            echo "<option value='{$p['id']}'>{$p['nombre']}</option>";
                        }
                        ?>
                    </select>

                    <input class="form-control mb-2" name="titulo" placeholder="Título" required>
                    <textarea class="form-control mb-2" name="descripcion" placeholder="Descripción"></textarea>
                    <input class="form-control mb-2" type="date" name="fecha" required>
                    <input class="form-control mb-2" type="time" name="hora" required>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================
     MODAL EDITAR
============================= -->
<div class="modal fade" id="modalEditar">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditar">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Actividad</h5>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="id" id="edit_id">

                    <select class="form-select mb-2" name="usuario_id" id="edit_usuario_id" required>
                        <?php
                        foreach ($pacientes as $p) {
                            echo "<option value='{$p['id']}'>{$p['nombre']}</option>";
                        }
                        ?>
                    </select>

                    <input class="form-control mb-2" name="titulo" id="edit_titulo" required>
                    <textarea class="form-control mb-2" name="descripcion" id="edit_descripcion"></textarea>
                    <input class="form-control mb-2" type="date" name="fecha" id="edit_fecha" required>
                    <input class="form-control mb-2" type="time" name="hora" id="edit_hora" required>

                    <select class="form-select" name="estado" id="edit_estado">
                        <option value="pendiente">Pendiente</option>
                        <option value="realizada">Realizada</option>
                    </select>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- BOTÓN VOLVER -->
    <div class="text-center mt-4">
        <button class="btn btn-secondary px-4 py-2" onclick="location.href='/admin/index.php'">
            Volver
        </button>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ===============================
// LISTAR
// ===============================
function cargarActividades() {
    fetch("../controllers/admin-actividades.php?action=listar")
        .then(r => r.json())
        .then(data => {
            const tbody = document.getElementById("tablaActividades");
            tbody.innerHTML = "";

            data.actividades.forEach(a => {
                tbody.innerHTML += `
                    <tr>
                        <td>${a.id}</td>
                        <td>${a.usuario_nombre}</td>
                        <td>${a.titulo}</td>
                        <td>${a.fecha}</td>
                        <td>${a.hora}</td>
                        <td>${a.estado}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="abrirEditar(${a.id})">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarActividad(${a.id})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
        });
}

// ===============================
// CREAR
// ===============================
document.getElementById("formCrear").addEventListener("submit", e => {
    e.preventDefault();

    const datos = Object.fromEntries(new FormData(e.target));

    fetch("../controllers/admin-actividades.php?action=crear", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(datos)
    })
    .then(r => r.json())
    .then(data => {
        alert(data.message);
        cargarActividades();
    });
});

// ===============================
// ABRIR EDITAR
// ===============================
function abrirEditar(id) {
    fetch("../controllers/admin-actividades.php?action=obtener", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    })
    .then(r => r.json())
    .then(data => {
        const a = data.actividad;

        document.getElementById("edit_id").value = a.id;
        document.getElementById("edit_usuario_id").value = a.usuario_id;
        document.getElementById("edit_titulo").value = a.titulo;
        document.getElementById("edit_descripcion").value = a.descripcion;
        document.getElementById("edit_fecha").value = a.fecha;
        document.getElementById("edit_hora").value = a.hora;
        document.getElementById("edit_estado").value = a.estado;

        new bootstrap.Modal(document.getElementById("modalEditar")).show();
    });
}

// ===============================
// EDITAR
// ===============================
document.getElementById("formEditar").addEventListener("submit", e => {
    e.preventDefault();

    const datos = Object.fromEntries(new FormData(e.target));

    fetch("../controllers/admin-actividades.php?action=editar", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(datos)
    })
    .then(r => r.json())
    .then(data => {
        alert(data.message);
        cargarActividades();
    });
});

// ===============================
// ELIMINAR
// ===============================
function eliminarActividad(id) {
    if (!confirm("¿Eliminar esta actividad?")) return;

    fetch("../controllers/admin-actividades.php?action=eliminar", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    })
    .then(r => r.json())
    .then(data => {
        alert(data.message);
        cargarActividades();
    });
}

cargarActividades();
</script>

</body>
</html>
