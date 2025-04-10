<?php
session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['nombre']) || $_SESSION['idnivel'] != 2) {
    header("location: ../../index.php");
    die();
}

// Conexión a la base de datos
include("../../php/conexion.php");

$response = [];

if (isset($_FILES['imagen_perfil']) && $_FILES['imagen_perfil']['error'] == 0) {
    $target_dir = "../../imagenes/";
    $target_file = $target_dir . basename($_FILES["imagen_perfil"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si la imagen es válida
    $check = getimagesize($_FILES["imagen_perfil"]["tmp_name"]);
    if ($check === false) {
        $response = ['success' => false, 'message' => 'El archivo no es una imagen.'];
        echo json_encode($response);
        die();
    }

    // Verificar el tamaño del archivo
    if ($_FILES["imagen_perfil"]["size"] > 500000) {
        $response = ['success' => false, 'message' => 'Lo sentimos, el archivo es demasiado grande.'];
        echo json_encode($response);
        die();
    }

    // Permitir ciertos formatos de archivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $response = ['success' => false, 'message' => 'Lo sentimos, sólo se permiten archivos JPG, JPEG, PNG y GIF.'];
        echo json_encode($response);
        die();
    }

    // Cambiar el nombre del archivo a "nempleado.jpg"
    $target_file = $target_dir . 'p' . $_SESSION['user'] . ".jpg";

    // Eliminar la imagen anterior si existe
    $sql = "SELECT imagen_de_perfil FROM profesores WHERE nempleado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      if (!empty($row['imagen_de_perfil']) && file_exists("../../" . $row['imagen_de_perfil'])) {
        unlink("../../" . $row['imagen_de_perfil']);
      }
    }
    $stmt->close();

    // Subir la imagen al servidor
    if (move_uploaded_file($_FILES["imagen_perfil"]["tmp_name"], $target_file)) {
        // Cambiar la ruta relativa para guardarla en la base de datos
        $db_image_path = str_replace("../../", "", $target_file);

        $stmt = $conn->prepare("UPDATE profesores SET imagen_de_perfil = ? WHERE nempleado = ?");
        $stmt->bind_param("ss", $db_image_path, $_SESSION['user']);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'La imagen de perfil se ha cargado exitosamente'];
        } else {
            $response = ['success' => false, 'message' => 'Ocurrió un error al actualizar la imagen de perfil en la base de datos'];
        }
        $stmt->close();
    } else {
        $response = ['success' => false, 'message' => 'Lo sentimos, hubo un error al cargar la imagen'];
    }
} else {
    $response = ['success' => false, 'message' => 'No se proporcionó ninguna imagen para cargar'];
}

// Cerrar la conexión a la base de datos
$conn->close();

// Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

