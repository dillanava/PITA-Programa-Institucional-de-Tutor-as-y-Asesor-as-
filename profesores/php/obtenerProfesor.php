<?php
include("../../php/conexion.php");

$id_nivel = $_GET['id_nivel'];

$consulta = "SELECT p.nempleado, u.nombre FROM profesor_nivel p INNER JOIN usuarios u ON p.nempleado = u.nempleado WHERE p.id_nivel = '$id_nivel'";
$resultado = $conn->query($consulta);

if ($resultado->num_rows > 0) {
    $profesores = [];
    while ($row = $resultado->fetch_assoc()) {
        $profesores[] = $row;
    }
    echo json_encode($profesores);
} else {
    echo json_encode([]);
}

$conn->close();
?>
