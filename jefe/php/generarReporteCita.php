<?php
include("../../php/conexion.php");

require_once('../../librerias/tcpdf/tcpdf.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id_cita = $_POST['id_cita'];

$sql = "SELECT * FROM citas WHERE id_citas = '$id_cita' UNION SELECT * FROM citas_eliminadas WHERE id_citas = '$id_cita'";
$result = $conn->query($sql);
$cita = $result->fetch_assoc();

$fecha_actual = date("d-m-Y H:i");

// Consulta para obtener el nombre del profesor utilizando el número de empleado (nempleado)
$profesor_sql = "SELECT nombre FROM profesores WHERE nempleado = '{$cita['nempleado']}'";
$profesor_result = $conn->query($profesor_sql);
$profesor_nempleado = $profesor_result->fetch_assoc();

// Consulta para obtener el nombre del profesor utilizando el número de empleado (tutor)
$profesor_sql = "SELECT nombre FROM profesores WHERE nempleado = '{$cita['tutor']}'";
$profesor_result = $conn->query($profesor_sql);
$profesor_tutor = $profesor_result->fetch_assoc();

// Consulta para obtener el nombre del problema del tipo de cita
$tipo_problema_sql = "SELECT tipo_problema FROM tipo_problema WHERE id_tipo_problema = '{$cita['tipo']}'";
$tipo_problema_result = $conn->query($tipo_problema_sql);
$tipo_problema_row = $tipo_problema_result->fetch_assoc();

// Consulta para obtener el nombre del periodo
$periodo_sql = "SELECT nombre_periodo FROM periodos WHERE periodo = '{$cita['periodo']}'";
$periodo_result = $conn->query($periodo_sql);
$periodo_row = $periodo_result->fetch_assoc();

$sql_periodo_actual = "SELECT CONCAT(p.nombre_periodo, ' del ', YEAR(NOW())) as nombre_periodo_actual
                       FROM periodos p
                       WHERE p.activo = 1";
$result_periodo_actual = $conn->query($sql_periodo_actual);
$row_periodo_actual = $result_periodo_actual->fetch_assoc();
$nombre_periodo_actual = $row_periodo_actual['nombre_periodo_actual'];

// Convierte el valor numérico del estatus en un string legible
$status_text = '';
if ($cita['status'] == 0) {
    $status_text = 'Inactivo';
} elseif ($cita['status'] == 1) {
    $status_text = 'Activo';
} elseif ($cita['status'] == 2) {
    $status_text = 'Resuelto';
} elseif ($cita['status'] == 3) {
    $status_text = 'No asistió';
}



$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Universidad Politécnica de Texcoco');
$pdf->SetTitle('Reporte de Cita');
$pdf->SetSubject('Reporte de Cita');
$pdf->SetKeywords('UPTex, PITA, PDF, reporte, cita');

$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$image_file = '../css/logo.jpg'; // Reemplaza con la ruta a tu imagen
$pdf->Image($image_file, 10, 15, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->SetY(20); // Ajusta la posición vertical del contenido después de insertar la imagen
$pdf->writeHTML('<h4 style="text-align: right;"><strong>Reporte generado en el periodo: </strong> ' . $nombre_periodo_actual . '<h4 style="text-align: right;"><strong>En la fecha y hora: </strong>' . $fecha_actual . '<br><br>');

function getCitaType($id_citaN) {
    if ($id_citaN == 2) {
        return 'Psicológica';
    } elseif ($id_citaN == 4) {
        return 'Académica';
    } else {
        return 'Desconocida';
    }
}

$cita_tipo_text = getCitaType($cita['id_citasN']);

$html = '
    <h1>Detalles de la cita con ID: ' . $cita['id_citas'] . '</h1>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID de cita</th>
            <td>' . $cita['id_citas'] . '</td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td>' . $cita['fecha'] . '</td>
        </tr>
        <tr>
            <th>Matrícula</th>
            <td>' . $cita['matricula'] . '</td>
        </tr>
        <tr>
            <th>Profesor asignado</th>
            <td>' . $cita['nempleado'] . ' - ' . $profesor_nempleado['nombre'] . '</td>
        </tr>
        <tr>
            <th>Tipo</th>
            <td>' . $tipo_problema_row['tipo_problema'] . '</td>
            </tr>
        <tr>
            <th>ID de citasN</th>
            <td>' . $cita_tipo_text . '</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>' . $status_text . '</td>
        </tr>
        <tr>
            <th>Hora</th>
            <td>' . $cita['hora'] . '</td>
        </tr>
        <tr>
            <th>Tutor</th>
            <td>' . $cita['tutor'] . ' - ' . $profesor_tutor['nombre'] . '</td>
        </tr>
        <tr>
            <th>Periodo</th>
            <td>' . $periodo_row['nombre_periodo'] . '</td>
            </tr>
    </table>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();
$pdf->Output('reporte_cita_' . $id_cita . '.pdf', 'I');
