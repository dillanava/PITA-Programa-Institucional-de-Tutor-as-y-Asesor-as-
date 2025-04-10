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

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;

if ($nombre === null || $nombre === '') {
    echo json_encode(array());
    exit();
}

$consulta = "SELECT nombre, nempleado, email, id_nivel, active FROM profesores WHERE nombre LIKE '%$nombre%' AND id_nivel NOT IN (1, 5)";
$resultado = $conn->query($consulta);

$profesores = array();
if ($resultado->num_rows > 0) {
    while ($profesor = $resultado->fetch_assoc()) {
        $profesores[] = $profesor;
    }
}

echo json_encode($profesores);
$conn->close();
?>
