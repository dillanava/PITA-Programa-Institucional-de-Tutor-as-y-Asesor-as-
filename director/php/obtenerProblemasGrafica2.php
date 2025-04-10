<?php
include("../../php/conexion.php");

$anio = $_POST['anio'];
$periodo = $_POST['periodo'];
$anio2 = $_POST['anio2'];
$periodo2 = $_POST['periodo2'];

$conditions1 = "WHERE YEAR(c.fecha) = $anio AND c.periodo = $periodo AND c.id_citasN = 2";
$conditions2 = !empty($anio2) && !empty($periodo2) ? "WHERE YEAR(c.fecha) = $anio2 AND c.periodo = $periodo2 AND c.id_citasN = 2" : null;

$sql1 = "SELECT tp.tipo_problema, COUNT(c.tipo) AS total
         FROM citas c
         INNER JOIN tipo_problema tp ON c.tipo = tp.id_tipo_problema
         $conditions1
         GROUP BY c.tipo";

$result1 = $conn->query($sql1);

$labels = [];
$data1 = [];

if ($result1->num_rows > 0) {
  while ($row = $result1->fetch_assoc()) {
    array_push($labels, $row['tipo_problema']);
    array_push($data1, $row['total']);
  }
}

$data2 = [];

if ($conditions2) {
  $sql2 = "SELECT tp.tipo_problema, COUNT(c.tipo) AS total
           FROM citas c
           INNER JOIN tipo_problema tp ON c.tipo = tp.id_tipo_problema
           $conditions2
           GROUP BY c.tipo";

  $result2 = $conn->query($sql2);

  if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
      array_push($data2, $row['total']);
    }
  }
}

$response = ['labels' => $labels, 'data1' => $data1, 'data2' => $data2];
echo json_encode($response);

$conn->close();
?>
