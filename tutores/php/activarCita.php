<?php
// activarCita.php

// Conectar a la base de datos
require_once 'conexion.php';

// Obtener el identificador de la cita desde la solicitud POST
$id = $_POST['id'];

// Copiar los datos de la cita de la tabla "citas_procesar" a la tabla "citas"
$sql = "INSERT INTO citas (id_citas, fecha, matricula, nempleado, descripcion, id_citasN, status, hora, tutor)
        SELECT NULL, fecha, matricula, nempleado, descripcion, id_citasN, 1, hora, tutor
        FROM citas_procesar
        WHERE id_citas = '$id'";

// Ejecutar la consulta SQL
if (mysqli_query($conn, $sql)) {
    // Eliminar la cita de la tabla "citas_procesar"
    $sql = "DELETE FROM citas_procesar WHERE id_citas = '$id'";
    mysqli_query($conn, $sql);

    // Enviar una respuesta al cliente para indicar que la operación se completó correctamente
    echo 'success';
} else {
    // Enviar una respuesta al cliente para indicar que hubo un error
    echo 'error';
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
