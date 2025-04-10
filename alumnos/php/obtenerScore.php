<?php
include("conexion.php");

// Consulta para obtener los 10 mejores puntajes
$sql = "SELECT alumnos.nombre, alumno_scores.score FROM alumno_scores JOIN alumnos ON alumno_scores.matricula = alumnos.matricula ORDER BY alumno_scores.score DESC LIMIT 10";

$result = mysqli_query($conn, $sql);

$topScores = array();

while($row = mysqli_fetch_assoc($result)){
    $topScores[] = $row;
}

echo json_encode($topScores);
?>
