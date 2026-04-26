<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Profesional</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/color.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">

    <style>
        .form-box {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            max-width: 700px;
            margin: auto;
        }
        .day-label {
            font-weight: 600;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<?php include "../includes/header.php"; ?>
<?php include "../includes/menu-admin.php"; ?>

<main class="admin-content flex-grow-1">
    <h1 class="text-center mb-4">Añadir Profesional</h1>

    <div class="form-box">
        <form id="formProfesional">

            <!-- DATOS BÁSICOS -->
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" id="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Especialidad</label>
                <input type="text" id="especialidad" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" id="direccion" class="form-control" required>
            </div>

            <!-- SERVICIOS -->
            <div class="mb-3">
                <label class="form-label">Servicios ofrecidos</label><br>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Fisioterapia" id="srv1">
                    <label class="form-check-label" for="srv1">Fisioterapia</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Rehabilitación" id="srv2">
                    <label class="form-check-label" for="srv2">Rehabilitación</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Masajes" id="srv3">
                    <label class="form-check-label" for="srv3">Masajes</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Terapia deportiva" id="srv4">
                    <label class="form-check-label" for="srv4">Terapia deportiva</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Podología" id="srv5">
                    <label class="form-check-label" for="srv5">Podología</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Nutrición" id="srv6">
                    <label class="form-check-label" for="srv6">Nutrición</label>
                </div>
            </div>

            <!-- HORARIOS -->
            <h5 class="mt-4">Horarios</h5>

            <?php
            $dias = [
                "lunes" => "Lunes",
                "martes" => "Martes",
                "miercoles" => "Miércoles",
                "jueves" => "Jueves",
                "viernes" => "Viernes"
            ];
            ?>

            <?php foreach ($dias as $key => $label): ?>
                <div class="mb-3">
                    <label class="form-label day-label"><?= $label ?></label>
                    <select id="<?= $key ?>" class="form-select">
                        <option value="Cerrado">Cerrado</option>
                        <option value="Mañana (08:00–14:00)">Mañana (08:00–14:00)</option>
                        <option value="Tarde (16:00–20:00)">Tarde (16:00–20:00)</option>
                        <option value="Completo (08:00–20:00)">Completo (08:00–20:00)</option>
                    </select>
                </div>
            <?php endforeach; ?>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="profesionales.php" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script>
document.getElementById("formProfesional").addEventListener("submit", function(e) {
    e.preventDefault();

    // Obtener servicios seleccionados
    const servicios = [];
    document.querySelectorAll(".form-check-input:checked").forEach(chk => {
        servicios.push(chk.value);
    });

    const data = {
        action: "create",
        nombre: document.getElementById("nombre").value,
        especialidad: document.getElementById("especialidad").value,
        direccion: document.getElementById("direccion").value,
        servicios: servicios.join(", "),
        lunes: document.getElementById("lunes").value,
        martes: document.getElementById("martes").value,
        miercoles: document.getElementById("miercoles").value,
        jueves: document.getElementById("jueves").value,
        viernes: document.getElementById("viernes").value
    };

    fetch("../controllers/admin-profesionales.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || data.error);

        if (data.success) {
            location.href = "profesionales.php";
        }
    })
    .catch(err => {
        console.error(err);
        alert("Error al guardar el profesional");
    });
});
</script>

</body>
</html>
