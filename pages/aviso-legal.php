<?php require_once "../middleware/session-public.php"?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso Legal</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/politicas.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
</head>

<body>

    <!-- HEADER -->
    <?php include '../includes/header.php'; ?>

    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <!-- MENÚ SEGÚN SESIÓN -->
    <?php
    if (!isset($_SESSION["user_id"])) {
        include '../includes/public-menu.php';
    } elseif ($_SESSION["rol"] === "admin") {
        include '../includes/menu-admin.php';
    } else {
        include '../includes/private-menu.php';
    }
    ?>

    <!-- MENÚ RESPONSIVE -->
    <?php include '../includes/responsive-menu.php'; ?>

    <!-- BANNER PÚBLICO -->
    <?php include '../includes/public-banner.php'; ?>

    <h2 class="text-center mt-5">Aviso legal</h2>

    <div class="container mt-4">

        <h2>Aviso legal - Alzheimer, tecnología y vida</h2>

        <p>
            En esta sección se detallan las condiciones legales del uso del sitio web.
            Al acceder y utilizar el sitio, el usuario acepta estas condiciones.
        </p>

        <p><strong>1. Datos identificativos</strong></p>
        <p>
            En cumplimiento con la Ley 34/2002 (LSSI-CE), se informa que:<br>
            • Titular: [Nombre o razón social]<br>
            • NIF/CIF: [Número de identificación fiscal]<br>
            • Domicilio: [Dirección completa]<br>
            • Correo electrónico: [Email de contacto]
        </p>

        <p><strong>2. Objeto y ámbito de aplicación</strong></p>
        <p>
            Este sitio web ofrece información y recursos relacionados con el Alzheimer y la tecnología aplicada a la salud.
            El acceso implica la aceptación plena de este Aviso Legal.
        </p>

        <p><strong>3. Condiciones de uso</strong></p>
        <p>
            El usuario se compromete a no realizar actividades ilícitas, difundir contenido ofensivo o dañar los sistemas del sitio.
            El titular podrá bloquear el acceso a usuarios que incumplan estas condiciones.
        </p>

        <p><strong>4. Propiedad intelectual e industrial</strong></p>
        <p>
            Todos los contenidos del sitio están protegidos por derechos de propiedad intelectual.
            Se prohíbe su reproducción o distribución sin autorización.
        </p>

        <p><strong>5. Responsabilidad</strong></p>
        <p>
            El titular no se responsabiliza de errores en los contenidos, falta de disponibilidad o daños derivados del uso del sitio.
        </p>

        <p><strong>6. Enlaces a terceros</strong></p>
        <p>
            El sitio puede contener enlaces externos. El titular no se hace responsable de sus contenidos o políticas.
        </p>

        <p><strong>7. Protección de datos personales (RGPD)</strong></p>
        <p>
            Los datos personales serán tratados conforme al RGPD y la normativa española vigente.
            Para más información, consulte la Política de Privacidad.
        </p>

        <p><strong>8. Derechos de los usuarios</strong></p>
        <p>
            El usuario puede ejercer sus derechos de acceso, rectificación, supresión, oposición y portabilidad mediante solicitud al correo indicado.
        </p>

        <p><strong>9. Exclusión de garantías</strong></p>
        <p>
            No se garantiza la ausencia de virus, aunque se aplican medidas para evitarlos.
        </p>

        <p><strong>10. Legislación aplicable</strong></p>
        <p>
            La relación entre el titular y el usuario se rige por la normativa española vigente.
        </p>

        <p><strong>11. Modificaciones</strong></p>
        <p>
            El titular podrá modificar este Aviso Legal en cualquier momento.
        </p>

        <p><strong>12. Documentos legales adicionales</strong></p>
        <p>
            Las políticas de privacidad, cookies y accesibilidad están disponibles en secciones independientes del sitio.
        </p>

        <!-- BOTÓN VOLVER -->
        <div class="text-center mt-4">
            <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/index.php'">Volver</button>
        </div>

    </div>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>

</body>
</html>
