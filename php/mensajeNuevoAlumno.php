<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("./conexion.php");
include("./templateAlumnoTemplate.php");

require './PHPMailer/Exception.php';
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';

// Recupera el correo electrónico y nombre del formulario
if (isset($_POST['email']) && isset($_POST['nombre'])) {
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];

    // Verifica si el correo electrónico existe en la base de datos
    $consulta_email = "SELECT email FROM profesores WHERE email = '$email' UNION SELECT email FROM alumnos WHERE email = '$email'";
    $resultado_email = $conn->query($consulta_email);

    if ($resultado_email->num_rows > 0) {
        // Si el correo electrónico existe en la base de datos, procede a enviar el correo
        $mail = new PHPMailer(true);

        try {
            // Configura el servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'proyectouptex@gmail.com';
            $mail->Password = 'cfidvrdhlvkcbhvl';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configura el correo
            $mail->setFrom('proyectouptex@gmail.com', 'Universidad Politécnica de Texcoco');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Bienvenido a la plataforma, '.$nombre;
            $logoUrl = 'https://i.imgur.com/HUZkpai.png'; // Reemplaza con la URL de tu logo
            $logopita = 'https://i.imgur.com/pVYsTa7.png'; // Logo PITA
            $mail->Body = usuarioNuevoTemplate($logoUrl, $logopita ,$nombre);

            // Envía el correo
            $mail->send();
        } catch (Exception $e) {
            // Si no se pudo enviar el correo, muestra un mensaje de error
            echo 'Error al mandar el mensaje de bienvenida';
        }
    } else {
        // Si el correo electrónico no existe en la base de datos, muestra un mensaje de error
        echo 'El correo electrónico no existe en la base de datos';
    }
} else {
    // Si no se ha recibido el correo electrónico o nombre, redirige al usuario al formulario de recuperación de contraseña
    header("location:./index.php");
}
?>
