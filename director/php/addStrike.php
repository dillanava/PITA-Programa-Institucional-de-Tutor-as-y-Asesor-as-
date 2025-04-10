<?php
include("../../php/conexion.php");

if (isset($_POST['matricula'])) {
    $matricula = $_POST['matricula'];

    $consulta_strikes = "SELECT strikes FROM alumnos WHERE matricula = '$matricula'";
    $resultado_strikes = $conn->query($consulta_strikes);

    if ($resultado_strikes->num_rows > 0) {
        $fila = $resultado_strikes->fetch_assoc();
        $strikes = $fila['strikes'];

        if ($strikes >= 3) {
            header("HTTP/1.1 400 Max Strikes");
            exit();
        } else {
            $consulta = "UPDATE alumnos SET strikes = strikes + 1 WHERE matricula = '$matricula'";
            $resultado = $conn->query($consulta);

            if ($resultado === TRUE) {
                header("HTTP/1.1 200 OK");
                exit();
            } else {
                header("HTTP/1.1 500 Internal Server Error");
                exit();
            }
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        exit();
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    exit();
}

$conn->close();
?>
