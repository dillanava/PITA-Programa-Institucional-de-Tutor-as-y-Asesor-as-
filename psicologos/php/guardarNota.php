<?php
include("../../php/conexion.php");
include("./encrypt.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 3 || $nombreUsuario == '') {
  header("location:../../index.php");
  die();
}

$titulo = $_POST['titulo'];
$nota = $_POST['nota'];

// Cifrar el título y la nota
$titulo_cifrado = encrypt($titulo);
$nota_cifrada = encrypt($nota);

// Insertar la nota cifrada en la tabla notas
$sql = "INSERT INTO notas (nempleado, titulo, nota) VALUES ('$usuario', '$titulo_cifrado', '$nota_cifrada')";
if ($conn->query($sql) === TRUE) {
  echo "success";
} else {
  echo $conn->error;
}


$conn->close();

?>
