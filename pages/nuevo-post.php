<?php require_once "../middleware/session.php"; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Publicación</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/nuevo-post.css">
</head>

<body>

    
    <?php include '../includes/header.php'; ?>

    
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    
    <?php
    if (!isset($_SESSION["user_id"])) {
        include '../includes/public-menu.php';

    } elseif ($_SESSION["rol"] === "admin") {
        include '../includes/menu-admin.php';

    } elseif ($_SESSION["rol"] === "familiar" || $_SESSION["rol"] === "cuidador") {
        include '../includes/menu-familiar.php';

    } else {
        include '../includes/private-menu.php';
    }
    ?>

    
    <?php include '../includes/responsive-menu.php'; ?>

    
    <?php
    if (!isset($_SESSION["user_id"])) {
        include '../includes/public-banner.php';
    } else {
        include '../includes/private-banner.php';
    }
    ?>

    <h1>Nueva Publicación</h1>
    <p class="subtitle">Comparte tus ideas o experiencias</p>

    
    <main class="newpost-container">

        <section class="newpost-section">

            <form id="postForm" class="newpost-form" action="../controllers/guardar_post.php" method="POST">

                <label for="titulo" class="form-label">Título</label>
                <input type="text" id="titulo" name="titulo" class="form-input"
                       placeholder="Escribe un título..." required autocomplete="off">

                <label for="contenido" class="form-label">Contenido</label>
                <textarea id="contenido" name="contenido" class="form-textarea"
                          placeholder="Escribe tu mensaje..." required autocomplete="off"></textarea>

                <button type="submit" class="main-btn">Publicar</button>

            </form>

        </section>

    </main>

    
    <div class="text-center mt-4">
        <button class="btn btn-secondary px-4 py-2" onclick="location.href='foro.php'">
            Volver
        </button>
    </div>

    
    <?php include '../includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>

</body>

</html>
