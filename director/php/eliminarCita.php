<?php
//Verificar que el usuario tenga iniciada la sesión, sino lo manda al login

include("../../php/conexion.php");
$_SESSION['send_status'] = 'success';
header("Location: ../mensajes.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

$nempleadoBorrar = $_GET['deleteCita'];

// Copiar la cita a la tabla citas_eliminadas antes de eliminarla
$sql_copy = "INSERT INTO citas_eliminadas (id_citas, fecha, matricula, nempleado, tipo, id_citasN, status, hora, tutor)
             SELECT id_citas, fecha, matricula, nempleado, tipo, id_citasN, 0, hora, tutor FROM citas WHERE id_citas=$nempleadoBorrar";

if ($conn->query($sql_copy) === TRUE) {
    // Eliminar la cita de la tabla citas
    $sql_delete = "DELETE FROM citas WHERE id_citas=$nempleadoBorrar";

    if ($conn->query($sql_delete) === TRUE) {
        header("location:../citas.php?deletecita=approved");
    } else {
        header("location:../citas.php?deletecita=error");
    }
} else {
    header("location:../citas.php?deletecita=error");
}
?>
