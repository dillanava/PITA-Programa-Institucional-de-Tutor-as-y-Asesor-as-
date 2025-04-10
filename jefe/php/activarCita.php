<?php
include("../../php/conexion.php");

if (isset($_POST['id_citas'])) {
    $id_citas = $_POST['id_citas'];

    $conn->autocommit(false);
    $conn->begin_transaction();

    $sql1 = "INSERT INTO citas SELECT * FROM citas_eliminadas WHERE id_citas = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param('i', $id_citas);
    $result1 = $stmt1->execute();

    $sql2 = "DELETE FROM citas_eliminadas WHERE id_citas = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param('i', $id_citas);
    $result2 = $stmt2->execute();

    if ($result1 && $result2) {
        $conn->commit();
        echo "Cita activada con éxito";
    } else {
        $conn->rollback();
        echo "Error al activar la cita: " . $stmt1->error . " " . $stmt2->error;
    }

    $stmt1->close();
    $stmt2->close();
}

$conn->close();
?>
