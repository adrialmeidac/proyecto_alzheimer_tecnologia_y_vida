<?php require_once "../middleware/session-public.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/login.css">

    <!-- Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400&display=swap" rel="stylesheet">
</head>

<body>

    <!-- HEADER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/header.php'; ?>

    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    <!-- MENÚ PÚBLICO -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/public-menu.php'; ?>

    <!-- BANNER PÚBLICO -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/public-banner.php'; ?>

    <main class="login-wrapper d-flex justify-content-center align-items-start">
        <div class="login-card">

            <h2 class="text-center mb-3">Iniciar sesión</h2>

            <form id="loginForm" class="login-form" method="POST" action="#">

                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="Introduce tu email" required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Introduce tu contraseña" required>

                <button type="submit" class="main-btn w-100 mt-4">Entrar</button>

                <!-- 🔥 ENLACE NUEVO: OLVIDÉ MI CONTRASEÑA -->
                <p class="forgot-password text-center mt-2">
                    <a href="/pages/recuperar-password.php" class="forgot-link">
                        ¿Olvidaste tu contraseña?
                    </a>
                </p>

                <p class="register-text mt-3 text-center">
                    ¿No tienes cuenta?
                    <a href="/pages/registro.php" class="register-link">Regístrate aquí</a>
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
    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
