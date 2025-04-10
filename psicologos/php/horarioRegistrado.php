<?php
include('conexion.php');

session_start();
$usuario = $_SESSION['user'];
$id_materia = $_POST['id_materia'];
$dias = $_POST['dias'];
$horas = $_POST['horas'];

function horarioRegistrado($conn, $usuario, $id_materia, $dias, $horas)
{
    $query = "SELECT * FROM horario
              JOIN materias ON horario.id_materia = materias.id_materias
              JOIN asignaturasa ON materias.id_materias = asignaturasa.id_materias
              WHERE asignaturasa.matricula = $usuario AND horario.id_materia = '$id_materia' AND horario.dias = '$dias' AND horario.horas = '$horas'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

echo horarioRegistrado($conn, $usuario, $id_materia, $dias, $horas) ? 'true' : 'false';
