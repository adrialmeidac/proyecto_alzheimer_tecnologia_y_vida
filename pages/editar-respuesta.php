<?php
require_once "../middleware/session-admin.php"; 
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$id = $_GET['id'] ?? null;
$tema_id = $_GET['tema'] ?? null;


$sql = $conn->prepare("SELECT * FROM foro_respuestas WHERE id = :id");
$sql->execute([':id' => $id]);
$respuesta = $sql->fetch(PDO::FETCH_ASSOC);

if (!$respuesta) {
    die("La respuesta no existe.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Respuesta</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/post.css">
    <link rel="stylesheet" href="/assets/css/foro.css">
</head>

<body>

<?php include '../includes/header.php'; ?>

<button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<?php include '../includes/menu-admin.php'; ?>


<?php include '../includes/responsive-menu.php'; ?>


<?php include '../includes/private-banner.php'; ?>

<div class="container forum-container">
    <h1>Editar Respuesta</h1>

    <form action="../controllers/actualizar_respuesta.php" method="POST">
        <input type="hidden" name="id" value="<?= $respuesta['id'] ?>">
        <input type="hidden" name="tema_id" value="<?= $tema_id ?>">

        <label class="form-label">Contenido</label>
        <textarea name="respuesta" class="form-control" rows="5" required><?= 
            htmlspecialchars($respuesta['respuesta']) 
        ?></textarea>

        <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>
    </form>

    <button class="btn btn-secondary mt-3"
            onclick="location.href='post.php?id=<?= $tema_id ?>'">
        Cancelar
    </button>
</div>

<?php include '../includes/footer.php'; ?>

<script src="/assets/js/theme.js"></script>

</body>
</html>
