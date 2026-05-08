<?php require_once "../middleware/session-public.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/footer.css">

    <!-- CSS LOGIN -->
    <link rel="stylesheet" href="/assets/css/login.css">

    <!-- Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400&display=swap" rel="stylesheet">
</head>

<body>

    <!-- HEADER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/header.php'; ?>

    <!-- MENÚ PÚBLICO -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/public-menu.php'; ?>

    <?php
        // Obtener token desde la URL
        $token = $_GET["token"] ?? null;
        $tokenValido = $token && preg_match("/^[a-f0-9]{64}$/", $token);
    ?>

    <main class="login-wrapper d-flex justify-content-center align-items-start">
        <div class="login-card">

            <h2 class="text-center mb-3">Restablecer contraseña</h2>

            <?php if (!$tokenValido): ?>
                <p class="text-danger text-center">Token inválido o faltante.</p>

            <?php else: ?>

                <p class="text-center mb-3">
                    Introduce tu nueva contraseña.
                </p>

                <form id="resetForm" class="login-form">

                    <input type="hidden" id="token" value="<?= htmlspecialchars($token) ?>">

                    <label for="password">Nueva contraseña</label>
                    <input type="password" id="password" placeholder="Introduce tu nueva contraseña" required minlength="6">

                    <label for="password2">Repetir contraseña</label>
                    <input type="password" id="password2" placeholder="Repite tu nueva contraseña" required minlength="6">

                    <button type="submit" id="btnSubmit" class="main-btn w-100 mt-4">
                        Guardar nueva contraseña
                    </button>

                </form>

                <div id="mensaje" class="mt-3 text-center"></div>

            <?php endif; ?>

        </div>
    </main>

    <!-- FOOTER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>

    <script>
        document.getElementById("resetForm")?.addEventListener("submit", async function(e) {
            e.preventDefault();

            const password = document.getElementById("password").value.trim();
            const password2 = document.getElementById("password2").value.trim();
            const token = document.getElementById("token").value;
            const mensaje = document.getElementById("mensaje");
            const btn = document.getElementById("btnSubmit");

            mensaje.innerHTML = "";

            if (password.length < 6) {
                mensaje.innerHTML = "<p class='text-danger'>La contraseña debe tener al menos 6 caracteres.</p>";
                return;
            }

            if (password !== password2) {
                mensaje.innerHTML = "<p class='text-danger'>Las contraseñas no coinciden.</p>";
                return;
            }

            btn.disabled = true;
            btn.innerText = "Procesando...";

            try {
                const response = await fetch("/controllers/reset-password.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ token, password })
                });

                const data = await response.json();

                if (data.success) {
                    mensaje.innerHTML = `
                        <p class='text-success'>Tu contraseña ha sido actualizada correctamente.</p>
                        <p class='text-muted'>Redirigiendo al inicio de sesión...</p>
                    `;

                    setTimeout(() => {
                        window.location.href = "/pages/login.php";
                    }, 2500);

                } else {
                    mensaje.innerHTML = `<p class='text-danger'>${data.error}</p>`;
                }

            } catch (error) {
                mensaje.innerHTML = "<p class='text-danger'>Error al procesar la solicitud.</p>";
            }

            btn.disabled = false;
            btn.innerText = "Guardar nueva contraseña";
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
