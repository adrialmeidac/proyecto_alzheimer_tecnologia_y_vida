<?php

function enviarEmail($destinatario, $asunto, $mensaje) {

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Notificaciones Cognitio <no-reply@tudominio.com>\r\n";

    return mail($destinatario, $asunto, $mensaje, $headers);
}
