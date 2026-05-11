<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Contenido</title>

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
        .pdf-link {
            color: 
            text-decoration: underline;
        }
    </style>
</head>

<body>

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-admin.php"; ?>
<button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<main class="admin-content flex-grow-1">

    <h1 class="text-center mb-4">Gestión de Contenido</h1>

    <div class="text-end mb-3">
        <button class="btn btn-primary" onclick="abrirCrear()">➕ Nuevo Documento</button>
    </div>

    
    <div id="crearContenidoBox" class="card mb-4 d-none">
        <div class="card-body">
            <h5 class="card-title">Nuevo documento</h5>
            <form id="formCrearContenido">
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Archivo PDF</label>
                    <input type="file" name="archivo" class="form-control" accept="application/pdf" required>
                </div>

                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarCrear()">Cancelar</button>
            </form>
        </div>
    </div>

    
    <div id="editarContenidoBox" class="card mb-4 d-none">
        <div class="card-body">
            <h5 class="card-title">Editar documento</h5>
            <form id="formEditarContenido">
                <input type="hidden" name="id">

                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Archivo PDF (opcional)</label>
                    <input type="file" name="archivo" class="form-control" accept="application/pdf">
                </div>

                <button type="submit" class="btn btn-warning">Actualizar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarEditar()">Cancelar</button>
            </form>
        </div>
    </div>

    
    <div class="admin-table table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Archivo</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaContenido">
                <tr><td colspan="6" class="text-center">Cargando contenido...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-secondary" onclick="location.href='index.php'">Volver</button>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script>



function cargarContenido() {
    fetch("../controllers/admin-contenido.php?action=listar")
        .then(res => res.json())
        .then(data => {
            const tabla = document.getElementById("tablaContenido");

            if (!data.success) {
                tabla.innerHTML = `<tr><td colspan="6" class="text-danger text-center">${data.error}</td></tr>`;
                return;
            }

            tabla.innerHTML = "";

            data.contenido.forEach(c => {
                const tr = document.createElement("tr");

                tr.innerHTML = `
                    <td>${c.id}</td>
                    <td>${c.titulo}</td>
                    <td>${c.descripcion.length > 60 ? c.descripcion.substring(0, 60) + "..." : c.descripcion}</td>
                    <td><a class="pdf-link" href="${c.archivo}" target="_blank">Ver PDF</a></td>
                    <td>${c.creado_en}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="abrirEditar(${c.id})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="eliminar(${c.id})">Eliminar</button>
                    </td>
                `;

                tabla.appendChild(tr);
            });
        })
        .catch(err => {
            console.error(err);
            document.getElementById("tablaContenido").innerHTML =
                `<tr><td colspan="6" class="text-danger text-center">Error al cargar contenido</td></tr>`;
        });
}

cargarContenido();




function abrirCrear() {
    document.getElementById("crearContenidoBox").classList.remove("d-none");
}

function cerrarCrear() {
    document.getElementById("crearContenidoBox").classList.add("d-none");
    document.getElementById("formCrearContenido").reset();
}

document.getElementById("formCrearContenido").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("../controllers/admin-contenido.php?action=crear", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);
        if (data.success) {
            cerrarCrear();
            cargarContenido();
        }
    })
    .catch(err => {
        console.error(err);
        alert("Error al crear el contenido");
    });
});




function abrirEditar(id) {
    fetch("../controllers/admin-contenido.php?action=listar")
        .then(res => res.json())
        .then(data => {
            const doc = data.contenido.find(d => d.id == id);
            if (!doc) return alert("Documento no encontrado");

            const box = document.getElementById("editarContenidoBox");
            const form = document.getElementById("formEditarContenido");

            form.id.value = doc.id;
            form.titulo.value = doc.titulo;
            form.descripcion.value = doc.descripcion;

            box.classList.remove("d-none");
        });
}

function cerrarEditar() {
    document.getElementById("editarContenidoBox").classList.add("d-none");
    document.getElementById("formEditarContenido").reset();
}

document.getElementById("formEditarContenido").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("../controllers/admin-contenido.php?action=editar", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);
        if (data.success) {
            cerrarEditar();
            cargarContenido();
        }
    })
    .catch(err => {
        console.error(err);
        alert("Error al actualizar el contenido");
    });
});




function eliminar(id) {
    if (!confirm("¿Eliminar este documento?")) return;

    const formData = new FormData();
    formData.append("id", id);

    fetch("../controllers/admin-contenido.php?action=eliminar", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);
        cargarContenido();
    });
}
</script>
<script src="/assets/js/theme.js"></script>

</body>
</html>
