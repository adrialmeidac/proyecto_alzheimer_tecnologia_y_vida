const colores = ["rojo", "azul", "verde", "amarillo"];
let secuencia = [];
let usuario = [];
let nivel = 0;
let bloqueado = false;

const startBtn = document.getElementById("startBtn");
const resetBtn = document.getElementById("resetBtn");
const botones = document.querySelectorAll(".color");
const timerEl = document.getElementById("timer");
const difficultyRadios = document.querySelectorAll("input[name='difficulty']");

let tiempo = 0;
let timerInterval;

// Niveles según dificultad
let nivelesMeta = 10; // por defecto (medio)

// Cambiar dificultad sin iniciar el juego
difficultyRadios.forEach(radio => {
    radio.addEventListener("change", () => {
        const nivelSel = radio.value;

        if (nivelSel === "facil") nivelesMeta = 5;
        if (nivelSel === "medio") nivelesMeta = 10;
        if (nivelSel === "dificil") nivelesMeta = 15;
    });
});

// Temporizador
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

// Iniciar juego
startBtn.onclick = iniciarJuego;

function iniciarJuego() {
    startBtn.disabled = true;

    detenerTemporizador();
    iniciarTemporizador();

    secuencia = [];
    usuario = [];
    nivel = 0;
    bloqueado = false;

    siguienteNivel();
}

// Siguiente nivel
function siguienteNivel() {
    bloqueado = true;
    usuario = [];
    nivel++;

    const colorAleatorio = colores[Math.floor(Math.random() * 4)];
    secuencia.push(colorAleatorio);

    reproducirSecuencia();
}

// Reproducir secuencia
function reproducirSecuencia() {
    let i = 0;
    bloqueado = true;

    const intervalo = setInterval(() => {
        iluminar(secuencia[i]);
        i++;

        if (i >= secuencia.length) {
            clearInterval(intervalo);
            setTimeout(() => bloqueado = false, 500);
        }
    }, 800);
}

// Iluminar color
function iluminar(color) {
    const div = document.querySelector(`.${color}`);
    div.classList.add("activo");

    setTimeout(() => {
        div.classList.remove("activo");
    }, 400);
}

// Clic del usuario
botones.forEach(btn => {
    btn.onclick = () => {
        if (bloqueado) return;

        const color = btn.dataset.color;
        usuario.push(color);
        iluminar(color);

        validar();
    };
});

// Validar jugada
function validar() {
    const i = usuario.length - 1;

    // Fallo
    if (usuario[i] !== secuencia[i]) {
        detenerTemporizador();
        bloqueado = true;
        startBtn.disabled = false;
        alert("Fallaste. Pulsa START para intentarlo de nuevo.");
        return;
    }

    // Secuencia completa
    if (usuario.length === secuencia.length) {

        // Final según dificultad
        if (nivel === nivelesMeta) {
            victoria();
        } else {
            setTimeout(siguienteNivel, 1000);
        }
    }
}

// Victoria
function victoria() {
    detenerTemporizador();
    bloqueado = true;
    startBtn.disabled = false;

    guardarResultadoBackend();

    setTimeout(() => {
        alert(`¡Excelente! Completaste el nivel ${nivelesMeta} en ${tiempo} segundos 🎉`);
    }, 300);
}

// Guardar resultado en backend
function guardarResultadoBackend() {
    const dificultad = document.querySelector("input[name='difficulty']:checked").value;

    fetch("/controllers/guardar-resultados.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            tipo: "colores",
            dificultad: dificultad,
            tiempo: tiempo,
            puntuacion: nivel
        })
    });
}

// Reiniciar juego
resetBtn.addEventListener("click", reiniciarJuego);

function reiniciarJuego() {
    detenerTemporizador();
    tiempo = 0;
    timerEl.textContent = "Tiempo: 0s";

    secuencia = [];
    usuario = [];
    nivel = 0;
    bloqueado = false;

    startBtn.disabled = false;
}
