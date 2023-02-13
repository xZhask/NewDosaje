<?php
require_once 'App/model/clsInfraccion.php';
$objInfraccion = new ClsInfraccion();

$positivos = 0;
$negativos = 0;
$tsm = 0;
$incurso = 0;

$fechaInicio = '2023-02-09';
$fechaFin = '2023-02-09';
$turno = 'M';
if ($turno === 'M') {
    $horaInicio = '07:30:00';
    $horaFin = '19:29:59';
} else {
    $horaInicio = '19:30:00';
    $horaFin = '06:29:59';
    $fechaFin = strtotime($fechaFin . "+ 1 days");
    $fechaFin = date("Y-m-d", $fechaFin);
}

/* echo $fechaInicio . ' - ' . $fechaFin;
echo '<br>';
echo $horaInicio . ' - ' . $horaFin; */

$parametrosReporte = [
    'fechaInicio' => $fechaInicio,
    'horaInicio' => $horaInicio,
    'fechaFin' => $fechaFin,
    'horaFin' => $horaFin,
];

$muestras = $objInfraccion->reporteMuestras($parametrosReporte);
$total = $muestras->rowCount();


$resultados = $objInfraccion->reporteResultados($parametrosReporte);
if ($resultados->rowCount() > 0) {
    while ($fila = $resultados->fetch(PDO::FETCH_OBJ)) {
        $tipoResultado = $fila->result_cuantitativo;
        if ($tipoResultado > 0) $positivos++;
        if ($tipoResultado === 0) $negativos++;
        if ($tipoResultado === 'T/S/M') $tsm++;
        if ($tipoResultado === 'N') {
            if ($fila->result_cualitativo === 'I')
                $incurso++;
        }
    }
}
$respuesta = ['total' => $total, 'positivos' => $positivos, 'negativos' => $negativos, 'TSM' => $tsm, 'incurso' => $incurso];
echo json_encode($respuesta);
echo '<br>';

$tabla = '<table>';
$tabla .= '<tr>';
$tabla .= '<td>TOTAL DE MUESTRAS TOMADAS</td>';
$tabla .= '<td>' . $total . '</td>';
$tabla .= '<tr>';
$tabla .= '<tr>';
$tabla .= '<td>POSITIVOS</td>';
$tabla .= '<td>' . $positivos . '</td>';
$tabla .= '<tr>';

$tabla .= '<tr>';
$tabla .= '<td>NEGATIVOS</td>';
$tabla .= '<td>' . $negativos . '</td>';
$tabla .= '<tr>';

$tabla .= '<tr>';
$tabla .= '<td>T/S/M</td>';
$tabla .= '<td>' . $tsm . '</td>';
$tabla .= '<tr>';

$tabla .= '<tr>';
$tabla .= '<td>INCURSO</td>';
$tabla .= '<td>' . $incurso . '</td>';
$tabla .= '<tr>';
$tabla .= '</table>';


echo $tabla;
