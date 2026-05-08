<?php
// Iniciar sesión solo si no existe
if (session_status() === PHP_SESSION_NONE) {

    // Configuración recomendada para seguridad
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_samesite', 'Lax');

    session_start();
}
