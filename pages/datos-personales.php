<?php require_once "../middleware/session.php"; ?>

<?php
// SOLO PACIENTES PUEDEN ACCEDER A ESTA PÁGINA
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "paciente") {
    header("Location: /pages/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos personales</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/datos-personales.css">

    <!-- Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400&display=swap" rel="stylesheet">
</head>

<body class="register-body">

    <!-- HEADER -->
    <?php include '../includes/header.php'; ?>

    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <!-- SIN MENÚ AQUÍ -->

    <main class="register-container">

        <div class="register-card">

            <h2>Datos personales</h2>
            <p class="register-subtitle">Completa tu información para continuar</p>

            <!-- Caja de errores -->
            <div id="datos-errors" class="register-errors" style="display:none;"></div>

            <!-- Formulario -->
            <form id="datosForm" class="register-form">

                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Introduce tu nombre">

                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" required placeholder="Introduce tu apellido">

                <label for="fecha">Fecha de nacimiento</label>
                <input type="date" id="fecha" name="fecha" required>

                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" placeholder="Ej: 612345678">

                <!-- ELIMINADO: Campo de rol (ya no se usa aquí) -->

                <button type="submit" class="register-btn">Guardar datos</button>

                <p class="register-login">
                    <a href="/pages/index.php">Volver al inicio</a>
                </p>

            </form>

        </div>

    </main>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>
    <script src="../assets/js/datos_personales.js"></script>

</body>

</html>
