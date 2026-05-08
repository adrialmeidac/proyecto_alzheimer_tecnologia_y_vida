const activitiesList = document.getElementById("activitiesList");
const addActivityBtn = document.getElementById("addActivityBtn");

// ============================
// 1. CARGAR ACTIVIDADES
// ============================

function loadActivities() {
    fetch("../controllers/actividades.php?action=listar")
        .then(res => res.json())
        .then(data => {
            activitiesList.innerHTML = "";
            data.actividades.forEach(act => renderActivity(act));
        });
}

// ============================
// 2. CREAR TARJETA DE ACTIVIDAD
// ============================

function renderActivity(act) {

    const col = document.createElement("div");
    col.classList.add("col-12", "col-md-6");

    const div = document.createElement("div");
    div.classList.add("actividad-card", "p-3", "border", "rounded");
    div.style.position = "relative";
    div.dataset.id = act.id;

    const realizada = act.estado === "realizada";

    div.innerHTML = `
        <h5 class="actividad-texto mb-2" contenteditable="true">
            ${act.titulo}
        </h5>

        <p class="text-muted mb-2"><strong>Descripción:</strong></p>
        <p class="actividad-descripcion mb-2" contenteditable="true">${act.descripcion || ""}</p>

        <p class="text-muted mb-2"><strong>Fecha:</strong> ${act.fecha}</p>

        <div class="mb-2">
            <label class="form-label mb-0"><strong>Hora límite:</strong></label>
            <input type="time" class="form-control actividad-hora" value="${act.hora || ""}">
        </div>

        <div class="d-flex justify-content-between align-items-center">

            <button class="btn btn-sm ${realizada ? "btn-success" : "btn-outline-success"} btn-realizada"
                ${realizada ? "disabled" : ""}>
                <i class="bi ${realizada ? "bi-check-lg" : "bi-square"} check-icon"></i>
                <span class="realizada-text">${realizada ? "Realizada" : "Marcar como realizada"}</span>
            </button>

            <button class="btn btn-sm btn-primary btn-guardar">Guardar</button>

            <button class="btn btn-sm btn-danger btn-eliminar">Eliminar</button>
        </div>
    `;

    col.appendChild(div);
    activitiesList.appendChild(col);

    // Eventos
    div.querySelector(".btn-guardar").addEventListener("click", () => {
        updateActivity(div);
    });

    div.querySelector(".btn-realizada").addEventListener("click", () => {
        markAsDone(div);
    });

    div.querySelector(".btn-eliminar").addEventListener("click", () => {
        deleteActivity(div);
    });

    if (realizada) aplicarEstilosRealizada(div);
}

// ============================
// 3. CREAR ACTIVIDAD (MODAL)
// ============================

addActivityBtn.addEventListener("click", () => {
    document.getElementById("nuevaTexto").value = "";
    document.getElementById("nuevaDescripcion").value = "";
    document.getElementById("nuevaFecha").value = "";
    document.getElementById("nuevaHora").value = "";

    const modal = new bootstrap.Modal(document.getElementById("modalNuevaActividad"));
    modal.show();
});

document.getElementById("btnGuardarNueva").addEventListener("click", () => {

    const titulo = document.getElementById("nuevaTexto").value.trim();
    const descripcion = document.getElementById("nuevaDescripcion").value.trim();
    const fecha = document.getElementById("nuevaFecha").value;
    const hora = document.getElementById("nuevaHora").value;

    if (!titulo || !fecha) {
        alert("Debes completar al menos título y fecha.");
        return;
    }

    fetch("../controllers/actividades.php?action=crear", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            titulo,
            descripcion,
            fecha,
            hora
        })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById("modalNuevaActividad"));
                modal.hide();
                loadActivities();
            }
        });
});

// ============================
// 4. ACTUALIZAR ACTIVIDAD
// ============================

function updateActivity(div) {
    const id = div.dataset.id;
    const titulo = div.querySelector(".actividad-texto").innerText.trim();
    const descripcion = div.querySelector(".actividad-descripcion").innerText.trim();
    const hora = div.querySelector(".actividad-hora").value;

    fetch("../controllers/actividades.php?action=actualizar", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            id,
            titulo,
            descripcion,
            hora
        })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Actividad guardada");
            }
        });
}

// ============================
// 5. MARCAR COMO REALIZADA
// ============================

function markAsDone(div) {
    const id = div.dataset.id;

    fetch("../controllers/actividades.php?action=marcar_realizada", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                aplicarEstilosRealizada(div);
            }
        });
}

// ============================
// 6. APLICAR ESTILOS DE REALIZADA
// ============================

function aplicarEstilosRealizada(div) {
    const btn = div.querySelector(".btn-realizada");
    const icon = btn.querySelector(".check-icon");
    const text = btn.querySelector(".realizada-text");

    btn.classList.remove("btn-outline-success");
    btn.classList.add("btn-success");
    btn.classList.add("realizada-bloqueada");

    icon.classList.remove("bi-square");
    icon.classList.add("bi-check-lg");

    text.textContent = "Realizada";

    div.classList.add("actividad-completada");

    const checkGrande = document.createElement("i");
    checkGrande.classList.add("bi", "bi-check-circle-fill", "actividad-check-grande");
    div.appendChild(checkGrande);

    const parent = div.parentElement;
    parent.remove();
    activitiesList.appendChild(parent);
}

// ============================
// 7. ELIMINAR ACTIVIDAD
// ============================

function deleteActivity(div) {
    const id = div.dataset.id;

    if (!confirm("¿Eliminar esta actividad?")) return;

    fetch("../controllers/actividades.php?action=eliminar", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                div.parentElement.remove();
            }
        });
}

// ============================
// 8. INICIALIZAR
// ============================

loadActivities();
