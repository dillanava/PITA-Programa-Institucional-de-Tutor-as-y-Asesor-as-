<?php
    header('Content-Type: application/json');

    include("../../php/conexion.php");

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $matricula = $_POST['matricula'];

    $sql = "SELECT carrera.id_carrera, carrera.carreras FROM alumnos
            INNER JOIN carrera ON alumnos.id_carrera = carrera.id_carrera
            WHERE alumnos.matricula = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();

    while ($row = $result->fetch_assoc()) {
        array_push($data, $row);
    }

    echo json_encode($data);

    $stmt->close();
    $conn->close();
?>
