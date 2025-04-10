<?php
include("../../php/conexion.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 4 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

$consulta = "SELECT citas_procesar.*, alumnos.nombre as nombre_alumno
             FROM citas_procesar
             JOIN alumnos ON citas_procesar.matricula = alumnos.matricula
             WHERE tutor='$usuario'";
$resultado = $conn->query($consulta);

if ($resultado->num_rows > 0) {
    $citas = array();
    while ($cita = $resultado->fetch_assoc()) {
        $citas[] = $cita;
    }
    echo json_encode($citas);
} else {
    header("location:../citas.php?editcita=error");
}

$conn->close();
?>
