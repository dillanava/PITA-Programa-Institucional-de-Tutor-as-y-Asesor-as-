<?php
include("../../php/conexion.php");
include './encrypt.php';
session_start();

// Get profile image URL
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT imagen_de_perfil FROM profesores WHERE nempleado = '" . $_SESSION['user'] . "'";
$result = $conn->query($sql);
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/PITA";
$rutaImagen = $baseUrl . "/imagenes/default.jpg";

if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    if (!empty($fila['imagen_de_perfil'])) {
        $rutaImagen = $baseUrl . "/" . $fila['imagen_de_perfil'];
    }
}

$usuario = $_SESSION['user'];

function paginar($conn, $consulta, $por_pagina = 10)
{
    $resultado = $conn->query($consulta);
    $total_registros = $resultado->num_rows;

    $paginas = ceil($total_registros / $por_pagina);
    $pagina_actual = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
    $inicio = ($pagina_actual - 1) * $por_pagina;

    $consulta .= " LIMIT $inicio, $por_pagina";
    $resultado = $conn->query($consulta);

    return array($resultado, $paginas, $pagina_actual);
}

$por_pagina = 6;
$sql = "SELECT mensajes.id_mensaje, profesores.nempleado, profesores.nombre, profesores.imagen_de_perfil, mensajes.mensaje, mensajes.leido FROM mensajes INNER JOIN profesores ON mensajes.remitente = profesores.nempleado WHERE mensajes.receptor = '$usuario'";
$result = $conn->query($sql);
list($result, $paginas, $pagina_actual) = paginar($conn, $sql, $por_pagina);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leido = $row["leido"] == 1 ? "../imagenes/check-double.png" : "../imagenes/check.png";
        $mensaje = decrypt($row["mensaje"]); // desencriptar mensaje
        echo "<div class='list-group-item list-group-item-action d-flex justify-content-between align-items-center' onclick='showMessageDetails(" . json_encode($row) . ")'>";
        echo "<div class='d-flex' onclick='showMessageDetails(" . json_encode($row) . ")'>"; // Agrega el evento onclick aquí
        $imagenPerfilRemitente = $baseUrl . "/imagenes/default.jpg";
        if (!empty($row['imagen_de_perfil'])) {
            $imagenPerfilRemitente = $baseUrl . "/" . $row['imagen_de_perfil'];
        }
        echo "<img src='{$imagenPerfilRemitente}' alt='Imagen de perfil del remitente' class='mr-3' style='width: 40px; height: 40px; border-radius: 50%;'>";
        echo "<div>";
        echo "<h5>" . $row["nombre"] . "</h5>";
        echo "<p>" . $mensaje . "</p>";
        echo "</div>";
        echo "</div>"; // Cierra el div envolvente
        echo "<div>";
        echo "<img src='{$leido}' alt='Estado de lectura' class='mr-3' style='width: 20px; height: 20px;'>";
        echo "<button type='button' class='btn btn-success' data-toggle='modal' data-target='#replyMessageModal' onclick='event.stopPropagation(); prepareReplyMessageForm(" . $row["nempleado"] . ")'>Responder</button>";
        echo "</div>";
        echo "</div>";
        
    }
} else {
    echo "<div class='list-group-item'>No hay mensajes</div>";
}
?>
