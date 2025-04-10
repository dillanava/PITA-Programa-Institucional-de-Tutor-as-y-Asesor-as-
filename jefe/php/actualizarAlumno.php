<?php
include("../../php/conexion.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 1 || $nombreUsuario == '') {
    header("location:../../index.php");
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
            $carrera_abreviatura = 'ET';
            break;
        case 4:
            $carrera_abreviatura = 'LT';
            break;
        case 7:
            $carrera_abreviatura = 'AG';
            break;
        case 8:
            $carrera_abreviatura = 'CI';
            break;
    }

    return $cuatrimestre . $turno_inicial . $carrera_abreviatura . $grupo;
}

$matricula = $_POST['matricula2'];
$promedio = $_POST['promedio2'];
$nombre = $_POST['nombre2'];
$strikes = $_POST['strikes2'];
$active = $_POST['activo2'];
$id_carrera = $_POST['id_carrera2'];
$email = $_POST['email2'];
$cuatrimestre = $_POST['cuatrimestre2'];
$grupo = $_POST['grupo2'];
$turno = $_POST['turno2'];
$matriculaorg = $_POST['matricula2_org'];

$grupo_generado = generarTexto($cuatrimestre, $grupo, $turno, $id_carrera);

$consulta_actualizar_alumno = "UPDATE alumnos SET matricula='$matricula', nombre='$nombre', active='$active', id_carrera='$id_carrera', email='$email', cuatrimestre='$cuatrimestre', promedio='$promedio', strikes='$strikes', grupo='$grupo_generado', turno='$turno' WHERE matricula='$matriculaorg'";

$resultado_actualizar_alumno= $conn->query($consulta_actualizar_alumno);

if ($resultado_actualizar_alumno === TRUE) {
    eliminarYCrearUsuario($matricula, $matriculaorg, $conn);
    actualizarMateriasDeProfesor($matricula, $cuatrimestre, $id_carrera, $conn);
} else {
    echo "Error al actualizar alumno: " . $conn->error;
}

function eliminarYCrearUsuario($matricula, $matriculaorg, $conn) {
    $consulta_eliminar_usuario = "DELETE FROM usuarios WHERE matricula='$matriculaorg'";
    $resultado_eliminar_usuario = $conn->query($consulta_eliminar_usuario);

    if ($resultado_eliminar_usuario === FALSE) {
        echo "Error al eliminar usuario: " . $conn->error;
        return;
    }

    $consulta_obtener_contrasena = "SELECT contraseña FROM alumnos WHERE matricula='$matriculaorg'";
    $resultado_obtener_contrasena = $conn->query($consulta_obtener_contrasena);

    if ($resultado_obtener_contrasena->num_rows > 0) {
        $fila = $resultado_obtener_contrasena->fetch_assoc();
        $contrasena = $fila['contraseña'];

        $consulta_obtener_datos = "SELECT nombre, email FROM alumnos WHERE matricula='$matricula'";
        $resultado_obtener_datos = $conn->query($consulta_obtener_datos);

        if ($resultado_obtener_datos->num_rows > 0) {
            $fila = $resultado_obtener_datos->fetch_assoc();
            $nombre = $_POST['nombre2'];
            $email = $_POST['email2'];

            $nivel_acceso = 0; // Asumiendo que el nivel de acceso para los alumnos es 3
            $consulta_crear_usuario = "INSERT INTO usuarios (matricula, nombre, contraseña, nivel_acceso, email) VALUES ('$matricula', '$nombre', '$contrasena', '$nivel_acceso', '$email')";
            $resultado_crear_usuario = $conn->query($consulta_crear_usuario);

            if ($resultado_crear_usuario === FALSE) {
                echo "Error al crear usuario: " . $conn->error;
            }
        } else {
            echo "Error al obtener los datos del alumno: " . $conn->error;
        }

    } else {
        echo "Error al obtener la contraseña del usuario original: " . $conn->error;
    }
}


function actualizarMateriasDeProfesor($matricula, $cuatrimestre, $id_carrera, $conn) {
    $sql_materias = "SELECT id_materias FROM materias WHERE id_carrera = {$id_carrera} AND cuatrimestre = {$cuatrimestre}";

    $result_materias = $conn->query($sql_materias);

    if ($result_materias->num_rows > 0) {

        $sql_eliminar = "DELETE FROM asignaturasa WHERE matricula = '{$matricula}'";
        $conn->query($sql_eliminar);

        while($row = $result_materias->fetch_assoc()) {
            $sql_asignar = "INSERT INTO asignaturasa (matricula, id_materias) VALUES ('{$matricula}', '{$row['id_materias']}')";

            if (!$conn->query($sql_asignar)) {
                echo "Error al asignar la materia: " . $conn->error;
            }
        }
    } else { 
        $sql_eliminar = "DELETE FROM asignaturasa WHERE matricula = '{$matricula}'";
        $conn->query($sql_eliminar);
    }
}

$conn->close();
