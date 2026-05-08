<?php 
require_once "../middleware/session.php"; 

// SOLO FAMILIAR O CUIDADOR
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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
   

</head>

<body>

    <!-- HEADER -->
    <?php include "../includes/header.php"; ?>

    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <!-- MENÚ FAMILIAR -->
    <?php include "../includes/menu-familiar.php"; ?>

    <!-- MENÚ RESPONSIVE -->
    <?php include "../includes/responsive-menu.php"; ?>

    <!-- BANNER PRIVADO -->
    <?php include "../includes/private-banner.php"; ?>

    <h2 class="subtitle mt-3">Panel Familiar / Cuidador</h2>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="dashboard-container container mt-4">

        <!-- TARJETAS PRINCIPALES -->
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
                <section class="dashboard-card" onclick="mostrar('crearActividad')">
                    <h3>Crear Actividad</h3>
                    <p>Asignar una nueva actividad</p>
                </section>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <section class="dashboard-card" onclick="mostrar('historial')">
                    <h3>Historial</h3>
                    <p>Ver actividades realizadas</p>
                </section>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <section class="dashboard-card" onclick="mostrar('vincular')">
                    <h3>Vincular Paciente</h3>
                    <p>Asociar un paciente por email</p>
                </section>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <section class="dashboard-card" onclick="location.href='/pages/foro.php'">
                    <h3>Foro</h3>
                    <p>Acceder al foro</p>
                </section>
            </div>

        </div>

        <!-- SECCIÓN: MIS PACIENTES -->
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

        <!-- SECCIÓN: ACTIVIDADES -->
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

        <!-- SECCIÓN: CREAR ACTIVIDAD -->
        <div id="crearActividad" class="seccion">
            <h3 class="subtitle">Crear Actividad</h3>
            <button class="main-btn mb-3" onclick="volver()">Volver</button>

            <form id="formCrearActividad">
                <select class="form-select mb-2" name="paciente_id" id="selectPacienteCrear" required></select>
                <input class="form-control mb-2" name="titulo" placeholder="Título" required>
                <textarea class="form-control mb-2" name="descripcion" placeholder="Descripción"></textarea>
                <input class="form-control mb-2" type="date" name="fecha" required>
                <input class="form-control mb-2" type="time" name="hora" required>
                <button class="main-btn">Crear Actividad</button>
            </form>
        </div>

        <!-- SECCIÓN: HISTORIAL -->
        <div id="historial" class="seccion">
            <h3 class="subtitle">Historial del Paciente</h3>
            <button class="main-btn mb-3" onclick="volver()">Volver</button>

            <select id="selectPacienteHistorial" class="form-select mb-3"></select>

            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody id="tablaHistorial"></tbody>
            </table>
        </div>

        <!-- SECCIÓN: VINCULAR PACIENTE -->
        <div id="vincular" class="seccion">
            <h3 class="subtitle">Vincular Paciente</h3>
            <button class="main-btn mb-3" onclick="volver()">Volver</button>

            <form id="formVincular">
                <input class="form-control mb-2" name="email" placeholder="Email del paciente" required>
                <input class="form-control mb-2" name="parentesco" placeholder="Parentesco" required>
                <button class="main-btn">Vincular</button>
            </form>
        </div>

    </main>

    <?php include "../includes/footer.php"; ?>

    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/emergencias.js"></script>
    <script src="/assets/js/familiar.js"></script>



</body>
</html>
