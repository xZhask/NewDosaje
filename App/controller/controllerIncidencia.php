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

            $infractor = $objPersona->BuscarUsuario($nroDocInfractor);
            if ($infractor->rowCount() > 0) {
                $infractor = $infractor->fetch(PDO::FETCH_OBJ);
                $infractor = $infractor->id_persona;
                $data = [
                    'edad' => $_POST['edad'],
                    'licConducir' => $_POST['licConducir'],
                    'id_persona' => $infractor->id_persona
                ];
                echo json_encode($data);
            } else
                $data = [
                    'tipoDoc' => $_POST['tipoDoc'],
                    'nroDoc' => $_POST['nroDoc'],
                    'nombre' => $_POST['nombre'],
                    'edad' => $_POST['edad'],
                    'sexo' => $_POST['sexo'],
                    'licConducir' => $_POST['licConducir'],
                    'nacionalidad' => $_POST['nacionalidad'],

                ];
            echo json_encode($data);


            /*
Si existe -> actualizar
si no existe -> registrar
 */


            /* $miau = [
                'motivo' => $_POST['motivo'],
                'fechaInfraccion' => $_POST['fechaInfraccion'],
                'horaInfraccion' => $_POST['horaInfraccion'],
                'vehiculo' => $_POST['vehiculo'],
                'placa' => $_POST['placa'],
                'clase' => $_POST['clase'],
                'nroOficio' => $_POST['nroOficio'],
                'idComisaria' => $_POST['idComisaria'],
                'fechaRecepcion' => $_POST['fechaRecepcion'],
                'horaRecepcion' => $_POST['horaRecepcion'],
                'nroDoc' => $_POST['nroDoc'], // Usuario infractor
                'digitador' => 'Digitador',
                'nroDocConductor' => $_POST['nroDocConductor'],
            ];
            echo json_encode($miau); */
            break;
    }
}
