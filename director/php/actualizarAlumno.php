<?php
include("../../php/conexion.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
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
            $carrera_abreviatura = 'IET';
            break;
        case 4:
            $carrera_abreviatura = 'ILT';
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
$grupo = $_POST['grupo2']; // Añade esta línea
$turno = $_POST['turno2']; // Añade esta línea
$matriculaorg = $_POST['matricula2_org'];

// Llama a la función generarTexto() para obtener el nuevo valor del grupo
$grupo_generado = generarTexto($cuatrimestre, $grupo, $turno, $id_carrera);

// Añade el campo 'grupo' en la consulta UPDATE
$consulta_actualizar_alumno = "UPDATE alumnos SET matricula='$matricula', nombre='$nombre', active='$active', id_carrera='$id_carrera', email='$email', cuatrimestre='$cuatrimestre', promedio='$promedio', strikes='$strikes', grupo='$grupo_generado', turno='$turno' WHERE matricula='$matriculaorg'";
$resultado_actualizar_alumno= $conn->query($consulta_actualizar_alumno);

if ($resultado_actualizar_alumno === TRUE) {
    actualizarMateriasDeProfesor($matricula, $cuatrimestre, $id_carrera, $conn);
} else {
    echo "Error al actualizar alumno: " . $conn->error;
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
    } else { $sql_eliminar = "DELETE FROM asignaturasa WHERE matricula = '{$matricula}'";
    $conn->query($sql_eliminar);
}
}

$conn->close();

?>