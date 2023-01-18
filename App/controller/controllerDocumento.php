<?php
require_once '../model/clsDocumento.php';
$accion = $_POST['accion'];
controlador($accion);

function controlador($accion)
{
    $objDocumento = new ClsDocumento();

    switch ($accion) {

        case 'LISTAR_TIPODOC':
            $tipoDoc = $objDocumento->listarTipoDocumento();
            $tipoDoc = $tipoDoc->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($tipoDoc);
            break;
    }
}
