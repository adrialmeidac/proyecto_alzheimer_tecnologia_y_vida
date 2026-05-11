<?php
require_once __DIR__ . "/../models/bbdd.php";
require_once __DIR__ . "/../controllers/crear-notificaciones.php";

$db = new Database();
$conn = $db->connect();


$hoy = date("Y-m-d");
$horaActual = date("H:i:s");


$sql = $conn->prepare("
    SELECT 
        id,
        usuario_id,
        texto,
        fecha,
        hora_limite
    FROM actividades_usuario
    WHERE fecha = :hoy
      AND hora_limite < :horaActual
      AND realizada = 0
      AND notificada = 0
      AND notificar = 1
");
$sql->execute([
    ":hoy" => $hoy,
    ":horaActual" => $horaActual
]);

$actividades = $sql->fetchAll(PDO::FETCH_ASSOC);

if (!$actividades) {
    exit("No hay actividades vencidas.\n");
}

foreach ($actividades as $actividad) {

    $actividadId = $actividad["id"];
    $pacienteId = $actividad["usuario_id"];
    $texto = $actividad["texto"];

    
    crearNotificacion(
        $pacienteId,
        "actividad_no_realizada",
        "No completaste la actividad: '{$texto}' antes de la hora límite.",
        $actividadId
    );

    
    $update = $conn->prepare("
        UPDATE actividades_usuario
        SET notificada = 1
        WHERE id = :id
    ");
    $update->execute([":id" => $actividadId]);
}

echo "Notificaciones generadas correctamente.\n";
