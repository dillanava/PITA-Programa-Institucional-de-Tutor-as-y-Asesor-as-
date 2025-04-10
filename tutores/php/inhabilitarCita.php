<?php

include("../../php/conexion.php");

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SESSION['idnivel'] != 2) {
    header("Location: ../../index.php");
    die();
}

$id_cita = $_POST['id_cita'];
$current_status = $_POST['status'];

$new_status = $current_status == "1" ? 0 : 1;

$sql_update = "UPDATE citas SET status = $new_status WHERE id_citas = $id_cita";

if ($conn->query($sql_update) === TRUE) {
    $response = array(
        'status' => 'success',
    );
} else {
    $response = array(
        'status' => 'error',
    );
}

echo json_encode($response);

$conn->close();

?>
