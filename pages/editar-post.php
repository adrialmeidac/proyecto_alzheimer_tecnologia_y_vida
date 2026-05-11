<?php
require_once "../middleware/session-admin.php"; 
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$id = $_GET['id'] ?? null;


$sql = $conn->prepare("SELECT * FROM foro_temas WHERE id = :id");
$sql->execute([':id' => $id]);
$post = $sql->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die("El post no existe.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Publicación</title>

    
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
    <h1>Editar Publicación</h1>

    <form action="../controllers/actualizar_post.php" method="POST">
        <input type="hidden" name="id" value="<?= $post['id'] ?>">

        <label class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control"
               value="<?= htmlspecialchars($post['titulo']) ?>" required>

        <label class="form-label mt-3">Contenido</label>
        <textarea name="contenido" class="form-control" rows="6" required><?= 
            htmlspecialchars($post['contenido']) 
        ?></textarea>

        <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>
    </form>

    <button class="btn btn-secondary mt-3"
            onclick="location.href='post.php?id=<?= $post['id'] ?>'">
        Cancelar
    </button>
</div>

<?php include '../includes/footer.php'; ?>

<script src="/assets/js/theme.js"></script>

</body>
</html>
