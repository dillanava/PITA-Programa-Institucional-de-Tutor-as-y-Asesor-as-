<?php
include("../../php/conexion.php");

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nempleado = $_POST['nempleado_hidden'];
$nombreProfesor = $_POST['nombreProfesor'];

$horarioStatus = "approved";

// Verificar si el nombre del profesor fue proporcionado y buscar su nempleado
if (!empty($nombreProfesor) || !empty($nempleado)) {
    $sql = "SELECT nempleado FROM profesores WHERE nombre = ? OR nempleado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nombreProfesor, $nempleado);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (empty($nempleado)) {
            $nempleado = $row['nempleado'];
        }
    } else {
    
        // Si el profesor no existe en la base de datos, redireccionar con un mensaje de error
        echo json_encode(['result' => 'error', 'message' => 'No se ha encontrado el profesor','text' => 'Verifica que el nombre o número del profesor sean correctos']);
        exit();
    }
}

for ($dia_semana = 1; $dia_semana <= 5; $dia_semana++) {
    $hora_inicio_array = isset($_POST["dia{$dia_semana}_inicio"]) ? $_POST["dia{$dia_semana}_inicio"] : array();
    $hora_fin_array = isset($_POST["dia{$dia_semana}_fin"]) ? $_POST["dia{$dia_semana}_fin"] : array();
    $tipo_hora_array = isset($_POST["dia{$dia_semana}_tipo"]) ? $_POST["dia{$dia_semana}_tipo"] : array();

    // Elimina los registros existentes para ese profesor y día de la semana
    $sql_delete = "DELETE FROM profesor_horario WHERE nempleado = '$nempleado' AND dia_semana = '$dia_semana'";
    if ($conn->query($sql_delete) !== TRUE) {
        echo json_encode(['result' => 'error', 'message' => 'Error al guardar el horario del profesor']);
        break;
    }

    // Solo inserta registros si hay bloques de horario para ese día
    if (!empty($hora_inicio_array) && !empty($hora_fin_array) && !empty($tipo_hora_array)) {
        for ($i = 0; $i < count($hora_inicio_array); $i++) {
            $hora_inicio = $hora_inicio_array[$i];
            $hora_fin = $hora_fin_array[$i];
            $tipo_hora = $tipo_hora_array[$i];

            if ($hora_inicio !== null && $hora_fin !== null && strtotime($hora_fin) <= strtotime($hora_inicio)) {
                $horarioStatus = "invalid";
                break;
            }

            // Inserta los datos en la tabla profesor_horario
            $sql = "INSERT INTO profesor_horario (nempleado, dia_semana, hora_inicio, hora_fin, tipo_hora)
                    VALUES ('$nempleado', '$dia_semana', '$hora_inicio', '$hora_fin', '$tipo_hora')";

            if ($conn->query($sql) !== TRUE) {
                echo json_encode(['result' => 'error', 'message' => 'Error al guardar el horario del profesor' ,'text' => 'Favor de revisar otra vez todos los campos que has ingresado']);
                break;
            }
        }
    }

    if ($horarioStatus != "approved") {
        break;
    }
}


echo json_encode(['result' => 'success', 'message' => 'Horario guardado con éxito' ,'text' => 'Se le ha asignado el horario al profesor, ya lo puedes visualizar']);
ob_end_flush();
exit();

$conn->close();

?>
