<?php
include("../../php/conexion.php");

$idCitas = $_POST['id_citas'];
$status = $_POST['status'];

// Consulta SQL para obtener el estado actual de la cita
$sql_select = "SELECT status FROM citas WHERE id_citas = $idCitas";
$result = $conn->query($sql_select);
$row = $result->fetch_assoc();

// Verificar si el estado actual de la cita ya es 2
if ($row['status'] == 2) {
    echo "already_resolved";
} else {
    // Actualizar el estado de la cita a 2
    $sql_update = "UPDATE citas SET status = $status WHERE id_citas = $idCitas";
    if ($conn->query($sql_update) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
}

$conn->close();
