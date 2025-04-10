function checkForNewAppointmentsSeparate() {
    const checkNewAppointmentsUrl = "/php/checkCitasSeparadas.php";
    fetch(checkNewAppointmentsUrl)
        .then(response => response.json())
        .then(data => {
            const citasPropiasBtn = document.querySelector(".btn-custom.citasPropias");
            const citasCanalizarBtn = document.querySelector(".btn-custom.citasCanalizar");

            if (data.totalCitasProximasPropiasNow > 0) {
                citasPropiasBtn.style.backgroundColor = "#C5E5A4";
            } else if (data.totalCitasProximasPropias5 > 0) {
                citasPropiasBtn.style.backgroundColor = "#FFA07A";
            } else if (data.totalCitasProximasPropias10 > 0) {
                citasPropiasBtn.style.backgroundColor = "#FFB347";
            } else if (data.totalCitas > 0) {
                citasPropiasBtn.style.backgroundColor = "#ff7f7f";
            } else {
                citasPropiasBtn.style.backgroundColor = "";
            }

            if (data.totalCitasProximasCanalizarNow > 0) {
                citasCanalizarBtn.style.backgroundColor = "#C5E5A4";
            } else if (data.totalCitasProximasCanalizar5 > 0) {
                citasCanalizarBtn.style.backgroundColor = "#FFA07A";
            } else if (data.totalCitasProximasCanalizar10 > 0) {
                citasCanalizarBtn.style.backgroundColor = "#FFB347";
            } else if (data.totalCitasProcesar > 0) {
                citasCanalizarBtn.style.backgroundColor = "#ff7f7f";
            } else {
                citasCanalizarBtn.style.backgroundColor = "";
            }
        })
        .catch(error => console.error("Error al verificar nuevas citas:", error));
}

// Verificar nuevas citas cada 10 segundos
setInterval(checkForNewAppointmentsSeparate, 10000);

// Verificar nuevas citas al cargar la página
checkForNewAppointmentsSeparate();
