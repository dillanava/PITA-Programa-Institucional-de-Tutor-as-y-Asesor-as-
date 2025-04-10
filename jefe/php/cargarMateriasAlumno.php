<?php
include("../../php/conexion.php");


session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];



if ($usuario == null || $usuario == '' || $idnivel != 1 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

$carrera = isset($_GET['carrera']) ? $_GET['carrera'] : null;
$cuatrimestre = isset($_GET['cuatrimestre']) ? $_GET['cuatrimestre'] : null;

if ($carrera !== null && $cuatrimestre !== null) {
    $sql_materias = "SELECT id_materias, materia FROM materias WHERE id_carrera = {$carrera} AND cuatrimestre = {$cuatrimestre}";
    $result_materias = $conn->query($sql_materias);

    $materias = array();

    if ($result_materias->num_rows > 0) {
        while ($row = $result_materias->fetch_assoc()) {
            $materias[] = array(
                'id' => $row['id_materias'],
                'nombre' => $row['materia'],
            );
        }
    }

    header('Content-Type: application/json');
    echo json_encode($materias);
} else {
    http_response_code(400);
    echo "Error: Parámetros de carrera y cuatrimestre no válidos.";
}

$conn->close();
?>
