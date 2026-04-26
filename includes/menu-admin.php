<div class="admin-menu-trigger">≡</div>

<nav class="admin-sidebar">
    <ul>
        <li><a href="/admin/index.php">Panel</a></li>
        <li><a href="/admin/usuarios.php">Usuarios</a></li>
        <li><a href="/admin/profesionales.php">Profesionales</a></li>
        <li><a href="/admin/foro.php">Foro</a></li>
        <li><a href="/admin/contenido.php">Contenido</a></li>
        <li><a href="/admin/actividades.php">Actividades</a></li>
        <li><a href="/admin/notificaciones.php">Notificaciones</a></li>
        <li><a href="/backend/logout.php" class="logout">Cerrar sesión</a></li>
    </ul>
</nav>

<style>
/* Botón flotante para abrir el menú */
.admin-menu-trigger {
    position: fixed;
    top: 8%;
    left: 10px;
    width: 40px;
    height: 40px;
    background: var(--color-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    z-index: 999;
    font-size: 22px;
    transition: 0.2s;
}

.admin-menu-trigger:hover {
    background: var(--color-primary-dark);
}

/* Sidebar oculto */
.admin-sidebar {
    position: fixed;
    top: 10%;
    left: -220px; /* oculto */
    width: 220px;
    height: 50vh; /* solo mitad de pantalla */
    background: var(--header-bg);
    padding: 20px;
    box-shadow: 2px 0 10px rgba(0,0,0,0.15);
    transition: left 0.3s ease;
    z-index: 998;
    border-radius: 0 10px 10px 0;
}

/* Mostrar menú al pasar el ratón por el botón */
.admin-menu-trigger:hover + .admin-sidebar,
.admin-sidebar:hover {
    left: 0;
}

/* Lista */
.admin-sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.admin-sidebar li {
    margin-bottom: 12px;
}

.admin-sidebar a {
    color: var(--color-text);
    text-decoration: none;
    font-size: 16px;
    padding: 8px 10px;
    display: block;
    border-radius: 6px;
    transition: 0.2s;
}

.admin-sidebar a:hover {
    background: rgba(0,0,0,0.1);
}

/* Cerrar sesión */
.logout {
    color: #c0392b !important;
    font-weight: bold;
}
.logout:hover {
    background: rgba(192,57,43,0.2);
}
</style>
