document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    if (!email || !password) {
        alert("Debes completar todos los campos");
        return;
    }

    try {
        const response = await fetch("/controllers/login.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (data.success) {
            
            window.location.href = data.redirect;
        } else {
            alert(data.error || data.message || "Credenciales incorrectas");
        }

    } catch (error) {
        console.error("Error:", error);
        alert("Hubo un problema con el servidor.");
    }
});
