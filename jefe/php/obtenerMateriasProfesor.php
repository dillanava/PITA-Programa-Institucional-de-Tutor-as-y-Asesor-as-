<?php
include("../../php/conexion.php");

$nempleado = $_POST['nempleado'];

$query = "SELECT m.*, a.id_asignaturasp FROM materias m
          JOIN asignaturasp a ON m.id_materias = a.id_materias
          WHERE a.nempleado = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $nempleado);
$stmt->execute();
$result = $stmt->get_result();

$materias = array();
while($row = $result->fetch_assoc()) {
    $materias[] = $row;
}



echo json_encode($materias);
?>
