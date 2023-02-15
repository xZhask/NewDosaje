<?php
require_once '../../../App/model/clsInfraccion.php';
require_once '../../../App/model/clsPersona.php';

function getPlantilla($fechaInicio, $turno)
{
    $objInfraccion = new clsInfraccion();
    $objPersona = new clsPersona();

    $positivos = 0;
    $negativos = 0;
    $tsm = 0;
    $incurso = 0;

    $fechaInicio = $fechaInicio;
    $fechaFin = $fechaInicio;

    if ($turno === 'M') {
        $horaInicio = '07:30:00';
        $horaFin = '19:29:59';
    } else {
        $horaInicio = '19:30:00';
        $horaFin = '06:29:59';
        $fechaFin = strtotime($fechaInicio . "+ 1 days");
        $fechaFin = date("Y-m-d", $fechaFin);
    }
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
    //$respuesta = ['fecha' => $fechaInicio, 'fecha' => $fechaInicio, 'turno' => $turno];
    $plantilla = '<body>';
    $plantilla .= '<h1>Muestras tomadas el ' . date("d-m-Y", strtotime($fechaInicio)) . '</h1>';
    $plantilla .= '<div class="reporte">';
    $plantilla .= '<table class="t_listado t_reporte">';
    $plantilla .= '<thead>';
    $plantilla .= '<tr>';
    $plantilla .= '<th>Muestra</th>';
    $plantilla .= '<th>Total</th>';
    $plantilla .= '<th>#</th>';
    $plantilla .= '<th>Comisiones</th>';
    $plantilla .= '</tr>';
    $plantilla .= '</thead>';
    $plantilla .= '<tr>';
    $plantilla .= '<td>POSITIVOS</td>';
    $plantilla .= '<td>' . $positivos . '</td>';
    $plantilla .= '<td></td>';
    $plantilla .= '<td></td>';
    $plantilla .= '</tr>';

    $plantilla .= '<tr>';
    $plantilla .= '<td>NEGATIVOS</td>';
    $plantilla .= '<td>' . $negativos . '</td>';
    $plantilla .= '<td></td>';
    $plantilla .= '<td></td>';
    $plantilla .= '</tr>';

    $plantilla .= '<tr>';
    $plantilla .= '<td>T/S/M</td>';
    $plantilla .= '<td>' . $tsm . '</td>';
    $plantilla .= '<td></td>';
    $plantilla .= '<td></td>';
    $plantilla .= '</tr>';

    $plantilla .= '<tr>';
    $plantilla .= '<td>INCURSO</td>';
    $plantilla .= '<td>' . $incurso . '</td>';
    $plantilla .= '<td></td>';
    $plantilla .= '<td></td>';
    $plantilla .= '</tr>';

    $plantilla .= '<tr>';
    $plantilla .= '<td>TOTAL DE MUESTRAS TOMADAS</td>';
    $plantilla .= '<td>' . $total . '</td>';
    $plantilla .= '<td></td>';
    $plantilla .= '<td></td>';
    $plantilla .= '</tr>';
    $plantilla .= '</table>';
    $plantilla .= '</div></body>';
    return $plantilla;
}
