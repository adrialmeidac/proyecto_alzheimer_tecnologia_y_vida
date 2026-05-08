document.getElementById("datosForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const nombre = document.getElementById("nombre").value.trim();
    const apellido = document.getElementById("apellido").value.trim();
    const fecha = document.getElementById("fecha").value;
    const telefono = document.getElementById("telefono").value.trim();

    const errorBox = document.getElementById("datos-errors");
    let errores = [];

    // ============================
    // VALIDACIONES
    // ============================

    // Nombre
    if (!/^[a-zA-ZÀ-ÿ\s]{2,40}$/.test(nombre)) {
        errores.push("El nombre debe contener solo letras y tener al menos 2 caracteres.");
    }

    // Apellido
    if (!/^[a-zA-ZÀ-ÿ\s]{2,60}$/.test(apellido)) {
        errores.push("El apellido debe contener solo letras y tener al menos 2 caracteres.");
    }

    // Fecha
    if (!fecha) {
        errores.push("Debes seleccionar una fecha de nacimiento.");
    } else {
        const fechaNacimiento = new Date(fecha);
        const hoy = new Date();

        if (fechaNacimiento > hoy) {
            errores.push("La fecha de nacimiento no puede ser futura.");
        }
    }

    // Teléfono
    if (telefono !== "" && !/^[1-9][0-9]{8}$/.test(telefono)) {
        errores.push("El teléfono debe tener 9 dígitos y no comenzar por 0.");
    }

    // Mostrar errores
    if (errores.length > 0) {
        errorBox.style.display = "block";
        errorBox.innerHTML = errores.map(e => `<p>${e}</p>`).join("");
        return;
    }

    errorBox.style.display = "none";

    // ============================
    // ENVIAR DATOS AL BACKEND
    // ============================

    const formData = new FormData(this);

    try {
        const response = await fetch("/controllers/guardar-datos-personales.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (!result.success) {
            errorBox.style.display = "block";
            errorBox.innerHTML = `<p>${result.error}</p>`;
            return;
        }

        // Redirigir
        if (result.redirect) {
            window.location.href = result.redirect;
        }

    } catch (error) {
        console.error("Error en la petición AJAX:", error);
        errorBox.style.display = "block";
        errorBox.innerHTML = "<p>Hubo un error inesperado. Inténtalo de nuevo.</p>";
    }
});
