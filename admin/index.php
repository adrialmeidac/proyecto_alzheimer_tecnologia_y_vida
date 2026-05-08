<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo</title>

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

    <!-- MENÚ RESPONSIVE -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/responsive-menu.php"; ?>

    <main class="admin-content flex-grow-1">

        <div class="container mt-5">

            <div class="admin-hero">
                <h1 class="admin-title">Panel Administrativo</h1>
                <h3>Gestiona usuarios, contenido y actividades desde un solo lugar.</h3>
            </div>

            <div class="row g-4">

                <div class="col-md-4">
                    <a href="usuarios.php" class="text-decoration-none">
                        <div class="admin-card">
                            <h3>Gestión de Usuarios</h3>
                            <p>Ver, editar roles y eliminar usuarios.</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="profesionales.php" class="text-decoration-none">
                        <div class="admin-card">
                            <h3>Profesionales</h3>
                            <p>Gestionar profesionales del sistema.</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="foro.php" class="text-decoration-none">
                        <div class="admin-card">
                            <h3>Foro</h3>
                            <p>Moderar temas y respuestas.</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="contenido.php" class="text-decoration-none">
                        <div class="admin-card">
                            <h3>Contenido Informativo</h3>
                            <p>Actualizar textos, artículos y recursos.</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="actividades.php" class="text-decoration-none">
                        <div class="admin-card">
                            <h3>Actividades</h3>
                            <p>Gestionar actividades del sistema.</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="notificaciones.php" class="text-decoration-none">
                        <div class="admin-card">
                            <h3>Notificaciones</h3>
                            <p>Enviar o revisar notificaciones.</p>
                        </div>
                    </a>
                </div>

            </div>

            <div class="text-center mt-4 mb-5">
                <a href="/controllers/logout.php" class="btn btn-danger px-4 py-2" style="font-size:18px;">
                    Cerrar sesión
                </a>
            </div>

        </div>

    </main>

    <!-- FOOTER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"; ?>

</body>
</html>
