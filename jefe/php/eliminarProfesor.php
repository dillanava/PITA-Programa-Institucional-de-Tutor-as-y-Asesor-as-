<?php
ob_start(); // Iniciar el buffer de salida

//Verificar que el usuario tenga iniciada la sesión, sino lo manda al login

include("../../php/conexion.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$_SESSION['send_status'] = 'success';

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 1 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

if (isset($_POST['nempleado'])) {

    $usuarioactual = $_SESSION['user'];
    $usuarioaborrar = $_POST['nempleado'];

    if ($usuarioactual == $usuarioaborrar) {
        echo json_encode(['status' => 'error', 'message' => 'No se puede eliminar al usuario actual.']);
        exit();
    } else {
        $nempleadoBorrar = $_POST['nempleado'];

        // Eliminar los mensajes en los que el profesor sea remitente o receptor
        $sql_eliminar_mensajes = "DELETE FROM mensajes WHERE remitente=$nempleadoBorrar OR receptor=$nempleadoBorrar";
        if (!$conn->query($sql_eliminar_mensajes)) {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar mensajes del profesor.']);
            exit();
        }

        // Eliminar las carreras asociadas al profesor en la tabla profesor_carrera
        $sql_eliminar_carreras = "DELETE FROM profesor_carrera WHERE nempleado=$nempleadoBorrar";
        if (!$conn->query($sql_eliminar_carreras)) {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar carreras asociadas al profesor.']);
            exit();
        }

        // Eliminar al profesor de la tabla profesores
        $sql_eliminar_profesor = "DELETE FROM profesores WHERE nempleado=$nempleadoBorrar";
        // echo $sql_eliminar_profesor; // Imprime la consulta SQL en pantalla (comentado para evitar interferir con la respuesta JSON)
        if ($conn->query($sql_eliminar_profesor) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Profesor eliminado con éxito.']);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar al profesor.']);
            exit();
        }
    }
}

ob_end_flush(); // Enviar la salida capturada
