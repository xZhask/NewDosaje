<?php
require_once 'App/model/clsInfraccion.php';
$objInfraccion = new ClsInfraccion();

$positivos = 0;
$negativos = 0;
$tsm = 0;
$resultados = $objInfraccion->reporteResultados();
if ($resultados->rowCount() > 0) {
    while ($fila = $resultados->fetch(PDO::FETCH_OBJ)) {
        $tipoResultado = $fila->result_cuantitativo;
        if ($tipoResultado > 0) $positivos++;
        if ($tipoResultado === 0) $negativos++;
        if ($tipoResultado === 'T/S/M') $tsm++;
    }
}
$respuesta = ['positivos' => $positivos, 'negativos' => $negativos, 'TSM' => $tsm];
echo json_encode($respuesta);
