<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión del Foro</title>

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
    <h1 class="text-center mb-4">Gestión del Foro</h1>
<div class="text-end mb-3">
    <button class="btn btn-primary" onclick="location.href='foro-nuevo.php'">
        Crear nuevo tema
    </button>
</div>

    <div class="admin-table table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Fecha</th>
                    <th>Respuestas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaTemas">
                <tr><td colspan="6" class="text-center">Cargando temas...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-secondary" onclick="location.href='index.php'">Volver</button>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script>
// Cargar temas del foro
fetch("../controllers/admin-foro.php?action=get_temas")
    .then(res => res.json())
    .then(data => {
        const tabla = document.getElementById("tablaTemas");

        if (!data.success) {
            tabla.innerHTML = `<tr><td colspan="6" class="text-danger text-center">${data.error}</td></tr>`;
            return;
        }

        if (!data.temas.length) {
            tabla.innerHTML = `<tr><td colspan="6" class="text-center">No hay temas en el foro.</td></tr>`;
            return;
        }

        tabla.innerHTML = "";

        data.temas.forEach(t => {
            const tr = document.createElement("tr");

            const fecha = t.fecha ? new Date(t.fecha).toLocaleString("es-ES") : "";

            tr.innerHTML = `
                <td>${t.id}</td>
                <td>${t.titulo}</td>
                <td>${t.nombre} ${t.apellido}</td>
                <td>${fecha}</td>
                <td>${t.respuestas}</td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="verTema(${t.id})">Ver</button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarTema(${t.id})">Eliminar</button>
                </td>
            `;

            tabla.appendChild(tr);
        });
    })
    .catch(err => {
        console.error(err);
        document.getElementById("tablaTemas").innerHTML =
            `<tr><td colspan="6" class="text-danger text-center">Error al cargar temas</td></tr>`;
    });

function verTema(id) {
    location.href = `foro-ver.php?id=${id}`;
}

function eliminarTema(id) {
    if (!confirm("¿Eliminar este tema y todas sus respuestas?")) return;

    fetch("../controllers/admin-foro.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            action: "delete_tema",
            id: id
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);
        if (data.success) location.reload();
    })
    .catch(err => {
        console.error(err);
        alert("Error al eliminar el tema");
    });
}
</script>

</body>
</html>
