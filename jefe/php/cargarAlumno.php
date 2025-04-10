<?php
include("../../php/conexion.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 1 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

$matricula = $_POST['matricula'];

// Consultar la información de la cita en la base de datos
$consulta = "SELECT * FROM alumnos WHERE matricula='$matricula'";
$resultado = $conn->query($consulta);

if ($resultado->num_rows > 0) {
    // Si se encontró la cita, convertirla en un array y devolverla como JSON
    $alumno = $resultado->fetch_assoc();
    echo json_encode($alumno);
} else {
    // Si no se encontró la cita, devolver un error
    header("location:../alumnos.php?deleteprofesor=error");
}

$conn->close();
?>
