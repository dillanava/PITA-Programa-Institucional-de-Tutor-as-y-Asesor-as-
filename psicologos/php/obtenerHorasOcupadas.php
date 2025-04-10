<?php

//Verificar que el usuario tenga iniciada la sesión, sino lo manda al login

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 3 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

header('Content-Type: application/json');

include("../../php/conexion.php");

$fecha = $_GET['fecha'];
$nempleado = $_GET['nempleado']; // Añadir esta línea para obtener el número de empleado del profesor

$consulta = "SELECT hora FROM citas WHERE fecha='$fecha' AND nempleado='$nempleado'"; // Modifica la consulta para incluir el número de empleado del profesor
$resultado = $conn->query($consulta);

$horasOcupadas = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $horasOcupadas[] = $row['hora'];
    }
}

echo json_encode($horasOcupadas);

$conn->close();
