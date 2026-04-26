<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Profesional</title>

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
    <h1 class="text-center mb-4">Editar Profesional</h1>

    <div class="form-box">
        <form id="formProfesional">

            <input type="hidden" id="id">

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

                <?php
                $serviciosLista = [
                    "Fisioterapia",
                    "Rehabilitación",
                    "Masajes",
                    "Terapia deportiva",
                    "Podología",
                    "Nutrición"
                ];
                ?>

                <?php foreach ($serviciosLista as $i => $srv): ?>
                    <div class="form-check">
                        <input class="form-check-input srv-check" type="checkbox" value="<?= $srv ?>" id="srv<?= $i ?>">
                        <label class="form-check-label" for="srv<?= $i ?>"><?= $srv ?></label>
                    </div>
                <?php endforeach; ?>
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

            $turnos = [
                "Cerrado",
                "Mañana (08:00–14:00)",
                "Tarde (16:00–20:00)",
                "Completo (08:00–20:00)"
            ];
            ?>

            <?php foreach ($dias as $key => $label): ?>
                <div class="mb-3">
                    <label class="form-label day-label"><?= $label ?></label>
                    <select id="<?= $key ?>" class="form-select">
                        <?php foreach ($turnos as $t): ?>
                            <option value="<?= $t ?>"><?= $t ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endforeach; ?>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <a href="profesionales.php" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script>
// Obtener ID desde la URL
const params = new URLSearchParams(window.location.search);
const id = params.get("id");

if (!id) {
    alert("ID no válido");
    location.href = "profesionales.php";
}

// Cargar datos del profesional
fetch("../controllers/admin-profesionales.php?action=get")
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            alert(data.error);
            location.href = "profesionales.php";
            return;
        }

        const profesional = data.profesionales.find(p => p.id == id);

        if (!profesional) {
            alert("Profesional no encontrado");
            location.href = "profesionales.php";
            return;
        }

        // Rellenar campos básicos
        document.getElementById("id").value = profesional.id;
        document.getElementById("nombre").value = profesional.nombre;
        document.getElementById("especialidad").value = profesional.especialidad;
        document.getElementById("direccion").value = profesional.direccion;

        // Rellenar servicios
        const servicios = profesional.servicios.split(",").map(s => s.trim());

        document.querySelectorAll(".srv-check").forEach(chk => {
            if (servicios.includes(chk.value)) {
                chk.checked = true;
            }
        });

        // Rellenar horarios
        document.getElementById("lunes").value = profesional.horario_lunes;
        document.getElementById("martes").value = profesional.horario_martes;
        document.getElementById("miercoles").value = profesional.horario_miercoles;
        document.getElementById("jueves").value = profesional.horario_jueves;
        document.getElementById("viernes").value = profesional.horario_viernes;
    });

// Guardar cambios
document.getElementById("formProfesional").addEventListener("submit", function(e) {
    e.preventDefault();

    // Obtener servicios seleccionados
    const servicios = [];
    document.querySelectorAll(".srv-check:checked").forEach(chk => {
        servicios.push(chk.value);
    });

    const data = {
        action: "update",
        id: document.getElementById("id").value,
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
        alert("Error al actualizar el profesional");
    });
});
</script>

</body>
</html>
