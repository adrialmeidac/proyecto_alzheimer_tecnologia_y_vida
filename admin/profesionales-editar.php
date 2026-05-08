<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Profesional</title>

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

    <!-- HEADER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/header.php"; ?>

    <!-- MENÚ ADMIN -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/menu-admin.php"; ?>

    <!-- MENÚ RESPONSIVE -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/responsive-menu.php"; ?>

    <main class="admin-content flex-grow-1">

        <h1 class="admin-title text-center mb-4">Editar Profesional</h1>

        <div class="form-box">

            <div id="mensaje" class="mb-3 text-center"></div>

            <form id="formProfesional" enctype="multipart/form-data">

                <input type="hidden" id="id">

                <!-- DATOS BÁSICOS -->
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" id="nombre" class="form-control" required minlength="3">
                </div>

                <div class="mb-3">
                    <label class="form-label">Especialidad</label>
                    <input type="text" id="especialidad" class="form-control" required minlength="3">
                </div>

                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" id="direccion" class="form-control" required minlength="5">
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

    <!-- FOOTER -->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"; ?>

    <script>
    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");

    const mensaje = document.getElementById("mensaje");

    if (!id || isNaN(id)) {
        mensaje.innerHTML = "<p class='text-danger'>ID inválido.</p>";
        setTimeout(() => location.href = "profesionales.php", 1500);
    }

    // Cargar datos del profesional
    async function cargarProfesional() {
        try {
            const res = await fetch(`/controllers/admin-profesionales.php?action=get&id=${id}`);
            const data = await res.json();

            if (!data.success) {
                mensaje.innerHTML = `<p class='text-danger'>${data.error}</p>`;
                return;
            }

            const p = data.profesional;

            document.getElementById("id").value = p.id;
            document.getElementById("nombre").value = p.nombre;
            document.getElementById("especialidad").value = p.especialidad;
            document.getElementById("direccion").value = p.direccion;

            // Servicios
            const servicios = p.servicios.split(",").map(s => s.trim());
            document.querySelectorAll(".srv-check").forEach(chk => {
                chk.checked = servicios.includes(chk.value);
            });

            // Horarios
            document.getElementById("lunes").value = p.horario_lunes;
            document.getElementById("martes").value = p.horario_martes;
            document.getElementById("miercoles").value = p.horario_miercoles;
            document.getElementById("jueves").value = p.horario_jueves;
            document.getElementById("viernes").value = p.horario_viernes;

        } catch (err) {
            mensaje.innerHTML = "<p class='text-danger'>Error al cargar datos.</p>";
        }
    }

    cargarProfesional();

    // Guardar cambios
    document.getElementById("formProfesional").addEventListener("submit", async e => {
        e.preventDefault();

        const formData = new FormData();

        formData.append("action", "editar");
        formData.append("id", document.getElementById("id").value);
        formData.append("nombre", document.getElementById("nombre").value);
        formData.append("especialidad", document.getElementById("especialidad").value);
        formData.append("direccion", document.getElementById("direccion").value);

        // Servicios
        document.querySelectorAll(".srv-check:checked").forEach(chk => {
            formData.append("servicios[]", chk.value);
        });

        // Horarios
        formData.append("horario_lunes", document.getElementById("lunes").value);
        formData.append("horario_martes", document.getElementById("martes").value);
        formData.append("horario_miercoles", document.getElementById("miercoles").value);
        formData.append("horario_jueves", document.getElementById("jueves").value);
        formData.append("horario_viernes", document.getElementById("viernes").value);


        try {
            const res = await fetch("/controllers/admin-profesionales.php", {
                method: "POST",
                body: formData
            });

            const data = await res.json();

            if (data.success) {
                mensaje.innerHTML = "<p class='text-success'>Cambios guardados correctamente.</p>";
                setTimeout(() => location.href = "profesionales.php", 1500);
            } else {
                mensaje.innerHTML = `<p class='text-danger'>${data.error}</p>`;
            }

        } catch (err) {
            mensaje.innerHTML = "<p class='text-danger'>Error al actualizar el profesional.</p>";
        }
    });
    </script>

</body>
</html>
