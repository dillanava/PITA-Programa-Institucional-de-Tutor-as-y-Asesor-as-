<?php
include("../../php/conexion.php");

$nempleado = $_POST['nempleado'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$activo = $_POST['activo-input'];
$id_nivel = $_POST['id_nivel-input'];

// Actualizar datos en la tabla profesores
$sql_profesores = "UPDATE profesores SET nombre = '$nombre', email = '$email', active = $activo, id_nivel = $id_nivel WHERE nempleado = $nempleado";
if ($conn->query($sql_profesores) === TRUE) {
    // Actualizar datos en la tabla profesor_carrera
    if (isset($_POST['carreras'])) {
        $carreras = $_POST['carreras'];
        $sql_carreras = "DELETE FROM profesor_carrera WHERE nempleado = $nempleado";
        $conn->query($sql_carreras);
        foreach ($carreras as $carrera) {
            $sql_carreras = "INSERT INTO profesor_carrera (nempleado, id_carrera) VALUES ($nempleado, $carrera)";
            $conn->query($sql_carreras);
        }
    }
    // Actualizar datos en la tabla profesor_nivel
    if (!empty($_POST['nivel'])) {
        $niveles = $_POST['nivel'];
        $sql_niveles = "DELETE FROM profesor_nivel WHERE nempleado = $nempleado";
        $conn->query($sql_niveles);
        foreach ($niveles as $nivel) {
            $sql_niveles = "INSERT INTO profesor_nivel (nempleado, id_nivel) VALUES ($nempleado, $nivel)";
            $conn->query($sql_niveles);
        }
    }

    // Actualizar datos en la tabla usuarios
    $sql_usuarios = "UPDATE usuarios SET nombre = '$nombre', email = '$email', nivel_acceso = $id_nivel WHERE nempleado = $nempleado";
    if ($conn->query($sql_usuarios) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
$conn->close();
