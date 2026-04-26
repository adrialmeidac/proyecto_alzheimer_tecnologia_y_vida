<?php
require_once __DIR__ . "/../models/bbdd.php";
require_once __DIR__ . "/../controllers/crear-notificaciones.php";

$db = new Database();
$conn = $db->connect();

// Fecha y hora actual
$hoy = date("Y-m-d");
$horaActual = date("H:i:s");

// 1) Buscar actividades del paciente vencidas y no notificadas
$sql = $conn->prepare("
    SELECT 
        id,
        user_id,
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
    $pacienteId = $actividad["user_id"];
    $texto = $actividad["texto"];

    // 2) Notificación para el PACIENTE
    crearNotificacion(
        $pacienteId,
        "actividad_no_realizada",
        "No completaste la actividad: '{$texto}' antes de la hora límite.",
        $actividadId
    );

    // 3) Buscar familiares vinculados
    $sqlFam = $conn->prepare("
        SELECT familiar_id 
        FROM relaciones_paciente_familiar
        WHERE paciente_id = :paciente
    ");
    $sqlFam->execute([":paciente" => $pacienteId]);
    $familiares = $sqlFam->fetchAll(PDO::FETCH_ASSOC);

    // 4) Notificar a cada familiar/cuidador
    foreach ($familiares as $fam) {
        $familiarId = $fam["familiar_id"];

        crearNotificacion(
            $familiarId,
            "actividad_no_realizada_paciente",
            "El paciente no completó la actividad: '{$texto}' antes de la hora límite.",
            $actividadId
        );
    }

    // 5) Marcar actividad como notificada
    $update = $conn->prepare("
        UPDATE actividades_usuario
        SET notificada = 1
        WHERE id = :id
    ");
    $update->execute([":id" => $actividadId]);
}

echo "Notificaciones generadas correctamente.\n";
