<?php
require_once 'App/model/clsInfraccion.php';
$objInfraccion = new ClsInfraccion();

$fechaInicio = '2023-02-08';
$fechaFin = '2023-02-08';
$turno = 'N';

if ($turno === 'M') {
    $horaInicio = '07:30:00';
    $horaFin = '19:29:59';
} else {
    $horaInicio = '19:30:00';
    $horaFin = '00:00:00';
    $fechaFin = strtotime($fechaInicio . "+ 1 days");
    $fechaFin = date("Y-m-d", $fechaFin);
}


$muestras = reporteMuestrasFechas($fechaInicio, $horaInicio, $fechaFin, $horaFin);
$total = $muestras->rowCount();

$totalMadrugada = 0;
if ($turno === 'N') {
    $horaInicio = '00:00:01';
    $horaFin = '07:29:59';
    $muestrasMadrugada = reporteMuestrasFechas($fechaInicio, $horaInicio, $fechaFin, $horaFin);
    $totalMadrugada = $muestrasMadrugada->rowCount();
}

$tabla = '<table>';
if ($total > 0 || $totalMadrugada > 0) {
    $resultados = reporteResultadoFechas($fechaInicio, $horaInicio, $fechaFin, $horaFin);
    $tabla .= $resultados;
    $tabla .= '<tr>';
    $tabla .= '<td>TOTAL DE MUESTRAS TOMADAS</td>';
    $tabla .= '<td>' . $total . '</td>';
    $tabla .= '</tr></tbody></table>';

    if ($turno === 'N') {
        $resultadosMadrugada = reporteResultadoFechas($fechaInicio, $horaInicio, $fechaFin, $horaFin);

        if ($totalMadrugada > 0) {
            $tabla .= '<table class="t_listado">';
            $tabla .= '<thead><tr>
                                <th>MADRUGADA</th>
                                <th>Total</th>
                                <th>#</th>
                                <th>Comisiones</th>
                                    </tr>
                            </thead>';
            $tabla .= $resultadosMadrugada;
            $tabla .= '<tr>';
            $tabla .= '<td>TOTAL DE MUESTRAS TOMADAS</td>';
            $tabla .= '<td>' . $totalMadrugada . '</td>';
            $tabla .= '</tr></tbody></table>';
        }
    }
    $response = 1;
    $data = $tabla;
} else {
    $response = 0;
    $data = '<tr><td colspan="4">No se encontraron resultados</td></tr>';
}
$respuesta = ['response' => $response, 'data' => $data];
echo json_encode($respuesta);


function reporteMuestrasFechas($fechaInicio, $horaInicio, $fechaFin, $horaFin)
{
    $objInfraccion = new ClsInfraccion();
    $parametrosReporte = [
        'fechaInicio' => $fechaInicio,
        'horaInicio' => $horaInicio,
        'fechaFin' => $fechaFin,
        'horaFin' => $horaFin,
    ];

    $muestras = $objInfraccion->reporteMuestras($parametrosReporte);
    return $muestras;
}
function reporteResultadoFechas($fechaInicio, $horaInicio, $fechaFin, $horaFin)
{
    $positivos = '-';
    $negativos = '-';
    $tsm = '-';
    $incurso = '-';
    $objInfraccion = new ClsInfraccion();
    $parametrosReporte = [
        'fechaInicio' => $fechaInicio,
        'horaInicio' => $horaInicio,
        'fechaFin' => $fechaFin,
        'horaFin' => $horaFin,
    ];

    $resultados = $objInfraccion->reporteResultados($parametrosReporte);
    if ($resultados->rowCount() > 0) {
        while ($fila = $resultados->fetch(PDO::FETCH_OBJ)) {
            $tipoResultado = $fila->result_cuantitativo;
            if ($tipoResultado > 0) $positivos++;
            else if ($tipoResultado === 0) $negativos++;
            else if ($tipoResultado === 'T/S/M') $tsm++;
            else if ($tipoResultado === 'N') {
                if ($fila->result_cualitativo === 'I')
                    $incurso++;
            }
        }
    }

    $tabla = '';
    $tabla .= '<tr><td>POSITIVOS</td>';
    $tabla .= '<td>' . $positivos . '</td>';
    $tabla .= '<td rowspan="5"></td>';
    $tabla .= '<td rowspan="5"></td>';
    $tabla .= '</tr>';

    $tabla .= '<tr>';
    $tabla .= '<td>NEGATIVOS</td>';
    $tabla .= '<td>' . $negativos . '</td>';
    $tabla .= '</tr>';

    $tabla .= '<tr>';
    $tabla .= '<td>T/S/M</td>';
    $tabla .= '<td>' . $tsm . '</td>';
    $tabla .= '</tr>';

    $tabla .= '<tr>';
    $tabla .= '<td>INCURSO</td>';
    $tabla .= '<td>' . $incurso . '</td>';
    $tabla .= '</tr>';

    return $tabla;
}
