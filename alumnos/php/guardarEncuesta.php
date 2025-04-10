<?php
// Conexión a la base de datos
include('conexion.php');

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$query = "SELECT * FROM periodos WHERE activo = 1";
$resultado = mysqli_query($conn, $query);
$row = mysqli_fetch_array($resultado);
$periodo = $row['periodo'];

$anio = date('Y');
$pregunta1 = $_POST['pregunta1'];
$pregunta2 = $_POST['pregunta2'];
$pregunta3 = $_POST['pregunta3'];
$pregunta4 = $_POST['pregunta4'];
$pregunta5 = $_POST['pregunta5'];
$pregunta6 = $_POST['pregunta6'];
$pregunta7 = $_POST['pregunta7'];
$pregunta8 = $_POST['pregunta8'];
$pregunta9 = $_POST['pregunta9'];
$pregunta10 = $_POST['pregunta10'];
$pregunta11 = $_POST['pregunta11'];

// Inserta los datos de la encuesta en la tabla resultados_encuesta
$query = "INSERT INTO `resultados_encuesta` (`anio`, `periodo`, `fecha`, `pregunta1`, `pregunta2`, `pregunta3`, `pregunta4`, `pregunta5`, `pregunta6`, `pregunta7`, `pregunta8`, `pregunta9`, `pregunta10`, `pregunta11`) VALUES ('$anio', '$periodo', CURDATE(), '$pregunta1', '$pregunta2', '$pregunta3', '$pregunta4', '$pregunta5', '$pregunta6', '$pregunta7', '$pregunta8', '$pregunta9', '$pregunta10', '$pregunta11')";
$result = mysqli_query($conn, $query);

$alumno_id = $_SESSION['user'];
$query_update = "UPDATE `alumnos` SET `encuesta_satisfaccion` = 1, `periodo_ultima_encuesta` = '$periodo' WHERE `matricula` = $alumno_id";
mysqli_query($conn, $query_update);

// Redireccionar al usuario a una página de confirmación o de vuelta al inicio
header('Location: ../indexAlumnos.php');
exit;
?>
