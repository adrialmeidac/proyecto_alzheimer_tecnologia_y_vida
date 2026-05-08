<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- MENÚ RESPONSIVE (solo visible en móvil) -->
<nav id="responsive-menu" class="responsive-menu">
    <ul class="responsive-menu-list">

        <?php if (!isset($_SESSION["user_id"])): ?>
            <!-- MENÚ PÚBLICO -->
            <li><a href="/pages/index.php">Inicio</a></li>
            <li><a href="/pages/que-es.php">¿Qué es el Alzheimer?</a></li>
            <li><a href="/pages/fases.php">Fases</a></li>
            <li><a href="/pages/prevencion.php">Prevención</a></li>
            <li><a href="/pages/tratamiento.php">Tratamiento</a></li>
            <li><a href="/pages/tipos-demencia.php">Tipos de demencia</a></li>
            <li><a href="/pages/ejercicio.php">Rutina diaria</a></li>
            <li><a href="/pages/aceptando.php">El cuidador</a></li>
            <li><a href="/pages/informacion.php">Temática descargable</a></li>
            <li><a href="/pages/foro.php">Foro</a></li>
            <li><a href="/pages/contactos-profesionales.php">Contacta a un profesional</a></li>
            <li><a href="/pages/login.php">Iniciar sesión</a></li>
            <li><a href="/pages/registro.php">Regístrate</a></li>

        <?php elseif ($_SESSION["rol"] === "admin"): ?>
            <!-- MENÚ ADMIN -->
            <li><a href="/pages/admin-dashboard.php">Panel administrativo</a></li>
            <li><a href="/pages/admin-usuarios.php">Gestión de usuarios</a></li>
            <li><a href="/pages/admin-profesionales.php">Profesionales</a></li>
            <li><a href="/pages/admin-foro.php">Foro</a></li>
            <li><a href="/pages/admin-contenido.php">Contenido</a></li>
            <li><a href="/pages/admin-actividades.php">Actividades</a></li>
            <li><a href="/pages/admin-notificaciones.php">Notificaciones</a></li>
            <li><a href="/controllers/logout.php">Cerrar sesión</a></li>

        <?php elseif (in_array($_SESSION["rol"], ["familiar", "cuidador"])): ?>
            <!-- MENÚ FAMILIAR / CUIDADOR -->
            <li><a href="/pages/dashboard.php">Panel principal</a></li>
            <li><a href="/pages/pacientes.php">Mis Pacientes</a></li>
            <li><a href="/pages/actividades_pacientes.php">Actividades del Paciente</a></li>
            <li><a href="/pages/historial_paciente.php">Historial</a></li>
            <li><a href="/pages/foro.php">Foro</a></li>
            <li><a href="/pages/notificaciones-familiar.php">Notificaciones</a></li>
            <li><a href="/controllers/logout.php">Cerrar sesión</a></li>

        <?php else: ?>
            <!-- MENÚ PACIENTE -->
            <li><a href="/pages/dashboard.php">Panel principal</a></li>
            <li><a href="/pages/actividades.php">Mis actividades</a></li>
            <li><a href="/pages/historial.php">Historial</a></li>
            <li><a href="/pages/juegos.php">Juegos</a></li>
            <li><a href="/pages/foro.php">Foro</a></li>
            <li><a href="/pages/notificaciones.php">Notificaciones</a></li>
            <li><a href="/controllers/logout.php">Cerrar sesión</a></li>

        <?php endif; ?>

    </ul>
</nav>

<div id="menu-overlay"></div>

<script>
const menuBtn = document.getElementById("menu-toggle");
const responsiveMenu = document.getElementById("responsive-menu");
const overlay = document.getElementById("menu-overlay");

// Abrir/cerrar menú
menuBtn.addEventListener("click", () => {
    responsiveMenu.classList.toggle("open");
    overlay.classList.toggle("active");
    document.body.style.overflow = responsiveMenu.classList.contains("open") ? "hidden" : "auto";
});

// Cerrar al tocar overlay
overlay.addEventListener("click", () => {
    responsiveMenu.classList.remove("open");
    overlay.classList.remove("active");
    document.body.style.overflow = "auto";
});

// Cerrar con tecla ESC
document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && responsiveMenu.classList.contains("open")) {
        responsiveMenu.classList.remove("open");
        overlay.classList.remove("active");
        document.body.style.overflow = "auto";
    }
});
</script>
