<?php
include("../../php/conexion.php");

require_once('../../librerias/tcpdf/tcpdf.php');

// Obtener información del grupo, año y periodo desde el formulario
$grupo = $_POST['grupo'];
$anio = $_POST['generacion'];
$periodo = $_POST['periodo_inicio'];

// Antes de la consulta SQL, comprueba si las variables tienen contenido
if (empty($grupo) || empty($anio) || empty($periodo)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Datos insuficientes o incorrectos']);
    exit;
}

$fecha_actual = date("d-m-Y H:i");


$sql_citas_grupo = "SELECT COUNT(*) as total_citas, 
    SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as citas_activas, 
    SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as citas_inactivas, 
    SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as citas_resueltas
    FROM citas
    WHERE YEAR(fecha) = '$anio' AND periodo = '$periodo' AND matricula IN (
        SELECT matricula FROM historial_grupos
        WHERE grupo = '$grupo' AND generacion = '$anio' AND periodo_inicio = '$periodo'
    )";
$result_citas_grupo = $conn->query($sql_citas_grupo);
$row_citas_grupo = $result_citas_grupo->fetch_assoc();


// Calcular el rango de fechas para el periodo especificado
switch ($periodo) {
    case 1:
        $fecha_inicio = $anio . "-01-01";
        $fecha_fin = $anio . "-04-30";
        break;
    case 2:
        $fecha_inicio = $anio . "-05-01";
        $fecha_fin = $anio . "-08-31";
        break;
    case 3:
        $fecha_inicio = $anio . "-09-01";
        $fecha_fin = $anio . "-12-31";
        break;
}

// Obtener el nombre del periodo de la base de datos
$sql_periodo = "SELECT nombre_periodo FROM periodos";
$result_periodo = $conn->query($sql_periodo);
$row_periodo = $result_periodo->fetch_assoc();
$nombre_periodo = $row_periodo['nombre_periodo'];

// Obtener información de alumnos del grupo en el año y periodo especificados
// La consulta selecciona los alumnos del grupo y año especificados, filtrando por generación y periodo_inicio
$sql_alumnos_grupo = "SELECT a.matricula, a.nombre
                      FROM alumnos a
                      JOIN historial_grupos hg ON a.matricula = hg.matricula
                      WHERE hg.grupo = '$grupo' AND hg.generacion = '$anio' AND hg.periodo_inicio = '$periodo'";

$result_alumnos_grupo = $conn->query($sql_alumnos_grupo);

$sql_periodo_actual = "SELECT CONCAT(p.nombre_periodo, ' del ', YEAR(NOW())) as nombre_periodo_actual
                       FROM periodos p
                       WHERE p.activo = 1";
$result_periodo_actual = $conn->query($sql_periodo_actual);
$row_periodo_actual = $result_periodo_actual->fetch_assoc();
$nombre_periodo_actual = $row_periodo_actual['nombre_periodo_actual'];

$sql_promedio_general = "SELECT AVG(h.calificacion) as promedio_general
                         FROM historial_calificaciones h
                         JOIN historial_grupos hg ON h.matricula = hg.matricula
                         WHERE hg.grupo = '$grupo' AND hg.generacion = '$anio' AND hg.periodo_inicio = '$periodo'";
$result_promedio_general = $conn->query($sql_promedio_general);
$row_promedio_general = $result_promedio_general->fetch_assoc();
$promedio_general_grupo = number_format($row_promedio_general['promedio_general'], 2);

// Verificar si el promedio general es 0
if ($promedio_general_grupo == 0) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No se encontraron grupos con esa generación, periodo de inicio y grupo']);
    exit;
}

// Crear una instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer propiedades básicas del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Universidad Politécnica de Texcoco');
$pdf->SetTitle('Reporte del Grupo '.$grupo);
$pdf->SetSubject('Reporte del Grupo');
$pdf->SetKeywords('UPTex, PITA, PDF, reporte, grupo');

// Contenido del PDF
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$image_file = '../css/logo.jpg'; // Reemplaza con la ruta a tu imagen
$pdf->Image($image_file, 10, 15, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->SetY(20); // Ajusta la posición vertical del contenido después de insertar la imagen
$pdf->writeHTML('<h4 style="text-align: right;"><strong>Reporte generado en el periodo: </strong> ' . $nombre_periodo_actual . '<h4 style="text-align: right;"><strong>En la fecha y hora: </strong>' . $fecha_actual . '<br><br>');

$html_promedio_general = '<h3 style="text-align: left">Generación: ' . $anio . '<br>';

$html_promedio_general = '<h3 style="text-align: left">Promedio general del grupo: ' . $promedio_general_grupo . '<br> <h3 style="text-align: left">Periodo de inicio: ' . $nombre_periodo  . '<br>';

// Crear tabla de información de alumnos del grupo
$html_alumnos_grupo = '<h2 style="text-align: center">Alumnos</h2>
<table cellspacing="0" cellpadding="5" border="1">
    <tr style="text-align: center">
        <th>Matrícula</th>
        <th>Nombre</th>
    </tr>';

while ($row_alumnos_grupo = $result_alumnos_grupo->fetch_assoc()) {
    $matricula = $row_alumnos_grupo['matricula'];
    $nombre = $row_alumnos_grupo['nombre'];

    $html_alumnos_grupo .= <<<EOD
    <tr style="text-align: center">
        <td>{$matricula}</td>
        <td>{$nombre}</td>
    </tr>
EOD;
}
$html_alumnos_grupo .= '</table>';

// Crear tabla de información de promedio y materias reprobadas por alumno del grupo
$html_promedio_reprobadas = '<br><h2 style="text-align: center">Promedio y materias reprobadas por alumno</h2>
<table cellspacing="0" cellpadding="5" border="1">
<tr style="text-align: center">
    <th>Matrícula</th>
    <th>Nombre</th>
    <th>Promedio general</th>
    <th>Materias reprobadas</th>
</tr>';

$result_alumnos_grupo->data_seek(0); // Regresar al inicio del resultado de la consulta
while ($row_alumnos_grupo = $result_alumnos_grupo->fetch_assoc()) {
    $matricula = $row_alumnos_grupo['matricula'];
    $nombre = $row_alumnos_grupo['nombre'];
    $sql_promedio_reprobadas = "SELECT AVG(h.calificacion) as promedio_general, COUNT(CASE WHEN h.calificacion < 7 THEN 1 ELSE NULL END) as materias_reprobadas
    FROM historial_calificaciones h
    JOIN historial_grupos hg ON h.matricula = hg.matricula
    WHERE hg.grupo = '$grupo' AND hg.generacion = '$anio' AND hg.periodo_inicio = '$periodo' AND h.matricula = '$matricula'
    AND h.grupo = hg.grupo AND h.generacion = hg.generacion AND h.periodo_inicio = hg.periodo_inicio";
    

    $result_promedio_reprobadas = $conn->query($sql_promedio_reprobadas);
    $row_promedio_reprobadas = $result_promedio_reprobadas->fetch_assoc();
    $promedio_general = number_format($row_promedio_reprobadas['promedio_general'], 2);
    $materias_reprobadas = $row_promedio_reprobadas['materias_reprobadas'];
    $materias_reprobadas = $row_promedio_reprobadas['materias_reprobadas'];

    $html_promedio_reprobadas .= <<<EOD
    <tr style="text-align: center">
        <td>{$matricula}</td>
        <td>{$nombre}</td>
        <td>{$promedio_general}</td>
        <td>{$materias_reprobadas}</td>
    </tr>
EOD;
}
$html_promedio_reprobadas .= '</table>';

function generarTablaCitasGrupo($row_citas_grupo) {
    $html_citas_grupo = '<h2 style="text-align: center">Citas realizadas en el grupo</h2>';
    $html_citas_grupo .= '<table cellspacing="0" cellpadding="5" border="1" style="text-align: center;">';
    $html_citas_grupo .= '<thead>
                            <tr>
                                <th>Citas generadas</th>
                                <th>Citas activas</th>
                                <th>Citas inactivas</th>
                                <th>Citas resueltas</th>
                            </tr>
                          </thead>';

    $html_citas_grupo .= '<tr>
                            <td>' . $row_citas_grupo['total_citas'] . '</td>
                            <td>' . $row_citas_grupo['citas_activas'] . '</td>
                            <td>' . $row_citas_grupo['citas_inactivas'] . '</td>
                            <td>' . $row_citas_grupo['citas_resueltas'] . '</td>
                          </tr>';

    $html_citas_grupo .= '</table>';

    return $html_citas_grupo;
}

$pdf->writeHTML($html_promedio_general, true, false, false, false, '');

$html_citas_grupo = generarTablaCitasGrupo($row_citas_grupo);
$pdf->writeHTML($html_citas_grupo, true, 0, true, 0);

$pdf->writeHTML($html_alumnos_grupo . $html_promedio_reprobadas, true, false, false, false, '');

// Cerrar y generar PDF
$pdf->lastPage();
$pdf->Output('reporte_grupo_' . $grupo . '.pdf', 'I');