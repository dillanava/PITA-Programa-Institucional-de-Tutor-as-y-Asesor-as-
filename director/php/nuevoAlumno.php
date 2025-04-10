<?php
include("../../php/conexion.php");

session_start();
$_SESSION['send_status'] = 'success';
header("Location: ../mensajes.php");
$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
    header("location:../index.php");
    die();
}
// Función para generar el texto deseado
function generarTexto($cuatrimestre, $grupo, $turno, $id_carrera) {
    $turno_inicial = ($turno === 'matutino') ? 'M' : 'V';
    
    $carrera_abreviatura = "";
    switch ($id_carrera) {
        case 1:
            $carrera_abreviatura = 'SC';
            break;
        case 2:
            $carrera_abreviatura = 'IR';
            break;
        case 3:
            $carrera_abreviatura = 'IET';
            break;
        case 4:
            $carrera_abreviatura = 'ILT';
            break;
        case 7:
            $carrera_abreviatura = 'LG';
            break;
        case 8:
            $carrera_abreviatura = 'CI';
            break;
    }

    return $cuatrimestre . $turno_inicial . $carrera_abreviatura . $grupo;
}

$nombre = $_POST['nombre'];
$matricula = $_POST['matricula'];
$id_carrera = $_POST['id_carrera'];
$contraseña = $_POST['contraseña'];
$email = $_POST['email'];
$cuatrimestre = $_POST['cuatrimestre'];
$promedio = $_POST['promedio'];
$grupo = $_POST['grupo'];
$turno = $_POST['turno'];
$strikes = $_POST['strikes'];
$active = $_POST['active'];
$materias_seleccionadas = $_POST['materias'];


// Generar el texto deseado
$texto_generado = generarTexto($cuatrimestre, $grupo, $turno, $id_carrera);

// Hash de la contraseña
$contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

$sql_check = "SELECT * FROM alumnos WHERE matricula='$matricula' OR email='$email'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    header("location:../alumnos.php?new=duplicated");
} else {
    $sql_insert = "INSERT INTO alumnos (nombre, matricula, active, id_carrera, contraseña, email, cuatrimestre, promedio, grupo, turno, strikes) 
                    VALUES ('$nombre', '$matricula', '$active', '$id_carrera', '$contraseña_hash', '$email', '$cuatrimestre', '$promedio', '$texto_generado', '$turno', '$strikes')";
    if ($conn->query($sql_insert) === TRUE) {
        asignarMateriasANuevoProfesor($matricula, $materias_seleccionadas, $conn);
        header("location:../alumnos.php?new=approved");
    } else {
        header("location:../alumnos.php?new=error");
    }
}

function asignarMateriasANuevoProfesor($matricula, $materias_seleccionadas, $conn) {
    // Verificar si se seleccionaron materias
    if (!empty($materias_seleccionadas)) {
        foreach($materias_seleccionadas as $id_materia) {
            // Insertar registro en la tabla 'asignaturasp' con el nempleado y el id_materia
            $sql_asignar = "INSERT INTO asignaturasa (matricula, id_materias) VALUES ('{$matricula}', '{$id_materia}')";

            if (!$conn->query($sql_asignar)) {
                echo "Error al asignar la materia: " . $conn->error;
            }
        }
    } else {
        echo "No se seleccionaron materias para asignar al profesor.";
    }
}

$conn->close();
?>
