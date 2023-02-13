<?php
require_once '../vendor/autoload.php';
require_once 'reporteDiario.php';
//\
$fechaInicio = $_GET['fechaInicio'];
$turno = $_GET['turno'];

$css = file_get_contents('estilosPDF.css');
$css = file_get_contents('../../../resources/css/style.css');

$mpdf = new \Mpdf\Mpdf([
    'format' => 'A4',
]);
$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);

//$plantilla = getPlantilla($idatencion);
$plantilla = getPlantilla($fechaInicio, $turno);
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);

$mpdf->Output('ReporteDiario.pdf', 'I');
