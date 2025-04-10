<?php
include("../../php/conexion.php");

session_start(); // Asegúrate de que esta línea esté al inicio del archivo antes de cualquier otro contenido

ob_start(); // Habilita el almacenamiento en búfer de salida

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtén el número de empleado del profesor
$nempleado = $_POST['nempleado_hidden'];

$horarioStatus = "approved"; // Inicializa el estado del horario como aprobado

// Itera sobre los días de la semana (1 = Lunes, 2 = Martes, etc.)
for ($dia_semana = 1; $dia_semana <= 5; $dia_semana++) {
    $hora_inicio = $_POST["dia{$dia_semana}_inicio"];
    $hora_fin = $_POST["dia{$dia_semana}_fin"];

    // Comprueba si la hora de fin es menor o igual que la hora de inicio
    if (strtotime($hora_fin) <= strtotime($hora_inicio)) {
        $horarioStatus = "invalid";
        break;
    }

    // Verifica si ya existe un registro para ese profesor en la tabla profesor_horario
    $sql_check = "SELECT * FROM profesor_horario WHERE nempleado = '$nempleado' AND dia_semana = '$dia_semana'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        // Si existe un registro, actualiza el horario
        $sql = "UPDATE profesor_horario SET hora_inicio = '$hora_inicio', hora_fin = '$hora_fin'
                WHERE nempleado = '$nempleado' AND dia_semana = '$dia_semana'";
    } else {
        // Si no existe un registro, inserta los datos en la tabla profesor_horario
        $sql = "INSERT INTO profesor_horario (nempleado, dia_semana, hora_inicio, hora_fin)
                VALUES ('$nempleado', '$dia_semana', '$hora_inicio', '$hora_fin')";
    }

    if ($conn->query($sql) !== TRUE) {
        $horarioStatus = "error";
        break;
    }
    
}

ob_end_flush(); // Termina el almacenamiento en búfer de salida
header("location:../horarioProfesor.php?horario=" . $horarioStatus);
exit();

$conn->close();
?>
