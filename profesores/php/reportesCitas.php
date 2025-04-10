<?php

// Verificar que el usuario tenga iniciada la sesión, sino lo manda al login
include("../../php/conexion.php");

session_start();

$tutor = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($tutor == null || $tutor == '' || $idnivel != 4 || $nombreUsuario == '') {
    header("location:../index.php");
    die();
}

$fecha_actual = date("d-m-Y H:i");

// Obtener la suma total de citas por tutor
$sql_sum_citas = "SELECT COUNT(*) as total_citas FROM citas WHERE tutor = '$tutor' OR nempleado = '$tutor'";
$result_sum_citas = $conn->query($sql_sum_citas);
$total_citas = $result_sum_citas->fetch_assoc()['total_citas'];

// Obtener la suma total de citas eliminadas por tutor
$sql_sum_citas_eliminadas = "SELECT COUNT(*) as total_citas_eliminadas FROM citas_eliminadas WHERE tutor = '$tutor' OR nempleado = '$tutor'";
$result_sum_citas_eliminadas = $conn->query($sql_sum_citas_eliminadas);
$total_citas_eliminadas = $result_sum_citas_eliminadas->fetch_assoc()['total_citas_eliminadas'];

// Obtener la suma total de citas de tipo id_citasN 2 por tutor
$sql_sum_citas_tipo_2 = "SELECT COUNT(*) as total_citas_tipo_2 FROM citas WHERE (tutor = '$tutor' AND id_citasN = 2) OR (nempleado = '$tutor' AND id_citasN = 2)";
$result_sum_citas_tipo_2 = $conn->query($sql_sum_citas_tipo_2);
$total_citas_tipo_2 = $result_sum_citas_tipo_2->fetch_assoc()['total_citas_tipo_2'];

// Obtener la suma total de citas de tipo id_citasN 4 por tutor
$sql_sum_citas_tipo_4 = "SELECT COUNT(*) as total_citas_tipo_4 FROM citas WHERE (tutor = '$tutor' AND id_citasN = 4) OR (nempleado = '$tutor' AND id_citasN = 4)";
$result_sum_citas_tipo_4 = $conn->query($sql_sum_citas_tipo_4);
$total_citas_tipo_4 = $result_sum_citas_tipo_4->fetch_assoc()['total_citas_tipo_4'];

$sql_periodo_actual = "SELECT CONCAT(p.nombre_periodo, ' del ', YEAR(NOW())) as nombre_periodo_actual
                       FROM periodos p
                       WHERE p.activo = 1";
$result_periodo_actual = $conn->query($sql_periodo_actual);
$row_periodo_actual = $result_periodo_actual->fetch_assoc();
$nombre_periodo_actual = $row_periodo_actual['nombre_periodo_actual'];

require_once('../../librerias/tcpdf/tcpdf.php');

// Crear una instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// Establecer propiedades básicas del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Universidad Politécnica de Texcoco');
$pdf->SetTitle('Reporte de Citas de profesor del Profesor');
$pdf->SetSubject('Reporte de Citas de profesor del Profesor');
$pdf->SetKeywords('TCPDF, PDF, reporte, citas, psicología, profesor');
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Agregar una imagen al PDF
$image_file = '../css/logo.jpg'; // Reemplaza con la ruta a tu imagen
$pdf->Image($image_file, 10, 15, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);

$pdf->SetY(20); // Ajusta la posición vertical del contenido después de insertar la imagen

$pdf->writeHTML('<h4 style="text-align: right;"><strong>Reporte generado en el periodo: </strong> ' . $nombre_periodo_actual . '<h4 style="text-align: right;"><strong>En la fecha y hora: </strong>' . $fecha_actual);

$pdf->writeHTML('<br><h1 style="text-align: center; font-size: 20pt;">Reporte de citas de profesor</h1>'. '<br><h2 style="text-align: center">Profesor: <i>' . $nombreUsuario . '</i><h2><br><br>');



function generarTabla($data) {
    $html = '<table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; border: none;">';
    $html .= '<tbody>';
    foreach ($data as $row) {
        $html .= '<tr>';
        foreach ($row as $key => $cell) {
            if ($key === 'id_citasN' && (int)$cell === 3) {
                $cell = 'Profesor';
            } elseif ($key === 'status') {
                if ((int)$cell === 1) {
                    $cell = 'Activo';
                } else if ((int)$cell === 0) {
                    $cell = 'Inactivo';
                }
            }
            $html .= '<td>' . $cell . '</td>';
        }
        
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    return $html;
}

function generarTabla2($header, $data) {
    $html = '<table cellspacing="0" cellpadding="5" border="1">';
    $html .= '<thead><tr>';
    foreach ($header as $col) {
        $html .= '<th>' . $col . '</th>';
    }
    $html .= '</tr></thead><tbody>';
    foreach ($data as $row) {
        $html .= '<tr>';
        foreach ($row as $key => $cell) {
            if ($key === 'id_citasN') {
                switch ((int)$cell) {
                    case 1:
                        $cell = 'Tutoría';
                        break;
                    case 2:
                        $cell = 'Psicológica';
                        break;
                    case 4:
                        $cell = 'Académica';
                        break;
                    default:
                        $cell = 'Desconocido';
                        break;
                }
            } elseif ($key === 'status') {
                if ((int)$cell === 1) {
                    $cell = '<span style="background-color: #C5E5A4;">Activa</span>';
                } else if ((int)$cell === 0) {
                    $cell = '<span style="background-color: #ff7f7f;">Inactiva</span>';
                } else if ((int)$cell === 2) {
                    $cell = '<span style="background-color: #FFEFBF;">Resuelta</span>';
                }
            } elseif ($key === 'tipo') {
                // No es necesario realizar ninguna acción, ya que el valor de la celda ya contiene el nombre del tipo de problema
            }
            $html .= '<td>' . $cell . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    return $html;
}

// Obtener información de citas psicológicas de un profesor específico
$sql_citas_psicologica_profesor = "SELECT citas.id_citas, citas.fecha, citas.hora, citas.matricula, citas.id_citasN, citas.status, nivelcitas.nombre AS nivel_nombre FROM citas INNER JOIN nivelcitas ON citas.id_citasN = nivelcitas.id_citasN INNER JOIN profesores ON citas.nempleado = profesores.nempleado WHERE nivelcitas.nombre = 'profesor' AND citas.nempleado = '$tutor'";
$result_citas_psicologica_profesor = $conn->query($sql_citas_psicologica_profesor);

// Obtener información de citas psicológicas de un profesor específico
$sql_citas_tutor = "SELECT citas.id_citas, citas.fecha, citas.hora, citas.matricula, citas.id_citasN, citas.status, tipo_problema.tipo_problema as tipo
FROM citas
INNER JOIN tipo_problema ON citas.tipo = tipo_problema.id_tipo_problema
WHERE citas.nempleado = '$tutor'";

$result_citas_2 = $conn->query($sql_citas_tutor);

// Encabezados de la tabla de citas
$header_citas_generartabla2 = array('ID', 'Fecha', 'Hora' , 'Matrícula', 'Tipo de cita', 'Estatus', 'Tipo de problema');


// Preparar datos de citas psicológicas de un profesor específico
$data_citas_psicologica_profesor = array();
while ($row = $result_citas_psicologica_profesor->fetch_assoc()) {
    $data_citas_psicologica_profesor[] = $row;
}

// Preparar datos de citas psicológicas de un profesor específico
$data_citas_2 = array();
while ($row = $result_citas_2->fetch_assoc()) {
    $data_citas_2[] = $row;
}

$pdf->writeHTML('<br><h3 style="text-align: left">Total de citas: ' . $total_citas . '</h3>');
$pdf->writeHTML('<br><h3 style="text-align: left">Total de citas eliminadas: ' . $total_citas_eliminadas . '</h3>');
$pdf->writeHTML('<br><h3 style="text-align: left">Total de citas psicológicas: ' . $total_citas_tipo_2 . '</h3>');
$pdf->writeHTML('<br><h3 style="text-align: left">Total de citas académicas: ' . $total_citas_tipo_4 . '</h3>');

$html_citas_psicologica_profesor = generarTabla($data_citas_psicologica_profesor);
$html_citas_generartabla2 = generarTabla2($header_citas_generartabla2, $data_citas_2);
$pdf->writeHTML($html_citas_psicologica_profesor, true, false, true, false, '');
$pdf->writeHTML($html_citas_generartabla2, true, false, true, false, '');


$pdf->lastPage();
$pdf->Output('reporte_citas_psicologia_profesor.pdf', 'I');

