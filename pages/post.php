<?php
require_once "../middleware/session-public.php";
require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

$id = $_GET['id'] ?? null;

// Obtener el post
$sql = $conn->prepare("
    SELECT ft.*, u.nombre, u.apellido
    FROM foro_temas ft
    INNER JOIN usuarios u ON u.id = ft.usuario_id
    WHERE ft.id = :id
");
$sql->execute([':id' => $id]);
$post = $sql->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die("El post no existe.");
}

// Obtener respuestas
$sqlResp = $conn->prepare("
    SELECT fr.*, u.nombre, u.apellido
    FROM foro_respuestas fr
    INNER JOIN usuarios u ON u.id = fr.usuario_id
    WHERE fr.tema_id = :id
    ORDER BY fr.fecha ASC
");
$sqlResp->execute([':id' => $id]);
$respuestas = $sqlResp->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($post['titulo']); ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/post.css">
</head>

<body>

<?php include '../includes/header.php'; ?>
    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

<!-- MENÚ SEGÚN SESIÓN -->
<?php
if (!isset($_SESSION["user_id"])) {
    include '../includes/public-menu.php';
} elseif ($_SESSION["rol"] === "admin") {
    include '../includes/menu-admin.php';
} else {
    include '../includes/private-menu.php';
}
?>

<?php include '../includes/responsive-menu.php'; ?>
<?php include '../includes/private-banner.php'; ?>
    <!-- BOTÓN MODO OSCURO -->
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


<div class="container forum-container">

    <h1><?php echo htmlspecialchars($post['titulo']); ?></h1>

    <p class="post-author">
        Publicado por: <?php echo htmlspecialchars($post['nombre'] . " " . $post['apellido']); ?>
    </p>

    <p class="post-date">
        Fecha: <?php echo $post['fecha']; ?>
    </p>

    <div class="post-content">
        <?php echo nl2br(htmlspecialchars($post['contenido'])); ?>
    </div>

    <!-- RESPUESTAS -->
    <h2 class="mt-5">Respuestas</h2>

    <?php if (empty($respuestas)): ?>
        <p>No hay respuestas todavía.</p>
    <?php else: ?>
       <?php foreach ($respuestas as $r): ?>
    <div class="respuesta-card">
        <p><strong><?php echo $r['nombre'] . " " . $r['apellido']; ?></strong></p>
        <p><?php echo nl2br(htmlspecialchars($r['respuesta'])); ?></p>
        <small><?php echo $r['fecha']; ?></small>

        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>
            <div class="admin-actions mt-2">
                <a href="editar-respuesta.php?id=<?php echo $r['id']; ?>&tema=<?php echo $id; ?>" 
                   class="btn btn-warning btn-sm me-2">Editar</a>

                <a href="../controllers/eliminar_respuesta.php?id=<?php echo $r['id']; ?>&tema=<?php echo $id; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('¿Eliminar esta respuesta?');">
                   Eliminar
                </a>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

    <?php endif; ?>

    <!-- FORMULARIO DE RESPUESTA -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <h3 class="mt-4">Responder</h3>

        <form action="../controllers/guardar_respuesta.php" method="POST">
            <input type="hidden" name="tema_id" value="<?php echo $id; ?>">

            <textarea name="respuesta" class="form-control" rows="4" required></textarea>

            <button type="submit" class="btn btn-primary mt-2">Enviar respuesta</button>
        </form>
    <?php else: ?>
        <p>Inicia sesión para responder.</p>
    <?php endif; ?>
<?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>
    <div class="admin-actions mt-3">
        <a href="editar-post.php?id=<?php echo $post['id']; ?>" class="btn btn-warning me-2">Editar</a>
        <a href="../controllers/eliminar_post.php?id=<?php echo $post['id']; ?>" 
           class="btn btn-danger"
           onclick="return confirm('¿Seguro que deseas eliminar este post?');">
           Eliminar
        </a>
    </div>
<?php endif; ?>

    <!-- BOTÓN VOLVER -->
    <div class="text-center mt-4">
        <button class="btn btn-secondary px-4 py-2" onclick="location.href='foro.php'">
            Volver al foro
        </button>
    </div>

</div>
    <script src="/assets/js/theme.js"></script>
<?php include '../includes/footer.php'; ?>

</body>
</html>
