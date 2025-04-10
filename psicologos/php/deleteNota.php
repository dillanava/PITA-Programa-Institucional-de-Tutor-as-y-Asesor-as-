<?php
include("../../php/conexion.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 3 || $nombreUsuario == '') {
  header("location:../../index.php");
  die();
}

// Obtener el ID de la nota desde el formulario
$id_nota = $_POST['id_nota'];

// Eliminar la nota de la tabla "notas" utilizando el ID de la nota
$sql = "DELETE FROM notas WHERE id_nota = '$id_nota' AND nempleado = '$usuario'";


if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error";
}

$conn->close();
?>
