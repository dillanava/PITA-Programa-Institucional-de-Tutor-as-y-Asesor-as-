<?php
include("../../php/conexion.php");
include './encrypt.php';

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

$remitente = $_SESSION['user'];

if (isset($_POST['enviarMensaje'])) {
    $profesorName = isset($_POST['profesorName']) ? $_POST['profesorName'] : null;
    $profesorId = isset($_POST['profesorId']) ? $_POST['profesorId'] : null;
    $mensaje = $_POST['messageText'];
    $mensajeEncriptado = encrypt($mensaje);

    // Agregar mensaje de depuración
    error_log("Profesor remitente: " . $remitente);

    if (!empty($profesorName)) {
        // Se está enviando un nuevo mensaje

        // Buscar al profesor por nombre
        $sqlBuscarProfesor = "SELECT nempleado FROM profesores WHERE nombre = ?";
        $stmtBuscarProfesor = $conn->prepare($sqlBuscarProfesor);
        $stmtBuscarProfesor->bind_param("s", $profesorName);
        $stmtBuscarProfesor->execute();
        $stmtBuscarProfesor->bind_result($nempleadoDestinatario);
        $stmtBuscarProfesor->fetch();
        $stmtBuscarProfesor->close();

        // No permitir que el usuario se envíe un mensaje a sí mismo
        if ($remitente != $nempleadoDestinatario) {
            // Verificar si se encontró al profesor
            if ($nempleadoDestinatario !== null) {
                // Insertar el mensaje en la base de datos
                $sqlInsertarMensaje = "INSERT INTO mensajes (remitente, receptor, mensaje, leido) VALUES (?, ?, ?, 0)";
                $stmtInsertarMensaje = $conn->prepare($sqlInsertarMensaje);
                $stmtInsertarMensaje->bind_param("sss", $remitente, $nempleadoDestinatario, $mensajeEncriptado);
                $stmtInsertarMensaje->execute();
                $stmtInsertarMensaje->close();

                header("Location: ../mensajes.php?send=success");
                exit();
            } else {
                // Si no se encuentra al profesor, redirige a mensajes.php con el parámetro de error
                header("Location: ../mensajes.php?send=profesorerror&profesorName=" . urlencode($profesorName));
                exit();
            }
        } else {
            // Si el remitente y el receptor son el mismo, redirige a mensajes.php con el parámetro de error
            header("Location: ../mensajes.php?send=selfmessageerror");
            exit();
        }
    } elseif (!empty($profesorId)) {
        // Se está respondiendo a un mensaje existente

        // No permitir que el usuario se envíe un mensaje a sí mismo
        if ($remitente != $profesorId) {
            // Insertar el mensaje en la base de datos
            $sqlInsertarMensaje = "INSERT INTO mensajes (remitente, receptor, mensaje, leido) VALUES (?, ?, ?, 0)";
            $stmtInsertarMensaje = $conn->prepare($sqlInsertarMensaje);
            $stmtInsertarMensaje->bind_param("sss", $remitente, $profesorId, $mensajeEncriptado);
            $stmtInsertarMensaje->execute();
            $stmtInsertarMensaje->close();

            header("Location: ../mensajes.php?send=success");
            exit();
        } else {
            // Si el remitente y el receptor son el mismo, redirige a mensajes.php con el parámetro de error
            header("Location: ../mensajes.php?send=selfmessageerror");
            exit();
        }
    }
}
?>