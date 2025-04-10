<?php
include("../../php/conexion.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

$carrera = isset($_GET['carrera']) ? $_GET['carrera'] : null;
$cuatrimestre = isset($_GET['cuatrimestre']) ? $_GET['cuatrimestre'] : null;
$nempleado = isset($_GET['nempleado']) ? $_GET['nempleado'] : null;

if ($carrera !== null && $cuatrimestre !== null) {
    $sql_materias = "SELECT id_materias, materia FROM materias WHERE id_carrera = {$carrera} AND cuatrimestre = {$cuatrimestre}";
    $result_materias = $conn->query($sql_materias);

    $materias = array();

    if ($result_materias->num_rows > 0) {
        while ($row = $result_materias->fetch_assoc()) {
            $id_materia = $row['id_materias'];
            $materia = array(
                'id' => $id_materia,
                'nombre' => $row['materia'],
                'asignada' => false
            );

            if ($nempleado !== null) {
                $sql_asignada = "SELECT * FROM asignaturasp WHERE nempleado = {$nempleado} AND id_materias = {$id_materia}";
                $result_asignada = $conn->query($sql_asignada);
                if ($result_asignada->num_rows > 0) {
                    $materia['asignada'] = true;
                }
            }

            $materias[] = $materia;
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
