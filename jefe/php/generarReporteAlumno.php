<?php
include("../../php/conexion.php");

require_once('../../librerias/tcpdf/tcpdf.php');

// Obtener información del alumno desde el formulario
$matricula = $_POST['matricula'];
$nombre = $_POST['nombre'];
$carrera_nombre = $_POST['carrera_nombre'];
$generacion = $_POST['generacion'];
$grupo = $_POST['grupo'];
$nombre_periodo = $_POST['nombre_periodo'];

$fecha_actual = date("d-m-Y H:i");

// Obtener información de citas del alumno
$sql_citas_alumno = "SELECT COUNT(*) as total_citas, 
SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as citas_activas, 
SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as citas_inactivas, 
SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as citas_resueltas, 
SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as citas_no_asistidas, 
(SELECT COUNT(*) FROM citas_eliminadas WHERE matricula = '$matricula') as total_citas_eliminadas 
FROM citas 
WHERE matricula = '$matricula'";
$result_citas_alumno = $conn->query($sql_citas_alumno);
$row_citas_alumno = $result_citas_alumno->fetch_assoc();

$sql_periodo_actual = "SELECT CONCAT(p.nombre_periodo, ' del ', YEAR(NOW())) as nombre_periodo_actual
                       FROM periodos p
                       WHERE p.activo = 1";
$result_periodo_actual = $conn->query($sql_periodo_actual);
$row_periodo_actual = $result_periodo_actual->fetch_assoc();
$nombre_periodo_actual = $row_periodo_actual['nombre_periodo_actual'];

$sql_historial_calificaciones = "SELECT h.cuatrimestre, h.grupo, h.periodo, h.anio, AVG(h.calificacion) as promedio_calificacion, p.nombre_periodo, COUNT(CASE WHEN h.calificacion < 7 THEN 1 ELSE NULL END) as materias_reprobadas
FROM historial_calificaciones h
JOIN periodos p ON h.periodo = p.periodo
WHERE h.matricula = '$matricula'
GROUP BY h.cuatrimestre, h.grupo, h.periodo, h.anio
ORDER BY h.anio, h.periodo, h.cuatrimestre, h.grupo";
$result_historial_calificaciones = $conn->query($sql_historial_calificaciones);

$sql_tutores_acudidos = "SELECT p.nombre, COUNT(*) as citas_total
FROM (
    SELECT c.nempleado
    FROM citas c
    WHERE c.matricula = '$matricula'
    UNION ALL
    SELECT ce.nempleado
    FROM citas_eliminadas ce
    WHERE ce.matricula = '$matricula'
) AS citas_union
JOIN profesores p ON citas_union.nempleado = p.nempleado
GROUP BY p.nempleado";

$result_tutores_acudidos = $conn->query($sql_tutores_acudidos);


// Crear una instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer propiedades básicas del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Universidad Politécnica de Texcoco');
$pdf->SetTitle('Reporte del Alumno '.$matricula);
$pdf->SetSubject('Reporte del Alumno');
$pdf->SetKeywords('UPTex, PITA, PDF, reporte, alumno');

// Contenido del PDF
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$image_file = '../css/logo.jpg'; // Reemplaza con la ruta a tu imagen
$pdf->Image($image_file, 10, 15, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);

$pdf->SetY(20); // Ajusta la posición vertical del contenido después de insertar la imagen
$pdf->writeHTML('<h4 style="text-align: right;"><strong>Reporte generado en el periodo: </strong> ' . $nombre_periodo_actual . '<h4 style="text-align: right;"><strong>En la fecha y hora: </strong>' . $fecha_actual . '<br><br>');

// Crear tabla de información del alumno
$html_alumno = <<<EOD

<table cellspacing="0" cellpadding="5" border="1">
    <tr>
        <th>Matrícula:</th>
        <td>{$matricula}</td>
    </tr>
    <tr>
        <th>Nombre:</th>
        <td>{$nombre}</td>
    </tr>
    <tr>
        <th>Carrera:</th>
        <td>{$carrera_nombre}</td>
    </tr>
    <tr>
        <th>Generación:</th>
        <td>{$generacion}</td>
    </tr>
    <tr>
        <th>Periodo de inicio:</th>
        <td>{$nombre_periodo}</td>
    </tr>
</table>
EOD;

// Crear tabla de información de citas del alumno
$html_citas_alumno = <<<EOD
<h2 style="text-align: center">Citas realizadas</h2>
<table cellspacing="0" cellpadding="5" border="1">
    <tr style="text-align: center">
        <th>Citas generadas</th>
        <th>Citas activas</th>
        <th>Citas inactivas</th>
        <th>Citas resueltas</th>
        <th>Citas no asistidas</th>
        <th>Citas eliminadas</th>
    </tr>
    <tr style="text-align: center">
        <td>{$row_citas_alumno['total_citas']}</td>
        <td>{$row_citas_alumno['citas_activas']}</td>
        <td>{$row_citas_alumno['citas_inactivas']}</td>
        <td>{$row_citas_alumno['citas_resueltas']}</td>
        <td>{$row_citas_alumno['citas_no_asistidas']}</td>
        <td>{$row_citas_alumno['total_citas_eliminadas']}</td>
    </tr>
</table>
EOD;

$html_historial_calificaciones = '<br><h2 style="text-align: center">Historial de calificaciones</h2>
<table cellspacing="0" cellpadding="5" border="1">
    <tr style="text-align: center">
        <th>Cuatrimestre</th>
        <th>Grupo</th>
        <th>Promedio</th>
        <th>Materias reprobadas</th>
        <th>Periodo</th>
    </tr>';

while ($row_historial_calificaciones = $result_historial_calificaciones->fetch_assoc()) {
    $cuatrimestre = $row_historial_calificaciones['cuatrimestre'];
    $grupo = $row_historial_calificaciones['grupo'];
    $promedio_calificacion = number_format($row_historial_calificaciones['promedio_calificacion'], 2);
    $nombre_periodo = $row_historial_calificaciones['nombre_periodo'];
    $anio = $row_historial_calificaciones['anio'];
    $materias_reprobadas = $row_historial_calificaciones['materias_reprobadas'];

    $html_historial_calificaciones .= <<<EOD
    <tr style="text-align: center">
        <td>{$cuatrimestre}</td>
        <td>{$grupo}</td>
        <td>{$promedio_calificacion}</td>
        <td>{$materias_reprobadas}</td>
        <td>{$nombre_periodo} {$anio}</td>
    </tr>
EOD;
}
$html_historial_calificaciones .= '</table>';

$html_tutores_acudidos = '<br><h2 style="text-align: center">Tutores acudidos</h2>
<table cellspacing="0" cellpadding="5" border="1">
    <tr style="text-align: center">
        <th>Nombre del profesor</th>
        <th>Veces que tuvo cita con el alumno</th>
    </tr>';

while ($row_tutores_acudidos = $result_tutores_acudidos->fetch_assoc()) {
    $nombre_profesor = $row_tutores_acudidos['nombre'];
    $citas_total = $row_tutores_acudidos['citas_total'];

    $html_tutores_acudidos .= <<<EOD
    <tr style="text-align: center">
        <td>{$nombre_profesor}</td>
        <td>{$citas_total}</td>
    </tr>
EOD;
}
$html_tutores_acudidos .= '</table>';


$pdf->writeHTML($html_alumno . $html_citas_alumno . $html_tutores_acudidos . $html_historial_calificaciones, true, false, false, false, '');


// Cerrar y generar PDF
$pdf->lastPage();
$pdf->Output('reporte_alumno_' . $matricula . '.pdf', 'I');
