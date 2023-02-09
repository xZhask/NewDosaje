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
                'hora_registro' => $_POST['horaRecepcion'],
                'fecha_registro' => $_POST['fechaRecepcion'],
                'infractor' => $idInfractor,
                'digitador' => $_SESSION['iduser'],
                'personal_conductor' => $idConductor,
                'lugar_incidencia' => '',
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
                $respuesta = 1;
            } else $respuesta = 'fail';
            $response = ['response' => $respuesta,];
            echo json_encode($response);
            break;
            /* SELECT id_infraccion, hoja_registro, Motivo, fecha_infr, hora_infr, vehiculo, clase, placa, n_oficio, id_comandancia, hora_registro, fecha_registro, infractor, digitador, personal_conductor, lugar_incidencia, n_certificado FROM infraccion
WHERE id_infraccion=7 */
    }
}
