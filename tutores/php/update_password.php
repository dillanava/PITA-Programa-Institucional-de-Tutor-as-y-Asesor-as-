<?php
include("./encrypt.php"); // Incluye el archivo encrypt.php aquí
include("./conexion.php"); // Incluye el archivo conexion.php aquí


session_start();


if (isset($_POST['nueva_password'])) {
    $nueva_password = $_POST['nueva_password'];

    // Encripta la nueva contraseña antes de guardarla en la base de datos
    $nueva_password_encrypted = encrypt($nueva_password);

    // Obtiene el ID del usuario/profesor actualmente autenticado
    // Asegúrate de reemplazar esto con la lógica adecuada para tu implementación
    $usuario_id = $_SESSION['user'];

    // Actualiza la contraseña para profesores y usuarios con ese ID de usuario en común
    $actualizar_profesor = "UPDATE profesores SET contraseña = '$nueva_password_encrypted', recien_creado = 0 WHERE nempleado = '$usuario_id'";
    $actualizar_usuario = "UPDATE usuarios SET contraseña = '$nueva_password_encrypted' WHERE nempleado = '$usuario_id'";

    $conn->query($actualizar_profesor);
    $conn->query($actualizar_usuario);

    // Redirecciona al usuario a una página después de la actualización exitosa de la contraseña
    header("Location: ../indexTutor.php?welcome");
} else {
    header("Location: index.php?error");
}
?>
