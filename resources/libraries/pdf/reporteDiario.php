<?php
require_once '../../../App/model/clsInfraccion.php';
require_once '../../../App/model/clsPersona.php';

function getPlantilla($fechaInicio, $turno)
{
    $objInfraccion = new clsInfraccion();
    $objPersona = new clsPersona();

    //$fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $fechaInicio;
    //$turno = $_POST['turno'];

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

    $resultados = reporteResultadoFechas($fechaInicio, $horaInicio, $fechaFin, $horaFin);
    $plantilla = '<body>';
    $plantilla .= '<h1>Muestras tomadas el ' . date("d-m-Y", strtotime($fechaInicio)) . '</h1>';
    $plantilla .= '<table>';
    $plantilla .= '<thead>';
    $plantilla .= '<tr>';
    $textoMuestra = ($turno === 'N') ? 'Noche' : 'Muestra';
    $plantilla .= '<th>' . $textoMuestra . '</th>';
    $plantilla .= '<th>Total</th>';
    $plantilla .= '<th>#</th>';
    $plantilla .= '<th>Comisiones</th>';
    $plantilla .= '</tr>';
    $plantilla .= '</thead>';
    $plantilla .= '<tbody>';
    $plantilla .= $resultados;
    $plantilla .= '<tr>';
    $plantilla .= '<td class="td-fill">Total de muestras tomadas</td>';
    $plantilla .= '<td class="td-fill t-center">' . $total . '</td>';
    $plantilla .= '</tr></tbody></table>';

    if ($turno === 'N') {
        $horaInicio = '00:00:01';
        $horaFin = '07:29:59';
        $muestrasMadrugada = reporteMuestrasFechas($fechaInicio, $horaInicio, $fechaFin, $horaFin);
        $totalMadrugada = $muestrasMadrugada->rowCount();

        $resultadosMadrugada = reporteResultadoFechas($fechaInicio, $horaInicio, $fechaFin, $horaFin);
        if ($totalMadrugada > 0) {
            $plantilla .= '<table class="t_listado"><thead>';
            $plantilla .= '<tr>
                            <th>Madrugada</th>
                            <th>Total</th>
                            <th>#</th>
                            <th>Comisiones</th>
                                </tr>
                        </thead>';
            $plantilla .= $resultadosMadrugada;
            $plantilla .= '<tr>';
            $plantilla .= '<td class="td-fill">Total de muestras tomadas</td>';
            $plantilla .= '<td class="td-fill t-center">' . $totalMadrugada . '</td>';
            $plantilla .= '</tr></tbody></table>';
        }
    }
    $plantilla .= '</body>';
    return $plantilla;
}
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
    $positivos = 0;
    $negativos = 0;
    $tsm = 0;
    $incurso = 0;
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
    $tabla .= '<td class="t-center">' . $positivos . '</td>';
    $tabla .= '<td rowspan="5"></td>';
    $tabla .= '<td rowspan="5"></td>';
    $tabla .= '</tr>';

    $tabla .= '<tr>';
    $tabla .= '<td>NEGATIVOS</td>';
    $tabla .= '<td class="t-center">' . $negativos . '</td>';
    $tabla .= '</tr>';

    $tabla .= '<tr>';
    $tabla .= '<td>T/S/M</td>';
    $tabla .= '<td class="t-center">' . $tsm . '</td>';
    $tabla .= '</tr>';

    $tabla .= '<tr>';
    $tabla .= '<td>INCURSO</td>';
    $tabla .= '<td class="t-center">' . $incurso . '</td>';
    $tabla .= '</tr>';

    return $tabla;
}
