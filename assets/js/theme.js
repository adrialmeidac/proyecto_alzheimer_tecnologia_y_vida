(function () {
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "dark") {
        document.body.classList.add("dark");
    }

    updateThemeIcon();
})();


// ===============================
//   FUNCIÓN PARA CAMBIAR TEMA
// ===============================
function toggleTheme() {
    document.body.classList.toggle("dark");

    // Guardar preferencia
    if (document.body.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }

    updateThemeIcon();
}


// ===============================
//   ACTUALIZAR ICONO DEL BOTÓN
// ===============================
function updateThemeIcon() {
    const btn = document.querySelector(".theme-toggle");
    if (!btn)
    return;

    if (document.body.classList.contains("dark")) {
        btn.textContent = "Modo claro"; // modo oscuro → mostrar sol
    } else {
        btn.textContent = "Modo oscuro"; // modo claro → mostrar luna
    }
}
