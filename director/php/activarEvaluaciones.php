<?php

include("../../php/conexion.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$consulta = "SELECT estado FROM evaluaciones_activas WHERE id = 1";
$resultado = $conn->query($consulta);
$fila = $resultado->fetch_assoc();
$estado = $fila['estado'];

$nuevoEstado = $estado == 1 ? 0 : 1;

$estadocalificaciones = $estado == 1 ? 1 : 0;


$actualizar = "UPDATE evaluaciones_activas SET estado = $nuevoEstado WHERE id = 1";
$conn->query($actualizar);

// Establece el valor de 'calificaciones_ingresadas' en la tabla 'alumnos' según el valor de '$nuevoEstado'
$actualizar_calificaciones_ingresadas = "UPDATE alumnos SET calificaciones_ingresadas = $estadocalificaciones";
$conn->query($actualizar_calificaciones_ingresadas);

header("Location: ../indexDirector.php");
die();

?>
