
const isLogged = localStorage.getItem("logged");
const role = localStorage.getItem("role");

const publicMenu = document.getElementById("public-menu");
const privateMenu = document.getElementById("private-menu");
const adminMenu = document.getElementById("admin-menu");

// ============================
// 2. CARRUSELES
// ============================

document.querySelectorAll(".carousel").forEach(carousel => {

    const track = carousel.querySelector(".carousel-track");
    const slides = Array.from(track.children);
    const nextBtn = carousel.querySelector(".next");
    const prevBtn = carousel.querySelector(".prev");

    let index = 0;
    let autoplay;

    // Evitar errores si no hay suficientes imágenes
    if (slides.length <= 1) return;

    // Función para actualizar el carrusel
    function updateCarousel() {
        track.style.transform = `translateX(-${index * 100}%)`;
    }

    // Autoplay
    function startAutoplay() {
        autoplay = setInterval(() => {
            index = (index + 1) % slides.length;
            updateCarousel();
        }, 3000);
    }

    function stopAutoplay() {
        clearInterval(autoplay);
    }

    // Botón siguiente
    if (nextBtn) {
        nextBtn.addEventListener("click", () => {
            stopAutoplay();
            index = (index + 1) % slides.length;
            updateCarousel();
            startAutoplay();
        });
    }

    // Botón anterior
    if (prevBtn) {
        prevBtn.addEventListener("click", () => {
            stopAutoplay();
            index = (index - 1 + slides.length) % slides.length;
            updateCarousel();
            startAutoplay();
        });
    }

    // Iniciar autoplay
    startAutoplay();
});

function confirmarEmergencia() {
    const confirmar = confirm("¿Deseas llamar al 112?");
    if (confirmar) {
        window.location.href = "tel:112";
    }
}


// ============================
// 3. MOSTRAR MENÚ SEGÚN ROL
// ============================

if (isLogged) {
    publicMenu.classList.add("hide-desktop");

    if (role === "admin") {
        adminMenu.style.display = "flex";
    } else {
        privateMenu.style.display = "flex";
    }
}    