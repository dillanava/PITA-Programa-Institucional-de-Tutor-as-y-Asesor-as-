<?php
include("./conexion.php");
session_start();

ob_start(); // Inicia el almacenamiento en búfer de la salida
header('Content-Type: application/json'); // Establece el encabezado de contenido como JSON

$usuario = $_SESSION['user'];
echo $usuario;

if ($usuario == null || $usuario == '') {
    echo json_encode(['error' => 'Usuario no autenticado']);
    die();
}

function checkNewMessages($conn, $usuario) {
    // Reemplaza 'tabla_mensajes' con el nombre de la tabla donde se almacenan los mensajes
    // Reemplaza 'usuario_destinatario' y 'leido' con los nombres de las columnas apropiadas en la tabla
    $query = "SELECT COUNT(*) as new_messages_count FROM mensajes WHERE receptor = ? AND leido = 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['new_messages_count'] > 0;
}

$newMessages = checkNewMessages($conn, $usuario);
ob_end_clean(); // Limpia y desactiva el almacenamiento en búfer de salida
echo json_encode(['newMessages' => $newMessages]);
?>
