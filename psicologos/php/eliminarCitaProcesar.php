<?php

//Verificar que el usuario tenga iniciada la sesión, sino lo manda al login

include("../../php/conexion.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];



if ($usuario == null || $usuario == '' || $idnivel != 3 || $nombreUsuario == '') {
    echo "Error: Usuario no autorizado";
    die();
}

$nempleadoBorrar = $_GET['id_cita'];

$sql = "DELETE FROM citas_procesar WHERE id_citas=$nempleadoBorrar";

if ($conn->query($sql) === TRUE) {
  $response = array(
    'status' => 'success',
    'message' => 'La cita ha sido eliminada correctamente'
  );
} else {
  $response = array(
    'status' => 'error',
    'message' => 'Hubo un problema al eliminar la cita'
  );
}

echo json_encode($response);


?>
