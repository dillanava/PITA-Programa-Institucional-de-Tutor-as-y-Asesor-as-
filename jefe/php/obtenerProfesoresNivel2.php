<?php
include("../../php/conexion.php");

    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT profesor_nivel.*, profesores.nombre FROM profesor_nivel 
INNER JOIN profesores ON profesor_nivel.nempleado = profesores.nempleado 
WHERE profesor_nivel.id_nivel = 2";
    $result = $conn->query($sql);

    $profesores = array();
    while ($row = $result->fetch_assoc()) {
        $profesores[] = $row;
    }

    echo json_encode($profesores);
?>
