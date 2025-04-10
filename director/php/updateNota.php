<?php
include("./conexion.php");
include("./encrypt.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
  header("location:../../index.php");
  die();
}

// Obtener el ID de la nota, el título y el contenido desde el formulario
$id_nota = $_POST['id_nota'];
$titulo = $_POST['titulo'];
$nota = $_POST['nota'];

// Cifrar el título y la nota
$titulo_cifrado = encrypt($titulo);
$nota_cifrada = encrypt($nota);

// Sanitizar el título y el contenido cifrados de la nota
$titulo_cifrado_sanitizado = mysqli_real_escape_string($conn, $titulo_cifrado);
$nota_cifrada_sanitizada = mysqli_real_escape_string($conn, $nota_cifrada);

// Actualizar la nota en la base de datos utilizando el ID de la nota
$sql = "UPDATE notas SET titulo = '$titulo_cifrado_sanitizado', nota = '$nota_cifrada_sanitizada' WHERE id_nota = '$id_nota' AND nempleado = '$usuario'";

if ($conn->query($sql) === TRUE) {
  $_SESSION['update_success'] = true;
  header("location:../notas.php");
} else {
  echo "Error al actualizar la nota: " . $conn->error;
}


$conn->close();
?>
