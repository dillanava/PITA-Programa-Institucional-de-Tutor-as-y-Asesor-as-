<?php
include 'conexion.php';

session_start();

$matricula = $_SESSION['user'];

// Consulta para obtener los datos del alumno
$sql_alumno = "SELECT grupo, generacion, periodo_inicio FROM alumnos WHERE matricula = ?";
$stmt = $conn->prepare($sql_alumno);
$stmt->bind_param("i", $matricula);
$stmt->execute();
$stmt->bind_result($grupo, $generacion, $periodo_inicio);
$stmt->fetch();
$stmt->close();

// Consulta para obtener el profesor que tenga en común esos campos
$sql_profesor = "SELECT p.* FROM profesores p
                 INNER JOIN tutor_grupos tg ON p.nempleado = tg.nempleado
                 WHERE tg.grupo = ? AND tg.generacion = ? AND tg.periodo_inicio = ?";
$stmt = $conn->prepare($sql_profesor);
$stmt->bind_param("sii", $grupo, $generacion, $periodo_inicio);
$stmt->execute();
$result = $stmt->get_result();
$profesores = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $profesores[] = $row;
    }
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($profesores);
?>