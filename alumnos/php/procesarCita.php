<?php
// Verificar que el usuario tenga iniciada la sesión, sino lo manda al login

include("conexion.php");
include("encrypt.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];

if ($usuario == null || $usuario == '' || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

// Recibe los datos que se mandaron en el formulario y los manda a la base de datos si es que sí se conectó

$fecha = $_POST['fecha'];
$tutor = $_POST['tutor'];
$hora = $_POST['hora'];
$matricula = $_POST['matricula'];
$profesor = $_POST['profesor'];
$id_citasN = $_POST['id_citasN'];
$descripcita = $_POST['descripcion'];

$descripcita_encriptada = encrypt($descripcita); // Encripta la descripción antes de enviarla a la base de datos

// Consultar si la cita ya está ocupada
$consulta1 = "SELECT * FROM citas WHERE fecha='$fecha' AND hora='$hora'";
$resultado1 = $conn->query($consulta1);

if ($resultado1->num_rows > 0) {
    // Si la cita ya está ocupada, mostrar un mensaje de error
    header("location:../agendarCita.php?agendar=errortime");
} else {
    // Consultar los strikes de un alumno específico en la tabla alumnos
    $consulta_strikes_alumno = "SELECT strikes FROM alumnos WHERE matricula='$matricula'";
    $resultado_strikes_alumno = $conn->query($consulta_strikes_alumno);

    if ($resultado_strikes_alumno->num_rows > 0) {
        $fila_strikes_alumno = $resultado_strikes_alumno->fetch_assoc();
        $strikes_alumno = $fila_strikes_alumno['strikes'];

        if ($strikes_alumno >= 3) {
            // Si los strikes son más o igual a 3, mostrar un mensaje de error
            header("location:../agendarCita.php?agendar=errorstrikes");
        } else {
            $consulta_citas_tipo_existente = "SELECT * FROM citas WHERE matricula='$matricula' AND id_citasN='$id_citasN' AND status=1
            UNION
            SELECT * FROM citas_procesar WHERE matricula='$matricula' AND id_citasN='$id_citasN' AND status=1";
            $resultado_citas_tipo_existente = $conn->query($consulta_citas_tipo_existente);


            if ($resultado_citas_tipo_existente->num_rows >= 1) {
                // Si el alumno ya tiene una cita agendada con estatus 1, mostrar un mensaje de error
                header("location:../agendarCita.php?agendar=errorcitaexistente");
            } else {

                // Agregar una clase a la hora si no está ocupada
                $hora_class = "disponible";
                // Consultar si la matrícula del alumno existe
                $consulta2 = "SELECT * FROM alumnos WHERE matricula='$matricula'";
                $resultado2 = $conn->query($consulta2);

                // Consultar si el número de empleado del profesor existe
                $consulta3 = "SELECT * FROM profesores WHERE nempleado='$profesor'";
                $resultado3 = $conn->query($consulta3);

                if ($resultado2->num_rows > 0 && $resultado3->num_rows > 0) {
                    // Si las tablas contienen filas con la matrícula y número de empleado especificados, entonces se inserta la fila en la tabla citas
                    $consulta4 = "INSERT INTO citas_procesar (id_citas, fecha, matricula, nempleado, descripcion, id_citasN, status, hora, tutor) 
                    VALUES (NULL, '$fecha', '$matricula', '$profesor', '$descripcita_encriptada', '$id_citasN', 0 , '$hora', '$tutor')";
                    
                    $resultado4 = $conn->query($consulta4);

                    if ($resultado4 === TRUE) {
                        // La fila se insertó correctamente
                        header("location:../agendarCita.php?agendar=approved");
                    } else {
                        // Ocurrió un error al insertar la fila
                        header("location:../agendarCita.php?agendar=error");
                    }
                } else {
                    // Si alguna de las tablas no contiene una fila con la matrícula o número de empleado especificados, se muestra un mensaje de error
                    if ($resultado2->num_rows == 0) {
                        header("location:../agendarCita.php?agendar=error");
                    } else {
                        header("location:../agendarCita.php?agendar=error");
                    }
                }
            }
        }
    }
}

$conn->close();
