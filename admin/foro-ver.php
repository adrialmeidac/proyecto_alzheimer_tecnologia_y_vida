<?php require_once "../middleware/admin.php"; ?>
<?php require_once "../models/bbdd.php"; ?>

<?php
$id = $_GET["id"] ?? null;
if (!$id) {
    header("Location: foro.php");
    exit;
}

$db = new Database();
$conn = $db->connect();

// Tema
$sqlTema = "
    SELECT 
        t.*,
        u.nombre,
        u.apellido
    FROM foro_temas t
    JOIN usuarios u ON t.usuario_id = u.id
    WHERE t.id = :id
";
$stmt = $conn->prepare($sqlTema);
$stmt->execute([":id" => $id]);
$tema = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tema) {
    header("Location: foro.php");
    exit;
}

// Respuestas
$sqlResp = "
    SELECT 
        r.*,
        u.nombre,
        u.apellido
    FROM foro_respuestas r
    JOIN usuarios u ON r.usuario_id = u.id
    WHERE r.tema_id = :id
    ORDER BY r.fecha ASC
";
$stmt = $conn->prepare($sqlResp);
$stmt->execute([":id" => $id]);
$respuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver tema foro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/color.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">

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

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-admin.php"; ?>

<main class="admin-content flex-grow-1">
    <h1 class="mb-4">Detalle del tema</h1>

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

    <h4>Respuestas</h4>

    <?php if ($respuestas): ?>
        <?php foreach ($respuestas as $r): ?>
            <div class="respuesta-card">
                <p class="mb-1">
                    <strong><?= htmlspecialchars($r["nombre"] . " " . $r["apellido"]) ?></strong>
                    · <?= (new DateTime($r["fecha"]))->format("d/m/Y H:i") ?>
                </p>
                <p><?= nl2br(htmlspecialchars($r["respuesta"])) ?></p>
                <button class="btn btn-sm btn-outline-danger" onclick="eliminarRespuesta(<?= (int)$r['id'] ?>)">
                    Eliminar respuesta
                </button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay respuestas en este tema.</p>
    <?php endif; ?>

</main>

<?php include "../includes/footer.php"; ?>

<script>
function eliminarTema(id) {
    if (!confirm("¿Eliminar este tema y todas sus respuestas?")) return;

    fetch("../controllers/admin-foro.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            action: "delete_tema",
            id: id
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);
        if (data.success) {
            location.href = "foro.php";
        }
    })
    .catch(err => {
        console.error(err);
        alert("Error al eliminar el tema");
    });
}

function eliminarRespuesta(id) {
    if (!confirm("¿Eliminar esta respuesta?")) return;

    fetch("../controllers/admin-foro.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            action: "delete_respuesta",
            id: id
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);
        if (data.success) {
            location.reload();
        }
    })
    .catch(err => {
        console.error(err);
        alert("Error al eliminar la respuesta");
    });
}
</script>

</body>
</html>
