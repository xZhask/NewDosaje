<?php
require_once 'conexion.php';

class clsPersona
{
    function BuscarUsuario($nrodoc)
    {
        $sql = 'SELECT nombre as nombre_completo,edad,lic_conducir,sexo FROM persona WHERE nro_doc=:nrodoc';
        global $cnx;
        $parametros = [
            ':nrodoc' => $nrodoc,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
