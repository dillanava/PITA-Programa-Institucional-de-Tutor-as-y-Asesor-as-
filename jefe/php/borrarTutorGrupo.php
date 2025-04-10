<?php
include("../../php/conexion.php");

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tutor_grupo = $_POST['id_tutor_grupo'];

    // Copiar el contenido de la tabla tutor_grupos a tutor_grupos_historial
    $query_copiar = "INSERT INTO tutor_grupos_historial (id_tutor_grupo, nempleado, nombre, grupo, generacion, periodo_inicio) SELECT id_tutor_grupo, nempleado, nombre, grupo, generacion, periodo_inicio FROM tutor_grupos WHERE id_tutor_grupo = ?";
    $stmt_copiar = mysqli_prepare($conn, $query_copiar);
    mysqli_stmt_bind_param($stmt_copiar, 'i', $id_tutor_grupo);
    $result_copiar = mysqli_stmt_execute($stmt_copiar);

    // Eliminar el registro de la tabla tutor_grupos
    $query_eliminar = "DELETE FROM tutor_grupos WHERE id_tutor_grupo = ?";
    $stmt_eliminar = mysqli_prepare($conn, $query_eliminar);
    mysqli_stmt_bind_param($stmt_eliminar, 'i', $id_tutor_grupo);
    $result_eliminar = mysqli_stmt_execute($stmt_eliminar);

    if ($result_copiar && $result_eliminar) {
        $response['success'] = true;
        $response['message'] = 'El profesor ha dejado de tener este grupo eliminado';
    } else {
        $response['success'] = false;
        $response['message'] = 'Error: No se pudo eliminar el registro';
    }
}

echo json_encode($response);

?>
