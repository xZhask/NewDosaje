<?php
try {
    $manejador = 'mysql'; //'pgsql';
    $servidor = 'localhost';
    $usuario = 'root'; //postgres
    $pass = 'mysql'; //root
    $db = 'dosajedb';
    //$usuario = 'odindeveloper_josue';
    //$pass = 'b(=-.[52yyfy';
    //$db = 'odindeveloper_dbcpms';
    $cadena = "$manejador:host=$servidor;dbname=$db";
    $cnx = new PDO($cadena, $usuario, $pass);
    date_default_timezone_set('America/Lima');
} catch (Exception $ex) {
    echo 'Error de acceso, informelo a la brevedad :' . $ex;
    exit();
}
