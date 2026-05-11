const piecesContainer = document.getElementById("pieces");
const dropzonesContainer = document.getElementById("dropzones");
const resetBtn = document.getElementById("resetBtn");
const timerEl = document.getElementById("timer");
const referenceImg = document.getElementById("referenceImg");
const difficultyRadios = document.querySelectorAll("input[name='difficulty']");

const imagenCompleta = {
    perro: "/assets/images/perro.jpg",
    globoaereo: "/assets/images/globoaereo.jpg"
};

let correctPieces = 0;
let time = 0;
let timerInterval;
let timerStarted = false; 
let bloqueado = false;    

const imagenes = ["perro", "globoaereo"];
let indiceImagen = 0;
let piezasTotales = 9;


const nombresPiezas = {
    perro: {
        2: ["perro1.jpg", "perro1-1.jpg", "perro1-2.jpg", "perro1-3.jpg"],
        3: [
            "perro_1.jpg","perro_2.jpg","perro_3.jpg",
            "perro_4.jpg","perro_5.jpg","perro_6.jpg",
            "perro_7.jpg","perro_8.jpg","perro_9.jpg"
        ],
        4: Array.from({length: 16}, (_, i) => `perro_${i+1}.jpg`)
    },
    globoaereo: {
        2: ["globoaereo_1.jpg","globoaereo_2.jpg","globoaereo_3.jpg","globoaereo_4.jpg"], 
        3: ["globoaereo_1.jpg","globoaereo_2.jpg","globoaereo_3.jpg",
            "globoaereo_4.jpg","globoaereo_5.jpg","globoaereo_6.jpg",
            "globoaereo_7.jpg","globoaereo_8.jpg","globoaereo_9.jpg"], 
        4: Array.from({length: 16}, (_, i) => `globoaereo_${i+1}.jpg`)
    }
};

function obtenerCarpetaImagen(nombre, columnas) {
    return `../assets/images/${nombre}_${columnas}x${columnas}`;
}




difficultyRadios.forEach(radio => {
    radio.addEventListener("change", () => {
        const nivel = radio.value;

        if (nivel === "facil") piezasTotales = 4;
        if (nivel === "medio") piezasTotales = 9;
        if (nivel === "dificil") piezasTotales = 16;

        timerStarted = false;
        detenerTemporizador();
        crearPiezas();
    });
});




function crearPiezas() {
    piecesContainer.innerHTML = "";
    dropzonesContainer.innerHTML = "";
    correctPieces = 0;
    bloqueado = false;
    timerStarted = false;

    const columnas = Math.sqrt(piezasTotales);
    const nombreImagen = imagenes[indiceImagen];
    const carpeta = obtenerCarpetaImagen(nombreImagen, columnas);

    referenceImg.src = imagenCompleta[nombreImagen];

    dropzonesContainer.style.gridTemplateColumns = `repeat(${columnas}, 1fr)`;
    piecesContainer.style.gridTemplateColumns = `repeat(${columnas}, 1fr)`;

    for (let i = 0; i < piezasTotales; i++) {
        const piece = document.createElement("div");
        piece.classList.add("piece");
        piece.dataset.id = i + 1;
        piece.draggable = true;

        const nombreArchivo = nombresPiezas[nombreImagen][columnas][i];
        piece.style.backgroundImage = `url('${carpeta}/${nombreArchivo}')`;

        piecesContainer.appendChild(piece);

        const zone = document.createElement("div");
        zone.classList.add("dropzone");
        zone.dataset.id = i + 1;
        dropzonesContainer.appendChild(zone);
    }

    activarEventos();
    mezclarPiezas(); 
}




function mezclarPiezas() {
    const piezas = Array.from(piecesContainer.children);

    for (let i = piezas.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        piecesContainer.insertBefore(piezas[j], piezas[i]);
        [piezas[i], piezas[j]] = [piezas[j], piezas[i]];
    }
}




function iniciarTemporizador() {
    time = 0;
    timerEl.textContent = "Tiempo: 0s";

    timerInterval = setInterval(() => {
        time++;
        timerEl.textContent = `Tiempo: ${time}s`;
    }, 1000);
}

function detenerTemporizador() {
    clearInterval(timerInterval);
}




function activarEventos() {
    const pieces = document.querySelectorAll(".piece");
    const dropzones = document.querySelectorAll(".dropzone");

    pieces.forEach(piece => {
        piece.addEventListener("dragstart", e => {

            
            if (!timerStarted) {
                iniciarTemporizador();
                timerStarted = true;
            }

            e.dataTransfer.setData("id", piece.dataset.id);
        });
    });

    dropzones.forEach(zone => {
        zone.addEventListener("dragover", e => e.preventDefault());

        zone.addEventListener("drop", e => {
            const idPieza = e.dataTransfer.getData("id");

            if (zone.dataset.id === idPieza) {
                const pieza = document.querySelector(`.piece[data-id='${idPieza}']`);
                zone.appendChild(pieza);

                pieza.draggable = false;
                pieza.style.cursor = "default";

                correctPieces++;
                verificarVictoria();
            }
        });
    });
}




function guardarResultadoBackend() {
    const dificultad = document.querySelector("input[name='difficulty']:checked").value;

    fetch("/controllers/guardar-resultados.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            tipo: "rompecabezas",
            dificultad: dificultad,
            tiempo: time,
            puntuacion: 1
        })
    });
}

function verificarVictoria() {
    if (correctPieces === piezasTotales) {
        detenerTemporizador();

        guardarResultadoBackend();

        setTimeout(() => {
            alert("¡Felicidades, completaste el rompecabezas!");
            indiceImagen = (indiceImagen + 1) % imagenes.length;
            crearPiezas();
        }, 800);
    }
}




resetBtn.addEventListener("click", () => {
    detenerTemporizador();
    timerStarted = false;
    crearPiezas();
});




crearPiezas();
