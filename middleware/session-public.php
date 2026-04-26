<?php
// Solo iniciar sesión si no existe
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
