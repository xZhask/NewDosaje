<?php
require_once '../model/clsPersona.php';
$accion = $_POST['accion'];
controlador($accion);

function controlador($accion)
{
    $objPersona = new ClsPersona();
    switch ($accion) {
        case 'REG_INCIDENCIA':
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
                if (!isset($tipoDocConductor)) {
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
                ':hoja_registro' => $_POST['hoja_registro'], //
                ':Motivo' => $_POST['motivo'],
                ':fecha_infr' => $_POST['fechaInfraccion'],
                ':hora_infr' => $_POST['horaInfraccion'],
                ':vehiculo' => $_POST['vehiculo'],
                ':clase' => $_POST['clase'],
                ':placa' => $_POST['placa'],
                ':n_oficio' => $_POST['nroOficio'],
                ':id_comandancia' => $_POST['idComisaria'],
                ':hora_registro' => $_POST['horaRecepcion'],
                ':fecha_registro' => $_POST['fechaRecepcion'],
                ':infractor' => $idInfractor,
                ':digitador' => '1',
                ':personal_conductor' => $idConductor,
                ':lugar_incidencia' => '',
                ':n_certificad' => ''
            ];

            $id_infraccion = null;
            $dataExtraccion = [
                'id_infraccion' =>  $id_infraccion,
                'tipoMuestra' =>  $_POST['tipoMuestra'],
                'idExtractor' =>  $_POST['idExtractor'],
                'fechaExtraccion' =>  $_POST['fechaExtraccion'],
                'horaExtraccion' =>  $_POST['horaExtraccion'],
            ];
            $dataPeritaje = [
                'id_infraccion' =>  $id_infraccion,
                'tipoMuestra' =>  $_POST['tipoMuestra'],
                'idPerito' =>  $_POST['idPerito'],
                'cuantitativo' =>  $_POST['cuantitativo'],
                'cualitativo' =>  $_POST['cualitativo'],
            ];
            echo json_encode($dataIncidencia);
            /*
            Si existe -> actualizar
            si no existe -> registrar
            */
            break;
    }
}
