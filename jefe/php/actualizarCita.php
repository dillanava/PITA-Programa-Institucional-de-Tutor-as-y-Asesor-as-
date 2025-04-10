<?php
include("../../php/conexion.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id_cita = $_POST['id_citas']; // Cambia esta línea a 'id_citas'
$tipo_cita = $_POST['tipo_cita'];
$problema = $_POST['problema'];
$nempleado = $_POST['nempleado'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$status = $_POST['status'];
$tutor = $_POST['tutor'];
$updateTutor = $_POST['updateTutor'] === 'true';

$sql = "UPDATE citas SET id_citasN = ?, tipo = ?, nempleado = ?, fecha = ?, hora = ?, status = ?" . ($updateTutor ? ", tutor = ?" : "") . " WHERE id_citas = ?";
$stmt = $conn->prepare($sql); // Agrega esta línea
if ($updateTutor) {
    $stmt->bind_param('iiissiii', $tipo_cita, $problema, $nempleado, $fecha, $hora, $status, $tutor, $id_cita);
} else {
    $stmt->bind_param('iiissii', $tipo_cita, $problema, $nempleado, $fecha, $hora, $status, $id_cita);
}
if ($stmt->execute()) {
    echo "Cita actualizada con éxito";
} else {
    echo "Error al actualizar la cita: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
