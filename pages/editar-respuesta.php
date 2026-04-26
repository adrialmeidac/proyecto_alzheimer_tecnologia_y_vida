<?php
require_once "../middleware/session-admin.php"; // SOLO ADMIN
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$id = $_GET['id'] ?? null;
$tema_id = $_GET['tema'] ?? null;

// Obtener la respuesta
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

    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/foro.css">
</head>

<body>

<?php include '../includes/header.php'; ?>
<?php include '../includes/menu-admin.php'; ?>
    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<div class="container forum-container">
    <h1>Editar Respuesta</h1>

    <form action="../controllers/actualizar_respuesta.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $respuesta['id']; ?>">
        <input type="hidden" name="tema_id" value="<?php echo $tema_id; ?>">

        <label>Contenido</label>
        <textarea name="contenido" class="form-control" rows="5" required><?php 
            echo htmlspecialchars($respuesta['contenido']); 
        ?></textarea>

        <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>
    </form>

    <button class="btn btn-secondary mt-3" onclick="location.href='post.php?id=<?php echo $tema_id; ?>'">
        Cancelar
    </button>
</div>

</body>
</html>
