<?php
require_once "../middleware/session-admin.php"; // SOLO ADMIN
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$id = $_GET['id'] ?? null;

// Obtener el post
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
    <title>Editar Post</title>

    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/post.css">
</head>

<body>

<?php include '../includes/header.php'; ?>
<?php include '../includes/menu-admin.php'; ?>

    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<div class="container forum-container">
    <h1>Editar Publicación</h1>

    <form action="../controllers/actualizar_post.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">

        <label>Título</label>
        <input type="text" name="titulo" class="form-control" 
               value="<?php echo htmlspecialchars($post['titulo']); ?>" required>

        <label class="mt-3">Contenido</label>
        <textarea name="contenido" class="form-control" rows="6" required><?php 
            echo htmlspecialchars($post['contenido']); 
        ?></textarea>

        <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>
    </form>

    <button class="btn btn-secondary mt-3" onclick="location.href='post.php?id=<?php echo $post['id']; ?>'">
        Cancelar
    </button>
</div>

</body>
</html>
