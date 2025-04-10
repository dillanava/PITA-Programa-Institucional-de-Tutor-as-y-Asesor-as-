<?php

header('Content-Type: application/json');
include("../../php/conexion.php");

$id_cita = isset($_GET['id_cita']) ? intval($_GET['id_cita']) : 0;

if ($id_cita > 0) {

    if (!$conn) {
        die('No se pudo conectar a la base de datos: ' . mysqli_connect_error());
    }

    $query = "SELECT * FROM citas WHERE id_citas = $id_cita";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Error en la consulta: ' . mysqli_error($conn));
    }

    $datosCita = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn);

    if ($datosCita) {
        echo json_encode($datosCita);
    } else {
        echo json_encode(['error' => 'No se encontró la cita con el ID proporcionado']);
    }
} else {
    echo json_encode(['error' => 'ID de cita inválido']);
}
