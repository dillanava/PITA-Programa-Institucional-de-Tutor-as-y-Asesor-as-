<?php
// Verificar que el usuario tenga iniciada la sesión, sino lo manda al login
include("conexion.php");
include("encrypt.php");
ob_start();

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



// Función para generar el texto deseado
function generarTexto($cuatrimestre, $grupo, $turno, $id_carrera)
{
    $turno_inicial = ($turno === 'Matutino') ? 'M' : 'V';

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

$nombre = $_POST['nombre'];
$matricula = $_POST['matricula'];
$id_carrera = $_POST['id_carrera'];
$contraseña = $_POST['contraseña'];
$email = $_POST['email2'];
$cuatrimestre = 1;
$promedio = 0;
$grupo = $_POST['grupo'];
$turno = $_POST['turno'];
$strikes = $_POST['strikes'];
$active = $_POST['active'];
$periodo_inicio = $_POST['periodo_inscripcion'];
$active = $_POST['active'];
$evaluaciones = 1;
$encuesta = 1;
$generacion = $_POST['generacion'];

$contraseña_encriptada = encrypt($contraseña);

if (!isPasswordSecure($contraseña)) {
    echo json_encode(['success' => false, 'message' => 'weak_password']);
    exit();
}

// Generar el texto deseado
$texto_generado = generarTexto($cuatrimestre, $grupo, $turno, $id_carrera);

$sql_check = "SELECT * FROM alumnos WHERE matricula='$matricula' OR email='$email'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'duplicated']);
} else {
    $sql_insert = "INSERT INTO alumnos (nombre, matricula, active, id_carrera, contraseña, email, cuatrimestre, promedio, grupo, turno, strikes, calificaciones_ingresadas, encuesta_satisfaccion , generacion, periodo_inicio) 
                    VALUES ('$nombre', '$matricula', '$active', '$id_carrera', '$contraseña_encriptada', '$email', '$cuatrimestre', '$promedio', '$texto_generado', '$turno', '$strikes', $evaluaciones, '$encuesta' , '$generacion', $periodo_inicio)";
if ($conn->query($sql_insert) === TRUE) {
    // Agregar información del alumno a la tabla 'usuarios'
    $nivel_acceso = 0; // 0 para alumnos
    $sql_insert_usuarios = "INSERT INTO usuarios (matricula, nombre, contraseña, email, nivel_acceso) 
    VALUES ('$matricula', '$nombre', '$contraseña_encriptada', '$email', '$nivel_acceso')";

    if (!$conn->query($sql_insert_usuarios)) {
        echo json_encode(['success' => false, 'message' => 'error']);
    }

    asignarMateriasPrimerCuatrimestre($matricula, $id_carrera, $conn); // Llamada a la función
    enviarCorreoAlumnoNuevo($email, $nombre); // Llamamos a la función para enviar el correo
    echo json_encode(['success' => true, 'message' => 'approved']);
} else {
    echo json_encode(['success' => false, 'message' => 'error']);
}
}

function asignarMateriasPrimerCuatrimestre($matricula, $id_carrera, $conn) {
    // Consultar las materias del cuatrimestre 1 de la carrera seleccionada
    $sql_materias = "SELECT id_materias FROM materias WHERE id_carrera='$id_carrera' AND cuatrimestre='1' AND active='1'";
    $result_materias = $conn->query($sql_materias);

    // Si se encuentran materias, asignarlas al estudiante en la tabla 'asignaturasa'
    if ($result_materias->num_rows > 0) {
        while($row = $result_materias->fetch_assoc()) {
            $id_materia = $row['id_materias'];
            $sql_insert = "INSERT INTO asignaturasa (matricula, id_materias, calificacion) VALUES ('$matricula', '$id_materia', 0)";
            $conn->query($sql_insert);
        }
    }
}


function enviarCorreoAlumnoNuevo($email, $nombre)
{
    $_POST['email'] = $email;
    $_POST['nombre'] = $nombre;
    include("mensajeNuevoAlumno.php");
}


$conn->close();
ob_end_flush();
