<?php require_once "../middleware/admin.php"; ?>
<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-admin.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Usuarios</title>

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
        .filter-box {
            background: var(--card-bg);
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: var(--shadow);
        }
    </style>
</head>

<body>

<?php include "../includes/header.php"; ?>

<main class="admin-content flex-grow-1">
    <h1 class="text-center mb-4">Resultados Registrados</h1>

    <!-- FILTROS -->
    <div class="filter-box">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Filtrar por usuario:</label>
                <select id="filtroUsuario" class="form-select">
                    <option value="todos">Todos</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Filtrar por tipo:</label>
                <select id="filtroTipo" class="form-select">
                    <option value="todos">Todos</option>
                    <option value="memoria">Memoria</option>
                    <option value="atencion">Atención</option>
                    <option value="orientacion">Orientación</option>
                    <option value="test">Test general</option>
                    <option value="juego">Juego</option>
                </select>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary w-100" onclick="aplicarFiltros()">Aplicar filtros</button>
            </div>
        </div>
    </div>

    <!-- TABLA -->
    <div class="admin-table table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Tipo</th>
                    <th>Dificultad</th>
                    <th>Tiempo</th>
                    <th>Puntuación</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaResultados">
                <tr><td colspan="8" class="text-center">Cargando resultados...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-secondary" onclick="location.href='index.php'">Volver</button>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script>
let resultados = [];
let usuarios = [];

// 1. Cargar usuarios para el filtro
fetch("../controllers/admin-obtener-usuarios.php")
    .then(res => res.json())
    .then(data => {
        if (!data.success) return;

        usuarios = data.usuarios;

        const select = document.getElementById("filtroUsuario");
        usuarios.forEach(u => {
            const option = document.createElement("option");
            option.value = u.id;
            option.textContent = `${u.nombre} (${u.email})`;
            select.appendChild(option);
        });
    });

// 2. Cargar resultados
fetch("../controllers/admin-obtener-resultados.php")
    .then(res => res.json())
    .then(data => {
        const tabla = document.getElementById("tablaResultados");

        if (!data.success) {
            tabla.innerHTML = `<tr><td colspan="8" class="text-danger text-center">${data.error}</td></tr>`;
            return;
        }

        resultados = data.resultados;
        mostrarResultados(resultados);
    });

// 5. Eliminar resultado
function eliminarResultado(id) {
    if (!confirm("¿Eliminar este resultado?")) return;

    fetch("../controllers/admin-eliminar-resultados.php", {
        method: "POST",
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
