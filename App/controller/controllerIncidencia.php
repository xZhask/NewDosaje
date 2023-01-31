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

            $infractor = $objPersona->BuscarUsuario($tipoDoc, $nroDocInfractor);
            if ($infractor->rowCount() > 0) {
                $infractor = $infractor->fetch(PDO::FETCH_OBJ);
                $infractor = $infractor->id_persona;
                $data = [
                    'edad' => $_POST['edad'],
                    'licConducir' => $_POST['licConducir'],
                    'id_persona' => $infractor
                ];
                //$infractor = $objPersona->ActualizarDatosPersona($data);
            } else {
                $data = [
                    'tipoDoc' => $tipoDoc,
                    'nroDoc' => $_POST['nroDoc'],
                    'nombre' => $_POST['nombre'],
                    'edad' => $_POST['edad'],
                    'sexo' => $_POST['sexo'],
                    'lic_conducir' => $_POST['licConducir'],
                    'nacionalidad' => $_POST['nacionalidad'],
                ];
                //$infractor = $objPersona->RegistrarInfractor($data);
            }

            //$dataUsuario = ['id_infractor' => $infractor];
            echo json_encode($data);
            /*
            Si existe -> actualizar
            si no existe -> registrar
            */
            break;
    }
}
