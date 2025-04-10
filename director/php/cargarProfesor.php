<?php
include("../../php/conexion.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];



if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

$nempleado = $_POST['nempleado'];

// Consultar la información de la cita en la base de datos
$consulta = "SELECT * FROM profesores WHERE nempleado='$nempleado'";
$resultado = $conn->query($consulta);

if ($resultado->num_rows > 0) {
    // Si se encontró la cita, convertirla en un array y devolverla como JSON
    $profesor = $resultado->fetch_assoc();
    echo json_encode($profesor);
} else {
    // Si no se encontró la cita, devolver un error
    header("location:../profesores.php?deleteprofesor=error");
}

$conn->close();
?>
