<?php require_once "../middleware/session.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividades Diarias</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/actividades.css">

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400&display=swap" rel="stylesheet">
</head>

<body>

    <!-- HEADER -->
    <?php include '../includes/header.php'; ?>

    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <!-- MENÚ PRIVADO -->
    <?php include '../includes/private-menu.php'; ?>

    <!-- MENÚ RESPONSIVE -->
    <?php include '../includes/responsive-menu.php'; ?>

    <!-- BANNER PRIVADO -->
    <?php include '../includes/private-banner.php'; ?>

    <p class="subtitle">Marca las actividades que realizaste hoy</p>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container mt-4">

        <!-- BOTÓN PARA AÑADIR ACTIVIDAD -->
        <div class="text-center mb-4">
            <button id="addActivityBtn" class="btn btn-success px-4 py-2">Añadir actividad</button>
        </div>

        <!-- CONTENEDOR DINÁMICO DE ACTIVIDADES -->
        <div id="activitiesList" class="row gy-4">
            <!-- Las actividades se generarán desde actividades.js -->
        </div>

    </main>

    <!-- BOTÓN VOLVER -->
    <div class="text-center mt-4">
        <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/dashboard.php'">
            Volver
        </button>
    </div>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?> 

    <!-- MODAL NUEVA ACTIVIDAD -->
    <div class="modal fade" id="modalNuevaActividad" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Nueva actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label class="form-label">Título</label>
                    <input type="text" id="nuevaTexto" class="form-control">

                    <label class="form-label mt-3">Descripción</label>
                    <textarea id="nuevaDescripcion" class="form-control" rows="3"></textarea>

                    <label class="form-label mt-3">Fecha</label>
                    <input type="date" id="nuevaFecha" class="form-control">

                    <label class="form-label mt-3">Hora límite</label>
                    <input type="time" id="nuevaHora" class="form-control">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnGuardarNueva" class="btn btn-primary">Guardar</button>
                </div>

            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>
    <script src="../assets/js/actividades.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
