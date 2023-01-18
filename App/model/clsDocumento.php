<?php
require_once 'conexion.php';

class clsDocumento
{
    function listarTipoDocumento()
    {
        $sql = 'SELECT * FROM tipo_documento';
        global $cnx;
        return $cnx->query($sql);
    }
}
