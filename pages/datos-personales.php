<?php 
require_once "../middleware/session.php"; 


if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "paciente") {
    header("Location: /pages/dashboard.php");
    exit();
}


if (!empty($_SESSION["perfil_completado"]) && $_SESSION["perfil_completado"] == 1) {
    header("Location: /pages/dashboard.php");
    exit();
}


require_once "../models/bbdd.php";
$db = new Database();
$conn = $db->connect();

$sql = $conn->prepare("
    SELECT u.nombre, u.apellidos, u.telefono, p.fecha_nacimiento
    FROM usuarios u
    LEFT JOIN pacientes p ON p.user_id = u.id
    WHERE u.id = :id
    LIMIT 1
");
$sql->execute([":id" => $_SESSION["user_id"]]);
$datos = $sql->fetch(PDO::FETCH_ASSOC);

$nombre   = htmlspecialchars($datos["nombre"] ?? "");
$apellido = htmlspecialchars($datos["apellidos"] ?? "");
$fecha    = htmlspecialchars($datos["fecha_nacimiento"] ?? "");
$telefono = htmlspecialchars($datos["telefono"] ?? "");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos personales</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/datos-personales.css">

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400&display=swap" rel="stylesheet">
</head>

<body class="register-body">

    
    <?php include '../includes/header.php'; ?>

    
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    
    <?php include '../includes/private-menu.php'; ?>

    
    <?php include '../includes/responsive-menu.php'; ?>

    
    <?php include '../includes/private-banner.php'; ?>

    <main class="register-container">

        <div class="register-card">

            <h2>Datos personales</h2>
            <p class="register-subtitle">Completa tu información para continuar</p>

            <div id="datos-errors" class="register-errors" style="display:none;"></div>

            <form id="datosForm" class="register-form">

                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required value="<?= $nombre ?>" placeholder="Introduce tu nombre">

                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" required value="<?= $apellido ?>" placeholder="Introduce tu apellido">

                <label for="fecha">Fecha de nacimiento</label>
                <input type="date" id="fecha" name="fecha" required value="<?= $fecha ?>">

                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" value="<?= $telefono ?>" placeholder="Ej: 612345678">

                <button type="submit" class="register-btn">Guardar datos</button>

                <p class="register-login">
                    <a href="/pages/index.php">Volver al inicio</a>
                </p>

            </form>

        </div>

    </main>

    
    <?php include '../includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/datos_personales.js"></script>

</body>

</html>
