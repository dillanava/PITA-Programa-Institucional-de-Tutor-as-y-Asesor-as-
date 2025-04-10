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

    $sql = "SELECT materias.id_materias, materias.materia FROM asignaturasa
            INNER JOIN materias ON asignaturasa.id_materias = materias.id_materias
            WHERE asignaturasa.matricula = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matricula);
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
