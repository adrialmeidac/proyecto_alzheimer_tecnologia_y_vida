<?php
require_once __DIR__ . "/../models/bbdd.php";
require_once __DIR__ . "/enviar_email.php";

function crearNotificacion($usuario_id, $tipo, $mensaje, $referencia_id = null)
{
    // Conexión
    $db = new Database();
    $conn = $db->connect();

    // 1. Insertar notificación (columna corregida)
    $sql = "INSERT INTO notificaciones (usuario_id, tipo, mensaje, referencia_id)
            VALUES (:usuario_id, :tipo, :mensaje, :referencia_id)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':tipo' => $tipo,
        ':mensaje' => $mensaje,
        ':referencia_id' => $referencia_id
    ]);

    // 2. Obtener email del paciente
    $sqlUser = $conn->prepare("
        SELECT nombre, apellidos, email 
        FROM usuarios 
        WHERE id = :id 
        LIMIT 1
    ");
    $sqlUser->execute([':id' => $usuario_id]);
    $paciente = $sqlUser->fetch(PDO::FETCH_ASSOC);

    if (!$paciente) {
        return false; // paciente eliminado o inexistente
    }

    $emailPaciente = $paciente['email'];
    $nombrePaciente = $paciente['nombre'] . " " . $paciente['apellidos'];

    // 3. Obtener familiares vinculados (tabla corregida)
    $sqlFam = $conn->prepare("
        SELECT u.email 
        FROM relaciones_paciente_familiar r
        INNER JOIN usuarios u ON u.id = r.familiar_id
        WHERE r.paciente_id = :id
    ");
    $sqlFam->execute([':id' => $usuario_id]);
    $familiares = $sqlFam->fetchAll(PDO::FETCH_ASSOC);

    // 4. Preparar email
    $asunto = "Nueva notificación de $nombrePaciente";
    $mensajeHTML = "
        <h2>Notificación del sistema</h2>
        <p><strong>Paciente:</strong> $nombrePaciente</p>
        <p><strong>Tipo:</strong> $tipo</p>
        <p>$mensaje</p>
        <p><small>Este mensaje fue generado automáticamente.</small></p>
    ";

    // 5. Enviar email a cada familiar vinculado
    foreach ($familiares as $fam) {
        if (!empty($fam['email'])) {
            enviarEmail($fam['email'], $asunto, $mensajeHTML);
        }
    }

    // 6. Enviar también al paciente (si tiene email)
    if (!empty($emailPaciente)) {
        enviarEmail($emailPaciente, $asunto, $mensajeHTML);
    }

    return true;
}
