<?php
header('Content-Type: application/json');
include("conexion.php");
session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$usuario = $_SESSION['user'];

$sql_citas_procesar = "SELECT COUNT(*) as total FROM citas_procesar WHERE tutor = '$usuario'";
$sql_citas = "SELECT COUNT(*) as total FROM citas WHERE nempleado = '$usuario' AND status = 1";

$result_citas_procesar = $conn->query($sql_citas_procesar);
$result_citas = $conn->query($sql_citas);

$row_citas_procesar = $result_citas_procesar->fetch_assoc(); 
$row_citas = $result_citas->fetch_assoc();

$newAppointments = false;

if ($row_citas_procesar['total'] > 0 || $row_citas['total'] > 0) {
    $newAppointments = true;
}

echo json_encode(['newAppointments' => $newAppointments]);

$conn->close();
?>
