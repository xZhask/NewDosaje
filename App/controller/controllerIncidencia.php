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
                $data = [
                    'id_tipodoc' => $tipoDocConductor,
                    'nro_doc' => $nroDocConductor,
                    'nombre' => $_POST['nombreConductor'],
                    'grado' => $_POST['gradoConductor'],
                    'nacionalidad' => 'Peruana',
                ];
                $idConductor = $objPersona->RegistrarConductor($data);
            }

            $dataIncidencia = [
                'idInfractor' => $idInfractor,
                'idConductor' => $idConductor,
                'comisaria' => $_POST['idComisaria'],
                'nroOficio' =>  $_POST['nroOficio'],
                'fechaRecepcion' => $_POST['fechaRecepcion'],
                'horaRecepcion' =>  $_POST['horaRecepcion'],
                'vehiculo' =>  $_POST['vehiculo'],
                'clase' =>  $_POST['clase'],
                'placa' =>  $_POST['placa'],
                'motivo' =>  $_POST['motivo'],
                'fechaInfraccion' =>  $_POST['fechaInfraccion'],
                'horaInfraccion' =>  $_POST['horaInfraccion'],
                'tipoMuestra' =>  $_POST['tipoMuestra'],
                'idExtractor' =>  $_POST['idExtractor'],
                'fechaExtraccion' =>  $_POST['fechaExtraccion'],
                'horaExtraccion' =>  $_POST['horaExtraccion'],
                'observacion' =>  $_POST['observacion'],
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
