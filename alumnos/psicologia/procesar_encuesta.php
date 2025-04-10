<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Tcpdf;

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbs10610773";

// Crear una nueva instancia de conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recibir los datos del formulario (asegúrate de validar y sanitizar los datos según tus necesidades)
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$matricula = isset($_POST['matricula']) ? $_POST['matricula'] : '';
$carrera = isset($_POST['carrera']) ? $_POST['carrera'] : '';
$grupo = isset($_POST['grupo']) ? $_POST['grupo'] : '';
$atencion_psicologica = isset($_POST['atencion_psicologica']) ? $_POST['atencion_psicologica'] : '';
$tratamiento_psiquiatrico = isset($_POST['tratamiento_psiquiatrico']) ? $_POST['tratamiento_psiquiatrico'] : '';
$asesoria_psicologica = isset($_POST['asesoria_psicologica']) ? $_POST['asesoria_psicologica'] : '';

// Insertar los datos en la base de datos
$sql = "INSERT INTO encuesta2 (nombre, matricula, carrera, grupo, atencion_psicologica, tratamiento_psiquiatrico, asesoria_psicologica) 
        VALUES ('$nombre', '$matricula', '$carrera', '$grupo', '$atencion_psicologica', '$tratamiento_psiquiatrico', '$asesoria_psicologica')";

if ($conn->query($sql) === TRUE) {
    // Cargar el archivo Excel existente
    $spreadsheet = IOFactory::load('4 Entrevista inicial 2.xlsx');

    // Obtener la hoja activa
    $sheet = $spreadsheet->getActiveSheet();

    // Encontrar la primera fila vacía para agregar los nuevos datos sin sobrescribir
    $nextRow = $sheet->getHighestRow() + 1;

    // Escribir los datos en las celdas específicas
    $sheet->setCellValue('B5', $nombre);
    $sheet->setCellValue('B6', $matricula);
    $sheet->setCellValue('B7', $carrera);
    $sheet->setCellValue('B8', $grupo);
    
    if ($atencion_psicologica == 'si') {
        $sheet->setCellValue('G11', 'X');
    } elseif ($atencion_psicologica == 'no') {
        $sheet->setCellValue('I11', 'X');
    }
    
    $sheet->setCellValue('N6', $tratamiento_psiquiatrico);
    
    if ($asesoria_psicologica == 'si') {
        $sheet->setCellValue('G13', 'X');
    } elseif ($asesoria_psicologica == 'no') {
        $sheet->setCellValue('I13', 'X');
    }

    // Guardar el archivo Excel actualizado
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('4 Entrevista inicial 2.xlsx');

    // Crear el archivo PDF directamente desde el Excel usando Tcpdf
    $pdfWriter = new Tcpdf($spreadsheet, 'F', 'LETTER', true, 'UTF-8', false);
    $pdfWriter->save('4 Entrevista inicial 2.pdf');

    echo "Datos guardados correctamente en '4 Entrevista inicial 2.xlsx' y PDF generado.";
} else {
    echo "Error al insertar datos en la base de datos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
