<?php
// Validar sesión y rol
if (!isset($_SESSION["rol"]) || !in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    return; // No mostrar menú si no es familiar/cuidador
}
?>

<nav id="private-menu" class="private-menu-header" aria-label="Menú privado">
    <ul class="menu-list">

        <li><a href="/pages/dashboardFamiliar.php">Panel principal</a></li>
        <li><a href="/pages/pacientes.php">Mis Pacientes</a></li>
        <li><a href="/pages/actividades_pacientes.php">Actividades del Paciente</a></li>
        <li><a href="/pages/historial_paciente.php">Historial</a></li>
        <li><a href="/pages/foro.php">Foro</a></li>
        <li><a href="/pages/notificaciones-familiar.php">Notificaciones</a></li>
        <li><a href="/controllers/logout.php">Cerrar sesión</a></li>

    </ul>
</nav>
