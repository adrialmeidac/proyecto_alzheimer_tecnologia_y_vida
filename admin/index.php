<?php
require_once "../middleware/admin.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/color.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">

    <style>
        .admin-card {
    background: var(--color-white);
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: 0.25s ease;
}

.admin-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

        .admin-hero {
    
    color: white;
    padding: 30px;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 30px;
    box-shadow: var(--shadow);
}
.admin-hero p{
    color: var(--color-primary);
}

    </style>
</head>

<body>

<?php include "../includes/header.php"; ?>


<main class="flex-grow-1">

    <div class="container text-center mt-5">
        <div class="admin-hero">
            <h1>Panel Administrativo</h1>
            <p>Gestiona usuarios, contenido y actividades desde un solo lugar.</p>
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
            
        </div><br>
        <a href="/controllers/logout.php" class="btn btn-danger px-4 py-2" style="font-size:18px;">
       Cerrar sesión
   </a>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

</body>
</html>
