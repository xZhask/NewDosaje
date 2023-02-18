<?php
require_once '../model/clsPersona.php';
require_once '../model/clsInfraccion.php';
$accion = $_POST['accion'];
controlador($accion);

function controlador($accion)
{
    $objPersona = new ClsPersona();
    $objInfraccion = new ClsInfraccion();

    switch ($accion) {
        case 'LISTAR_INCIDENCIAS':
            if (empty($_POST['datoSearch']))
                $listaInfracciones = $objInfraccion->listarInfracciones();
            else
                $listaInfracciones = $objInfraccion->filtrarInfraccionUsuario($_POST['datoSearch']);

            //$listaInfracciones = $objInfraccion->filtrarInfracciones($idInfractor);
            $listado = '';
            while ($fila = $listaInfracciones->fetch(PDO::FETCH_NAMED)) {
                $idInfraccion = $fila['id_infraccion'];
                //EXTRACCIÓN
                $muestra = '';
                $fechaExtraccion = '';
                $hrsTranscurridas = '';
                $Extractor = '';
                $observacion = '';
                $extraccion = $objInfraccion->buscarExtraccion($idInfraccion);
                if ($extraccion->rowCount() > 0) {
                    $extraccion = $extraccion->fetch(PDO::FETCH_NAMED);
                    $muestra = $extraccion['tipo_muestra'];
                    $fechaExtraccion = date("d-m-Y", strtotime($extraccion['fecha_extracc'])) . ' ' . $extraccion['hora_extracc'];
                    $hrsTranscurridas = $extraccion['hrs_transcurridas'];
                    $Extractor = $extraccion['extractor'];
                    $observacion = $extraccion['observacion'];
                }
                //PERITAJE
                $colPeritaje = '';
                $colCertificado = '';
                $peritaje = $objInfraccion->buscarPeritaje($idInfraccion);
                $certificados = $objInfraccion->buscarCertificados($idInfraccion);
                if ($peritaje->rowCount() > 0) {
                    $perito = '';
                    $cualitativo = '';
                    $cuantitativo = '';
                    $peritaje = $peritaje->fetch(PDO::FETCH_NAMED);
                    $perito = $peritaje['perito'];
                    if ($perito != NULL) {
                        $busquedaPerito = $objPersona->BuscarPersonal($perito);
                        $busquedaPerito = $busquedaPerito->fetch(PDO::FETCH_NAMED);
                        $perito = $busquedaPerito['nombre'];
                    } else $perito = '-';
                    $cualitativo = $peritaje['cualitativo'];
                    $cuantitativo = $peritaje['cuantitativo'];
                    $classResultado = ($cualitativo == 'POSITIVO') ? 'p-red' : '';
                    $colPeritaje .= '<td class="t_left">';
                    $colPeritaje .= '<p class="' . $classResultado . '"><span>Cualitativo: </span> ' . $cualitativo . '</p>';
                    $colPeritaje .= '<p><span>Cuantitativo: </span> ' . $cuantitativo . '</p>';
                    $colPeritaje .= '<p><span>Perito: </span> ' . $perito . '</p>';
                    $colPeritaje .= '</td>';

                    if ($certificados->rowCount() > 0) {
                        $colCertificado .= '<td class="td-certificado">';
                        while ($row = $certificados->fetch(PDO::FETCH_OBJ)) {
                            if ($row->estado == 'I')
                                $colCertificado .= '<p>' . $row->n_serie . '-'  . $row->n_certificado . '</p><br>';
                            else
                                $colCertificado .= '<button class="lnkCertificado btn-blue">' . $row->n_serie . '-' . $row->n_certificado . '</button><br>';
                        }
                        $colCertificado .= '<button class="bntNewCertificado btnUpdateCertificado">Nuevo Certificado</button></td>';
                    } else $colCertificado .= '<td><button class="bntNewCertificado btnRegCertificado">Reg. Certificado</button></td>';
                } else {
                    $colPeritaje .= '<td><button class="btnRegPeritaje">Registrar Peritaje</button></td>';
                    $colCertificado .= '<td></td>';
                }

                $listado .= '<tr>';
                $listado .= '<td>' . $idInfraccion . '</td>';
                $listado .= '<td class="t_left">';
                $listado .= '<p><span>' . $fila['infractor'] . '</span></p>';
                $listado .= '<p><span>DNI: </span> ' . $fila['nro_doc'] . '</p>';
                $listado .= '<p><span>Edad: </span> ' . $fila['edad'] . '</p>';
                $listado .= '<p><span>Sexo: </span> ' . $fila['sexo'] . '</p>';
                $listado .= '<p><span>Lic. conducir: </span> ' . $fila['lic_conducir'] . '</td>';
                $listado .= '<td class="t_left">';
                $listado .= '<p><span>Vehículo: </span>  ' . $fila['vehiculo'] . '</p>';
                $listado .= '<p><span>Clase: </span>  ' . $fila['clase'] . '</p>';
                $listado .= '<p><span>Placa: </span>  ' . $fila['placa'] . '</p>';
                $listado .= '</td>';
                $listado .= '<td class="t_left">';
                $listado .= '<p><span>N° Oficio: </span>  ' . $fila['n_oficio'] . '</p>';
                $listado .= '<p><span>Comandancia: </span>  ' . $fila['comisaria'] . '</p>';
                $listado .= '<p><span>Motivo: </span>  ' . $fila['Motivo'] . '</p>';
                $listado .= '<p><span>Conducido por: </span>  ' . $fila['conductor'] . '</p>';
                $listado .= '<p><span>Fecha infracción: </span>  ' . date("d-m-Y", strtotime($fila['fecha_infr'])) . ' ' . $fila['hora_infr'] . '</p>';
                $listado .= '</td>';
                $listado .= '<td class="t_left">';
                $listado .= '<p><span>Muestra: </span>  ' . $muestra . '</p>';
                $listado .= '<p><span>Fecha. Ext.: </span> ' . $fechaExtraccion . '</p>';
                $listado .= '<p><span>Hrs. Transcurridas.: </span>  ' . $hrsTranscurridas . '</p>';
                $listado .= '<p><span>Extractor: </span> ' . $Extractor . '</p>';
                $listado .= '</td>';
                $listado .= '<td>' . $observacion . '</td>';
                $listado .= $colPeritaje;
                $listado .= '<td class="t_left">';
                $listado .= '<p><span>Hoja de Registro:</span>  ' . $fila['hoja_registro'] . '</p>';
                $listado .= '<p><span>Digitador:</span>  ' . $fila['digitador'] . '</p>';
                $listado .= '<p><span>Recepción:</span>  ' . date("d-m-Y", strtotime($fila['fecha_recepcion'])) . ' ' . $fila['hora_recepcion'] . '</p>';
                $listado .= '</td>';
                $listado .= $colCertificado;
                $listado .= '</tr>';
            }
            $response = ['listado' => $listado];
            echo json_encode($response);
            break;
        case 'REGISTRAR_INCIDENCIA':
            session_start();
            $nroDocInfractor = $_POST['nroDoc']; // Usuario infractor
            $tipoDoc = $_POST['tipoDoc'];
            $nroDocConductor = $_POST['nroDocConductor']; // Usuario Conductor
            $tipoDocConductor = 7; // COD DNI EN LA BD
            /* INFRACTOR */
            $infractor = $objPersona->BuscarUsuario($tipoDoc, $nroDocInfractor);
            if ($infractor->rowCount() > 0) {
                $infractor = $infractor->fetch(PDO::FETCH_OBJ);
                $idInfractor = $infractor->id_persona;
                $data = [
                    'edad' => $_POST['edad'],
                    'lic_conducir' => $_POST['licConducir'],
                    'id_persona' => $idInfractor
                ];
                $objPersona->ActualizarDatosPersona($data);
            } else {
                $data = [
                    'id_tipodoc' => $tipoDoc,
                    'nro_doc' => $nroDocInfractor,
                    'nombre' => $_POST['nombre'],
                    'edad' => $_POST['edad'],
                    'sexo' => $_POST['sexo'],
                    'lic_conducir' => $_POST['licConducir'],
                    'nacionalidad' => $_POST['nacionalidad'],
                ];
                $idInfractor = $objPersona->RegistrarInfractor($data);
            }

            /* CONDUCTOR */
            $conductor = $objPersona->BuscarUsuario($tipoDocConductor, $nroDocConductor);
            if ($conductor->rowCount() > 0) {
                $conductor = $conductor->fetch(PDO::FETCH_OBJ);
                $idConductor = $conductor->id_persona;
            } else {
                if (!empty($nroDocConductor)) {
                    $data = [
                        'id_tipodoc' => $tipoDocConductor,
                        'nro_doc' => $nroDocConductor,
                        'nombre' => $_POST['nombreConductor'],
                        'grado' => $_POST['gradoConductor'],
                        'nacionalidad' => 'Peruana',
                    ];
                    $idConductor = $objPersona->RegistrarConductor($data);
                }
            }
            $dataIncidencia = [
                'hoja_registro' => $_POST['hojaRegistro'],
                'Motivo' => $_POST['motivo'],
                'fecha_infr' => $_POST['fechaInfraccion'],
                'hora_infr' => $_POST['horaInfraccion'],
                'vehiculo' => $_POST['vehiculo'],
                'clase' => $_POST['clase'],
                'placa' => $_POST['placa'],
                'n_oficio' => $_POST['nroOficio'],
                'id_comandancia' => $_POST['idComisaria'],
                'hora_recepcion' => $_POST['horaRecepcion'],
                'fecha_recepcion' => $_POST['fechaRecepcion'],
                'infractor' => $idInfractor,
                'digitador' => $_SESSION['iduser'],
                'personal_conductor' => $idConductor,
                'lugar_incidencia' => $_POST['lugarComision'],
            ];
            $idInfraccion = $objInfraccion->RegistrarInfraccion($dataIncidencia);

            if ($idInfraccion > 0) {
                $fechaInfraccion = new DateTime($_POST['fechaInfraccion'] . ' ' . $_POST['horaInfraccion']);
                $fechaExtraccion = new DateTime($_POST['fechaExtraccion'] . ' ' . $_POST['horaExtraccion']);
                $horasTranscurridas = $fechaInfraccion->diff($fechaExtraccion);
                $horasTranscurridas = $horasTranscurridas->format('%H:%i');

                $dataExtraccion = [
                    'tipo_muestra' => $_POST['tipoMuestra'],
                    'hora_extracc' => $_POST['horaExtraccion'],
                    'fecha_extracc' => $_POST['fechaExtraccion'],
                    'hrs_transcurridas' => $horasTranscurridas,
                    'extractor' => $_POST['idExtractor'],
                    'id_infraccion' => $idInfraccion,
                    'observacion' => $_POST['observacion'],
                ];
                $objInfraccion->RegistrarExtraccion($dataExtraccion);

                if ($_POST['tipoProcedimiento'] != 'E') {
                    $dataPeritaje = [
                        'result_cualitativo' => $_POST['cualitativo'],
                        'result_cuantitativo' => $_POST['cuantitativo'],
                        'perito' => NULL,
                        'id_infraccion' => $idInfraccion,
                    ];
                    $objInfraccion->RegistrarPeritaje($dataPeritaje);
                }
                $respuesta = $idInfraccion;
            } else $respuesta = 0;
            $response = ['response' => $respuesta,];
            echo json_encode($response);
            break;
        case 'BUSCAR_INFRACCION':
            $idInfraccion = $_POST['idInfraccion'];
            $infraccion = $objInfraccion->buscarInfraccion($idInfraccion);
            $infraccion = $infraccion->fetchAll(PDO::FETCH_NAMED);

            $extraccion = $objInfraccion->buscarExtraccion($idInfraccion);
            if ($extraccion->rowCount() > 0) {
                $extraccion = $extraccion->fetch(PDO::FETCH_OBJ);
            } else
                $extraccion = [];
            $peritaje = $objInfraccion->buscarPeritaje($idInfraccion);
            if ($peritaje->rowCount() > 0) {
                $peritaje = $peritaje->fetch(PDO::FETCH_OBJ);
            } else
                $peritaje = [];

            $response = ['infraccion' => $infraccion, 'extraccion' => $extraccion, 'peritaje' => $peritaje];
            echo json_encode($response);
            break;
        case 'REGISTRAR_PERITAJE':
            $datosPeritaje = [
                'result_cualitativo' => $_POST['cualitativo'],
                'result_cuantitativo' => $_POST['cuantitativo'],
                'perito' => $_POST['idPerito'],
                'id_infraccion' => $_POST['idInfraccion'],
            ];
            $idPeritaje = $objInfraccion->RegistrarPeritaje($datosPeritaje);
            $response = ($idPeritaje > 0) ? $idPeritaje : 0;
            $respuesta = ['response' => $response];
            echo json_encode($respuesta);
            break;
        case 'REGISTRAR_CERTIFICADO':
            $idIfraccion = $_POST['idInfraccion'];
            //if (!empty($idInfraccion))
            $objInfraccion->AnularCertificados($idIfraccion);
            $datosCertificado = [
                'n_certificado' => $_POST['nroCertificado'],
                'n_serie' => $_POST['nroSerie'],
                'id_infraccion' => $idIfraccion,
            ];
            $RegCertificado = $objInfraccion->RegistrarCertificado($datosCertificado);
            $response = ($RegCertificado > 0) ? 1 : 0;
            $respuesta = ['response' => $response];
            echo json_encode($respuesta);
            break;
        case 'REPORTE_RESULTADOS':
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFin = $_POST['fechaInicio'];
            $turno = $_POST['turno'];

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

            $tabla = '<table>';
            $tabla .= $resultados;
            $tabla .= '<tr>';
            $tabla .= '<td>TOTAL DE MUESTRAS TOMADAS</td>';
            $tabla .= '<td>' . $total . '</td>';
            //$tabla .= '<td></td>';
            //$tabla .= '<td></td>';
            $tabla .= '</tr></tbody></table>';

            if ($turno === 'N') {
                $horaInicio = '00:00:01';
                $horaFin = '07:29:59';
                $muestrasMadrugada = reporteMuestrasFechas($fechaInicio, $horaInicio, $fechaFin, $horaFin);
                $totalMadrugada = $muestrasMadrugada->rowCount();

                $resultadosMadrugada = reporteResultadoFechas($fechaInicio, $horaInicio, $fechaFin, $horaFin);
                if ($totalMadrugada > 0) {
                    $tabla .= '<table class="t_listado"><thead>';
                    $tabla .= '<tr>
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
            $respuesta = ['response' => $tabla];
            echo json_encode($respuesta);
            break;
    }
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
