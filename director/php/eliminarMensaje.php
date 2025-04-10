<?php

//Verificar que el usuario tenga iniciada la sesión, sino lo manda al login

include("../../php/conexion.php");


session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];
$_SESSION['send_status'] = 'success';
header("Location: ../mensajes.php");


if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
    header("location:../../index.php");
    die();
}

include("conexion.php");

if (isset($_GET['delete'])) {
    $id_mensaje = $_GET['delete'];

    $sql = "DELETE FROM mensajes WHERE id_mensaje = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_mensaje);
    $stmt->execute();

    header("location:../mensajes.php?delete=approved");
} elseif (isset($_GET['read'])) {
    $id_mensaje = $_GET['read'];

    $sql = "UPDATE mensajes SET leido = 1 WHERE id_mensaje = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_mensaje);
    $stmt->execute();

    header("location:../mensajes.php?read=success");
} else {
    header("location:../mensajes.php?delete=error");
}

$conn->close();