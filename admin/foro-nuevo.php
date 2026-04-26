<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Tema del Foro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/color.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
</head>

<body>

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-admin.php"; ?>

<main class="admin-content flex-grow-1">
    <h1 class="text-center mb-4">Crear nuevo tema</h1>

    <div class="card p-4 shadow">
        <div class="mb-3">
            <label class="form-label">Título del tema</label>
            <input type="text" id="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contenido</label>
            <textarea id="contenido" class="form-control" rows="6" required></textarea>
        </div>

        <div class="text-end">
            <button class="btn btn-success" onclick="guardarTema()">Guardar</button>
            <button class="btn btn-secondary" onclick="location.href='foro.php'">Cancelar</button>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script>
function guardarTema() {
    const titulo = document.getElementById("titulo").value.trim();
    const contenido = document.getElementById("contenido").value.trim();

    if (!titulo || !contenido) {
        alert("Todos los campos son obligatorios");
        return;
    }

    fetch("../controllers/admin-foro.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            action: "create_tema",
            titulo: titulo,
            contenido: contenido
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
        alert("Error al crear el tema");
    });
}
</script>

</body>
</html>
