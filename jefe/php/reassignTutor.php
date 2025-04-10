<?php
session_start();

include("../../php/conexion.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nempleado = $_POST['tutores'];
    $grupo = $_POST['grupo'];
    $generacion = $_POST['generacion'];
    $periodo_inicio = $_POST['periodo_inicio'];
    $existing_tutor_id = $_POST['existing_tutor_id'];
    
// Eliminar el tutor existente
$query_delete = "DELETE FROM tutor_grupos WHERE id_tutor_grupo = ?";
$stmt_delete = mysqli_prepare($conn, $query_delete);
mysqli_stmt_bind_param($stmt_delete, 'i', $existing_tutor_id);
$delete_result = mysqli_stmt_execute($stmt_delete);
$response['delete_result'] = $delete_result;

if ($delete_result) {
    $response['message'] = 'El tutor existente ha sido eliminado correctamente.';
} else {
    $response['message'] = 'Error al eliminar el tutor existente.';
}


// Asignar el nuevo tutor
$query_nombre = "SELECT nombre FROM profesores WHERE nempleado = ?";
$stmt_nombre = mysqli_prepare($conn, $query_nombre);
mysqli_stmt_bind_param($stmt_nombre, 'i', $nempleado);
mysqli_stmt_execute($stmt_nombre);
$result_nombre = mysqli_stmt_get_result($stmt_nombre);
$row_nombre = mysqli_fetch_assoc($result_nombre);
$nombre_profesor = $row_nombre['nombre'];

// Insertar el nuevo profesor en la tabla tutor_grupos
$query_assign = "INSERT INTO tutor_grupos (nempleado, nombre, grupo, generacion, periodo_inicio) VALUES (?, ?, ?, ?, ?)";
$stmt_assign = mysqli_prepare($conn, $query_assign);
mysqli_stmt_bind_param($stmt_assign, 'issii', $nempleado, $nombre_profesor, $grupo, $generacion, $periodo_inicio);
$assign_result = mysqli_stmt_execute($stmt_assign);
$response['success'] = $assign_result;
$response['assign_result'] = $assign_result;
;}

echo json_encode($response);
?>
