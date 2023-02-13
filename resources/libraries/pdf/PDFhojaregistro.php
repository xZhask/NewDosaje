<?php
require_once '../vendor/autoload.php';
require_once 'hojaregistro.php';
//\
$IdHojaRegistro = $_GET['IdHojaRegistro'];


$css = file_get_contents('estilosPDF.css');

//$idatencion = $_REQUEST['idatencion'];
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);

//$plantilla = getPlantilla($idatencion);
$plantilla = getPlantilla($IdHojaRegistro);
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);

$mpdf->Output('HojaRegistro.pdf', 'I');