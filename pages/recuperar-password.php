<?php require_once "../middleware/session-public.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/footer.css">

    
    <link rel="stylesheet" href="/assets/css/login.css">

    
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400&display=swap" rel="stylesheet">
</head>

<body>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/header.php'; ?>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/public-menu.php'; ?>
    

    <main class="login-wrapper d-flex justify-content-center align-items-start">
        <div class="login-card">

            <h2 class="text-center mb-3">Recuperar contraseña</h2>

            <p class="text-center mb-3">
                Introduce tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
            </p>

            <form id="recuperarForm" class="login-form">

                <label for="email">Correo electrónico</label>
                <input 
                    type="email" 
                    id="email" 
                    placeholder="Introduce tu email"
                    required
                >

                <button type="submit" id="btnSubmit" class="main-btn w-100 mt-4">
                    Enviar enlace
                </button>

                <button type="button" class="back-btn mt-3" onclick="location.href='/pages/login.php'">
                    Volver al inicio de sesión
                </button>

            </form>

            
            <div id="mensaje" class="mt-3 text-center"></div>

        </div>
    </main>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>

    <script>
        document.getElementById("recuperarForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const email = document.getElementById("email").value.trim();
            const mensaje = document.getElementById("mensaje");
            const btn = document.getElementById("btnSubmit");

            mensaje.innerHTML = "";

            if (!email) {
                mensaje.innerHTML = "<p class='text-danger'>Debes introducir un email.</p>";
                return;
            }

            if (!email.includes("@") || email.length < 6) {
                mensaje.innerHTML = "<p class='text-danger'>Introduce un email válido.</p>";
                return;
            }

            btn.disabled = true;
            btn.innerText = "Enviando...";

            try {
                const response = await fetch("/controllers/solicitar-reset.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ email })
                });

                const data = await response.json();

                if (data.success) {
                    mensaje.innerHTML = `
                        <p class='text-success'>
                            Si el correo está registrado, recibirás un enlace para restablecer tu contraseña.
                        </p>
                    `;
                } else {
                    mensaje.innerHTML = `<p class='text-danger'>${data.error}</p>`;
                }

            } catch (error) {
                mensaje.innerHTML = "<p class='text-danger'>Error al procesar la solicitud.</p>";
            }

            btn.disabled = false;
            btn.innerText = "Enviar enlace";
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
