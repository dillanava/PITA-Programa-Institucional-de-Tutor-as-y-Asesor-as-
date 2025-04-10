<?php
include("../../php/conexion.php");

if (isset($_GET['nempleado'])) {
    $nempleado = $_GET['nempleado'];

    $sql = "SELECT imagen_de_perfil FROM profesores WHERE nempleado = '" . $nempleado . "'";
    $result = $conn->query($sql);
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/PITA";
    $rutaImagen = $baseUrl . "/imagenes/default.jpg";

    if ($result->num_rows > 0) {
        $fila = $result->fetch_assoc();
        if (!empty($fila['imagen_de_perfil'])) {
            $rutaImagen = $baseUrl . "/" . $fila['imagen_de_perfil'];
        }
    }

    echo json_encode(['rutaImagen' => $rutaImagen]);
}
?>
