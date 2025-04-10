<?php
include("../../php/conexion.php");

session_start();
$tutor = $_SESSION['user'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$fecha = $_POST['fecha'];
$matricula = $_POST['matricula'];
$nempleado = $_POST['nempleado'];
$tipo = $_POST['problema'];
$id_citasN = $_POST['tipo'];

if (isset($_POST['carrera']) && isset($_POST['materia'])) {
  $carrera = $_POST['carrera'] == -1 ? null : $_POST['carrera'];
  $materia = $_POST['materia'] == -1 ? null : $_POST['materia'];
} else {
  $carrera = null;
  $materia = null;
}



// Si el valor de id_citasN es 3, asignar 2
if ($id_citasN == 3) {
    $id_citasN = 2;
}

$status = 1;
$hora = $_POST['hora'];
$tutor = $_SESSION['user'];
$id_citas = $_POST['id_citas'];

// Obtener el periodo activo
$periodoSql = "SELECT periodo FROM periodos WHERE activo = 1";
$periodoResult = $conn->query($periodoSql);

if ($periodoResult->num_rows > 0) {
    $periodoRow = $periodoResult->fetch_assoc();
    $periodo = $periodoRow['periodo'];
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se encontró un periodo activo.']);
    exit();
}

if ($carrera === null && $materia === null) {
  $consulta = "INSERT INTO citas (fecha, matricula, nempleado, tipo, id_citasN, status, hora, tutor, periodo) VALUES ('$fecha', $matricula, $nempleado, $tipo, $id_citasN, $status, '$hora', $tutor, $periodo)";
} else {
  $consulta = "INSERT INTO citas (fecha, matricula, nempleado, tipo, id_citasN, status, hora, tutor, periodo, carrera, materia) VALUES ('$fecha', $matricula, $nempleado, $tipo, $id_citasN, $status, '$hora', $tutor, $periodo, ?, ?)";
}

$stmt = $conn->prepare($consulta);

if ($carrera !== null && $materia !== null) {
  $stmt->bind_param("ii", $carrera, $materia);
} else {
  $stmt->bind_param("ss", $carrera, $materia);
}


$resultado = $stmt->execute();


if ($resultado === TRUE) {
  // Eliminar la cita de citas_procesar
  $eliminacion = "DELETE FROM citas_procesar WHERE id_citas = $id_citas";
  if ($conn->query($eliminacion) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Cita canalizada y eliminada de "citas por canalizar"']);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la cita de citas_procesar: ' . $conn->error]);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Error al canalizar la cita: ' . $conn->error]);
}

$conn->close();
?>
