<?php

session_start();

$usuario = $_SESSION['user'];

if ($usuario == null || $usuario == '') {
    header("location:../index.php");
    die();
}

// Eliminar la cookie si existe
if (isset($_COOKIE['user'])) {
    setcookie("user", "", time() - 3600, "/");
}

session_destroy();

header("location:../index.php");
exit();

?>
