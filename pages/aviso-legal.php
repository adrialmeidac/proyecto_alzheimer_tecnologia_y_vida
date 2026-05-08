<?php require_once "../middleware/session-public.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso Legal</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS GLOBAL -->
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
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/header.php"; ?>

    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <!-- MENÚ SEGÚN SESIÓN -->
    <?php
        if (!isset($_SESSION["user_id"])) {
            include $_SERVER["DOCUMENT_ROOT"] . "/includes/public-menu.php";
        } elseif ($_SESSION["rol"] === "admin") {
            include $_SERVER["DOCUMENT_ROOT"] . "/includes/menu-admin.php";
        } else {
            include $_SERVER["DOCUMENT_ROOT"] . "/includes/private-menu.php";
        }
    ?>

    <!-- MENÚ RESPONSIVE -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/responsive-menu.php"; ?>

    <!-- BANNER PÚBLICO -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/public-banner.php"; ?>

    <main class="public-content container mt-5">

        <h1 class="text-center mb-4">Aviso Legal</h1>

        <p>
            En esta sección se detallan las condiciones legales del uso del sitio web.
            Al acceder y utilizar el sitio, el usuario acepta estas condiciones.
        </p>

        <h3>1. Datos identificativos</h3>
        <p>
            En cumplimiento con la Ley 34/2002 (LSSI-CE), se informa que:<br>
            • Titular: [Nombre o razón social]<br>
            • NIF/CIF: [Número de identificación fiscal]<br>
            • Domicilio: [Dirección completa]<br>
            • Correo electrónico: [Email de contacto]
        </p>

        <h3>2. Objeto y ámbito de aplicación</h3>
        <p>
            Este sitio web ofrece información y recursos relacionados con el Alzheimer y la tecnología aplicada a la salud.
            El acceso implica la aceptación plena de este Aviso Legal.
        </p>

        <h3>3. Condiciones de uso</h3>
        <p>
            El usuario se compromete a no realizar actividades ilícitas, difundir contenido ofensivo o dañar los sistemas del sitio.
            El titular podrá bloquear el acceso a usuarios que incumplan estas condiciones.
        </p>

        <h3>4. Propiedad intelectual e industrial</h3>
        <p>
            Todos los contenidos del sitio están protegidos por derechos de propiedad intelectual.
            Se prohíbe su reproducción o distribución sin autorización.
        </p>

        <h3>5. Responsabilidad</h3>
        <p>
            El titular no se responsabiliza de errores en los contenidos, falta de disponibilidad o daños derivados del uso del sitio.
        </p>

        <h3>6. Enlaces a terceros</h3>
        <p>
            El sitio puede contener enlaces externos. El titular no se hace responsable de sus contenidos o políticas.
        </p>

        <h3>7. Protección de datos personales (RGPD)</h3>
        <p>
            Los datos personales serán tratados conforme al RGPD y la normativa española vigente.
            Para más información, consulte la Política de Privacidad.
        </p>

        <h3>8. Derechos de los usuarios</h3>
        <p>
            El usuario puede ejercer sus derechos de acceso, rectificación, supresión, oposición y portabilidad mediante solicitud al correo indicado.
        </p>

        <h3>9. Exclusión de garantías</h3>
        <p>
            No se garantiza la ausencia de virus, aunque se aplican medidas para evitarlos.
        </p>

        <h3>10. Legislación aplicable</h3>
        <p>
            La relación entre el titular y el usuario se rige por la normativa española vigente.
        </p>

        <h3>11. Modificaciones</h3>
        <p>
            El titular podrá modificar este Aviso Legal en cualquier momento.
        </p>

        <h3>12. Documentos legales adicionales</h3>
        <p>
            Las políticas de privacidad, cookies y accesibilidad están disponibles en secciones independientes del sitio.
        </p>

        <!-- BOTÓN VOLVER -->
        <div class="text-center mt-4">
            <button class="btn btn-secondary px-4 py-2" onclick="location.href='./index.php'">Volver</button>
        </div>

    </main>

    <!-- FOOTER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"; ?>

    <script src="/assets/js/theme.js"></script>

</body>
</html>
