<?php
include("../../php/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nempleado = $_POST['nempleado'];

  $sql = "SELECT p.nempleado, p.id_nivel, p.active, p.nombre, p.email, GROUP_CONCAT(pc.id_carrera SEPARATOR ',') AS carreras FROM profesores p LEFT JOIN profesor_carrera pc ON p.nempleado = pc.nempleado WHERE p.nempleado = '$nempleado'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();

    // Consulta adicional para obtener los niveles de acceso
    $sql_niveles = "SELECT GROUP_CONCAT(pn.id_nivel SEPARATOR ',') AS niveles FROM profesor_nivel pn WHERE pn.nempleado = '$nempleado'";
    $result_niveles = $conn->query($sql_niveles);

    if ($result_niveles->num_rows > 0) {
      $data_niveles = $result_niveles->fetch_assoc();
      $data['niveles'] = $data_niveles['niveles'];
    } else {
      $data['niveles'] = '';
    }

    echo json_encode($data);
  } else {
    echo json_encode(['error' => 'No se encontró el profesor.']);
  }
} else {
  echo json_encode(['error' => 'Método de solicitud no válido.']);
}
?>
