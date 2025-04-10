<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nempleado'])) {
    include("conexion.php");

    $nempleado = $_POST['nempleado'];
    $id_medalla_easter_egg = 5;

    // Verificar si el profesor ya tiene la medalla
    $sql = "SELECT * FROM `medallas_profesor` WHERE `nempleado` = ? AND `id_medalla` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $nempleado, $id_medalla_easter_egg);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si el profesor no tiene la medalla, agrégala a medallas_profesor
    if ($result->num_rows === 0) {
        $sql = "INSERT INTO `medallas_profesor` (`nempleado`, `id_medalla`) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $nempleado, $id_medalla_easter_egg);
        $stmt->execute();
    }
}
?>
