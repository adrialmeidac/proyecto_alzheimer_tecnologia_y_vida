<?php require_once "../middleware/session-public.php"; ?>
<?php require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

// Obtener todos los temas del foro
$sql = $conn->prepare("
    SELECT ft.id, ft.titulo, ft.contenido, ft.fecha, u.nombre, u.apellido
    FROM foro_temas ft
    INNER JOIN usuarios u ON u.id = ft.usuario_id
    ORDER BY ft.fecha DESC
");
$sql->execute();
$temas = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro de la Comunidad</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/foro.css">
</head>

<body>

    <!-- HEADER -->
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

    <!-- MENÚ RESPONSIVE -->
    <?php include '../includes/responsive-menu.php'; ?>

    <!-- BANNER PÚBLICO -->
    <?php include '../includes/public-banner.php'; ?>

    <h1>Foro de la Comunidad</h1>
    <p class="subtitle">Comparte experiencias y apoya a otros usuarios</p>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container forum-container">

        <!-- Crear publicación -->
        <div class="text-center mb-4">
            <?php if (isset($_SESSION["user_id"])): ?>
                <button class="btn btn-primary px-4 py-2" onclick="location.href='nuevo-post.php'">
                    Crear Publicación
                </button>
            <?php else: ?>
                <h3>Inicia sesión para publicar</h3>
            <?php endif; ?>
        </div>

        <!-- LISTA DE POSTS DINÁMICOS -->
        <section class="post-list">

            <?php if (empty($temas)): ?>
                <p>No hay publicaciones en el foro todavía.</p>

            <?php else: ?>
                <?php foreach ($temas as $t): ?>
                    <article class="post-card">
                        <h3><?php echo htmlspecialchars($t['titulo']); ?></h3>

                        <p class="post-author">
                            Publicado por: <?php echo htmlspecialchars($t['nombre'] . " " . $t['apellido']); ?>
                        </p>

                        <p class="post-preview">
                            <?php echo htmlspecialchars(substr($t['contenido'], 0, 120)) . "..."; ?>
                        </p>

                        <button class="btn btn-info px-3 py-2"
                                onclick="location.href='post.php?id=<?php echo $t['id']; ?>'">
                            Ver más
                        </button>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>

        </section> 

        <!-- BOTÓN VOLVER -->
<?php if (isset($_SESSION["user_id"])): ?>
    <button class="text-center mt-4 mb-4 btn btn-secondary" onclick="location.href='/pages/dashboard.php'">
        Volver
    </button>
<?php else: ?>
    <button class="text-center mt-4 mb-4 btn btn-secondary" onclick="location.href='/pages/index.php'">
        Volver
    </button>
<?php endif; ?>

    </main>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>

    <!-- JS -->
    <script src="/assets/js/theme.js"></script>

</body>
</html>
