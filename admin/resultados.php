<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Usuarios</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS GLOBAL -->
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

    <!-- HEADER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/header.php"; ?>

    <!-- MENÚ ADMIN -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/menu-admin.php"; ?>

    <!-- MENÚ RESPONSIVE -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/responsive-menu.php"; ?>

    <main class="admin-content flex-grow-1">

        <h1 class="admin-title text-center mb-4">Resultados Registrados</h1>

        <!-- FILTROS -->
        <div class="filter-box">
            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Usuario</label>
                    <select id="filtroUsuario" class="form-select">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tipo</label>
                    <select id="filtroTipo" class="form-select">
                        <option value="">Todos</option>
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

    <!-- FOOTER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"; ?>

    <script>
    let resultados = [];
    let usuarios = [];

    // ===============================
    // CARGAR USUARIOS PARA FILTRO
    // ===============================
    async function cargarUsuarios() {
        const res = await fetch("/controllers/admin-obtener-usuarios.php");
        const data = await res.json();

        if (!data.success) return;

        usuarios = data.usuarios;

        const select = document.getElementById("filtroUsuario");
        usuarios.forEach(u => {
            select.innerHTML += `<option value="${u.id}">${u.nombre} (${u.email})</option>`;
        });
    }

    // ===============================
    // CARGAR RESULTADOS
    // ===============================
    async function cargarResultados() {
        const res = await fetch("/controllers/admin-obtener-resultados.php");
        const data = await res.json();

        const tabla = document.getElementById("tablaResultados");

        if (!data.success) {
            tabla.innerHTML = `<tr><td colspan="8" class="text-danger text-center">${data.error}</td></tr>`;
            return;
        }

        resultados = data.resultados;
        mostrarResultados(resultados);
    }

    // ===============================
    // MOSTRAR RESULTADOS
    // ===============================
    function mostrarResultados(lista) {
        const tabla = document.getElementById("tablaResultados");
        tabla.innerHTML = "";

        if (!lista.length) {
            tabla.innerHTML = `<tr><td colspan="8" class="text-center">No hay resultados.</td></tr>`;
            return;
        }

        lista.forEach(r => {
            tabla.innerHTML += `
                <tr>
                    <td>${r.id}</td>
                    <td>${r.usuario}</td>
                    <td>${r.tipo}</td>
                    <td>${r.dificultad}</td>
                    <td>${r.tiempo}</td>
                    <td>${r.puntuacion}</td>
                    <td>${r.fecha}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="eliminarResultado(${r.id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });
    }

    // ===============================
    // APLICAR FILTROS
    // ===============================
    function aplicarFiltros() {
        const usuario = document.getElementById("filtroUsuario").value;
        const tipo = document.getElementById("filtroTipo").value;

        let filtrados = resultados;

        if (usuario) filtrados = filtrados.filter(r => r.usuario_id == usuario);
        if (tipo) filtrados = filtrados.filter(r => r.tipo == tipo);

        mostrarResultados(filtrados);
    }

    // ===============================
    // ELIMINAR RESULTADO
    // ===============================
    async function eliminarResultado(id) {
        if (!confirm("¿Eliminar este resultado?")) return;

        const res = await fetch("/controllers/admin-eliminar-resultados.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id })
        });

        const data = await res.json();

        alert(data.message || data.error);

        if (data.success) cargarResultados();
    }

    // Inicializar
    cargarUsuarios();
    cargarResultados();
    </script>

</body>
</html>
