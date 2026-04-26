<?php
// Seguridad opcional: solo mostrar si el usuario es familiar/cuidador
if (!isset($_SESSION)) { session_start(); }

if (!in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    return; // evita que otros roles lo vean
}
?>

<nav class="private-menu">
    <ul>

        <!-- INICIO -->
        <li>
            <a href="/pages/dashboard.php">
                <img src="/assets/icons/home.svg" alt="Inicio">
                Inicio
            </a>
        </li>

        <!-- MIS PACIENTES -->
        <li>
            <a href="/pages/pacientes.php">
                <img src="/assets/icons/users.svg" alt="Pacientes">
                Mis Pacientes
            </a>
        </li>

        <!-- ACTIVIDADES DEL PACIENTE -->
        <li>
            <a href="/pages/actividades_paciente.php">
                <img src="/assets/icons/tasks.svg" alt="Actividades">
                Actividades del Paciente
            </a>
        </li>

        <!-- HISTORIAL -->
        <li>
            <a href="/pages/historial_paciente.php">
                <img src="/assets/icons/history.svg" alt="Historial">
                Historial
            </a>
        </li>

        <!-- FORO (opcional, si quieres que participen) -->
        <li>
            <a href="/pages/foro.php">
                <img src="/assets/icons/forum.svg" alt="Foro">
                Foro
            </a>
        </li>

        <!-- Notificaciones-->
        <li><a href="/pages/notificaciones-familiar.php">Notificaciones</a></li>


        <!-- CERRAR SESIÓN -->
        <li>
            <a href="/controllers/logout.php" class="logout-link">
                <img src="/assets/icons/logout.svg" alt="Salir">
                Cerrar sesión
            </a>
        </li>

    </ul>
</nav>
