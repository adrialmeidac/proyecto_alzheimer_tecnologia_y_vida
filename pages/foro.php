<?php require_once "../middleware/session-public.php"; ?>
<?php require_once "../models/bbdd.php";

$db = new Database();
$conn = $db->connect();

// Obtener todos los temas del foro
$sql = $conn->prepare("
    SELECT ft.id, ft.titulo, ft.contenido, ft.fecha
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

    } elseif ($_SESSION["rol"] === "familiar" || $_SESSION["rol"] === "cuidador") {
        include '../includes/menu-familiar.php';

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

        <!-- LISTA DE POSTS -->
        <section class="post-list">

            <?php if (empty($temas)): ?>
                <p>No hay publicaciones en el foro todavía.</p>

            <?php else: ?>
                <?php foreach ($temas as $t): ?>
                    <article class="post-card">
                        <h3><?= htmlspecialchars($t['titulo']) ?></h3>

                        <p class="post-author">
                            Publicado por: <?= htmlspecialchars($t['nombre'] . " " . $t['apellidos']) ?>
                        </p>

                        <p class="post-preview">
                            <?= htmlspecialchars(substr($t['contenido'], 0, 120)) . "..." ?>
                        </p>

                        <button class="btn btn-info px-3 py-2"
                                onclick="location.href='post.php?id=<?= $t['id'] ?>'">
                            Ver más
                        </button>

                        <!-- SOLO ADMIN PUEDE EDITAR/ELIMINAR -->
                        <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin"): ?>
                            <div class="mt-2">
                                <button class="btn btn-warning btn-sm"
                                        onclick="location.href='editar-post.php?id=<?= $t['id'] ?>'">
                                    Editar
                                </button>

                                <button class="btn btn-danger btn-sm"
                                        onclick="if(confirm('¿Eliminar publicación?')) location.href='../controllers/eliminar-post.php?id=<?= $t['id'] ?>'">
                                    Eliminar
                                </button>
                            </div>
                        <?php endif; ?>

                    </article>
                <?php endforeach; ?>
            <?php endif; ?>

        </section>

        <!-- BOTÓN VOLVER -->
<button class="text-center mt-4 mb-4 btn btn-secondary"
    onclick="location.href='<?php
        if (!isset($_SESSION['user_id'])) {
            echo "/pages/index.php";
        } else {
            switch ($_SESSION['rol']) {
                case 'paciente':
                    echo "/pages/dashboard.php";
                    break;
                case 'familiar':
                case 'cuidador':
                    echo "/pages/dashboardFamiliar.php";
                    break;
                case 'admin':
                    echo "/admin/index.php";
                    break;
                default:
                    echo "/pages/index.php";
            }
        }
    ?>'">
    Volver
</button>

    </main>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>

    <script src="/assets/js/theme.js"></script>

</body>
</html>
