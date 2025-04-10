<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Verificar que el usuario tenga iniciada la sesión, sino lo manda al login

include("../../php/conexion.php");
include("encrypt.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];



if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

//Recibe los datos que se mandaron en el formulario y los manda a la base de datos si es que si se conecto


$tutor = $_POST['tutor'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$matricula = $_POST['matricula'];
$profesor = $_POST['profesor'];
$id_cita = $_POST['id_cita'];
$descripcita = $_POST['descripcita'];

$descripcita_encriptada = encrypt($descripcita); // Encripta la descripción antes de enviarla a la base de datos

// Consultar si la cita ya está ocupada
$consulta1 = "SELECT * FROM citas WHERE fecha='$fecha' AND hora='$hora'";
$resultado1 = $conn->query($consulta1);

if ($resultado1->num_rows > 0) {
    // Si la cita ya está ocupada, mostrar un mensaje de error
    header("location:../citas.php?new=errortime");
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
        // Consulta para contar strikes
        $consulta_strikes = "SELECT strikes FROM alumnos WHERE matricula='$matricula'";
        $resultado_strikes = $conn->query($consulta_strikes);
        $fila_strikes = $resultado_strikes->fetch_assoc();
        $strikes = $fila_strikes['strikes'];
    
        if ($strikes >= 3) {
            // Si los strikes son más o igual a 3, mostrar un mensaje de error
            header("location:../citas.php?new=errorstrikes");
        } else {
            // Si las tablas contienen filas con la matrícula y número de empleado especificados, entonces se inserta la fila en la tabla citas
            $consulta4 = "INSERT INTO citas (id_citas, fecha, matricula, nempleado, descripcion, id_citasN, status, hora, tutor) 
            VALUES (NULL, '$fecha', '$matricula', '$profesor', '$descripcita_encriptada', '$id_cita', 1 , '$hora', '$tutor')";
            
            $resultado4 = $conn->query($consulta4);
    
            if ($resultado4 === TRUE) {
                // La fila se insertó correctamente
                header("location:../citas.php?new=approved");
            } else {
                // Ocurrió un error al insertar la fila
                header("location:../citas.php?new=error");
            }
        }
    } else {
        // Si alguna de las tablas no contiene una fila con la matrícula o número de empleado especificados, se muestra un mensaje de error
        if ($resultado2->num_rows == 0) {
            header("location:../citas.php?new=studenterror");
        } else {
            header("location:../citas.php?new=profesorerror");
        }
    }
}

$conn->close();
