<?php require_once "../middleware/session-public.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Crear cuenta</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/footer.css">

    <!-- CSS REGISTRO -->
    <link rel="stylesheet" href="/assets/css/registro.css">

    <!-- Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400&display=swap" rel="stylesheet">
</head>

<body>

    <!-- HEADER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/header.php'; ?>

    <!-- MENÚ PÚBLICO -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/public-menu.php'; ?>
    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <main class="registro-wrapper d-flex justify-content-center align-items-start">
        <div class="registro-card">

            <h2 class="text-center mb-3">Crear cuenta</h2>

            <form id="registroForm" class="registro-form">

                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" placeholder="Introduce tu nombre">

                <label for="email">Correo electrónico</label>
                <input type="email" id="email" placeholder="Introduce tu email">

                <label for="password">Contraseña</label>
                <input type="password" id="password" placeholder="Crea una contraseña">

                <label for="password2">Repetir contraseña</label>
                <input type="password" id="password2" placeholder="Repite la contraseña">

                <!-- NUEVO: Selección de rol -->
                <label for="rol" class="mt-3">Tipo de cuenta</label>
                <select id="rol" name ="rol" class="form-select">
                    <option value="paciente">Paciente</option>
                    <option value="familiar">Familiar</option>
                    <option value="cuidador">Cuidador</option>
                </select>

                <button 
                    class="g-recaptcha main-btn w-100 mt-4"
                    data-sitekey="6LcHlbgsAAAAAOZ5avcwIW3sMduPFBvynXZ9fnxK"
                    data-callback="onSubmit"
                    data-action="submit">
                    Crear cuenta
                </button>

                <p class="login-text mt-3 text-center">
                    ¿Ya tienes cuenta?
                    <a href="/pages/login.php" class="login-link">Inicia sesión aquí</a>
                </p>

                <button type="button" class="back-btn mt-3" onclick="location.href='/pages/index.php'">
                    Volver al inicio
                </button>

            </form>

        </div>
    </main>

    <!-- FOOTER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/registro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
