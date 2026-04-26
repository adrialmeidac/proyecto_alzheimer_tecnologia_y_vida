<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>

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
        .role-badge {
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.9rem;
            color: white;
        }
        .role-admin { background: #198754; }
        .role-paciente { background: #0d6efd; }
        .role-familiar { background: #6f42c1; }
        .role-cuidador { background: #fd7e14; }
    </style>
</head>

<body>

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-admin.php"; ?>

<main class="admin-content flex-grow-1">
    <h1 class="text-center mb-4">Gestión de Usuarios</h1>

    <div class="admin-table table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Actividades</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaUsuarios">
                <tr><td colspan="6" class="text-center">Cargando usuarios...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-secondary" onclick="location.href='index.php'">Volver</button>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<!-- MODAL CAMBIAR ROL -->
<div class="modal fade" id="modalCambiarRol" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Cambiar Rol del Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="usuarioId">

        <label class="form-label">Selecciona el nuevo rol:</label>
        <select id="nuevoRol" class="form-select">
            <option value="paciente">Paciente</option>
            <option value="familiar">Familiar</option>
            <option value="cuidador">Cuidador</option>
            <option value="admin">Administrador</option>
        </select>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" onclick="guardarNuevoRol()">Guardar cambios</button>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Cargar usuarios desde backend
fetch("../controllers/admin-obtener-usuarios.php")
    .then(res => res.json())
    .then(data => {
        const tabla = document.getElementById("tablaUsuarios");

        if (!data.success) {
            tabla.innerHTML = `<tr><td colspan="6" class="text-danger text-center">${data.error}</td></tr>`;
            return;
        }

        tabla.innerHTML = "";

        data.usuarios.forEach(u => {
            const tr = document.createElement("tr");

            tr.innerHTML = `
                <td>${u.id}</td>
                <td>${u.email}</td>
                <td>${u.nombre}</td>
                <td>
                    <span class="role-badge role-${u.rol}">
                        ${u.rol}
                    </span>
                </td>
                <td>${u.total_actividades}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="cambiarRol(${u.id})">Cambiar rol</button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(${u.id})">Eliminar</button>
                </td>
            `;

            tabla.appendChild(tr);
        });
    })
    .catch(err => {
        console.error(err);
        document.getElementById("tablaUsuarios").innerHTML =
            `<tr><td colspan="6" class="text-danger text-center">Error al cargar usuarios</td></tr>`;
    });

// Modal Bootstrap
let modalCambiarRol = null;

document.addEventListener("DOMContentLoaded", () => {
    modalCambiarRol = new bootstrap.Modal(document.getElementById("modalCambiarRol"));
});

// Abrir modal
function cambiarRol(id) {
    document.getElementById("usuarioId").value = id;
    modalCambiarRol.show();
}

// Guardar nuevo rol
function guardarNuevoRol() {
    const id = document.getElementById("usuarioId").value;
    const rol = document.getElementById("nuevoRol").value;

    fetch("../controllers/admin-cambiar-rol.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, rol })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);

        if (data.success) {
            modalCambiarRol.hide();
            location.reload();
        }
    })
    .catch(err => {
        console.error(err);
        alert("Error al actualizar el rol");
    });
}

// Eliminar usuario
function eliminarUsuario(id) {
    if (!confirm("¿Eliminar este usuario? Esta acción no se puede deshacer.")) return;

    fetch("../controllers/admin-eliminar-usuario.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);
        location.reload();
    });
}
</script>

</body>
</html>
