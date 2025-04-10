<?php
include("../../php/conexion.php");
include("./encrypt.php"); // Incluye el archivo 'encrypt.php' para usar las funciones de encriptación y desencriptación

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

$id_cita = $_POST['id_cita'];

$consulta = "SELECT * FROM citas WHERE id_citas='$id_cita'";
$resultado = $conn->query($consulta);

if ($resultado->num_rows > 0) {
    $cita = $resultado->fetch_assoc();
    $cita['descripcion'] = decrypt($cita['descripcion']); // Desencripta la descripción antes de enviarla como JSON
    echo json_encode($cita);
} else {
    header("location:../citas.php?editcita=error");
}

$conn->close();
?>
