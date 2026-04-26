function confirmarEmergencia() {
    document.getElementById("emergency-modal").style.display = "flex";
}

function cerrarModalEmergencia() {
    document.getElementById("emergency-modal").style.display = "none";
}

function realizarLlamadaEmergencia() {

    const esMovil = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);

    if (esMovil) {
        window.location.href = "tel:112";
    } else {
        alert("No se puede realizar una llamada desde este dispositivo. Usa un teléfono móvil.");
    }

    cerrarModalEmergencia();
}
