<?php
header('Content-Type: application/json');
include("conexion.php");
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("America/Mexico_City");

$usuario = $_SESSION['user'];
$now = date("Y-m-d H:i:s");
$next30Minutes = date("Y-m-d H:i:s", strtotime("+30 minutes"));
$next15Minutes = date("Y-m-d H:i:s", strtotime("+15 minutes"));
$next10Minutes = date("Y-m-d H:i:s", strtotime("+10 minutes"));
$next5Minutes = date("Y-m-d H:i:s", strtotime("+5 minutes"));

$sql_citas_procesar = "SELECT COUNT(*) as total FROM citas_procesar WHERE tutor = $usuario AND TIMESTAMP(fecha, hora) > '$now'";
$sql_citas = "SELECT COUNT(*) as total FROM citas WHERE nempleado = $usuario AND status = 1 AND TIMESTAMP(fecha, hora) > '$now'";
$sql_citas_proximas_propias = "SELECT COUNT(*) as total FROM citas WHERE nempleado = $usuario AND status = 1 AND TIMESTAMP(fecha, hora) BETWEEN '$now' AND '$next30Minutes'";
$sql_citas_proximas_canalizar = "SELECT COUNT(*) as total FROM citas_procesar WHERE tutor = $usuario AND TIMESTAMP(fecha, hora) BETWEEN '$now' AND '$next30Minutes'";

$sql_citas_proximas_propias_15 = "SELECT COUNT(*) as total FROM citas WHERE nempleado = $usuario AND status = 1 AND TIMESTAMP(fecha, hora) > '$now' AND TIMESTAMP(fecha, hora) <= '$next15Minutes'";
$sql_citas_proximas_propias_10 = "SELECT COUNT(*) as total FROM citas WHERE nempleado = $usuario AND status = 1 AND TIMESTAMP(fecha, hora) > '$now' AND TIMESTAMP(fecha, hora) <= '$next10Minutes'";
$sql_citas_proximas_propias_5 = "SELECT COUNT(*) as total FROM citas WHERE nempleado = $usuario AND status = 1 AND TIMESTAMP(fecha, hora) > '$now' AND TIMESTAMP(fecha, hora) <= '$next5Minutes'";
$sql_citas_proximas_propias_now = "SELECT COUNT(*) as total FROM citas WHERE nempleado = $usuario AND status = 1 AND TIMESTAMP(fecha, hora) <= '$now' AND TIMESTAMP(fecha, hora) >= DATE_SUB('$now', INTERVAL 5 MINUTE)";

$sql_citas_proximas_canalizar_15 = "SELECT COUNT(*) as total FROM citas_procesar WHERE tutor = $usuario AND TIMESTAMP(fecha, hora) > '$now' AND TIMESTAMP(fecha, hora) <= '$next15Minutes'";
$sql_citas_proximas_canalizar_10 = "SELECT COUNT(*) as total FROM citas_procesar WHERE tutor = $usuario AND TIMESTAMP(fecha, hora) > '$now' AND TIMESTAMP(fecha, hora) <= '$next10Minutes'";
$sql_citas_proximas_canalizar_5 = "SELECT COUNT(*) as total FROM citas_procesar WHERE tutor = $usuario AND TIMESTAMP(fecha, hora) > '$now' AND TIMESTAMP(fecha, hora) <= '$next5Minutes'";
$sql_citas_proximas_canalizar_now = "SELECT COUNT(*) as total FROM citas_procesar WHERE tutor = $usuario AND TIMESTAMP(fecha, hora) <= '$now' AND TIMESTAMP(fecha, hora) >= DATE_SUB('$now', INTERVAL 5 MINUTE)";

$result_citas_procesar = $conn->query($sql_citas_procesar);
$result_citas = $conn->query($sql_citas);
$result_citas_proximas_propias = $conn->query($sql_citas_proximas_propias);
$result_citas_proximas_canalizar = $conn->query($sql_citas_proximas_canalizar);

$result_citas_proximas_propias_15 = $conn->query($sql_citas_proximas_propias_15);
$result_citas_proximas_propias_10 = $conn->query($sql_citas_proximas_propias_10);
$result_citas_proximas_propias_5 = $conn->query($sql_citas_proximas_propias_5);
$result_citas_proximas_propias_now = $conn->query($sql_citas_proximas_propias_now);

$result_citas_proximas_canalizar_15 = $conn->query($sql_citas_proximas_canalizar_15);
$result_citas_proximas_canalizar_10 = $conn->query($sql_citas_proximas_canalizar_10);
$result_citas_proximas_canalizar_5 = $conn->query($sql_citas_proximas_canalizar_5);
$result_citas_proximas_canalizar_now = $conn->query($sql_citas_proximas_canalizar_now);

$row_citas_procesar = $result_citas_procesar->fetch_assoc();
$row_citas = $result_citas->fetch_assoc();
$row_citas_proximas_propias = $result_citas_proximas_propias->fetch_assoc();
$row_citas_proximas_canalizar = $result_citas_proximas_canalizar->fetch_assoc();

$row_citas_proximas_propias_15 = $result_citas_proximas_propias_15->fetch_assoc();
$row_citas_proximas_propias_10 = $result_citas_proximas_propias_10->fetch_assoc();
$row_citas_proximas_propias_5 = $result_citas_proximas_propias_5->fetch_assoc();
$row_citas_proximas_propias_now = $result_citas_proximas_propias_now->fetch_assoc();

$row_citas_proximas_canalizar_15 = $result_citas_proximas_canalizar_15->fetch_assoc();
$row_citas_proximas_canalizar_10 = $result_citas_proximas_canalizar_10->fetch_assoc();
$row_citas_proximas_canalizar_5 = $result_citas_proximas_canalizar_5->fetch_assoc();
$row_citas_proximas_canalizar_now = $result_citas_proximas_canalizar_now->fetch_assoc();

$total_citas_procesar = $row_citas_procesar['total'];
$total_citas = $row_citas['total'];
$total_citas_proximas_propias = $row_citas_proximas_propias['total'];
$total_citas_proximas_canalizar = $row_citas_proximas_canalizar['total'];

$total_citas_proximas_propias_15 = $row_citas_proximas_propias_15['total'];
$total_citas_proximas_propias_10 = $row_citas_proximas_propias_10['total'];
$total_citas_proximas_propias_5 = $row_citas_proximas_propias_5['total'];
$total_citas_proximas_propias_now = $row_citas_proximas_propias_now['total'];

$total_citas_proximas_canalizar_15 = $row_citas_proximas_canalizar_15['total'];
$total_citas_proximas_canalizar_10 = $row_citas_proximas_canalizar_10['total'];
$total_citas_proximas_canalizar_5 = $row_citas_proximas_canalizar_5['total'];
$total_citas_proximas_canalizar_now = $row_citas_proximas_canalizar_now['total'];

echo json_encode([
    'totalCitasProcesar' => $total_citas_procesar,
    'totalCitas' => $total_citas,
    'totalCitasProximasPropias' => $total_citas_proximas_propias,
    'totalCitasProximasCanalizar' => $total_citas_proximas_canalizar,
    'totalCitasProximasPropias15' => $total_citas_proximas_propias_15,
    'totalCitasProximasPropias10' => $total_citas_proximas_propias_10,
    'totalCitasProximasPropias5' => $total_citas_proximas_propias_5,
    'totalCitasProximasPropiasNow' => $total_citas_proximas_propias_now,
    'totalCitasProximasCanalizar15' => $total_citas_proximas_canalizar_15,
    'totalCitasProximasCanalizar10' => $total_citas_proximas_canalizar_10,
    'totalCitasProximasCanalizar5' => $total_citas_proximas_canalizar_5,
    'totalCitasProximasCanalizarNow' => $total_citas_proximas_canalizar_now
]);


$conn->close();
?>
