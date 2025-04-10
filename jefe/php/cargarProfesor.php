<?php
include("../../php/conexion.php");

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 1 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

$nempleado = isset($_POST['nempleado']) ? $_POST['nempleado'] : null;
$nombreProfesor = isset($_POST['nombreProfesor']) ? $_POST['nombreProfesor'] : null;


$consulta = "";
if ($nempleado !== null && $nempleado !== '') {
    $consulta = "SELECT nombre, nempleado, email, id_nivel, active FROM profesores WHERE nempleado='$nempleado' AND id_nivel NOT IN (1, 5)";
} elseif ($nombreProfesor !== null && $nombreProfesor !== '') {
    $consulta = "SELECT nombre, nempleado, email, id_nivel, active FROM profesores WHERE nombre='$nombreProfesor' AND id_nivel NOT IN (1, 5)";
} else {
    echo json_encode(new stdClass());
    exit();
}

$resultado = $conn->query($consulta);


if ($resultado->num_rows > 0) {
    $profesor = $resultado->fetch_assoc();
    echo json_encode($profesor);
} else {
    echo json_encode(new stdClass());
}


$conn->close();
?>
