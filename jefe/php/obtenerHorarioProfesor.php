<?php
include("../../php/conexion.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if (isset($_POST['nempleado'])) {
    $nempleado = intval($_POST['nempleado']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Realiza la consulta
    $sql = "SELECT * FROM profesor_horario WHERE nempleado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $nempleado);
    $stmt->execute();

    $result = $stmt->get_result();
    $horario = $result->fetch_all(MYSQLI_ASSOC);

    // Cierra la conexión
    $stmt->close();
    $conn->close();

    // Retorna el horario en formato JSON
    echo json_encode($horario);
}
?>
