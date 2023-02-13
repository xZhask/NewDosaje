<?php
require_once '../vendor/autoload.php';
require_once 'certificado.php';
//\
$idInfraccion = $_GET['idInfraccion'];

$css = file_get_contents('estilosPDF.css');
$mpdf = new \Mpdf\Mpdf([
    'format' => 'A4',
]);
$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);

//$plantilla = getPlantilla($idatencion);
$plantilla = getPlantilla($idInfraccion);
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);

$mpdf->Output('Certificado.pdf', 'I');
