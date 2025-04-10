<?php
include("../../php/conexion.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['deleteCita'])) {
    $id_cita = $_GET['deleteCita'];

    // 1. Obtener la información de la cita eliminada
    $query = "SELECT * FROM citas_eliminadas WHERE id_citas = '$id_cita'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error al obtener información de la cita eliminada.");
    }
    $cita = mysqli_fetch_assoc($result);

    // 2. Insertar la información de la cita eliminada de vuelta a la tabla de citas
    $matricula = $cita['matricula'];
    $nempleado = $cita['nempleado'];
    $id_citasN = $cita['id_citasN'];
    $status = 1;
    $fecha = $cita['fecha'];
    $hora = $cita['hora'];
    $tipo = $cita['tipo'];
    $tutor = $cita['tutor']; // Agregar esta línea para obtener la descripción de la cita
     // Agregar esta línea para obtener la descripción de la cita

    $query = "INSERT INTO citas (id_citas, matricula, nempleado, id_citasN, status, fecha, hora, tipo, tutor) VALUES ('$id_cita', '$matricula', '$nempleado', '$id_citasN', '$status', '$fecha', '$hora', '$tipo', '$tutor')"; // Agregar la columna "descripcion" en la consulta
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error al insertar la cita en la tabla de citas.");
    }

    // 3. Eliminar la cita de la tabla de citas_eliminadas
    $query = "DELETE FROM citas_eliminadas WHERE id_citas = '$id_cita'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        header("Location: ../citas_eliminadas.php?activate=error");
    }

    // 4. Redireccionar a la página de citas eliminadas
    header("Location: ../citas_eliminadas.php?activate=approved");
}
?>
