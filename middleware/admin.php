<?php
require_once __DIR__ . "/session.php"; 


if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {

    
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

    
    header("Location: /pages/login.php");
    exit;
}
