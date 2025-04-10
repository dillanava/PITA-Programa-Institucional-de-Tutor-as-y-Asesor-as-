<?php
include('conexion.php');
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Verificar conexión
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Obtener el score enviado en el cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"), true);
$score = $data['score'];

// Aquí debes obtener la matrícula del alumno actual, por ejemplo, desde la sesión
$matricula = $_SESSION['matricula'];

// Preparar la consulta SQL para verificar si ya existe un registro para este usuario
$stmt = $conn->prepare("SELECT * FROM alumno_scores WHERE matricula = ?");
$stmt->bind_param("i", $matricula);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Ya existe un registro para este usuario
    $row = $result->fetch_assoc();
    $current_score = $row["score"];

    if ($score > $current_score) {
        // Actualizar el puntaje si el nuevo es más alto que el actual
        $stmt = $conn->prepare("UPDATE alumno_scores SET score = ? WHERE matricula = ?");
        $stmt->bind_param("ii", $score, $matricula);
        
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array("message" => "Score actualizado exitosamente."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Error al actualizar el score."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("message" => "El score no es más alto que el actual."));
    }
} else {
    // No existe un registro para este usuario, crear uno nuevo
    $stmt = $conn->prepare("INSERT INTO alumno_scores (matricula, score) VALUES (?, ?)");
    $stmt->bind_param("ii", $matricula, $score);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(array("message" => "Score guardado exitosamente."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error al guardar el score."));
    }
}

$stmt->close();
$conn->close();
?>
