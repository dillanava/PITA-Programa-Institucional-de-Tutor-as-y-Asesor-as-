<?php
include("../../php/conexion.php");
include("encrypt.php");

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function isPasswordSecure($password) {
    $strength = 0;
    $regexRules = [
        '/[a-z]/',
        '/[A-Z]/',
        '/[0-9]/',
        '/[^A-Za-z0-9]/',
    ];

    foreach ($regexRules as $regex) {
        if (preg_match($regex, $password)) $strength++;
    }

    return $strength;
}

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];
if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

$nombre = $_POST['nombre'];
$num_empleado = $_POST['num_empleado'];
$niveles_acceso = $_POST['nivel_acceso'];
$contraseña = $_POST['contraseña'];
$email = $_POST['email'];
$recien_creado = 1;
$id_nivel_acceso = 1;
$carreras = isset($_POST['carreras']) ? $_POST['carreras'] : [];

$contraseña_encrypt = encrypt($contraseña);

// Verificar si la contraseña es segura antes de guardarla
if (!isPasswordSecure($contraseña)) {
    echo json_encode(['success' => false, 'message' => 'weak_password']);
    exit();
}


$sql_insert_usuario = "INSERT INTO usuarios (nombre, contraseña, nivel_acceso, email, created_at, matricula, nempleado) 
                       VALUES ('$nombre', '$contraseña_encrypt', '$id_nivel_acceso', '$email', CURRENT_TIMESTAMP, NULL, '$num_empleado')";

// Compruebe si se seleccionó al menos un tipo de profesor
if (count($niveles_acceso) == 0) {
    echo json_encode([
        'status' => 'error',
        'icon' => 'error',
        'message' => 'No se ha seleccionado un nivel para el profesor nuevo',
        'title' => 'Selecciona un nivel de profesor'
    ]);
    exit();
    die();
}


$sql_insert_usuario = "INSERT INTO usuarios (nombre, contraseña, nivel_acceso, email, created_at, matricula, nempleado, recien_creado) 
                       VALUES ('$nombre', '$contraseña_encrypt', '$id_nivel_acceso', '$email', CURRENT_TIMESTAMP, NULL, '$num_empleado', $recien_creado)";

// Compruebe si se seleccionó al menos un nivel
if (empty($niveles_acceso)) {
    header("location:../profesores.php?new=no_nivel");
    die();
}


$sql_check = "SELECT * FROM profesores WHERE nempleado='$num_empleado' OR email='$email'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo json_encode([
        'status' => 'error',
        'icon' => 'error',
        'message' => 'El número de empleado o email ya se han registrado en otro profesor',
        'title' => 'Número de profesor ya existente o email ya registrado'
    ]);
    exit();
    die();
} else {
    $id_nivel = $niveles_acceso[0];
    $sql_insert = "INSERT INTO profesores (nombre, nempleado, active, contraseña, email, id_nivel, recien_creado) 
    VALUES ('$nombre', '$num_empleado', '1', '$contraseña_encrypt', '$email', '$id_nivel', $recien_creado)";
    if ($conn->query($sql_insert) === TRUE) {
        $sql_insert_usuario = "INSERT INTO usuarios (nombre, contraseña, nivel_acceso, email, created_at, matricula, nempleado) 
                       VALUES ('$nombre', '$contraseña_encrypt', '$id_nivel_acceso', '$email', CURRENT_TIMESTAMP, NULL, '$num_empleado')";
        if ($conn->query($sql_insert_usuario) === TRUE) {

            asignarCarrerasANuevoProfesor($num_empleado, $conn, $_POST['carreras']);
            asignarNivelesANuevoProfesor($num_empleado, $_POST['nivel_acceso'], $conn);
            echo json_encode([
                'status' => 'success',
                'icon' => 'success',
                'message' => 'Se ha dado de alta  correctamente al nuevo profesor',
                'title' => 'Profesor dado de alta exitosamente'
            ]);
            exit();
            die();
        } else {
            echo json_encode([
                'status' => 'error',
                'icon' => 'error',
                'message' => 'Se ha presentado un error al dar de alta al profesor',
                'title' => 'Error al dar de alta'
            ]);
            exit();
            die();
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'icon' => 'error',
            'message' => 'Se ha presentado un error al dar de alta al profesor',
            'title' => 'Error al dar de alta'
        ]);
        exit();
        die();
    }
}

function asignarCarrerasANuevoProfesor($nempleado, $conn, $carreras)
{
    if (!empty($carreras)) { // Verifica si el array de carreras no está vacío
        foreach ($carreras as $id_carrera) {
            $sql_asignar = "INSERT INTO profesor_carrera (nempleado, id_carrera) VALUES ('$nempleado', '$id_carrera')";

            if (!$conn->query($sql_asignar)) {
                echo "Error al asignar la carrera: " . $conn->error;
            }
        }
    } else {
        echo "No se seleccionaron carreras para asignar al profesor.";
    }
}


function asignarNivelesANuevoProfesor($nempleado, $niveles_acceso, $conn)
{
    if (!empty($niveles_acceso)) {
        foreach ($niveles_acceso as $nivel) {
            $sql_asignar_nivel = "INSERT INTO profesor_nivel (nempleado, id_nivel) VALUES ('$nempleado', '$nivel')";

            if (!$conn->query($sql_asignar_nivel)) {
                echo "Error al asignar el nivel: " . $conn->error;
            }
        }
    } else {
        echo "No se seleccionaron niveles para asignar al profesor.";
    }
}


$conn->close();
