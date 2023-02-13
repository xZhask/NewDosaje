<?php
require_once '../../../App/model/clsInfraccion.php';

function getPlantilla($IdHojaRegistro)
{
    $objIncidencia = new clsInfraccion();

    $listado = $objIncidencia->buscarInfraccion($IdHojaRegistro);
    $fila = $listado->fetch(PDO::FETCH_NAMED);
    $idInfraccion = $fila['id_infraccion'];
    $extraccion = $objIncidencia->buscarExtraccion($idInfraccion);
    //EXTRACCIÓN
    $muestra = '';
    $fechaExtraccion = '';
    $hrsTranscurridas = '';
    $Extractor = '';
    $observacion = '';
    $horaExtraccion = '';
    if ($extraccion->rowCount() > 0) {
        $extraccion = $extraccion->fetch(PDO::FETCH_NAMED);
        $muestra = $extraccion['tipo_muestra'];
        $fechaExtraccion = $extraccion['fecha_extracc'];
        $horaExtraccion = $extraccion['hora_extracc'];
        $hrsTranscurridas = $extraccion['hrs_transcurridas'];
        $Extractor = $extraccion['extractor'];
        $observacion = $extraccion['observacion'];
    }

    $fecha = $fila['fecha_registro'];

    $fechainfraccion = date_create($fila['fecha_infr']);
    $fechaextraccion = date_create($fechaExtraccion);

    $dia = date("d", strtotime($fecha));
    $mes = date("m", strtotime($fecha));
    $year = date("Y", strtotime($fecha));
    $hora = date("h:i a", strtotime($fecha));

    switch ($mes) {
        case '01':
            $mes = 'ENERO';
            break;
        case '02':
            $mes = 'FEBRERO';
            break;
        case '03':
            $mes = 'MARZO';
            break;
        case '04':
            $mes = 'ABRIL';
            break;
        case '05':
            $mes = 'MAYO';
            break;
        case '06':
            $mes = 'JUNIO';
            break;
        case '07':
            $mes = 'JULIO';
            break;
        case '08':
            $mes = 'AGOSTO';
            break;
        case '09':
            $mes = 'SETIEMBRE';
            break;
        case '10':
            $mes = 'OCTUBRE';
            break;
        case '11':
            $mes = 'NOVIEMBRE';
            break;
        case '12':
            $mes = 'DICIEMBRE';
            break;
    }
    $plantilla = '<body>';
    $plantilla .=   '<h3 class="lugar_com"></h3>';
    $plantilla .= '<div><p class="unidadHR">UNIDAD DESCONCENTRADA DE DOSAJE ETILICO - SEDE ZARATE SJL</p>
                    <table class="filaHR filahoraHR">
                        <tr><td class="horaC">' . $hora . '</td>
                        <td class="diaC">' . $dia . '</td>
                        <td class="mesC">' . $mes . '</td>
                        <td class="yearC">' . $year . '</td>
                        </tr>
                    </table>
                    <p class="nombreHR">' . $fila['infractor'] . '</p>
                    <table class="filaHR filaoficio">
                        <tr><td class="nrooficioHR">' . $fila['n_oficio'] . '</td>
                        <td>' . $fila['comisaria'] . '</td>
                        </tr>
                    </table>
                    <p class="usuarioHR">' . $fila['digitador'] . '</p>
                    <p class="nacionalidadHR">' . $fila['nacionalidad'] . '</p>
                    <table class="filaHR filadatosinf">
                        <tr><td class="nrodocHR">' . $fila['tipo_doc'] . ': ' . $fila['nro_doc'] . '</td>
                        <td >' . $fila['edad'] . '</td>
                        </tr>
                    </table>
                    <table class="filaHR datoslicenciaHR">
                        <tr><td class="licenciaHR">' . $fila['lic_conducir'] . '</td>
                        <td class="claseHR">' . $fila['clase'] . '</td>
                        <td class="vehiculoHR">' . $fila['vehiculo'] . '</td>
                        <td>' . $fila['placa'] . '</td>
                        </tr>
                    </table>
                    <p class="motivoHR">' . $fila['Motivo'] . '</p>
                    <table class="filaHR datosinfraccionHR">
                        <tr><td class="hora_infraccionHR">' . $fila['hora_infr'] . '</td>
                        <td class="fecha_infraccionHR">' . date_format($fechainfraccion, 'd-m-Y') . '</td></tr>
                    </table>
                    <table class="filaHR datosextraccionHR">
                        <tr><td class="hora_extraccionHR">' . $horaExtraccion . '</td>
                        <td class="fecha_extraccionHR">' . date_format($fechaextraccion, 'd-m-Y') . '</td></tr>
                    </table>
                    <p class="conductorHR">' . $fila['grado'] . ' ' . $fila['conductor'] . '</p>
                    </div>';
    $plantilla .= '</body>';
    return $plantilla;
}
