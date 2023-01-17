<?php
require_once '../model/clsComisaria.php';
$accion = $_POST['accion'];
controlador($accion);

function controlador($accion)
{
    $objComisaria = new ClsComisaria();

    switch ($accion) {
        case 'LISTAR_COMISARIAS':
            $comisarias = $objComisaria->listarComisarias();
            $comisarias = $comisarias->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($comisarias);
            break;
    }
}
