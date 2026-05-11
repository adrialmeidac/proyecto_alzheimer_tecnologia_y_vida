<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Relaciones Familiares</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/menu.css">


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

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/header.php"; ?>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/menu-admin.php"; ?>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/responsive-menu.php"; ?>
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


    <main class="admin-content flex-grow-1">

        <h1 class="admin-title text-center mb-4">Relaciones Familiares</h1>

        <div class="text-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
                Crear Relación
            </button>
        </div>

        <div class="admin-table table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Familiar/Cuidador</th>
                        <th>Parentesco</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaRelaciones">
                    <tr><td colspan="5" class="text-center">Cargando relaciones...</td></tr>
                </tbody>
            </table>
        </div>

    </main>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"; ?>

    
    <div class="modal fade" id="modalCrear">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCrear">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear Relación</h5>
                    </div>
                    <div class="modal-body">

                        <label>Paciente</label>
                        <select class="form-select mb-2" id="crear_paciente" required></select>

                        <label>Familiar / Cuidador</label>
                        <select class="form-select mb-2" id="crear_familiar" required></select>

                        <input class="form-control mb-2" id="crear_parentesco" placeholder="Parentesco" required>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalEditar">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditar">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Relación</h5>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" id="edit_id">

                        <label>Paciente</label>
                        <select class="form-select mb-2" id="edit_paciente" required></select>

                        <label>Familiar / Cuidador</label>
                        <select class="form-select mb-2" id="edit_familiar" required></select>

                        <input class="form-control mb-2" id="edit_parentesco" required>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    
    
    
    async function cargarListas() {
        const res = await fetch("/controllers/admin-relaciones.php?action=listas");
        const data = await res.json();

        const selPac = document.getElementById("crear_paciente");
        const selFam = document.getElementById("crear_familiar");
        const selPacE = document.getElementById("edit_paciente");
        const selFamE = document.getElementById("edit_familiar");

        data.pacientes.forEach(p => {
            selPac.innerHTML += `<option value="${p.id}">${p.nombre}</option>`;
            selPacE.innerHTML += `<option value="${p.id}">${p.nombre}</option>`;
        });

        data.familiares.forEach(f => {
            selFam.innerHTML += `<option value="${f.id}">${f.nombre}</option>`;
            selFamE.innerHTML += `<option value="${f.id}">${f.nombre}</option>`;
        });
    }

    
    
    
    async function cargarRelaciones() {
        const res = await fetch("/controllers/admin-relaciones.php?action=listar");
        const data = await res.json();

        const tbody = document.getElementById("tablaRelaciones");
        tbody.innerHTML = "";

        data.relaciones.forEach(r => {
            tbody.innerHTML += `
                <tr>
                    <td>${r.id}</td>
                    <td>${r.paciente_nombre}</td>
                    <td>${r.familiar_nombre}</td>
                    <td>${r.parentesco}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="abrirEditar(${r.id})">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarRelacion(${r.id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });
    }

    
    
    
    document.getElementById("formCrear").addEventListener("submit", async e => {
        e.preventDefault();

        const payload = {
            paciente_id: document.getElementById("crear_paciente").value,
            familiar_id: document.getElementById("crear_familiar").value,
            parentesco: document.getElementById("crear_parentesco").value
        };

        const res = await fetch("/controllers/admin-relaciones.php?action=crear", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload)
        });

        const data = await res.json();
        alert(data.message);
        cargarRelaciones();
    });

    
    
    
    async function abrirEditar(id) {
        const res = await fetch("/controllers/admin-relaciones.php?action=obtener", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id })
        });

        const data = await res.json();
        const r = data.relacion;

        document.getElementById("edit_id").value = r.id;
        document.getElementById("edit_paciente").value = r.paciente_id;
        document.getElementById("edit_familiar").value = r.familiar_id;
        document.getElementById("edit_parentesco").value = r.parentesco;

        new bootstrap.Modal(document.getElementById("modalEditar")).show();
    }

    
    
    
    document.getElementById("formEditar").addEventListener("submit", async e => {
        e.preventDefault();

        const payload = {
            id: document.getElementById("edit_id").value,
            paciente_id: document.getElementById("edit_paciente").value,
            familiar_id: document.getElementById("edit_familiar").value,
            parentesco: document.getElementById("edit_parentesco").value
        };

        const res = await fetch("/controllers/admin-relaciones.php?action=editar", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload)
        });

        const data = await res.json();
        alert(data.message);
        cargarRelaciones();
    });

    
    
    
    async function eliminarRelacion(id) {
        if (!confirm("¿Eliminar esta relación?")) return;

        const res = await fetch("/controllers/admin-relaciones.php?action=eliminar", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id })
        });

        const data = await res.json();
        alert(data.message);
        cargarRelaciones();
    }

    
    cargarListas();
    cargarRelaciones();
    </script>
<script src="/assets/js/theme.js"></script>

</body>
</html>
