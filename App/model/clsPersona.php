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
    function listarPrersonal()
    {
        $sql = 'SELECT p.id_persona, p.nro_doc,p.nombre,p.grado,u.profesion,pf.perfil FROM usuario u INNER JOIN persona p ON u.id_persona=p.id_persona INNER JOIN perfil pf ON u.id_perfil=pf.id_perfil';
        global $cnx;
        return $cnx->query($sql);
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
    function ValidarLogin($nroDoc)
    {
        $sql = 'SELECT u.id_persona,p.nro_doc,,u.id_perfil,u.profesion,u.pass,p.nombre,pf.perfil FROM usuario u INNER JOIN persona p ON u.id_persona=p.id_persona INNER JOIN perfil pf ON pf.id_perfil=u.id_perfil WHERE p.nro_doc=:nro_doc';
        global $cnx;
        $parametros = [
            ':nro_doc' => $nroDoc,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarUsuario($datosUser)
    {
        $sql = 'INSERT INTO usuario(id_persona, pass, profesion, id_perfil, estado) VALUES (:id_persona, :pass, :profesion, :id_perfil, :estado)';
        global $cnx;
        $parametros = [
            ':id_persona' => $datosUser['id_persona'],
            ':pass' => $datosUser['pass'],
            ':profesion' => $datosUser['profesion'],
            ':id_perfil' => $datosUser['id_perfil'],
            ':estado' => 'A',
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarUsuario($datosUser)
    {
        $sql = 'UPDATE usuario SET pass=:passWHERE id_persona=:id_persona';
        global $cnx;
        $parametros = [
            ':id_persona' => $datosUser['id_persona'],
            ':pass' => $datosUser['pass'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre->rowCount();
    }
}

/*
UPDATE usuario SET pass='[value-2]' WHERE id_persona='[value-1]'
*/