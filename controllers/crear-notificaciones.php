<?php
require_once __DIR__ . "/../models/bbdd.php";
require_once __DIR__ . "/enviar_email.php";

function crearNotificacion($user_id, $tipo, $mensaje, $referencia_id = null) {

    // Conexión
    $db = new Database();
    $conn = $db->connect();

    // 1. Insertar notificación
    $sql = "INSERT INTO notificaciones (user_id, tipo, mensaje, referencia_id)
            VALUES (:user_id, :tipo, :mensaje, :referencia_id)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':user_id' => $user_id,
        ':tipo' => $tipo,
        ':mensaje' => $mensaje,
        ':referencia_id' => $referencia_id
    ]);

    // 2. Obtener email del paciente
    $sqlUser = $conn->prepare("SELECT email FROM usuarios WHERE id = :id LIMIT 1");
    $sqlUser->execute([':id' => $user_id]);
    $paciente = $sqlUser->fetch(PDO::FETCH_ASSOC);

    $emailPaciente = $paciente ? $paciente['email'] : null;

    // 3. Obtener familiares vinculados
    $sqlFam = $conn->prepare("
        SELECT u.email 
        FROM relaciones_familiares rf
        INNER JOIN usuarios u ON u.id = rf.familiar_id
        WHERE rf.paciente_id = :id
    ");
    $sqlFam->execute([':id' => $user_id]);
    $familiares = $sqlFam->fetchAll(PDO::FETCH_ASSOC);

    // 4. Preparar email
    $asunto = "Nueva notificación en Cognitio";
    $mensajeHTML = "
        <h2>Notificación del sistema</h2>
        <p>{$mensaje}</p>
        <p><small>Este mensaje fue generado automáticamente.</small></p>
    ";

    // 5. Enviar email a cada familiar
    foreach ($familiares as $fam) {
        if (!empty($fam['email'])) {
            enviarEmail($fam['email'], $asunto, $mensajeHTML);
        }
    }

    // 6. Opcional: enviar también al paciente
    if ($emailPaciente) {
        enviarEmail($emailPaciente, $asunto, $mensajeHTML);
    }

    return true;
}
