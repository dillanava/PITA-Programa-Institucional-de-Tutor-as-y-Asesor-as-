<?php
include("../../php/conexion.php");

session_start();

$jefe = $_SESSION['user'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
(
    SELECT c.*, a.nombre AS nombre_alumno, tp.tipo_problema, nc.nombre AS nombre_tipo, p.nombre AS nombre_profesor
    FROM citas c
    JOIN alumnos a ON c.matricula = a.matricula
    JOIN tipo_problema tp ON c.tipo = tp.id_tipo_problema
    JOIN nivelcitas nc ON c.id_citasN = nc.id_citasN
    JOIN profesores p ON c.nempleado = p.nempleado
    WHERE a.id_carrera IN (
        SELECT id_carrera
        FROM profesor_carrera
        WHERE nempleado = '$jefe'
    )
)
UNION ALL
(
    SELECT ce.*, a.nombre AS nombre_alumno, tp.tipo_problema, nc.nombre AS nombre_tipo, p.nombre AS nombre_profesor
    FROM citas_eliminadas ce
    JOIN alumnos a ON ce.matricula = a.matricula
    JOIN tipo_problema tp ON ce.tipo = tp.id_tipo_problema
    JOIN nivelcitas nc ON ce.id_citasN = nc.id_citasN
    JOIN profesores p ON ce.nempleado = p.nempleado
    WHERE a.id_carrera IN (
        SELECT id_carrera
        FROM profesor_carrera
        WHERE nempleado = '$jefe'
    )
)
ORDER BY fecha DESC, hora ASC
";



$result = $conn->query($sql);
$citas = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $citas[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($citas);

$conn->close();
?>
