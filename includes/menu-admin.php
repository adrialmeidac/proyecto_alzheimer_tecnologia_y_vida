<?php

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    return; 
}
?>

<nav id="private-menu" class="private-menu-header" aria-label="Menú administrador">
    <ul class="menu-list">

        <li><a href="/admin/index.php">Panel principal</a></li>
        <li><a href="/admin/usuarios.php">Usuarios</a></li>
        <li><a href="/admin/profesionales.php">Profesionales</a></li>
        <li><a href="/admin/foro.php">Foro</a></li>
        <li><a href="/admin/contenido.php">Contenido</a></li>
        <li><a href="/admin/actividades.php">Actividades</a></li>
        <li><a href="/admin/notificaciones.php">Notificaciones</a></li>
        <li><a href="/controllers/logout.php" class="logout">Cerrar sesión</a></li>

    </ul>
</nav>
