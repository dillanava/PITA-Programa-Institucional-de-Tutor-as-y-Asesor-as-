<?php
header('Content-Type: application/json');

include("../../php/conexion.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data_elim2 = array(); // Añade esta línea para inicializar $data_elim2
$anio = $_POST['anio'];
$periodo = $_POST['periodo'];
$anio2 = isset($_POST['anio2']) ? $_POST['anio2'] : null;
$periodo2 = isset($_POST['periodo2']) ? $_POST['periodo2'] : null;

$data2 = array(); // Añade esta línea para inicializar $data2

// Obtener datos para el primer período
$query = "SELECT * FROM citas WHERE YEAR(fecha) = ? AND periodo = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $anio, $periodo);
$stmt->execute();
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
$stmt->close();

// Obtener datos de citas eliminadas para el primer período
$query_elim = "SELECT * FROM citas_eliminadas WHERE YEAR(fecha) = ? AND periodo = ?";
$stmt_elim = $conn->prepare($query_elim);
$stmt_elim->bind_param("ii", $anio, $periodo);
$stmt_elim->execute();
$result_elim = $stmt_elim->get_result();
$data_elim = array();
while ($row_elim = $result_elim->fetch_assoc()) {
    $data_elim[] = $row_elim;
}
$stmt_elim->close();

// Obtener datos para el segundo período si se proporciona
if ($anio2 && $periodo2) {
  $query_elim2 = "SELECT * FROM citas_eliminadas WHERE YEAR(fecha) = ? AND periodo = ?";
  $stmt_elim2 = $conn->prepare($query_elim2);
  $stmt_elim2->bind_param("ii", $anio2, $periodo2);
  $stmt_elim2->execute();
  $result_elim2 = $stmt_elim2->get_result();
  while ($row_elim2 = $result_elim2->fetch_assoc()) {
      $data_elim2[] = $row_elim2;
  }
  $stmt_elim2->close();
}

// Preparar la respuesta
// Preparar la respuesta
$response = array(
  'labels' => array('Citas', 'Citas eliminadas'),
  'citas' => array(
      'data' => array(count($data)),
      'data_elim' => array(count($data_elim))
  ),
  'citas_elim' => array( // Añade esta línea
      'data_elim' => array(count($data_elim)), // Añade esta línea
      'data_elim2' => array(count($data_elim2)) // Añade esta línea
  ) // Añade esta línea
);


if ($anio2 && $periodo2) {
  $response['citas']['data2'] = array(count($data2));
  $response['citas']['data_elim2'] = array(count($data_elim2));
}


echo json_encode($response);
?>
