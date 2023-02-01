<?php
require_once 'conexion.php';

class clsPersona
{
    function BuscarUsuario($tipoDoc, $nrodoc)
    {
        $sql = 'SELECT id_persona, nombre as nombre_completo,edad,grado,lic_conducir,sexo,nacionalidad FROM persona WHERE nro_doc=:nrodoc AND id_tipodoc=:id_tipodoc';
        global $cnx;
        $parametros = [
            ':id_tipodoc' => $tipoDoc,
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
    function RegistrarInfractor($DatosPersona)
    {
        $sql = 'INSERT INTO persona(id_tipodoc, nro_doc, nombre, edad, lic_conducir, sexo, nacionalidad) VALUES(:id_tipodoc, :nro_doc, :nombre, :edad, :lic_conducir, :sexo, :nacionalidad)';

        $parametros = [
            ':id_tipodoc' => $DatosPersona['id_tipodoc'],
            ':nro_doc' => $DatosPersona['nro_doc'],
            ':nombre' => $DatosPersona['nombre'],
            ':edad' => $DatosPersona['edad'],
            ':lic_conducir' => $DatosPersona['lic_conducir'],
            ':sexo' => $DatosPersona['sexo'],
            ':nacionalidad' => $DatosPersona['nacionalidad'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        if ($pre->rowCount() > 0) return $cnx->lastInsertId();
    }
    function ActualizarDatosPersona($DatosPersona)
    {
        $sql = 'UPDATE persona SET edad=:edad,lic_conducir=:lic_conducir WHERE id_persona=:id_persona';

        $parametros = [
            ':edad' => $DatosPersona['edad'],
            ':lic_conducir' => $DatosPersona['lic_conducir'],
            ':id_persona' => $DatosPersona['id_persona'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre->rowCount();
    }
    function RegistrarConductor($DatosPersona)
    {
        $sql = 'INSERT INTO persona(id_tipodoc, nro_doc, nombre, grado, nacionalidad) VALUES(:id_tipodoc, :nro_doc, :nombre, :grado, :nacionalidad)';

        $parametros = [
            ':id_tipodoc' => $DatosPersona['id_tipodoc'],
            ':nro_doc' => $DatosPersona['nro_doc'],
            ':nombre' => $DatosPersona['nombre'],
            ':grado' => $DatosPersona['grado'],
            ':nacionalidad' => $DatosPersona['nacionalidad'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        if ($pre->rowCount() > 0) return $cnx->lastInsertId();
    }
}
