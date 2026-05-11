function mostrar(id) {
    document.getElementById("dashboard").style.display = "none";
    document.querySelectorAll(".seccion").forEach(s => s.style.display = "none");
    document.getElementById(id).style.display = "block";

    if (id === "pacientes") cargarPacientes();
    if (id === "actividades") cargarPacientesSelect("selectPacienteActividades");
    if (id === "historial") cargarPacientesSelect("selectPacienteHistorial");
}

function volver() {
    document.querySelectorAll(".seccion").forEach(s => s.style.display = "none");
    document.getElementById("dashboard").style.display = "flex";
}

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

            if (idSelect === "selectPacienteActividades") cargarActividades();
            if (idSelect === "selectPacienteHistorial") cargarHistorial();
        });
}

document.getElementById("selectPacienteActividades")?.addEventListener("change", cargarActividades);

function cargarActividades() {
    const id = document.getElementById("selectPacienteActividades")?.value;
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

document.getElementById("selectPacienteHistorial")?.addEventListener("change", cargarHistorial);

function cargarHistorial() {
    const id = document.getElementById("selectPacienteHistorial")?.value;
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

/* ⭐ CORREGIDO: evitar error si formVincular NO existe */
const formVincular = document.getElementById("formVincular");
if (formVincular) {
    formVincular.addEventListener("submit", async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        const response = await fetch("../controllers/vincular_paciente.php", {
            method: "POST",
            body: formData
        });

        const text = await response.text();
        const msgBox = document.getElementById("msgVincular");

        if (text.includes("correctamente")) {
            msgBox.innerHTML = `<div class="alert alert-success mt-2">${text}</div>`;
            this.reset();
            cargarPacientes();
        } else {
            msgBox.innerHTML = `<div class="alert alert-danger mt-2">${text}</div>`;
        }
    });
}

/* ⭐⭐ CREAR ACTIVIDAD — AHORA FUNCIONA PERFECTO ⭐⭐ */
document.addEventListener("DOMContentLoaded", () => {
    const formCrear = document.querySelector("form[action*='actividades-familiar.php']");
    if (!formCrear) return;

    formCrear.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(formCrear);

        const response = await fetch(formCrear.action, {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert("Actividad creada correctamente");
            formCrear.reset();
            location.reload();
        } else {
            alert("Error: " + result.error);
        }
    });
});
