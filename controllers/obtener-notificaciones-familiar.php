<?php

require_once __DIR__ . "/../models/bbdd.php";

function obtenerNotificacionesFamiliar($familiar_id)
{
    $db = new Database();
    $conn = $db->connect();

    
    $sql = $conn->prepare("
SELECT 
    n.id,
    n.usuario_id AS paciente_id,
    n.mensaje,
    n.fecha,
    n.leida,
    CONCAT(u.nombre, ' ', u.apellidos) AS paciente_nombre
FROM notificaciones n
INNER JOIN relaciones_familiares rf 
    ON rf.paciente_id = n.usuario_id
INNER JOIN usuarios u
    ON u.id = n.usuario_id
WHERE rf.familiar_id = :familiar_id
ORDER BY n.fecha DESC;
    ");

    $sql->execute([':familiar_id' => $familiar_id]);

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}
