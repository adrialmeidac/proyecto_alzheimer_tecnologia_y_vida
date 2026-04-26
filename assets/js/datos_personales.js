document.getElementById("datosForm").addEventListener("submit", async function(e) {
    e.preventDefault(); // Evita envío automático

    const nombre = document.getElementById("nombre").value.trim();
    const apellido = document.getElementById("apellido").value.trim();
    const fecha = document.getElementById("fecha").value;
    const telefono = document.getElementById("telefono").value.trim();

    const errorBox = document.getElementById("datos-errors");
    let errores = [];

    // Validación de nombre
    if (nombre.length < 2) {
        errores.push("El nombre debe tener al menos 2 caracteres.");
    }

    // Validación de apellido
    if (apellido.length < 2) {
        errores.push("El apellido debe tener al menos 2 caracteres.");
    }

    // Validación de fecha de nacimiento
    if (!fecha) {
        errores.push("Debes seleccionar una fecha de nacimiento.");
    } else {
        const fechaNacimiento = new Date(fecha);
        const hoy = new Date();

        if (fechaNacimiento > hoy) {
            errores.push("La fecha de nacimiento no puede ser futura.");
        }
    }

    // Validación de teléfono (opcional pero si se escribe debe ser válido)
    if (telefono !== "" && !(/^[0-9]{9}$/.test(telefono))) {
        errores.push("El teléfono debe tener 9 dígitos.");
    }

    // Mostrar errores si existen
    if (errores.length > 0) {
        errorBox.style.display = "block";
        errorBox.innerHTML = errores.map(e => `<p>${e}</p>`).join("");
        return;
    }

    // Si todo está bien, ocultar errores
    errorBox.style.display = "none";

    // Enviar datos al backend por AJAX
    const formData = new FormData(this);

    try {
        const response = await fetch("../controllers/guardar-datos-personales.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        // Si el backend devuelve error
        if (!result.success) {
            errorBox.style.display = "block";
            errorBox.innerHTML = `<p>${result.error}</p>`;
            return;
        }

        // Si todo va bien → redirigir al dashboard
        if (result.redirect) {
            window.location.href = result.redirect;
        }

    } catch (error) {
        console.error("Error en la petición AJAX:", error);
        errorBox.style.display = "block";
        errorBox.innerHTML = "<p>Hubo un error inesperado. Inténtalo de nuevo.</p>";
    }
});
