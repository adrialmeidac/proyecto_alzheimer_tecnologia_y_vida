document.querySelectorAll(".carousel").forEach(carousel => {

    const track = carousel.querySelector(".carousel-track");
    const slides = Array.from(track.children);
    const nextBtn = carousel.querySelector(".next");
    const prevBtn = carousel.querySelector(".prev");

    let index = 0;
    let autoplay;

    
    if (slides.length <= 1) return;

    function updateCarousel() {
        track.style.transform = `translateX(-${index * 100}%)`;
    }

    function startAutoplay() {
        autoplay = setInterval(() => {
            index = (index + 1) % slides.length;
            updateCarousel();
        }, 3000);
    }

    function stopAutoplay() {
        clearInterval(autoplay);
    }

    if (nextBtn) {
        nextBtn.addEventListener("click", () => {
            stopAutoplay();
            index = (index + 1) % slides.length;
            updateCarousel();
            startAutoplay();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener("click", () => {
            stopAutoplay();
            index = (index - 1 + slides.length) % slides.length;
            updateCarousel();
            startAutoplay();
        });
    }

    document.addEventListener("visibilitychange", () => {
        if (document.hidden) {
            stopAutoplay();
        } else {
            startAutoplay();
        }
    });

  
    startAutoplay();
});

