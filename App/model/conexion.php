<?php
$manejador = 'mysql'; //'pgsql';
$servidor = 'localhost';
$dbname = 'dosajedb';
$usuario = 'root'; //postgres
$pass = 'mysql'; //root
//$usuario = 'odindeveloper_josue';
//$pass = 'b(=-.[52yyfy';
//$dbname = 'odindeveloper_dbcpms';
try {
    $cadena = "$manejador:host=$servidor;dbname=$dbname";
    $cnx = new PDO($cadena, $usuario, $pass, array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
    date_default_timezone_set('America/Lima');
} catch (PDOException $ex) {
    die('Error de acceso' . $ex->getMessage());
}
