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
    <title>Gestión de Usuarios</title>
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

    <h2 class="mb-4">Gestión de Usuarios</h2>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCrear">
        Crear Usuario
    </button>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaUsuarios"></tbody>
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
                    <h5 class="modal-title">Crear Usuario</h5>
                </div>
                <div class="modal-body">

                    <input class="form-control mb-2" name="nombre" placeholder="Nombre" required>
                    <input class="form-control mb-2" name="email" placeholder="Email" required>
                    <input class="form-control mb-2" name="password" placeholder="Contraseña" required>

                    <select class="form-select" name="rol" required>
                        <option value="paciente">Paciente</option>
                        <option value="familiar">Familiar</option>
                        <option value="cuidador">Cuidador</option>
                        <option value="admin">Administrador</option>
                    </select>

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
                    <h5 class="modal-title">Editar Usuario</h5>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="id" id="edit_id">

                    <input class="form-control mb-2" name="nombre" id="edit_nombre" required>
                    <input class="form-control mb-2" name="email" id="edit_email" required>

                    <select class="form-select" name="rol" id="edit_rol" required>
                        <option value="paciente">Paciente</option>
                        <option value="familiar">Familiar</option>
                        <option value="cuidador">Cuidador</option>
                        <option value="admin">Administrador</option>
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
function cargarUsuarios() {
    fetch("../controllers/admin-usuarios.php?action=listar")
        .then(r => r.json())
        .then(data => {
            const tbody = document.getElementById("tablaUsuarios");
            tbody.innerHTML = "";

            data.usuarios.forEach(u => {
                tbody.innerHTML += `
                    <tr>
                        <td>${u.id}</td>
                        <td>${u.nombre}</td>
                        <td>${u.email}</td>
                        <td>${u.rol}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="abrirEditar(${u.id})">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(${u.id})">Eliminar</button>
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

    fetch("../controllers/admin-usuarios.php?action=crear", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(datos)
    })
    .then(r => r.json())
    .then(data => {
        alert(data.message);
        cargarUsuarios();
    });
});

// ===============================
// ABRIR MODAL EDITAR
// ===============================
function abrirEditar(id) {
    fetch("../controllers/admin-usuarios.php?action=obtener", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    })
    .then(r => r.json())
    .then(data => {
        const u = data.usuario;

        document.getElementById("edit_id").value = u.id;
        document.getElementById("edit_nombre").value = u.nombre;
        document.getElementById("edit_email").value = u.email;
        document.getElementById("edit_rol").value = u.rol;

        new bootstrap.Modal(document.getElementById("modalEditar")).show();
    });
}

// ===============================
// EDITAR
// ===============================
document.getElementById("formEditar").addEventListener("submit", e => {
    e.preventDefault();

    const datos = Object.fromEntries(new FormData(e.target));

    fetch("../controllers/admin-usuarios.php?action=editar", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(datos)
    })
    .then(r => r.json())
    .then(data => {
        alert(data.message);
        cargarUsuarios();
    });
});

// ===============================
// ELIMINAR
// ===============================
function eliminarUsuario(id) {
    if (!confirm("¿Eliminar este usuario?")) return;

    fetch("../controllers/admin-usuarios.php?action=eliminar", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    })
    .then(r => r.json())
    .then(data => {
        alert(data.message);
        cargarUsuarios();
    });
}

cargarUsuarios();
</script>

</body>
</html>
