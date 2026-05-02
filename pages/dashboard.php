<?php 
require_once "../middleware/session.php"; 

// REDIRECCIÓN SEGÚN PERFIL COMPLETADO
if (!isset($_SESSION["perfil_completado"]) || $_SESSION["perfil_completado"] == 0) {

    if ($_SESSION["rol"] === "paciente") {
        header("Location: /pages/datos-personales.php");
        exit();
    }

    if ($_SESSION["rol"] === "familiar" || $_SESSION["rol"] === "cuidador") {
        header("Location: /pages/registro_familiar.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
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

    <?php
    // MENÚ SEGÚN ROL
    if ($_SESSION["rol"] === "admin") {
        include "../includes/menu-admin.php";

    } elseif ($_SESSION["rol"] === "paciente") {
        include "../includes/private-menu.php";

    } elseif ($_SESSION["rol"] === "familiar" || $_SESSION["rol"] === "cuidador") {
        include "../includes/menu-familiar.php"; // ESTE LO CREAMOS AHORA

    } else {
        include "../includes/private-menu.php";
    }
    ?>

    <!-- MENÚ RESPONSIVE -->
    <?php include "../includes/responsive-menu.php"; ?>

    <!-- BANNER PRIVADO -->
    <?php include "../includes/private-banner.php"; ?>

    <h2 class="subtitle mt-3">¿Qué haremos hoy?</h2>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="dashboard-container container mt-4">

        <?php if ($_SESSION["rol"] === "paciente"): ?>

            <!-- TARJETAS DEL PACIENTE -->
            <div class="row g-4">

                <!-- JUEGOS -->
                <div class="col-12 col-md-6 col-lg-4">
                    <section class="dashboard-card" onclick="location.href='juegos.php'">
                        <div class="carousel">
                            <div class="carousel-track">
                                <img src="/assets/images/rompe1.jpg">
                                <img src="/assets/images/rompe2.jpg">
                                <img src="/assets/images/memo1.jpg">
                                <img src="/assets/images/ajedrez.jpg">
                                <img src="/assets/images/sudoku.jpg">
                                <img src="/assets/images/bingo.jpg">
                            </div>
                        </div>
                        <h3>Juegos Cognitivos</h3>
                        <p>Ejercita la memoria y la atención</p>
                    </section>
                </div>

                <!-- ACTIVIDADES -->
                <div class="col-12 col-md-6 col-lg-4">
                    <section class="dashboard-card" onclick="location.href='actividades.php'">
                        <div class="carousel">
                            <div class="carousel-track">
                                <img src="/assets/images/act-bicicleta.jpg">
                                <img src="/assets/images/act-comer.jpg">
                                <img src="/assets/images/act-caminar.jpg">
                                <img src="/assets/images/act-tomar-medic.jpg">
                            </div>
                        </div>
                        <h3>Actividades Diarias</h3>
                        <p>Marca tus actividades diarias</p>
                    </section>
                </div>

                <!-- FORO -->
                <div class="col-12 col-md-6 col-lg-4">
                    <section class="dashboard-card" onclick="location.href='foro.php'">
                        <div class="carousel">
                            <div class="carousel-track">
                                <img src="/assets/images/foro-1.jpg">
                                <img src="/assets/images/foro-2.png">
                                <img src="/assets/images/foro-3.png">
                            </div>
                        </div>
                        <h3>Foro</h3>
                        <p>Participa y cuenta tu experiencia</p>
                    </section>
                </div>

                <!-- INFORMACIÓN -->
                <div class="col-12 col-md-6 col-lg-4">
                    <section class="dashboard-card" onclick="location.href='informacion.php'">
                        <div class="carousel">
                            <div class="carousel-track">
                                <img src="/assets/images/informacion1.jpg">
                                <img src="/assets/images/informacion2.jpg">
                                <img src="/assets/images/informacion3.jpg">
                            </div>
                        </div>
                        <h3>Información</h3>
                        <p>Aprende sobre el Alzheimer</p>
                    </section>
                </div>

                <!-- TESTS -->
                <div class="col-12 col-md-6 col-lg-4">
                    <section class="dashboard-card" onclick="location.href='test.php'">
                        <div class="carousel">
                            <div class="carousel-track">
                                <img src="/assets/images/test1.jpg">
                                <img src="/assets/images/test2.jpg">
                                <img src="/assets/images/test3.jpg">
                            </div>
                        </div>
                        <h3>Tests Cognitivos</h3>
                        <p>Evalúa tu estado mental</p>
                    </section>
                </div>

                <!-- EMERGENCIA -->
                <div class="col-12 col-md-6 col-lg-4">
                    <section class="dashboard-card" onclick="confirmarEmergencia()">
                        <div class="img-emergencia">
                            <img src="/assets/images/emergencia112.png">
                        </div>
                        <h3>Llamada de emergencia</h3>
                        <p>Si necesitas ayuda pincha aquí</p>
                    </section>
                </div>

            </div>

        <?php else: ?>

            <!-- TARJETAS DEL FAMILIAR / CUIDADOR -->
            <div class="row g-4">

                <div class="col-12 col-md-6 col-lg-4">
                    <section class="dashboard-card" onclick="location.href='pacientes.php'">
                        <h3>Mis Pacientes</h3>
                        <p>Ver y gestionar pacientes vinculados</p>
                    </section>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <section class="dashboard-card" onclick="location.href='actividades_pacientes.php'">
                        <h3>Actividades del Paciente</h3>
                        <p>Crear y revisar actividades</p>
                    </section>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <section class="dashboard-card" onclick="location.href='historial_paciente.php'">
                        <h3>Historial</h3>
                        <p>Ver progreso y registros</p>
                    </section>
                </div>

            </div>

        <?php endif; ?>

    </main>

    <?php include "../includes/footer.php"; ?>

    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/emergencias.js"></script>

    <!-- MODAL DE EMERGENCIA -->
<div id="emergency-modal" class="emergency-modal">
    <div class="emergency-modal-content">
        <h2>🚨 Llamada de emergencia</h2>
        <p>¿Deseas llamar al <strong>112</strong>? Usa esta opción solo en situaciones reales.</p>

        <div class="emergency-buttons">
            <button class="btn-cancelar" onclick="cerrarModalEmergencia()">Cancelar</button>
            <button class="btn-llamar" onclick="realizarLlamadaEmergencia()">Llamar</button>
        </div>
    </div>
</div>


</body>
</html>
