<?php

session_start();
include("../../php/conexion.php");

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

// Verificar si el usuario es el rector
if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

// Obtener el periodo activo
$query_periodo = "SELECT periodo FROM periodos WHERE activo = 1";
$result_periodo = mysqli_query($conn, $query_periodo);
$row_periodo = mysqli_fetch_array($result_periodo);
$periodo_activo = $row_periodo['periodo'];

// Desactivar el periodo actual
$query_desactivar = "UPDATE periodos SET activo = 0 WHERE periodo = $periodo_activo";
mysqli_query($conn, $query_desactivar);

// Activar el siguiente periodo (si el actual es el 3, activar el 1)
$periodo_siguiente = $periodo_activo == 3 ? 1 : $periodo_activo + 1;
$query_activar = "UPDATE periodos SET activo = 1 WHERE periodo = $periodo_siguiente";
mysqli_query($conn, $query_activar);

// Establecer encuesta_satisfaccion en 0 para todos los alumnos
$query_reset_encuesta = "UPDATE alumnos SET encuesta_satisfaccion = 0";
mysqli_query($conn, $query_reset_encuesta);

// Redirigir al rector a la página principal
header("Location: ../indexDirector.php");
exit;
?>
