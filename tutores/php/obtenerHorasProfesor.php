<?php
include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

if (isset($_GET['nempleado']) && isset($_GET['fecha'])) {
    $nempleado = $_GET['nempleado'];
    $fecha = $_GET['fecha'];
    $dia_semana = date('w', strtotime($fecha)); // Obtiene el día de la semana en formato numérico (0 = domingo, 1 = lunes, ..., 6 = sábado)

    $citaTipo = $_GET['citaTipo'];

    if ($citaTipo == 3) {
        $citaTipo = 2;
    }

    $horario_query = "SELECT hora_inicio, hora_fin, tipo_hora FROM profesor_horario WHERE nempleado = $nempleado AND dia_semana = $dia_semana";
    
    $horario_result = mysqli_query($conn, $horario_query);
    $horarios = [];
    
    while ($row = mysqli_fetch_assoc($horario_result)) {
        $horarios[] = $row;
    }

    $citas_query = "SELECT hora FROM (SELECT hora FROM citas WHERE nempleado = $nempleado AND fecha = '$fecha' AND status = 1 UNION SELECT hora FROM citas_procesar WHERE tutor = $nempleado AND fecha = '$fecha') AS horas_ocupadas";
    $citas_result = mysqli_query($conn, $citas_query);

    $horas_ocupadas = [];
    while ($row = mysqli_fetch_assoc($citas_result)) {
        $horas_ocupadas[] = $row['hora'];
    }

    $hora_actual = "07:00:00"; // Fija la hora de inicio a las 07:00:00
    $fin_del_dia = "21:00:00"; // Fija la hora de fin a las 21:00:00
    $horas_disponibles = [];

    while ($hora_actual < $fin_del_dia) {
        $dentro_de_horario = false;
        foreach ($horarios as $horario) {
            if ($hora_actual >= $horario['hora_inicio'] && $hora_actual < $horario['hora_fin'] && $citaTipo == $horario['tipo_hora']) {
                $dentro_de_horario = true;
                break;
            }
        }

        if ($dentro_de_horario) {
            if (!in_array($hora_actual, $horas_ocupadas)) {
                $horas_disponibles[] = ['hora' => $hora_actual, 'estado' => 'disponible'];
            } else {
                $horas_disponibles[] = ['hora' => $hora_actual, 'estado' => 'ocupado'];
            }
        } else {
            $horas_disponibles[] = ['hora' => $hora_actual, 'estado' => 'fuera_horario'];
        }
    
        $hora_actual = date('H:i:s', strtotime('+30 minutes', strtotime($hora_actual))); // Aumenta en 30 minutos
    }

    header('Content-Type: application/json');
    echo json_encode($horas_disponibles);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Parámetros insuficientes.']);
}
