document.addEventListener("DOMContentLoaded", () => {

    // Obtener parámetro de la URL
    const params = new URLSearchParams(window.location.search);
    const tipoTest = params.get("test");

    // Elementos del DOM
    const titulo = document.getElementById("tituloTest");
    const descripcion = document.getElementById("descripcionTest");
    const preguntaDiv = document.getElementById("pregunta");
    const opcionesDiv = document.getElementById("opciones");
    const btnSiguiente = document.getElementById("btnSiguiente");
    const estimuloDiv = document.getElementById("estimulo");

    // Helpers botón siguiente
    function mostrarBotonSiguiente(callback) {
        btnSiguiente.style.display = "block";
        btnSiguiente.onclick = callback;
    }

    function ocultarBotonSiguiente() {
        btnSiguiente.style.display = "none";
    }

    // Base de tests
    const tests = {
        memoria: {
            titulo: "Test de Memoria",
            descripcion: "Recuerda las palabras que verás a continuación.",
            palabrasClave: ["silla", "mesa", "casa"],
            distractoras: ["perro", "árbol", "coche", "flor", "zapato", "sol", "libro"],
            historia: `Esta mañana, Laura salió temprano de casa para encontrarse con su hermana en el parque. 
        El clima estaba fresco y el cielo despejado, así que decidió caminar en lugar de tomar el autobús. 
        Mientras avanzaba por la calle principal, observó cómo los comercios abrían sus puertas y los vecinos 
        comenzaban su rutina diaria. Al llegar al parque, vio a varios niños jugando cerca de la fuente y a un 
        grupo de personas mayores haciendo ejercicio suave. Su hermana llegó unos minutos después con una bolsa 
        de pan recién horneado. Se sentaron en un banco a conversar sobre los planes familiares para el fin de 
        semana, recordando anécdotas de su infancia y riendo por cosas que solo ellas entendían. Después de un 
        rato, decidieron dar un paseo alrededor del lago antes de regresar a casa.`
        },

        atencion: {
            titulo: "Test de Atención",
            descripcion: "Observa el color y luego responde.",
            estimulos: ["🔴", "🟦", "🟩", "🟨"],
            rondas: 5
        },

        orientacion: {
            titulo: "Test de Orientación",
            descripcion: "Evalúa tu orientación en tiempo y espacio.",
            preguntas: []
        }
    };

    // Validar test
    if (!tipoTest || !tests[tipoTest]) {
        titulo.textContent = "Test no encontrado";
        descripcion.textContent = "El test solicitado no existe.";
        return;
    }

    const test = tests[tipoTest];
    let indice = 0;
    let puntaje = 0;

    // Mostrar título y descripción
    titulo.textContent = test.titulo;
    descripcion.textContent = test.descripcion;

    // ===============================
    //   MEMORIA
    // ===============================
    function mostrarPalabrasMemoria() {
        preguntaDiv.textContent = "Memoriza estas palabras:";
        opcionesDiv.innerHTML = `<h2>${test.palabrasClave.join(" – ")}</h2>`;

        setTimeout(() => {
            opcionesDiv.innerHTML = "";
            mostrarHistoriaMemoria();
        }, 5000);
    }

    function mostrarHistoriaMemoria() {
        preguntaDiv.textContent = "Lee la siguiente historia:";
        opcionesDiv.innerHTML = `<p>${test.historia}</p>`;

        mostrarBotonSiguiente(() => mostrarOpcionesMemoria());
    }

    function mostrarOpcionesMemoria() {
        ocultarBotonSiguiente();

        preguntaDiv.textContent = "Selecciona las palabras que viste al inicio:";
        opcionesDiv.innerHTML = "";

        const todas = [...test.palabrasClave, ...test.distractoras];
        const mezcladas = todas.sort(() => Math.random() - 0.5);

        mezcladas.forEach(palabra => {
            const btn = document.createElement("button");
            btn.classList.add("test-option-btn");
            btn.textContent = palabra;

            btn.onclick = () => {
                const seleccionadas = opcionesDiv.querySelectorAll(".selected");

                if (seleccionadas.length >= 3 && !btn.classList.contains("selected")) return;

                btn.classList.toggle("selected");
            };

            opcionesDiv.appendChild(btn);
        });

        mostrarBotonSiguiente(() => evaluarMemoria());
    }

    function evaluarMemoria() {
        const seleccionadas = [...document.querySelectorAll(".selected")].map(b => b.textContent);

        let aciertos = 0;
        test.palabrasClave.forEach(p => {
            if (seleccionadas.includes(p)) aciertos++;
        });

        puntaje = aciertos;
        mostrarResultado();
    }

    // ===============================
    //   ATENCIÓN
    // ===============================
    let rondaAtencion = 0;
    let colorCorrectoActual = null;

    function mostrarEstimuloAtencion() {
        rondaAtencion = 0;
        puntaje = 0;
        iniciarRondaAtencion();
    }

    function iniciarRondaAtencion() {
        if (rondaAtencion >= test.rondas) {
            mostrarResultado();
            return;
        }

        ocultarBotonSiguiente();
        opcionesDiv.innerHTML = "";
        preguntaDiv.textContent = "Observa el color:";

        const color = test.estimulos[Math.floor(Math.random() * test.estimulos.length)];
        colorCorrectoActual = color;

        estimuloDiv.textContent = color;
        estimuloDiv.style.display = "block";

        setTimeout(() => {
            estimuloDiv.style.display = "none";
            mostrarPreguntaAtencion();
        }, 1500);
    }

    function mostrarPreguntaAtencion() {
        preguntaDiv.textContent = "¿Qué color viste?";
        opcionesDiv.innerHTML = "";

        test.estimulos.forEach(opcion => {
            const btn = document.createElement("button");
            btn.classList.add("test-option-btn");
            btn.textContent = opcion;

            btn.onclick = () => seleccionarRespuestaAtencion(btn, opcion);

            opcionesDiv.appendChild(btn);
        });
    }

    function seleccionarRespuestaAtencion(btn, opcion) {
        const botones = opcionesDiv.querySelectorAll(".test-option-btn");
        botones.forEach(b => b.disabled = true);

        if (opcion === colorCorrectoActual) {
            puntaje++;
            btn.classList.add("correct");
        } else {
            btn.classList.add("incorrect");
            botones.forEach(b => {
                if (b.textContent === colorCorrectoActual) b.classList.add("correct");
            });
        }

        mostrarBotonSiguiente(() => {
            rondaAtencion++;
            iniciarRondaAtencion();
        });
    }

    // ===============================
    //   ORIENTACIÓN
    // ===============================
    function generarPreguntasOrientacion() {
        const ahora = new Date();
        const diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
        const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

        const diaReal = diasSemana[ahora.getDay()];
        const mesReal = meses[ahora.getMonth()];
        const anioReal = ahora.getFullYear();

        const mesIndex = ahora.getMonth();
        let estacion;
        if (mesIndex === 11 || mesIndex <= 1) estacion = "Invierno";
        else if (mesIndex >= 2 && mesIndex <= 4) estacion = "Primavera";
        else if (mesIndex >= 5 && mesIndex <= 7) estacion = "Verano";
        else estacion = "Otoño";

        function opcionesAleatorias(correcta, lista) {
            const otras = lista.filter(x => x !== correcta);
            const mezcladas = otras.sort(() => Math.random() - 0.5).slice(0, 2);
            const todas = [correcta, ...mezcladas].sort(() => Math.random() - 0.5);
            const correctaIndex = todas.indexOf(correcta);
            return { opciones: todas, correcta: correctaIndex };
        }

        const p1 = opcionesAleatorias(diaReal, diasSemana);
        const p2 = opcionesAleatorias(mesReal, meses);
        const p3 = opcionesAleatorias(String(anioReal), [String(anioReal - 1), String(anioReal), String(anioReal + 1)]);
        const p4 = opcionesAleatorias(estacion, ["Primavera", "Verano", "Otoño", "Invierno"]);

        tests.orientacion.preguntas = [
            { texto: "¿En qué día de la semana estamos?", opciones: p1.opciones, correcta: p1.correcta },
            { texto: "¿En qué mes estamos?", opciones: p2.opciones, correcta: p2.correcta },
            { texto: "¿En qué año estamos?", opciones: p3.opciones, correcta: p3.correcta },
            { texto: "¿Qué estación del año es?", opciones: p4.opciones, correcta: p4.correcta }
        ];
    }

    function mostrarPregunta() {
        const p = test.preguntas[indice];

        preguntaDiv.textContent = p.texto;
        opcionesDiv.innerHTML = "";
        ocultarBotonSiguiente();

        p.opciones.forEach((opcion, i) => {
            const btn = document.createElement("button");
            btn.classList.add("test-option-btn");
            btn.textContent = opcion;

            btn.onclick = () => seleccionarRespuesta(i, btn);

            opcionesDiv.appendChild(btn);
        });
    }

    function seleccionarRespuesta(i, btn) {
        const correcta = test.preguntas[indice].correcta;
        const botones = opcionesDiv.querySelectorAll(".test-option-btn");
        botones.forEach(b => b.disabled = true);

        if (i === correcta) {
            puntaje++;
            btn.classList.add("correct");
        } else {
            btn.classList.add("incorrect");
            botones[correcta].classList.add("correct");
        }

        mostrarBotonSiguiente(() => {
            indice++;
            if (indice < test.preguntas.length) {
                mostrarPregunta();
            } else {
                mostrarResultado();
            }
        });
    }

    // ===============================
    //   RESULTADO + BACKEND
    // ===============================
    function mostrarResultado() {
        preguntaDiv.textContent = "Resultado del Test";

        let mensaje = "";
        let interpretacion = "";

        if (tipoTest === "memoria") {
            if (puntaje === 3) {
                mensaje = "Excelente memoria.";
                interpretacion = "No se observan dificultades significativas.";
            } else if (puntaje === 2) {
                mensaje = "Memoria conservada.";
                interpretacion = "Pequeñas dificultades, pero aceptable.";
            } else if (puntaje === 1) {
                mensaje = "Memoria reducida.";
                interpretacion = "Dificultades en retención reciente.";
            } else {
                mensaje = "Déficit significativo.";
                interpretacion = "Se recomienda evaluación profesional.";
            }
        }

        if (tipoTest === "atencion") {
            mensaje = `Obtuviste ${puntaje} de ${tests.atencion.rondas} respuestas correctas.`;
            if (puntaje === tests.atencion.rondas) {
                interpretacion = "Atención excelente.";
            } else if (puntaje >= Math.ceil(tests.atencion.rondas * 0.6)) {
                interpretacion = "Atención conservada.";
            } else {
                interpretacion = "Dificultades en atención sostenida.";
            }
        }

        if (tipoTest === "orientacion") {
            mensaje = `Obtuviste ${puntaje} de ${test.preguntas.length} respuestas correctas.`;
            if (puntaje === test.preguntas.length) {
                interpretacion = "Orientación conservada.";
            } else if (puntaje >= Math.ceil(test.preguntas.length * 0.5)) {
                interpretacion = "Orientación parcialmente conservada.";
            } else {
                interpretacion = "Dificultades importantes.";
            }
        }

        opcionesDiv.innerHTML = `
            <h2>${mensaje}</h2>
            <p>${interpretacion}</p>
        `;

        ocultarBotonSiguiente();

        const btnRepetir = document.createElement("button");
        btnRepetir.classList.add("test-option-btn");
        btnRepetir.textContent = "Repetir test";
        btnRepetir.onclick = () => {
            indice = 0;
            puntaje = 0;

            if (tipoTest === "memoria") mostrarPalabrasMemoria();
            if (tipoTest === "atencion") mostrarEstimuloAtencion();
            if (tipoTest === "orientacion") {
                generarPreguntasOrientacion();
                mostrarPregunta();
            }
        };

        opcionesDiv.appendChild(btnRepetir);

        guardarResultadoBackend();
    }

    function guardarResultadoBackend() {
        fetch("/controllers/guardar-resultados.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                tipo: "test",
                dificultad: "ninguna",
                tiempo: 0,
                puntuacion: puntaje
            })
        })
        .then(res => res.json())
        .then(data => console.log("Resultado guardado:", data))
        .catch(err => console.error("Error al guardar resultado:", err));
    }

    // ===============================
    //   INICIO AUTOMÁTICO DEL TEST
    // ===============================
    if (tipoTest === "memoria") mostrarPalabrasMemoria();
    if (tipoTest === "atencion") mostrarEstimuloAtencion();
    if (tipoTest === "orientacion") {
        generarPreguntasOrientacion();
        mostrarPregunta();
    }

});

