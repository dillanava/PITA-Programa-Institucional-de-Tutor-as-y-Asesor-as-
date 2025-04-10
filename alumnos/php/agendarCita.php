<?php
include('conexion.php');

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica la conexión
if ($conn->connect_error) {
  die("La conexión falló: " . $conn->connect_error);
}

// Obtiene los datos enviados por el formulario
$nempleado = $_POST['nempleado'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$matricula = $_SESSION['user'];

// Verificar si el usuario tiene más de una cita en proceso
$sql_count = "SELECT COUNT(*) as count FROM citas_procesar WHERE matricula = '$matricula'";
$result = $conn->query($sql_count);
$row = $result->fetch_assoc();
$citas_count = $row['count'];

// Establecer la cantidad máxima permitida de citas en proceso
$max_citas = 1;

// Insertar la cita solo si el usuario no tiene más de una cita en proceso
if ($citas_count < $max_citas) {
  $sql = "INSERT INTO citas_procesar (fecha, matricula, tutor, id_citasN, hora)
  VALUES ('$fecha', $matricula, $nempleado, 1, '$hora')";

  if ($conn->query($sql) === TRUE) {
    $respuesta = array(
      'titulo' => 'La cita con el tutor ha sido agendada',
      'texto' => 'Recuerda atender a la cita sino se te dara un strike',
      'icono' => 'success',
      'timer' => 2500,
      'showConfirmButton' => false,
      'timerProgressBar' => true
    );
  } else {
    $respuesta = array(
      'titulo' => 'Error',
      'texto' => 'Hubo un problema al crear la cita',
      'icono' => 'error',
      'timer' => 2500,
      'showConfirmButton' => false,
      'timerProgressBar' => true
    );
  }
} else {
  $respuesta = array(
    'titulo' => 'Más de una cita registrada',
    'texto' => 'No puedes agendar más de una cita en proceso',
    'icono' => 'error',
    'timer' => 2500,
    'showConfirmButton' => false,
    'timerProgressBar' => true
  );
}

echo json_encode($respuesta);

$conn->close();
?>
