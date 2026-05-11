<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /pages/login.php");
    exit();
}


if (!in_array($_SESSION["rol"], ["familiar", "cuidador"])) {
    header("Location: /pages/dashboardFamiliar.php");
    exit();
}

require_once __DIR__ . "/../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$familiar_id = $_SESSION['user_id'];
$mensaje = "";
$tipo_mensaje = "";
$exito = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email_paciente = trim($_POST["email_paciente"]);
    $tipo_relacion = trim($_POST["tipo_relacion"]);

    
    if (!filter_var($email_paciente, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo no es válido.";
        $tipo_mensaje = "error";
    } else {

        
        $sql = $conn->prepare("SELECT id, rol, perfil_completado FROM usuarios WHERE email = ?");
        $sql->execute([$email_paciente]);
        $paciente = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$paciente) {
            $mensaje = "No existe un usuario con ese correo.";
            $tipo_mensaje = "error";

        } elseif ($paciente["rol"] !== "paciente") {
            $mensaje = "El usuario encontrado no es un paciente.";
            $tipo_mensaje = "error";

        } elseif ($paciente["id"] == $familiar_id) {
            $mensaje = "No puedes vincularte a ti mismo.";
            $tipo_mensaje = "error";

        } elseif ($paciente["perfil_completado"] == 0) {
            $mensaje = "El paciente aún no ha completado su perfil.";
            $tipo_mensaje = "error";

        } else {

            $paciente_id = $paciente["id"];

            
            $sql = $conn->prepare("
                SELECT id FROM relaciones_familiares
                WHERE paciente_id = ? AND familiar_id = ?
            ");
            $sql->execute([$paciente_id, $familiar_id]);

            if ($sql->fetch()) {
                $mensaje = "Este paciente ya está vinculado contigo.";
                $tipo_mensaje = "error";

            } else {

                
                $sql = $conn->prepare("
                    INSERT INTO relaciones_familiares (paciente_id, familiar_id, parentesco)
                    VALUES (?, ?, ?)
                ");
                $sql->execute([$paciente_id, $familiar_id, $tipo_relacion]);

                
                $update = $conn->prepare("
                    UPDATE usuarios SET perfil_completado = 1
                    WHERE id = ?
                ");
                $update->execute([$familiar_id]);

                $_SESSION["perfil_completado"] = 1;

                $mensaje = "Paciente vinculado correctamente.";
                $tipo_mensaje = "exito";
                $exito = true;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vincular Paciente</title>

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/panel-familiar.css">
</head>

<body>

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-familiar.php"; ?>
<?php include "../includes/responsive-menu.php"; ?>
<?php include "../includes/private-banner.php"; ?>

<button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

<div class="panel-familiar-container form-container">
    <h2 class="text-center">Vincular Paciente</h2>

    <?php if ($mensaje): ?>
        <div class="mensaje <?php echo $tipo_mensaje; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <?php if (!$exito): ?>
        <form method="POST">

            <label class="form-label">Correo del paciente</label>
            <input type="email" name="email_paciente" class="form-control" required>

            <label class="form-label mt-3">Tipo de relación</label>
            <select name="tipo_relacion" class="form-select" required>
                <option value="hijo">Hijo/a</option>
                <option value="nieto">Nieto/a</option>
                <option value="cuidador">Cuidador</option>
                <option value="otro">Otro</option>
            </select>

            <button class="btn btn-primary w-100 mt-4">Vincular</button>
        </form>

    <?php else: ?>

        <div class="text-center mt-4">
            <a href="/pages/dashboard.php" class="btn btn-success w-100">Ir al Dashboard</a>
        </div>

    <?php endif; ?>
</div>

<?php include "../includes/footer.php"; ?>

<script src="/assets/js/theme.js"></script>

</body>
</html>
