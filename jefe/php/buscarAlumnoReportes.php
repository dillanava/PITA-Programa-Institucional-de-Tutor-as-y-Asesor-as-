<?php
header('Content-Type: application/json');

include("../../php/conexion.php");

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "dillan";
$password = "123";
$dbname = "dbs10610773";

$conexion = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);

$nempleado = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($nempleado == null || $nempleado == '' || $idnivel != 1 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

$matricula = $_POST['matricula'];

$SQL = "SELECT a.nombre, a.matricula, a.strikes, a.id_carrera, a.cuatrimestre, a.grupo, a.turno, a.active, a.email, a.promedio, a.generacion, p.nombre_periodo, c.carreras AS carrera_nombre
FROM alumnos a
INNER JOIN carrera c ON a.id_carrera = c.id_carrera
INNER JOIN profesor_carrera pc ON a.id_carrera = pc.id_carrera
INNER JOIN periodos p ON a.periodo_inicio = p.periodo
WHERE pc.nempleado = :nempleado AND a.matricula LIKE :matricula";

$query = $conexion->prepare($SQL);
$query->execute([
    ':nempleado' => $nempleado,
    ':matricula' => '%' . $matricula . '%',
]);

$alumnos = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($alumnos);
