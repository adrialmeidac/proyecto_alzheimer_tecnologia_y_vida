<?php 
require_once "../middleware/session.php"; 

if (!isset($_SESSION["user_id"]) || !in_array($_SESSION["rol"], ["familiar","cuidador"])) {
    header("Location: /index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Familiar / Cuidador</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>

<body>

    <?php include "../includes/header.php"; ?>

    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <?php include "../includes/menu-familiar.php"; ?>
    <?php include "../includes/responsive-menu.php"; ?>
    <?php include "../includes/private-banner.php"; ?>

    <h2 class="subtitle mt-3">Panel Familiar / Cuidador</h2>

    <main class="dashboard-container container mt-4">

        <div id="dashboard" class="row g-4">

            <div class="col-12 col-md-6 col-lg-4">
                <section class="dashboard-card" onclick="mostrar('pacientes')">
                    <h3>Mis Pacientes</h3>
                    <p>Ver pacientes vinculados</p>
                </section>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <section class="dashboard-card" onclick="mostrar('actividades')">
                    <h3>Actividades del Paciente</h3>
                    <p>Ver actividades asignadas</p>
                </section>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <section class="dashboard-card" onclick="location.href='/pages/actividades_pacientes.php'">
                    <h3>Crear Actividades</h3>
                    <p>Accede a actividades</p>
                </section>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <section class="dashboard-card" onclick="location.href='/pages/historial_paciente.php'">
                    <h3>Historial de Actividades</h3>
                    <p>Ver actividades realizadas</p>
                </section>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <section class="dashboard-card" onclick="location.href='/pages/pacientes.php'">
                    <h3>Vincular Paciente</h3>
                    <p>Vincula uno o más pacientes</p>
                </section>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <section class="dashboard-card" onclick="location.href='/pages/foro.php'">
                    <h3>Foro</h3>
                    <p>Acceder al foro</p>
                </section>
            </div>

        </div>


        <div id="pacientes" class="seccion">
            <h3 class="subtitle">Mis Pacientes</h3>
            <button class="main-btn mb-3" onclick="volver()">Volver</button>

            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody id="tablaPacientes"></tbody>
            </table>
        </div>

        <div id="actividades" class="seccion">
            <h3 class="subtitle">Actividades del Paciente</h3>
            <button class="main-btn mb-3" onclick="volver()">Volver</button>

            <select id="selectPacienteActividades" class="form-select mb-3"></select>

            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody id="tablaActividades"></tbody>
            </table>
        </div>


    </main>

    <?php include "../includes/footer.php"; ?>

    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/familiar.js"></script>

</body>
</html>
