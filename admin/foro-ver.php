<?php require_once "../middleware/admin.php"; ?>
<?php require_once "../models/bbdd.php"; ?>

<?php
$id = $_GET["id"] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: foro.php");
    exit;
}

$db = new Database();
$conn = $db->connect();

// Obtener tema
$stmt = $conn->prepare("
    SELECT t.*, u.nombre, u.apellido
    FROM foro_temas t
    JOIN usuarios u ON t.usuario_id = u.id
    WHERE t.id = ?
");
$stmt->execute([$id]);
$tema = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tema) {
    header("Location: foro.php");
    exit;
}

// Obtener respuestas
$stmt = $conn->prepare("
    SELECT r.*, u.nombre, u.apellido
    FROM foro_respuestas r
    JOIN usuarios u ON r.usuario_id = u.id
    WHERE r.tema_id = ?
    ORDER BY r.fecha ASC
");
$stmt->execute([$id]);
$respuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del tema</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/menu.css">


    <style>
        .card-foro {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }
        .respuesta-card {
            background: var(--card-bg);
            border-radius: 10px;
            padding: 15px;
            box-shadow: var(--shadow);
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/header.php"; ?>

    <!-- MENÚ ADMIN -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/menu-admin.php"; ?>

    <main class="admin-content flex-grow-1">

        <h1 class="admin-title mb-4">Detalle del tema</h1>

        <div class="card-foro">
            <h3><?= htmlspecialchars($tema["titulo"]) ?></h3>

            <p class="text-muted">
                Por <?= htmlspecialchars($tema["nombre"] . " " . $tema["apellido"]) ?>
                · <?= (new DateTime($tema["fecha"]))->format("d/m/Y H:i") ?>
            </p>

            <p><?= nl2br(htmlspecialchars($tema["contenido"])) ?></p>

            <div class="mt-3">
                <button class="btn btn-danger" onclick="eliminarTema(<?= (int)$tema['id'] ?>)">
                    Eliminar tema
                </button>
                <button class="btn btn-secondary" onclick="location.href='foro.php'">
                    Volver al listado
                </button>
            </div>
        </div>

        <h4 class="mt-4">Respuestas</h4>

        <div id="listaRespuestas">
            <?php if ($respuestas): ?>
                <?php foreach ($respuestas as $r): ?>
                    <div class="respuesta-card">
                        <p class="mb-1">
                            <strong><?= htmlspecialchars($r["nombre"] . " " . $r["apellido"]) ?></strong>
                            · <?= (new DateTime($r["fecha"]))->format("d/m/Y H:i") ?>
                        </p>
                        <p><?= nl2br(htmlspecialchars($r["respuesta"])) ?></p>

                        <button class="btn btn-sm btn-outline-danger"
                                onclick="eliminarRespuesta(<?= (int)$r['id'] ?>)">
                            Eliminar respuesta
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay respuestas en este tema.</p>
            <?php endif; ?>
        </div>

    </main>

    <!-- FOOTER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"; ?>

    <script>
    async function eliminarTema(id) {
        if (!confirm("¿Eliminar este tema y todas sus respuestas?")) return;

        const res = await fetch("/controllers/admin-foro.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "delete_tema", id })
        });

        const data = await res.json();

        alert(data.message || data.error);

        if (data.success) {
            location.href = "foro.php";
        }
    }

    async function eliminarRespuesta(id) {
        if (!confirm("¿Eliminar esta respuesta?")) return;

        const res = await fetch("/controllers/admin-foro.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "delete_respuesta", id })
        });

        const data = await res.json();

        alert(data.message || data.error);

        if (data.success) {
            location.reload();
        }
    }
    </script>

</body>
</html>
