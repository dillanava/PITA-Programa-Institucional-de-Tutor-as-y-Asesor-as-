function checkForNewMessages() {
    // Reemplazar esta URL con la ruta del archivo PHP que verifica si hay mensajes nuevos
    const checkNewMessagesUrl = "/php/nuevosMensajes.php";

    fetch(checkNewMessagesUrl)
        .then(response => response.json())
        .then(data => {
            const mensajesBtn = document.getElementById("mensajesBtn");

            if (data.newMessages) {
                mensajesBtn.classList.add("btn-red");
                mensajesBtn.classList.remove("btn-dark");
            } else {
                mensajesBtn.classList.remove("btn-red");
                mensajesBtn.classList.add("btn-dark");
            }
        })
        .catch(error => console.error("Error al verificar mensajes nuevos:", error));
}

// Verificar mensajes nuevos cada 10 segundos
setInterval(checkForNewMessages, 10000);

// Verificar mensajes nuevos al cargar la página
checkForNewMessages();
