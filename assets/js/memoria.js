const grid = document.getElementById("grid");
const resetBtn = document.getElementById("resetBtn");
const timerEl = document.getElementById("timer");
const difficultyRadios = document.querySelectorAll("input[name='difficulty']");

let cartasBase = [
    "🍎","⭐","🐶","🌼","🍌","🚗",
    "🎈","🍇","🍒","🐱","🌻","🍉"
];

let cartas = [];
let seleccionadas = [];
let bloqueado = false; // 🔓 El jugador puede empezar
let tiempo = 0;
let timerInterval;
let timerIniciado = false;
let parejasObjetivo = 8; // medio por defecto

// ===============================
//   CAMBIO DE DIFICULTAD
// ===============================
difficultyRadios.forEach(radio => {
    radio.addEventListener("change", () => {
        const nivel = radio.value;

        if (nivel === "facil") parejasObjetivo = 6;
        if (nivel === "medio") parejasObjetivo = 8;
        if (nivel === "dificil") parejasObjetivo = 12;

        reiniciarJuego();
    });
});

// ===============================
//   GENERAR CARTAS
// ===============================
function generarCartas() {
    const seleccion = cartasBase.slice(0, parejasObjetivo);
    cartas = [...seleccion, ...seleccion];
}

function ajustarColumnas() {
    let columnas = 4;

    if (parejasObjetivo === 6) columnas = 3;
    else if (parejasObjetivo === 8) columnas = 4;
    else if (parejasObjetivo === 12) columnas = 6;

    grid.style.gridTemplateColumns = `repeat(${columnas}, 100px)`;
}

function mezclarCartas() {
    cartas.sort(() => Math.random() - 0.5);
}

// ===============================
//   CREAR TABLERO
// ===============================
function crearTablero() {
    grid.innerHTML = "";
    seleccionadas = [];
    bloqueado = false;
    timerIniciado = false;

    generarCartas();
    mezclarCartas();
    ajustarColumnas();

    cartas.forEach((emoji, index) => {
        const card = document.createElement("div");
        card.classList.add("memory-card");
        card.dataset.valor = emoji;
        card.dataset.index = index;
        card.onclick = () => revelarCarta(card);
        grid.appendChild(card);
    });
}

// ===============================
//   TEMPORIZADOR
// ===============================
function iniciarTemporizador() {
    tiempo = 0;
    timerEl.textContent = "Tiempo: 0s";

    timerInterval = setInterval(() => {
        tiempo++;
        timerEl.textContent = `Tiempo: ${tiempo}s`;
    }, 1000);
}

function detenerTemporizador() {
    clearInterval(timerInterval);
}

// ===============================
//   REVELAR CARTA
// ===============================
function revelarCarta(card) {
    if (bloqueado) return;
    if (card.classList.contains("revealed")) return;

    // ⏳ Iniciar timer en el primer clic
    if (!timerIniciado) {
        iniciarTemporizador();
        timerIniciado = true;
    }

    card.classList.add("revealed");
    card.textContent = card.dataset.valor;
    seleccionadas.push(card);

    if (seleccionadas.length === 2) {
        verificarPareja();
    }
}

// ===============================
//   VERIFICAR PAREJA
// ===============================
function verificarPareja() {
    bloqueado = true;

    const [c1, c2] = seleccionadas;

    if (c1.dataset.valor === c2.dataset.valor) {
        seleccionadas = [];
        bloqueado = false;
        verificarVictoria();
    } else {
        setTimeout(() => {
            c1.classList.remove("revealed");
            c1.textContent = "";
            c2.classList.remove("revealed");
            c2.textContent = "";
            seleccionadas = [];
            bloqueado = false;
        }, 700);
    }
}

// ===============================
//   VERIFICAR VICTORIA
// ===============================
function verificarVictoria() {
    const todas = document.querySelectorAll(".memory-card.revealed");

    if (todas.length === cartas.length) {
        detenerTemporizador();
        bloqueado = true;

        guardarResultadoBackend();

        setTimeout(() => {
            alert(`¡Excelente! Encontraste todas las parejas en ${tiempo} segundos 🎉`);
        }, 300);
    }
}

// ===============================
//   GUARDAR RESULTADO EN BACKEND
// ===============================
function guardarResultadoBackend() {
    const dificultad = document.querySelector("input[name='difficulty']:checked").value;

    fetch("/controllers/guardar-resultados.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            tipo: "memoria",
            dificultad: dificultad,
            tiempo: tiempo,
            puntuacion: parejasObjetivo
        })
    })
    .then(res => res.json())
    .then(data => console.log("Resultado guardado:", data))
    .catch(err => console.error("Error al guardar resultado:", err));
}

// ===============================
//   REINICIAR JUEGO
// ===============================
function reiniciarJuego() {
    detenerTemporizador();
    timerIniciado = false;
    tiempo = 0;
    timerEl.textContent = "Tiempo: 0s";
    crearTablero();
}

resetBtn.addEventListener("click", reiniciarJuego);

// ===============================
//   INICIALIZAR
// ===============================
crearTablero();
