<?php
require_once 'conexion.php';

class clsPersona
{
    function BuscarUsuario($nrodoc)
    {
        $sql = 'SELECT id_persona, nombre as nombre_completo,edad,lic_conducir,sexo,nacionalidad FROM persona WHERE nro_doc=:nrodoc';
        global $cnx;
        $parametros = [
            ':nrodoc' => $nrodoc,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function listarProfesionales($tipoP)
    {
        $sql = 'SELECT p.id_persona,p.nombre FROM persona p INNER JOIN usuario u ON p.id_persona=u.id_persona WHERE u.profesion=:profesion';
        global $cnx;
        $parametros = [
            ':profesion' => $tipoP,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
