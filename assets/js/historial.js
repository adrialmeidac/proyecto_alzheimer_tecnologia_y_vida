const historialList = document.getElementById("historialList");
const clearHistoryBtn = document.getElementById("clearHistoryBtn");

// ============================
// 1. CARGAR HISTORIAL
// ============================

function loadHistorial() {
    fetch("/controllers/actividades.php?action=listar_historial")
        .then(res => res.json())
        .then(data => {

            if (!data.success) {
                historialList.innerHTML = "<li>Error al cargar historial</li>";
                return;
            }

            historialList.innerHTML = "";

            data.historial.forEach(item => renderHistorialItem(item));
        });
}

// ============================
// 2. CREAR ITEM EN EL DOM
// ============================

function renderHistorialItem(item) {

    const li = document.createElement("li");
    li.classList.add("historial-item");

    const fecha = new Date(item.fecha);
    const fechaFormateada = fecha.toLocaleString("es-ES", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit"
    });

    li.innerHTML = `
        <div class="historial-texto">
            <strong>${item.detalle}</strong>
            <br>
            <small>${fechaFormateada}</small>
        </div>
    `;

    historialList.appendChild(li);
}

// ============================
// 3. BORRAR HISTORIAL
// ============================

clearHistoryBtn.addEventListener("click", () => {
    if (!confirm("¿Borrar todo el historial?")) return;

    fetch("/controllers/actividades.php?action=borrar_historial", {
        method: "POST"
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                historialList.innerHTML = "";
            }
        });
});

// ============================
// 4. FILTROS
// ============================

document.querySelectorAll(".filter-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        const filtro = btn.dataset.filter;
        aplicarFiltro(filtro);
    });
});

function aplicarFiltro(filtro) {
    fetch("/controllers/actividades.php?action=listar_historial")
        .then(res => res.json())
        .then(data => {

            if (!data.success) return;

            const ahora = new Date();
            let filtrado = data.historial;

            if (filtro === "hoy") {
                filtrado = filtrado.filter(item => {
                    const fecha = new Date(item.fecha);
                    return fecha.toDateString() === ahora.toDateString();
                });
            }

            if (filtro === "semana") {
                const hace7dias = new Date();
                hace7dias.setDate(ahora.getDate() - 7);

                filtrado = filtrado.filter(item => {
                    const fecha = new Date(item.fecha);
                    return fecha >= hace7dias;
                });
            }

            if (filtro === "hora") {
                const hace1hora = new Date();
                hace1hora.setHours(ahora.getHours() - 1);

                filtrado = filtrado.filter(item => {
                    const fecha = new Date(item.fecha);
                    return fecha >= hace1hora;
                });
            }

            historialList.innerHTML = "";
            filtrado.forEach(item => renderHistorialItem(item));
        });
}

// ============================
// 5. INICIALIZAR
// ============================

loadHistorial();
