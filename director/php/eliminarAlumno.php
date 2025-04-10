<?php

//Verificar que el usuario tenga iniciada la sesión, sino lo manda al login

include("../../php/conexion.php");


session_start();
$_SESSION['send_status'] = 'success';
header("Location: ../mensajes.php");
$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

if (isset($_GET['delete'])) {

    $usuarioactual = $_SESSION['user'];
    $usuarioaborrar = $_GET['delete'];

    if ($usuarioactual == $usuarioaborrar) {
        header("location:../alumnos.php?delete=sameuser");
    } else {
        $nempleadoBorrar = $_GET['delete'];

        // Eliminar al profesor de la tabla profesores
        $sql_eliminar_profesor = "DELETE FROM alumnos WHERE matricula=$nempleadoBorrar";

        if ($conn->query($sql_eliminar_profesor) === TRUE) {
            header("location:../alumnos.php?delete=approved");
        } else {
            header("location:../alumnos.php?delete=error");
        }
    }
}

