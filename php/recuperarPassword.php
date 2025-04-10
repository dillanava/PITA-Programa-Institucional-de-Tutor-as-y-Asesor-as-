<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("./conexion.php");
include("./templateEmail.php");

require './PHPMailer/Exception.php';
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';

// Recupera el correo electrónico del formulario
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Verifica si el correo electrónico existe en la base de datos
    $consulta_email = "SELECT email, 'profesor' as tipo, nempleado as numerousuario FROM profesores WHERE email = '$email' UNION SELECT email, 'alumno' as tipo, matricula as numerousuario FROM alumnos WHERE email = '$email'";
    $resultado_email = $conn->query($consulta_email);

    $consulta_nombre = "SELECT nombre FROM profesores WHERE email = '$email' UNION SELECT nombre FROM alumnos WHERE email = '$email'";
    $resultado_nombre = $conn->query($consulta_email);

    if ($resultado_email->num_rows > 0) {

        $row = $resultado_email->fetch_assoc();
        $numerousuario = $row['numerousuario'];

        // Genera un código de verificación
        $codigo = rand(100000, 999999);

        $consulta = "INSERT INTO recuperacion_contrasenia (email, codigo) VALUES ('$email', '$codigo')";
        $resultado = $conn->query($consulta);

        if ($resultado) {
            // Si se ha guardado correctamente el código en la base de datos, procede a enviar el correo
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
                $mail->Subject = 'Recuperación de contraseña';
                $logoUrl = 'https://i.imgur.com/HUZkpai.png'; // Logo UPTex
                $logopita = 'https://i.imgur.com/pVYsTa7.png'; // Logo PITA
                $mail->Body = getEmailTemplate($logoUrl,$logopita, $codigo, $numerousuario);

                // Envía el correo
                $mail->send();
                // Muestra el modal de verificación de código
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                // Si no se pudo enviar el correo, muestra un mensaje de error
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            // Si no se pudo guardar el código en la base de datos, muestra un mensaje de error
            echo "Error al guardar el código en la base de datos";
        }
    } else {
        // Si el correo electrónico no existe en la base de datos, devuelve un mensaje de error
        echo json_encode(['success' => false, 'message' => 'El correo electrónico ingresado no se encuentra en nuestra base de datos.']);
    }
} else {
    // Si no se ha recibido el correo electrónico, redirige al usuario al formulario de recuperación de contraseña
    header("location:./index.php");
}
?>
