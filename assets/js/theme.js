(function () {
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "dark") {
        document.body.classList.add("dark");
    }

    updateThemeIcon();
})();



function toggleTheme() {
    document.body.classList.toggle("dark");

    
    if (document.body.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }

    updateThemeIcon();
}





function updateThemeIcon() {
    const btn = document.querySelector(".theme-toggle");
    if (!btn)
    return;

    if (document.body.classList.contains("dark")) {
        btn.textContent = "Modo claro"; 
    } else {
        btn.textContent = "Modo oscuro"; 
    }
}
