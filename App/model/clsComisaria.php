<?php
require_once 'conexion.php';

class clsComisaria
{
    function listarComisarias()
    {
        $sql = 'SELECT * FROM comandancia';
        global $cnx;
        return $cnx->query($sql);
    }
}
