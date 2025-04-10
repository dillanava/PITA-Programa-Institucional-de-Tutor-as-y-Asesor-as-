<?php
include("../php/conexion.php");

if (isset($_POST['id_cita'])) {
    $idCita = $_POST['id_cita'];

    // Obtén la matrícula del alumno relacionada con la cita
    $sql = "SELECT matricula FROM citas WHERE id_citas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $idCita);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $matricula = $row['matricula'];
    $stmt->close();

    // Verifica si el alumno ya tiene 3 o más strikes
    $sql = "SELECT strikes FROM alumnos WHERE matricula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $matricula);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $strikes = $row['strikes'];
    $stmt->close();

    if ($strikes >= 3) {
        $response['status'] = 'error';
        $response['message'] = "El alumno ya tiene 3 o más strikes y no se pueden agregar más";
    } else {
        // Incrementa la columna "strikes" en la tabla "alumnos"
        $sql = "UPDATE alumnos SET strikes = strikes + 1 WHERE matricula = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $matricula);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = "Se le ha sumado un strike al alumno con matrícula " . $matricula;
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = "Error: no se recibió el ID de la cita";
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>