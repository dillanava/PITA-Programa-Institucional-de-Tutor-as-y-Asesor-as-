<?php
// Incluir la clase TCPDF
require_once('tcpdf/tcpdf.php');

// Recibir datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $matricula = $_POST['matricula'] ?? '';
    $carrera = $_POST['carrera'] ?? '';
    $grupo = $_POST['grupo'] ?? '';
    $atencion_psicologica = $_POST['atencion_psicologica'] ?? '';
    $tratamiento_psiquiatrico = $_POST['tratamiento_psiquiatrico'] ?? '';
    $asesoria_psicologica = $_POST['asesoria_psicologica'] ?? '';

    // Crear instancia de TCPDF
    $pdf = new TCPDF();

    // Configurar el documento
    $pdf->SetCreator('Tu Nombre');
    $pdf->SetAuthor('Tu Nombre');
    $pdf->SetTitle('Encuesta Psicológica');
    $pdf->SetSubject('Encuesta Psicológica');

    // Agregar página
    $pdf->AddPage();

    // Contenido del PDF
    $contenido = <<<EOF
    <h1>Datos de la Encuesta</h1>
    <p><strong>Nombre:</strong> $nombre</p>
    <p><strong>Matrícula:</strong> $matricula</p>
    <p><strong>Carrera:</strong> $carrera</p>
    <p><strong>Grupo Escolar:</strong> $grupo</p>
    <p><strong>¿Has recibido atención Psicológica anteriormente?</strong> $atencion_psicologica</p>
    <p><strong>Tratamiento Psiquiátrico:</strong> $tratamiento_psiquiatrico</p>
    <p><strong>¿Te gustaría recibir asesoría psicológica en tu estancia en la universidad?</strong> $asesoria_psicologica</p>
    EOF;

    // Escribir contenido en el PDF
    $pdf->writeHTML($contenido, true, false, true, false, '');

    // Nombre del archivo de salida
    $file_name = 'encuesta_psicologica_' . date('Y-m-d_H-i-s') . '.pdf';

    // Salida del PDF (descarga)
    $pdf->Output($file_name, 'D');
}
?>
