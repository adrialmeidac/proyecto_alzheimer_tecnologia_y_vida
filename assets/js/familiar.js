  
  
    // ===============================
    // MOSTRAR SECCIONES
    // ===============================
    function mostrar(id) {
        document.getElementById("dashboard").style.display = "none";
        document.querySelectorAll(".seccion").forEach(s => s.style.display = "none");
        document.getElementById(id).style.display = "block";

        if (id === "pacientes") cargarPacientes();
        if (id === "actividades") cargarPacientesSelect("selectPacienteActividades");
        if (id === "crearActividad") cargarPacientesSelect("selectPacienteCrear");
        if (id === "historial") cargarPacientesSelect("selectPacienteHistorial");
    }

    function volver() {
        document.querySelectorAll(".seccion").forEach(s => s.style.display = "none");
        document.getElementById("dashboard").style.display = "flex";
    }

    // ===============================
    // LISTAR PACIENTES
    // ===============================
    function cargarPacientes() {
        fetch("/controllers/familiar.php?action=listar_pacientes")
            .then(r => r.json())
            .then(data => {
                const tbody = document.getElementById("tablaPacientes");
                tbody.innerHTML = "";

                if (!data.success) return;

                data.pacientes.forEach(p => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${p.nombre}</td>
                            <td>${p.email}</td>
                        </tr>
                    `;
                });
            });
    }

    function cargarPacientesSelect(idSelect) {
        fetch("/controllers/familiar.php?action=listar_pacientes")
            .then(r => r.json())
            .then(data => {
                const select = document.getElementById(idSelect);
                select.innerHTML = "";

                if (!data.success) return;

                data.pacientes.forEach(p => {
                    select.innerHTML += `<option value="${p.id}">${p.nombre}</option>`;
                });

                // Disparar carga inicial de actividades/historial si aplica
                if (idSelect === "selectPacienteActividades") cargarActividades();
                if (idSelect === "selectPacienteHistorial") cargarHistorial();
            });
    }

    // ===============================
    // ACTIVIDADES DEL PACIENTE
    // ===============================
    document.getElementById("selectPacienteActividades").addEventListener("change", cargarActividades);

    function cargarActividades() {
        const id = document.getElementById("selectPacienteActividades").value;
        if (!id) return;

        fetch("/controllers/familiar.php?action=actividades_paciente", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ paciente_id: id })
        })
        .then(r => r.json())
        .then(data => {
            const tbody = document.getElementById("tablaActividades");
            tbody.innerHTML = "";

            if (!data.success) return;

            data.actividades.forEach(a => {
                tbody.innerHTML += `
                    <tr>
                        <td>${a.titulo}</td>
                        <td>${a.fecha}</td>
                        <td>${a.hora}</td>
                        <td>${a.estado ?? ""}</td>
                    </tr>
                `;
            });
        });
    }

    // ===============================
    // CREAR ACTIVIDAD
    // ===============================
    document.getElementById("formCrearActividad").addEventListener("submit", e => {
        e.preventDefault();

        const datos = Object.fromEntries(new FormData(e.target));

        fetch("/controllers/familiar.php?action=crear_actividad", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(datos)
        })
        .then(r => r.json())
        .then(data => {
            alert(data.message || data.error);
        });
    });

    // ===============================
    // HISTORIAL
    // ===============================
    document.getElementById("selectPacienteHistorial").addEventListener("change", cargarHistorial);

    function cargarHistorial() {
        const id = document.getElementById("selectPacienteHistorial").value;
        if (!id) return;

        fetch("/controllers/familiar.php?action=historial_paciente", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ paciente_id: id })
        })
        .then(r => r.json())
        .then(data => {
            const tbody = document.getElementById("tablaHistorial");
            tbody.innerHTML = "";

            if (!data.success) return;

            data.historial.forEach(a => {
                tbody.innerHTML += `
                    <tr>
                        <td>${a.titulo}</td>
                        <td>${a.fecha}</td>
                        <td>${a.hora}</td>
                    </tr>
                `;
            });
        });
    }

    // ===============================
    // VINCULAR PACIENTE
    // ===============================
    document.getElementById("formVincular").addEventListener("submit", e => {
        e.preventDefault();

        const datos = Object.fromEntries(new FormData(e.target));

        fetch("/controllers/familiar.php?action=vincular", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(datos)
        })
        .then(r => r.json())
        .then(data => {
            alert(data.message || data.error);
        });
    });

