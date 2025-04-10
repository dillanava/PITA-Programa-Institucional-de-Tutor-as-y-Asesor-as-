<?php
include("../../php/conexion.php");

$id_nivel = $_GET['id_nivel'];
$id_nivel_consulta = $id_nivel == 3 ? 2 : $id_nivel; // Operador ternario para asignar valor dependiendo de $id_nivel

$query = "SELECT * FROM tipo_problema WHERE id_nivel = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_nivel_consulta); // Enlazar el valor de $id_nivel_consulta al parámetro de la consulta
$stmt->execute();
$result = $stmt->get_result();
$tiposProblema = array();

while ($row = $result->fetch_assoc()) {
    array_push($tiposProblema, $row);
}

echo json_encode($tiposProblema);

?>
