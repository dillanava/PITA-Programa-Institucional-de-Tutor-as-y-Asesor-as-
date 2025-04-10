<?php

include("./conexion.php");
include("./encrypt.php"); // Incluye el archivo encrypt.php aquí

if (isset($_POST['codigo']) && isset($_POST['nueva_password']) && isset($_GET['email'])) {
    $codigo = $_POST['codigo'];
    $nueva_password = $_POST['nueva_password'];
    $email = $_GET['email'];

    // Verifica si el código existe para ese correo
    $consulta = "SELECT * FROM recuperacion_contrasenia WHERE email = '$email' AND codigo = '$codigo'";
    $resultado = $conn->query($consulta);

    if ($resultado->num_rows > 0) {
        // Encripta la nueva contraseña antes de guardarla en la base de datos
        $nueva_password_encrypted = encrypt($nueva_password);

        // Actualiza la contraseña para profesores, alumnos y usuarios con ese email en común
        $actualizar_profesor = "UPDATE profesores SET contraseña = '$nueva_password_encrypted' WHERE email = '$email'";
        $actualizar_alumno = "UPDATE alumnos SET contraseña = '$nueva_password_encrypted' WHERE email = '$email'";
        $actualizar_usuario = "UPDATE usuarios SET contraseña = '$nueva_password_encrypted' WHERE email = '$email'";

        $conn->query($actualizar_profesor);
        $conn->query($actualizar_alumno);
        $conn->query($actualizar_usuario); // Ejecuta la actualización para la tabla usuarios

        // Elimina el registro de recuperación de contraseña
        $eliminar_recuperacion = "DELETE FROM recuperacion_contrasenia WHERE email = '$email' AND codigo = '$codigo'";
        $conn->query($eliminar_recuperacion);

        header("location:../index.php?reset_password=success");
    } else {
        header("location:../index.php?showVerificarCodigoModal=true&email=$email&reset_password=error");
    }
} else {
    header("location:../index.php");
}

?>
