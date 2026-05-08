<?php
session_start();

// Si no hay sesión → no autorizado
if (!isset($_SESSION["user_id"])) {

    // Si es AJAX → devolver JSON
    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
    ) {
        http_response_code(401);
        echo json_encode([
            "success" => false,
            "error" => "No autorizado"
        ]);
        exit;
    }

    // Navegación normal → redirigir al login
    header("Location: /pages/login.php");
    exit;
}
