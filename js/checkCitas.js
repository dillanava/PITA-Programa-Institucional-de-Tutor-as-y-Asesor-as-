function checkForNewAppointments() {
    // Reemplazar esta URL con la ruta del archivo PHP que verifica si hay nuevas citas
    const checkNewAppointmentsUrl = "/php/nuevasCitas.php";
    fetch(checkNewAppointmentsUrl)
        .then(response => response.json())
        .then(data => {
            const citasBtn = document.getElementById("citasBtn");
            if (data.newAppointments) {
                citasBtn.classList.add("btn-red");
                citasBtn.classList.remove("btn-dark");
            } else {
                citasBtn.classList.remove("btn-red");
                citasBtn.classList.add("btn-dark");
            }
        })
        .catch(error => console.error("Error al verificar nuevas citas:", error));
}

// Verificar nuevas citas cada 10 segundos
setInterval(checkForNewAppointments, 10000);

// Verificar nuevas citas al cargar la página
checkForNewAppointments();
