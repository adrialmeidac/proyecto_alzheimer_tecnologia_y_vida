// VALIDACIÓN PREVIA ANTES DE EJECUTAR RECAPTCHA
document.getElementById("registroForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const nombre    = document.getElementById("nombre").value.trim();
    const email     = document.getElementById("email").value.trim();
    const password  = document.getElementById("password").value.trim();
    const password2 = document.getElementById("password2").value.trim();
    const rol       = document.getElementById("rol").value; // NUEVO

    const errores = [];

    // Validación de nombre
    if (nombre.length < 3) {
        errores.push("El nombre debe tener al menos 3 caracteres.");
    }

    // Validación de email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        errores.push("El correo electrónico no es válido.");
    }

    // Validación de contraseña
    if (password.length < 6) {
        errores.push("La contraseña debe tener al menos 6 caracteres.");
    }

    // Confirmación de contraseña
    if (password !== password2) {
        errores.push("Las contraseñas no coinciden.");
    }

    // Validación de rol
    if (!rol) {
        errores.push("Debes seleccionar un tipo de cuenta.");
    }

    // Mostrar errores si existen
    if (errores.length > 0) {
        alert(errores.join("\n"));
        if (typeof grecaptcha !== "undefined") {
            grecaptcha.reset();
        }
        return;
    }

    // Si todo está bien → ejecutar reCAPTCHA invisible
    grecaptcha.execute();
});


// FUNCIÓN QUE GOOGLE LLAMA CUANDO EL USUARIO PASA EL RECAPTCHA
function onSubmit(token) {
    const nombre    = document.getElementById("nombre").value.trim();
    const email     = document.getElementById("email").value.trim();
    const password  = document.getElementById("password").value.trim();
    const password2 = document.getElementById("password2").value.trim();
    const rol       = document.getElementById("rol").value; // NUEVO

    fetch("/controllers/registro.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            nombre: nombre,
            email: email,
            password: password,
            password2: password2,
            rol: rol,           // NUEVO
            recaptcha: token
        })
    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {
            // Redirección dinámica según el rol
            window.location.href = data.redirect;
            return;
        }

        alert(data.error || "Error en el registro");

        if (typeof grecaptcha !== "undefined") {
            grecaptcha.reset();
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Hubo un problema con el servidor.");

        if (typeof grecaptcha !== "undefined") {
            grecaptcha.reset();
        }
    });
}
