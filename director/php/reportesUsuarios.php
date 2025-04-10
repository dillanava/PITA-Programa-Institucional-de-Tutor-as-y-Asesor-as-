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

// Obtener información de alumnos
$sql_alumnos = "SELECT nombre, matricula, grupo, cuatrimestre, promedio, id_carrera, strikes, active, email FROM alumnos";
$result_alumnos = $conn->query($sql_alumnos);

// Obtener información de profesores
$sql_profesores = "SELECT nombre, nempleado, id_nivel, active , id_carrera, nuevoU, email, cuatrimestre FROM profesores";
$result_profesores = $conn->query($sql_profesores);

function generarTabla($header, $data)
{
    $html = '<table cellspacing="0" cellpadding="5" border="1">';
    $html .= '<thead><tr>';

    foreach ($header as $col) {
        $html .= '<th>' . $col . '</th>';
    }

    $html .= '</tr></thead><tbody>';

    foreach ($data as $row) {
        $html .= '<tr>';
        foreach ($row as $key => $cell) {
            if ($key == 'id_nivel') {
                $cell = nivelDescripcion($cell);
            }
            $html .= '<td>' . $cell . '</td>';
        }
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    return $html;
}

function nivelDescripcion($id_nivel)
{
    switch ($id_nivel) {
        case 1:
            return 'Jefe de Carrera';
        case 2:
            return 'Tutor';
        case 3:
            return 'Psicólogo';
        case 4:
            return 'Profesor';
        default:
            return 'No especificado';
    }
}


function activeStatus($active)
{
    return $active == 1 ? 'Activo' : 'Inactivo';
}

function nuevoUStatus($nuevoU)
{
    return $nuevoU == 1 ? 'Sí' : 'No';
}

function carreraDescripcion($id_carrera)
{
    switch ($id_carrera) {

        case 1:
            return 'Ingeniería en Sistemas Computacionales';
        case 2:
            return 'Ingeniería en Robótica';
        case 3:
            return 'Ingeniería en Electrónica y Telecomunicaciones';
        case 4:
            return 'Ingeniería en Logística y Transporte';
        case 5:
            return 'Jefe de Carrera';
            case 6:
                return 'Psicólogo';
        case 7:
            return 'Licenciatura en Administración y Gestión Empresarial';
        case 8:
            return 'Licenciatura en Comercio Internacional y Aduanas';
        default:
            return 'No especificado';
    }
    
}



// Encabezados de la tabla de alumnos
$header_alumnos = array('Nombre', 'Matrícula', 'Grupo', 'Cuatrimestre', 'Promedio', 'Carrera', 'Strikes', 'Activo', 'Email');
$data_alumnos = array();

// Preparar datos de alumnos para la tabla
while ($row = $result_alumnos->fetch_assoc()) {
    $row['id_carrera'] = carreraDescripcion($row['id_carrera']);
    $row['active'] = activeStatus($row['active']);
    $data_alumnos[] = $row;
}

// Preparar datos de profesores para las tablas
$data_tutores = array();
$data_psicologos = array();
$data_profesores = array();
$data_jefes_carrera = array();

while ($row = $result_profesores->fetch_assoc()) {
    $row['id_carrera'] = carreraDescripcion($row['id_carrera']);
    $row['active'] = activeStatus($row['active']);

    if ($row['id_carrera'] == 'Jefe de Carrera' || $row['id_carrera'] == 'Psicólogo') {
        $row['cuatrimestre'] = '';
    }

    switch ($row['id_nivel']) {
        case 2:
            $data_tutores[] = $row;
            break;
        case 3:
            $data_psicologos[] = $row;
            break;
        case 4:
            $data_profesores[] = $row;
            break;
        case 1:
            $data_jefes_carrera[] = $row;
            break;
    }

    
}
// Encabezados de la tabla de profesores
$header_profesores = array('Nombre', 'No. Empleado', 'Nivel', 'Activo', 'Nivel', 'Nuevo', 'Email');

// Crear una instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer propiedades básicas del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Universidad Politécnica de Texcoco');
$pdf->SetTitle('Reporte de Alumnos, Profesores, Tutores, Psicólogos y Jefes de Carrera');
$pdf->SetSubject('Reporte de Alumnos, Profesores, Tutores, Psicólogos y Jefes de Carrera');
$pdf->SetKeywords('TCPDF, PDF, reporte, alumnos, profesores, tutores, psicologos, jefes de carrera');

// Generar tabla de alumnos
$html_alumnos = generarTabla($header_alumnos, $data_alumnos);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

$image_file = '../css/logo.jpg'; // Reemplaza con la ruta a tu imagen
$pdf->Image($image_file, 10, 15, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);

$pdf->SetY(20); // Ajusta la posición vertical del contenido después de insertar la imagen

$pdf->writeHTML('<br><h1 style="text-align: center; font-size: 20pt;">Reporte general de usuarios </h1>' . '<br><h2 style="text-align: center">Profesor: <i>' . $nombreUsuario . '</i><h2><br><br>');
$pdf->writeHTML('<h3 style="text-align:center">Alumnos</h3><br>', true, false, true, false, '');
$pdf->writeHTML($html_alumnos, true, false, true, false, '');

$pdf->writeHTML('<br>', true, false, true, false, '');

// Generar tabla de tutores
$html_tutores = generarTabla($header_profesores, $data_tutores);
$pdf->writeHTML('<h3 style="text-align:center">Tutores</h3><br>', true, false, true, false, '');
$pdf->writeHTML($html_tutores, true, false, true, false, '');

$pdf->writeHTML('<br>', true, false, true, false, '');

// Generar tabla de psicólogos
$html_psicologos = generarTabla($header_profesores, $data_psicologos);
$pdf->writeHTML('<h3 style="text-align:center">Psicólogos</h3><br>', true, false, true, false, '');
$pdf->writeHTML($html_psicologos, true, false, true, false, '');

$pdf->writeHTML('<br>', true, false, true, false, '');

// Generar tabla de profesores
$html_profesores = generarTabla($header_profesores, $data_profesores);
$pdf->writeHTML('<h3 style="text-align:center">Profesores</h3><br>', true, false, true, false, '');
$pdf->writeHTML($html_profesores, true, false, true, false, '');

$pdf->writeHTML('<br>', true, false, true, false, '');

// Generar tabla de jefes de carrera
$html_jefes_carrera = generarTabla($header_profesores, $data_jefes_carrera);
$pdf->writeHTML('<h3 style="text-align:center">Jefes de Carrera</h3><br>', true, false, true, false, '');
$pdf->writeHTML($html_jefes_carrera, true, false, true, false, '');

// Cerrar y generar PDF
$pdf->lastPage();
$pdf->Output('reporte_alumnos_profesores_tutores_psicologos_jefes_carrera.pdf', 'I');
