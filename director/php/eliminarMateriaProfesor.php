<?php
include("../../php/conexion.php");

$nempleado = $_POST['nempleado'];
$id_asignaturasp = $_POST['id_asignaturasp'];

$query = "DELETE FROM asignaturasp WHERE nempleado = ? AND id_asignaturasp = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $nempleado, $id_asignaturasp);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Materia eliminada correctamente.";
} else {
    echo "Error al eliminar la materia.";
}

$stmt->close();
$conn->close();
?>
