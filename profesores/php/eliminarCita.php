<?php

include("../../php/conexion.php");

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SESSION['idnivel'] != 4) {
    header("Location: ../../index.php");
    die();
}

$id_cita = $_GET['id_cita'];

// Consultar la cita antes de eliminarla
$sql_select = "SELECT * FROM citas WHERE id_citas = $id_cita";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Copiar la cita a citas_eliminadas
    $sql_insert = "INSERT INTO citas_eliminadas (id_citas, fecha, matricula, nempleado, tipo, id_citasN, status, hora, tutor, periodo, carrera, materia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("isiiisisssii", $row['id_citas'], $row['fecha'], $row['matricula'], $row['nempleado'], $row['tipo'], $row['id_citasN'], $row['status'], $row['hora'], $row['tutor'], $row['periodo'], $row['carrera'], $row['materia']);
    $stmt->execute();
    $stmt->close();

    // Eliminar la cita de la tabla citas
    $sql_delete = "DELETE FROM citas WHERE id_citas = $id_cita";

    if ($conn->query($sql_delete) === TRUE) {
        $response = array(
            'status' => 'success',
            'message' => 'La cita ha sido eliminada correctamente'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Hubo un problema al eliminar la cita'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'No se encontró la cita'
    );
}

echo json_encode($response);

$conn->close();

?>
