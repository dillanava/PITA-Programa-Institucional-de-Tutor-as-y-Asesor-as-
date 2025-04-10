<?php
session_start();
include("../php/encrypt.php");
include("../../php/conexion.php");

// Verifica si el usuario está logueado
if (isset($_SESSION['user'])) {
    $numerousuario = $_SESSION['user'];
} else {
    // Si el usuario no está logueado, redirige al usuario al formulario de inicio de sesión
    header("location:../indexJefe.php");
    exit;
}

// Recupera la contraseña actual y la nueva contraseña del formulario
if (isset($_POST['password_actual']) && isset($_POST['nueva_password'])) {
    $password_actual = $_POST['password_actual'];
    $nueva_password = $_POST['nueva_password'];

    // Verifica si el número de empleado o matrícula existe en la base de datos
    $consulta_numerousuario = "SELECT contraseña FROM profesores WHERE nempleado = '$numerousuario' UNION SELECT contraseña FROM alumnos WHERE matricula = '$numerousuario'";
    $resultado_numerousuario = $conn->query($consulta_numerousuario);

    if ($resultado_numerousuario->num_rows > 0) {

        $row = $resultado_numerousuario->fetch_assoc();
        $password_encrypted = $row['contraseña'];
        $password_decrypted = decrypt($password_encrypted);

        // Verifica si la contraseña actual coincide con la contraseña almacenada en la base de datos
        if ($password_actual === $password_decrypted) {
            // Si la contraseña actual coincide, actualiza la contraseña en la base de datos
            $nueva_password_encrypted = encrypt($nueva_password);
            $consulta_update = "UPDATE profesores SET contraseña = '$nueva_password_encrypted' WHERE nempleado = '$numerousuario';
                                UPDATE alumnos SET contraseña = '$nueva_password_encrypted' WHERE matricula = '$numerousuario';
                                UPDATE usuarios SET contraseña = '$nueva_password_encrypted' WHERE matricula = '$numerousuario' OR nempleado = '$numerousuario';";
            $resultado_update = $conn->multi_query($consulta_update);

            if ($resultado_update) {
                // Si se actualizó la contraseña correctamente, devuelve un mensaje de éxito
                echo json_encode(['success' => true, 'message' => 'La contraseña ha sido actualizada correctamente']);
            } else {
                // Si no se pudo actualizar la contraseña, muestra un mensaje de error
                echo json_encode(['success' => false, 'message' => 'Error al actualizar la contraseña']);
            }
        } else {
            // Si la contraseña actual no coincide, devuelve un mensaje de error
            echo json_encode(['success' => false, 'message' => 'La contraseña actual ingresada es incorrecta']);
        }
    } else {
        // Si el número de empleado o matrícula no existe en la base de datos, devuelve un mensaje de error
        echo json_encode(['success' => false, 'message' => 'El número de empleado o matrícula ingresado no se encuentra en nuestra base de datos']);
    }
} else {
    // Si no se ha recibido la contraseña actual y la nueva contraseña, redirige al usuario al formulario de cambio de contraseña
    header("location:../indexJefe.php");
}
?>
