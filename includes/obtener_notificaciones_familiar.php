<?php
require_once __DIR__ . "/../models/bbdd.php";

function obtenerNotificacionesFamiliar($familiar_id) {

    $db = new Database();
    $conn = $db->connect();

    $sql = $conn->prepare("
        SELECT n.*
        FROM notificaciones n
        INNER JOIN relaciones_paciente_familiar rpf 
            ON rpf.paciente_id = n.usuario_id
        WHERE rpf.familiar_id = :familiar
        ORDER BY n.fecha DESC
    ");

    $sql->execute([':familiar' => $familiar_id]);

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}
