<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Tema del Foro</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/menu.css">

</head>

<body>

    <!-- HEADER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/header.php"; ?>

    <!-- MENÚ ADMIN -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/menu-admin.php"; ?>

    <main class="admin-content flex-grow-1">

        <h1 class="admin-title text-center mb-4">Crear nuevo tema</h1>

        <div class="admin-card card p-4 shadow">

            <div class="mb-3">
                <label class="form-label">Título del tema</label>
                <input type="text" id="titulo" class="form-control" required minlength="3">
            </div>

            <div class="mb-3">
                <label class="form-label">Contenido</label>
                <textarea id="contenido" class="form-control" rows="6" required minlength="5"></textarea>
            </div>

            <div id="mensaje" class="mt-2"></div>

            <div class="text-end mt-3">
                <button class="btn btn-success" id="btnGuardar">Guardar</button>
                <button class="btn btn-secondary" onclick="location.href='foro.php'">Cancelar</button>
            </div>

        </div>

    </main>

    <!-- FOOTER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"; ?>

    <script>
    document.getElementById("btnGuardar").addEventListener("click", async () => {

        const titulo = document.getElementById("titulo").value.trim();
        const contenido = document.getElementById("contenido").value.trim();
        const mensaje = document.getElementById("mensaje");
        const btn = document.getElementById("btnGuardar");

        mensaje.innerHTML = "";

        if (titulo.length < 3) {
            mensaje.innerHTML = "<p class='text-danger'>El título debe tener al menos 3 caracteres.</p>";
            return;
        }

        if (contenido.length < 5) {
            mensaje.innerHTML = "<p class='text-danger'>El contenido debe tener al menos 5 caracteres.</p>";
            return;
        }

        btn.disabled = true;
        btn.innerText = "Guardando...";

        try {
            const res = await fetch("/controllers/admin-foro.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action: "create_tema",
                    titulo,
                    contenido
                })
            });

            const data = await res.json();

            if (data.success) {
                mensaje.innerHTML = "<p class='text-success'>Tema creado correctamente. Redirigiendo...</p>";
                setTimeout(() => location.href = "foro.php", 1500);
            } else {
                mensaje.innerHTML = `<p class='text-danger'>${data.error}</p>`;
            }

        } catch (err) {
            mensaje.innerHTML = "<p class='text-danger'>Error al crear el tema.</p>";
        }

        btn.disabled = false;
        btn.innerText = "Guardar";
    });
    </script>

</body>
</html>
