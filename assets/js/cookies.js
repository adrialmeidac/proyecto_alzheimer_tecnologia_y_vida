document.addEventListener("DOMContentLoaded", () => {

    const banner = document.getElementById("cookies-banner");
    const settings = document.getElementById("cookies-settings");

    const btnAccept = document.getElementById("cookies-accept");
    const btnReject = document.getElementById("cookies-reject");
    const btnConfigure = document.getElementById("cookies-configure");

    const btnSave = document.getElementById("cookies-save");
    const btnClose = document.getElementById("cookies-close");

    const chkAnalytics = document.getElementById("cookie-analytics");
    const chkPersonalization = document.getElementById("cookie-personalization");

    const STORAGE_KEY = "cookies-preferences";

    // ================================
    // 1. Mostrar banner si no hay preferencias
    // ================================
    if (!localStorage.getItem(STORAGE_KEY)) {
        banner.style.display = "block";
    }

    // ================================
    // 2. Aceptar todas
    // ================================
    btnAccept.addEventListener("click", () => {
        const prefs = {
            analytics: true,
            personalization: true
        };

        localStorage.setItem(STORAGE_KEY, JSON.stringify(prefs));

        banner.style.display = "none";
        settings.style.display = "none";
    });

    // ================================
    // 3. Rechazar todas
    // ================================
    btnReject.addEventListener("click", () => {
        const prefs = {
            analytics: false,
            personalization: false
        };

        localStorage.setItem(STORAGE_KEY, JSON.stringify(prefs));

        banner.style.display = "none";
        settings.style.display = "none";
    });

    // ================================
    // 4. Abrir configuración desde el banner
    // ================================
    btnConfigure.addEventListener("click", () => {
        banner.style.display = "none";
        settings.style.display = "flex";
    });

    // ================================
    // 5. Guardar configuración
    // ================================
    btnSave.addEventListener("click", () => {
        const prefs = {
            analytics: chkAnalytics.checked,
            personalization: chkPersonalization.checked
        };

        localStorage.setItem(STORAGE_KEY, JSON.stringify(prefs));

        settings.style.display = "none";
    });

    // ================================
    // 6. Cerrar panel sin guardar
    // ================================
    btnClose.addEventListener("click", () => {
        settings.style.display = "none";
    });

});
