<?php

if (isset($_SESSION["rol"])) {
    return;
}
?>

<nav id="public-menu" class="public-menu-header" aria-label="Menú público">
    <ul class="menu-list" role="menu">

        <li role="menuitem"><a href="/pages/index.php">Inicio</a></li>

        
        <li class="menu-item has-submenu" role="menuitem">
            <a href="#" aria-haspopup="true" aria-expanded="false">Alzheimer y demencia</a>
            <ul class="submenu" role="menu">
                <li role="menuitem"><a href="/pages/que-es.php">¿Qué es?</a></li>
                <li role="menuitem"><a href="/pages/fases.php">Fases de la enfermedad</a></li>
                <li role="menuitem"><a href="/pages/prevencion.php">Prevención</a></li>
                <li role="menuitem"><a href="/pages/tratamiento.php">Tratamiento</a></li>
                <li role="menuitem"><a href="/pages/tipos-demencia.php">Tipos de demencia</a></li>
                <li role="menuitem"><a href="/pages/trastorno-comportamiento.php">Trastornos del comportamiento</a></li>
            </ul>
        </li>

        
        <li class="menu-item has-submenu" role="menuitem">
            <a href="#" aria-haspopup="true" aria-expanded="false">Rutina diaria en casa</a>
            <ul class="submenu" role="menu">
                <li role="menuitem"><a href="/pages/ejercicio.php">Ejercicio físico</a></li>
                <li role="menuitem"><a href="/pages/alimentacion.php">Alimentación</a></li>
                <li role="menuitem"><a href="/pages/higiene.php">Higiene personal</a></li>
                <li role="menuitem"><a href="/pages/estimulacion.php">Estimulación cognitiva</a></li>
                <li role="menuitem"><a href="/pages/sueno.php">Sueño y descanso</a></li>
                <li role="menuitem"><a href="/pages/seguridad.php">Seguridad</a></li>
            </ul>
        </li>

        
        <li class="menu-item has-submenu" role="menuitem">
            <a href="#" aria-haspopup="true" aria-expanded="false">El cuidador</a>
            <ul class="submenu" role="menu">
                <li role="menuitem"><a href="/pages/aceptando.php">Aceptando la enfermedad</a></li>
                <li role="menuitem"><a href="/pages/estres.php">Estrés emocional</a></li>
                <li role="menuitem"><a href="/pages/colaborativos.php">Cuidados colaborativos</a></li>
                <li role="menuitem"><a href="/pages/amor.php">Amarse sin culpa</a></li>
                <li role="menuitem"><a href="/pages/riesgos.php">Los riesgos del cuidador</a></li>
            </ul>
        </li>

        
        <li role="menuitem"><a href="/pages/informacion.php">Temática descargable</a></li>
        <li role="menuitem"><a href="/pages/foro.php">Foro</a></li>
        <li role="menuitem"><a href="/pages/contactos-profesionales.php">Contacta a un profesional</a></li>

        
        <li role="menuitem"><a href="/pages/registro.php">Regístrate</a></li>
        <li role="menuitem"><a href="/pages/login.php">Iniciar sesión</a></li>

    </ul>
</nav>
