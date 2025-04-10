<?php

// Verificar que el usuario tenga iniciada la sesión, sino lo manda al login
include("../../php/conexion.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
    header("location:../index.php");
    die();
}

require_once('../../librerias/tcpdf/tcpdf.php');

// Obtener información de nivelcitas
$sql_nivelcitas = "SELECT id_citasN, nombre, descripcion FROM nivelcitas";
$result_nivelcitas = $conn->query($sql_nivelcitas);

// Obtener información de citas
$sql_citas = "SELECT id_citas, fecha, matricula, nempleado, descripcion, id_citasN, status, hora FROM citas";
$result_citas = $conn->query($sql_citas);

function generarTabla($header, $data) {
    $html = '<table cellspacing="0" cellpadding="5" border="1">';
    $html .= '<thead><tr>';

    foreach ($header as $col) {
        $html .= '<th>' . $col . '</th>';
    }

    $html .= '</tr></thead><tbody>';

    foreach ($data as $row) {
        $html .= '<tr>';
        foreach ($row as $cell) {
            $html .= '<td>' . $cell . '</td>';
        }
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    return $html;
}

// Encabezados de la tabla de nivelcitas
$header_nivelcitas = array('ID CitasN', 'Nombre', 'Descripción');
$data_nivelcitas = array();

// Preparar datos de nivelcitas para la tabla
while ($row = $result_nivelcitas->fetch_assoc()) {
    $data_nivelcitas[] = $row;
}

// Preparar datos de citas para la tabla
$data_citas = array();

while ($row = $result_citas->fetch_assoc()) {
    $data_citas[] = $row;
}
// Crear una instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer propiedades básicas del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Universidad Politécnica de Texcoco');
$pdf->SetTitle('Reporte de Citas y Niveles de Citas');
$pdf->SetSubject('Reporte de Citas y Niveles de Citas');
$pdf->SetKeywords('TCPDF, PDF, reporte, citas, nivelcitas');

// Generar tabla de nivelcitas
$html_nivelcitas = generarTabla($header_nivelcitas, $data_nivelcitas);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 9);

$image_file = '../css/logo.jpg'; // Reemplaza con la ruta a tu imagen
$pdf->Image($image_file, 10, 15, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);

$pdf->SetY(20); // Ajusta la posición vertical del contenido después de insertar la imagen
$pdf->writeHTML('<br><h1 style="text-align: center; font-size: 20pt;">Reporte general de citas </h1>'. '<br><h2 style="text-align: center">Profesor: <i>' . $nombreUsuario . '</i><h2><br><br>');


// Obtener información de citas por nivel
$sql_citas = "SELECT citas.id_citas, citas.fecha, citas.hora, citas.matricula, citas.nempleado, citas.id_citasN, citas.status, nivelcitas.nombre AS nivel_nombre FROM citas INNER JOIN nivelcitas ON citas.id_citasN = nivelcitas.id_citasN";
$result_citas = $conn->query($sql_citas);

// Preparar datos de citas por nivel
$data_citas_tutoria = array();
$data_citas_psicologica = array();
$data_citas_profesor = array();

while ($row = $result_citas->fetch_assoc()) {
    // Cambiar el valor de id_citasN a "tutoria" si es 1
    if ($row['id_citasN'] == 1) {
        $row['id_citasN'] = 'Tutoría';
    } else if ($row['id_citasN'] == 2) {
        $row['id_citasN'] = 'Psicológica';
    }else if ($row['id_citasN'] == 3) {
        $row['id_citasN'] = 'Profesor';
    }

    // Cambiar el valor de status a "Activa" si es 1, o "Inactiva" si es 0
    if ($row['status'] == 1) {
        $row['status'] = 'Activa';
    } else {
        $row['status'] = 'Inactiva';
    }

    switch ($row['nivel_nombre']) {
        case 'tutoria':
            $data_citas_tutoria[] = $row;
            break;
        case 'psicologica':
            $data_citas_psicologica[] = $row;
            break;
        case 'profesor':
            $data_citas_profesor[] = $row;
            break;
    }
}



// Encabezados de la tabla de citas
$header_citas = array('ID', 'Fecha', 'Hora', 'Matrícula', 'No. Empleado', 'Tipo de cita', 'Estatus');

// Generar tabla de citas de tutoría
$html_citas_tutoria = generarTabla($header_citas, $data_citas_tutoria);
$pdf->writeHTML('<h3 style="text-align:center">Citas de tutoría</h3><br>', true, false, true, false, '');
$pdf->writeHTML($html_citas_tutoria, true, false, true, false, '');

$pdf->writeHTML('<br>', true, false, true, false, '');

// Generar tabla de citas psicológicas
$html_citas_psicologica = generarTabla($header_citas, $data_citas_psicologica);
$pdf->writeHTML('<h3 style="text-align:center">Citas psicológicas</h3><br>', true, false, true, false, '');
$pdf->writeHTML($html_citas_psicologica, true, false, true, false, '');

$pdf->writeHTML('<br>', true, false, true, false, '');

// Generar tabla de citas con profesor
$html_citas_profesor = generarTabla($header_citas, $data_citas_profesor);
$pdf->writeHTML('<h3 style="text-align:center">Citas de profesores</h3><br>', true, false, true, false, '');
$pdf->writeHTML($html_citas_profesor, true, false, true, false, '');

// Cerrar y generar PDF
$pdf->lastPage();
$pdf->Output('reporte_citas.pdf', 'I');




