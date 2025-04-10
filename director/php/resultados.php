<?php
include("../../php/conexion.php");


$anio = $_POST['anio'];
$periodo = $_POST['periodo'];

$query = "SELECT * FROM resultados_encuesta WHERE anio = $anio AND periodo = $periodo";
$result = mysqli_query($conn, $query);
$datos = [];


while ($row = mysqli_fetch_assoc($result)) {
    $datos[] = $row;
}

echo json_encode($datos);

