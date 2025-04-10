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

// Verificar si el grupo existe en la tabla alumnos
$query_group_exists = "SELECT * FROM alumnos WHERE grupo = ? AND generacion = ? AND periodo_inicio = ?";
$stmt_group_exists = mysqli_prepare($conn, $query_group_exists);
mysqli_stmt_bind_param($stmt_group_exists, 'sii', $grupo, $generacion, $periodo_inicio);
mysqli_stmt_execute($stmt_group_exists);
$result_group_exists = mysqli_stmt_get_result($stmt_group_exists);

if (!mysqli_fetch_assoc($result_group_exists)) {
    $response['success'] = false;
    $response['message'] = 'El grupo no existe o no esta vigente';
} else {
    // Verificar si el grupo ya está asignado a otro profesor
    $query_check = "SELECT * FROM tutor_grupos WHERE grupo = ? AND generacion = ? AND periodo_inicio = ?";
    $stmt_check = mysqli_prepare($conn, $query_check);
    mysqli_stmt_bind_param($stmt_check, 'sii', $grupo, $generacion, $periodo_inicio);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if ($row_check = mysqli_fetch_assoc($result_check)) {
        $response['success'] = false;
        $response['existing_tutor_name'] = $row_check['nombre'];
        $response['existing_tutor_id'] = $row_check['id_tutor_grupo'];
    } else {
        // Asignar el grupo al profesor
        // Obtener el nombre del profesor
        $query_nombre = "SELECT nombre FROM profesores WHERE nempleado = ?";
        $stmt_nombre = mysqli_prepare($conn, $query_nombre);
        mysqli_stmt_bind_param($stmt_nombre, 'i', $nempleado);
        mysqli_stmt_execute($stmt_nombre);
        $result_nombre = mysqli_stmt_get_result($stmt_nombre);
        $row_nombre = mysqli_fetch_assoc($result_nombre);
        $nombre_profesor = $row_nombre['nombre'];

        // Insertar el profesor y el grupo en la tabla tutor_grupos
        $query_insert = "INSERT INTO tutor_grupos (nempleado, nombre, grupo, generacion, periodo_inicio) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $query_insert);
        mysqli_stmt_bind_param($stmt_insert, 'issii', $nempleado, $nombre_profesor, $grupo, $generacion, $periodo_inicio);

        if (mysqli_stmt_execute($stmt_insert)) {
            $response['success'] = true;
            $response['message'] = 'Se ha asignado el nuevo tutor al grupo';
        } else {
            $response['success'] = false;
            $response['message'] = 'Error al asignar el nuevo tutor al grupo';
        }
    }
}

}

echo json_encode($response);

