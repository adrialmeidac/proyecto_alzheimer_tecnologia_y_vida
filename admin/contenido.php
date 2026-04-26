<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Contenido</title>

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
        .pdf-link {
            color: #0d6efd;
            text-decoration: underline;
        }
    </style>
</head>

<body>

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-admin.php"; ?>

<main class="admin-content flex-grow-1">

    <h1 class="text-center mb-4">Gestión de Contenido</h1>

    <div class="text-end mb-3">
        <button class="btn btn-primary" onclick="abrirCrear()">➕ Nuevo Documento</button>
    </div>

    <!-- FORMULARIO CREAR CONTENIDO -->
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
// ---------------------------------------------------------
// Cargar contenido
// ---------------------------------------------------------
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
                    <td>${c.descripcion.substring(0, 60)}...</td>
                    <td><a class="pdf-link" href="${c.archivo}" target="_blank">Ver PDF</a></td>
                    <td>${c.fecha}</td>
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

// ---------------------------------------------------------
// Crear contenido (formulario)
// ---------------------------------------------------------
function abrirCrear() {
    document.getElementById("crearContenidoBox").classList.remove("d-none");
}

function cerrarCrear() {
    document.getElementById("crearContenidoBox").classList.add("d-none");
    document.getElementById("formCrearContenido").reset();
}

document.getElementById("formCrearContenido").addEventListener("submit", function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

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

// ---------------------------------------------------------
// Editar contenido (sigue con prompt + selector archivo)
// ---------------------------------------------------------
function abrirEditar(id) {
    const nuevoTitulo = prompt("Nuevo título:");
    if (!nuevoTitulo) return;

    const nuevaDescripcion = prompt("Nueva descripción:");
    if (!nuevaDescripcion) return;

    const archivo = document.createElement("input");
    archivo.type = "file";
    archivo.accept = "application/pdf";

    archivo.onchange = () => {
        const formData = new FormData();
        formData.append("id", id);
        formData.append("titulo", nuevoTitulo);
        formData.append("descripcion", nuevaDescripcion);

        if (archivo.files.length > 0) {
            formData.append("archivo", archivo.files[0]);
        }

        fetch("../controllers/admin-contenido.php?action=editar", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || data.error);
            cargarContenido();
        });
    };

    // Opcional: si no quiere cambiar el PDF, simplemente pulsa cancelar en el diálogo
    archivo.click();
}

// ---------------------------------------------------------
// Eliminar contenido
// ---------------------------------------------------------
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

</body>
</html>
