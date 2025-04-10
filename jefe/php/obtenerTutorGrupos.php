<?php
header('Content-Type: application/json');

include("../../php/conexion.php");

try {
    $query = "SELECT tutor_grupos.id_tutor_grupo, tutor_grupos.nempleado, tutor_grupos.nombre, tutor_grupos.grupo, tutor_grupos.generacion, periodos.nombre_periodo as periodo_nombre
              FROM tutor_grupos
              JOIN periodos ON tutor_grupos.periodo_inicio = periodos.periodo";
    $result = mysqli_query($conn, $query);

    $data = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($data, $row);
        }
    }

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
?>
