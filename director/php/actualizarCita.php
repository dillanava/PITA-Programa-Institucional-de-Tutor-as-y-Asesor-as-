<?php
// Incluir la conexión y las funciones de encriptación
include("../../php/conexion.php");
include("encrypt.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

$id_cita = $_POST['id_citas'];
$fecha = $_POST['fecha'];
$hora = isset($_POST['hora']) ? $_POST['hora'] : null; // Obtén la hora del formulario, si se proporciona
$matricula = $_POST['matricula'];
$nempleado = $_POST['nempleado'];
$status = $_POST['status'];
$descripcita = $_POST['descripcita'];
$citasN = $_POST['id_citasN'];

// Encripta la descripción antes de actualizar la información en la base de datos
$descripcita_encrypted = encrypt($descripcita);

// Actualiza solo los campos proporcionados en el formulario
$consulta = "UPDATE citas SET fecha='$fecha', matricula='$matricula', nempleado='$nempleado', descripcion='$descripcita_encrypted', status='$status', id_citasN='$citasN'";

// Si se proporciona la hora, inclúyela en la consulta
if ($hora !== null) {
    $consulta .= ", hora='$hora'";
}

$consulta .= " WHERE id_citas='$id_cita'";
$resultado = $conn->query($consulta);

if ($conn->query($consulta) === TRUE) {
    header("location:../citas.php?modified=approved");
} else {
    echo "Error: " . $consulta . "<br>" . $conn->error;
}

$conn->close();
?>
