const historialList = document.getElementById("historialList");
const clearHistoryBtn = document.getElementById("clearHistoryBtn");





async function loadHistorial() {
    try {
        const res = await fetch("/controllers/actividades.php?action=listar_historial");
        const data = await res.json();

        if (!data.success || !Array.isArray(data.historial)) {
            historialList.innerHTML = "<li>Error al cargar historial</li>";
            return;
        }

        renderLista(data.historial);

    } catch (error) {
        historialList.innerHTML = "<li>Error de conexión</li>";
    }
}





function renderLista(lista) {
    historialList.innerHTML = "";

    if (lista.length === 0) {
        historialList.innerHTML = "<li>No hay actividades en este periodo</li>";
        return;
    }

    lista.forEach(item => renderHistorialItem(item));
}





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
            <strong>${sanitize(item.detalle)}</strong>
            <br>
            <small>${fechaFormateada}</small>
        </div>
    `;

    historialList.appendChild(li);
}





clearHistoryBtn.addEventListener("click", async () => {
    if (!confirm("¿Borrar todo el historial?")) return;

    try {
        const res = await fetch("/controllers/actividades.php?action=borrar_historial", {
            method: "POST"
        });
        const data = await res.json();

        if (data.success) {
            historialList.innerHTML = "<li>Historial borrado</li>";
        }

    } catch (error) {
        alert("Error al borrar el historial");
    }
});





document.querySelectorAll(".filter-btn").forEach(btn => {
    btn.addEventListener("click", () => aplicarFiltro(btn.dataset.filter));
});

async function aplicarFiltro(filtro) {
    try {
        const res = await fetch("/controllers/actividades.php?action=listar_historial");
        const data = await res.json();

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

        renderLista(filtrado);

    } catch (error) {
        historialList.innerHTML = "<li>Error al aplicar filtro</li>";
    }
}



function sanitize(text) {
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
}





loadHistorial();
