<?php

// Verificar que el usuario tenga iniciada la sesión, sino lo manda al login
include("../../php/conexion.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 2 || $nombreUsuario == '') {
    header("location:../index.php");
    die();
}

require_once('../../librerias/tcpdf/tcpdf.php');

function generarTabla($header, $data) {
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
            }
            $html .= '<td>' . $cell . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    return $html;
}


// Crear una instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// Establecer propiedades básicas del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Universidad Politécnica de Texcoco');
$pdf->SetTitle('Reporte de citas de tutoría');
$pdf->SetSubject('Reporte de citas de tutoría');
$pdf->SetKeywords('TCPDF, PDF, reporte, citas, tutoría, profesor');
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Agregar una imagen al PDF
$image_file = '../css/logo.jpg'; // Reemplaza con la ruta a tu imagen
$pdf->Image($image_file, 10, 15, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);

$pdf->SetY(20); // Ajusta la posición vertical del contenido después de insertar la imagen
$pdf->writeHTML('<br><h1 style="text-align: center; font-size: 20pt;">Reporte de citas para tutorías</h1>'. '<br><h2 style="text-align: center">Profesor: <i>' . $nombreUsuario . '</i><h2><br><br>');

// Encabezados de la tabla de citas
$header_citas = array('ID', 'Fecha', 'Hora' , 'Matrícula', 'Tipo de cita', 'Estatus', 'Número de profesor');

// Obtener información de citas psicológicas de un profesor específico
$specific_professor = $usuario;
$sql_citas_tutor = "SELECT citas.id_citas, citas.fecha, citas.hora, citas.matricula, citas.id_citasN, citas.status, citas.nempleado FROM citas WHERE citas.tutor = '$usuario'";
$result_citas_psicologica_profesor = $conn->query($sql_citas_tutor);

// Preparar datos de citas psicológicas de un profesor específico
$data_citas_psicologica_profesor = array();
while ($row = $result_citas_psicologica_profesor->fetch_assoc()) {
    $data_citas_psicologica_profesor[] = $row;
}

// Generar tabla de citas psicológicas de un profesor específico
$html_citas_psicologica_profesor = generarTabla($header_citas, $data_citas_psicologica_profesor);
$pdf->writeHTML($html_citas_psicologica_profesor, true, false, true, false, '');

// Cerrar y generar PDF
$pdf->lastPage();
$pdf->Output('reporte_citas_tutor.pdf', 'I');
