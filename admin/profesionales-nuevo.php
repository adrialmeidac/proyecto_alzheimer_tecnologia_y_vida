<?php require_once "../middleware/admin.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Profesional</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
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

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/header.php"; ?>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/menu-admin.php"; ?>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/responsive-menu.php"; ?>
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>


    <main class="admin-content flex-grow-1">

        <h1 class="admin-title text-center mb-4">Añadir Profesional</h1>

        <div class="form-box">

            <div id="mensaje" class="mb-3 text-center"></div>

            <form id="formProfesional" enctype="multipart/form-data">

                
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
               

                
                <div class="mb-3">
                    <label class="form-label">Servicios ofrecidos</label><br>

                    <?php
                    $serviciosLista = [
                        "Resonancias Magnéticas",
                        "Rehabilitación",
                        "Masajes terapeuticos",
                        "Enfermedades del sistema nervioso central",
                        "Cefaleas, migrañas",
                        "Nutrición para mayores"
                    ];
                    ?>

                    <?php foreach ($serviciosLista as $i => $srv): ?>
                        <div class="form-check">
                            <input class="form-check-input srv-check" type="checkbox" value="<?= $srv ?>" id="srv<?= $i ?>">
                            <label class="form-check-label" for="srv<?= $i ?>"><?= $srv ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                
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
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="profesionales.php" class="btn btn-secondary">Cancelar</a>
                </div>

            </form>
        </div>
    </main>

    
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php"; ?>

    <script>
    document.getElementById("formProfesional").addEventListener("submit", async e => {
        e.preventDefault();

        const mensaje = document.getElementById("mensaje");

        const formData = new FormData();

        formData.append("action", "crear");
        formData.append("nombre", document.getElementById("nombre").value);
        formData.append("especialidad", document.getElementById("especialidad").value);
        formData.append("direccion", document.getElementById("direccion").value);

        
        document.querySelectorAll(".srv-check:checked").forEach(chk => {
            formData.append("servicios[]", chk.value);
        });

        
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
                mensaje.innerHTML = "<p class='text-success'>Profesional creado correctamente.</p>";
                setTimeout(() => location.href = "profesionales.php", 1500);
            } else {
                mensaje.innerHTML = `<p class='text-danger'>${data.error}</p>`;
            }

        } catch (err) {
            mensaje.innerHTML = "<p class='text-danger'>Error al guardar el profesional.</p>";
        }
    });
    </script>
<script src="/assets/js/theme.js"></script>

</body>
</html>
