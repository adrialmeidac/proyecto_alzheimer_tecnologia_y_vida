<?php
require_once __DIR__ . "/../models/bbdd.php";

function obtenerNotificacionesFamiliar($familiar_id) {

    $db = new Database();
    $conn = $db->connect();

    $sql = $conn->prepare("
        SELECT 
            n.id,
            n.usuario_id AS paciente_id,
            u.nombre AS paciente_nombre,
            u.apellidos AS paciente_apellidos,
            n.tipo,
            n.mensaje,
            n.fecha,
            n.leida
        FROM notificaciones n
        INNER JOIN relaciones_familiares rpf 
            ON rpf.paciente_id = n.usuario_id
        INNER JOIN usuarios u
            ON u.id = n.usuario_id
        WHERE rpf.familiar_id = :familiar
        ORDER BY n.fecha DESC
    ");

    $sql->execute([':familiar' => $familiar_id]);

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}
