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

    const isFamiliar = act.origen === "familiar";

    div.innerHTML = `
        <h5 class="actividad-texto mb-2" contenteditable="${isFamiliar ? "false" : "true"}">
            ${act.texto}
        </h5>

        ${isFamiliar ? "" : `
        <div class="mb-2">
            <label class="form-label mb-0"><strong>Hora límite:</strong></label>
            <input type="time" class="form-control actividad-hora" value="${act.hora_limite || ""}">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input actividad-notif" type="checkbox" ${act.notificar == 1 ? "checked" : ""}>
            <label class="form-check-label">Notificar si no se realiza</label>
        </div>
        `}

        <div class="d-flex justify-content-between align-items-center">

            <button class="btn btn-sm ${act.realizada ? "btn-success" : "btn-outline-success"} btn-realizada"
                ${act.realizada ? "disabled" : ""}>
                <i class="bi ${act.realizada ? "bi-check-lg" : "bi-square"} check-icon"></i>
                <span class="realizada-text">${act.realizada ? "Realizada" : "Marcar como realizada"}</span>
            </button>

            ${isFamiliar ? "" : `
            <button class="btn btn-sm btn-primary btn-guardar">Guardar</button>
            `}

            ${isFamiliar ? "" : `
            <button class="btn btn-sm btn-danger btn-eliminar">Eliminar</button>
            `}
        </div>
    `;

    col.appendChild(div);
    activitiesList.appendChild(col);

    // Eventos SOLO si la actividad es del paciente
    if (!isFamiliar) {

        div.querySelector(".btn-guardar").addEventListener("click", () => {
            updateActivity(div);
        });

        div.querySelector(".btn-realizada").addEventListener("click", () => {
            markAsDone(div);
        });

        div.querySelector(".btn-eliminar").addEventListener("click", () => {
            deleteActivity(div);
        });

    } else {
        // Actividades del familiar: solo marcar como realizada
        div.querySelector(".btn-realizada").addEventListener("click", () => {
            markAsDone(div);
        });
    }
}

// ============================
// 3. CREAR ACTIVIDAD
// ============================

addActivityBtn.addEventListener("click", () => {
    const texto = prompt("Escribe el nombre de la actividad:");
    if (!texto) return;

    fetch("../controllers/actividades.php?action=crear", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ texto })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                loadActivities();
            }
        });
});

// ============================
// 4. ACTUALIZAR ACTIVIDAD
// ============================

function updateActivity(div) {
    const id = div.dataset.id;
    const texto = div.querySelector(".actividad-texto").innerText.trim();
    const hora = div.querySelector(".actividad-hora").value;
    const notificar = div.querySelector(".actividad-notif").checked;

    fetch("../controllers/actividades.php?action=actualizar", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            id,
            texto,
            hora_limite: hora,
            notificar
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
        body: JSON.stringify({ id, realizada: 1 })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {

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
        });
}

// ============================
// 6. ELIMINAR ACTIVIDAD
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
// 7. INICIALIZAR
// ============================

loadActivities();
