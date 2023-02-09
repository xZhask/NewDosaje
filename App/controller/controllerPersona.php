<?php
require_once '../model/clsPersona.php';
$accion = $_POST['accion'];
controlador($accion);

function controlador($accion)
{
    $objPersona = new ClsPersona();

    switch ($accion) {
        case 'CONSULTA_DNI':
            $dni = $_POST['dni'];
            $token =
                'e49fddfa2a41c2c2f26d48840f7d81a66dc78dc2b0e085742a883f0ab0f84158';
            $url = "https://apiperu.dev/api/dni/$dni?api_token=$token";
            $curl = curl_init();
            $header = [];
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            //para ejecutar los procesos de forma local en windows
            //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
            curl_setopt(
                $curl,
                CURLOPT_CAINFO,
                dirname(__FILE__) . '/cacert-2023-01-10.pem'
            );
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                echo 'cURL Error #:' . $err;
            } else {
                echo $response;
            }
            break;

        case 'BUSCAR_PERSONA':
            $infoPersona = $objPersona->BuscarUsuario($_POST['tipoDoc'], $_POST['nrodoc']);
            $infoPersona = $infoPersona->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($infoPersona);
            break;
        case 'BUSCAR_EMPLEADO':
            $infoPersonal = $objPersona->BuscarPersonal($_POST['idPersona']);
            $infoPersonal = $infoPersonal->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($infoPersonal);
            break;
        case 'CARGAR_PROFESIONALES':
            $listaProfesionales = $objPersona->listarProfesionales($_POST['tipoProfesional']);
            $listaProfesionales = $listaProfesionales->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($listaProfesionales);
            break;
        case 'LISTAR_PERSONAL':
            $listaPersonal = $objPersona->listarPrersonal();
            $listaPersonal = $listaPersonal->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($listaPersonal);
            break;
        case 'LOGIN':
            $pass = $_POST['pass'];
            $nroDoc = $_POST['user'];
            $datosLogin = $objPersona->ValidarLogin($nroDoc);
            if ($datosLogin->rowCount() > 0) {
                $datosLogin = $datosLogin->fetch(PDO::FETCH_OBJ);
                $userPass = $datosLogin->pass;
                if (password_verify($pass, $userPass)) {
                    session_start();
                    $_SESSION['active'] = true;
                    $_SESSION['nombre'] = $datosLogin->nombre;
                    $_SESSION['iduser'] =  $datosLogin->id_persona;
                    $_SESSION['idperfil'] =  $datosLogin->id_perfil;
                    $_SESSION['perfil'] =  $datosLogin->perfil;
                    $_SESSION['profesion'] =  $datosLogin->profesion;
                    $_SESSION['nroDoc'] =  $datosLogin->nro_doc;
                    echo 'OK';
                } else {
                    echo 'FAIL';
                }
            }
            //echo json_encode($datosLogin);
            break;
        case 'LOGOUT':
            session_start();
            if (!empty($_SESSION['active']) == true) {
                $_SESSION['active'] = false;
                session_destroy();
                $response = ['respuesta' => 'logout'];
                echo json_encode($response);
            }
            break;
        case 'CAMBIAR_PASS':
            session_start();
            $passActual = $_POST['passActual'];
            $passNueva = $_POST['passNueva'];
            $datosLogin = $objPersona->ValidarLogin($_SESSION['nroDoc']);
            if ($datosLogin->rowCount() > 0) {
                $datosLogin = $datosLogin->fetch(PDO::FETCH_OBJ);
                $userPass = $datosLogin->pass;
                if (password_verify($passActual, $userPass)) {
                    $passNueva = password_hash($passNueva, PASSWORD_DEFAULT, ['cost' => 7]);
                    $datos = [
                        'id_persona' => $_SESSION['iduser'],
                        'pass' => $passNueva,
                    ];
                    $respuesta = $objPersona->UpdatePass($datos);
                } else
                    $respuesta = 'Contraseña Incorrecta';
                $response = ['response' => $respuesta];
                echo json_encode($response);
            }
            break;
        case 'REGISTRAR_PERSONAL':
            $nroDocPersonal = $_POST['nroDocPersonal']; // Usuario Conductor
            $tipoDocPersonal = 7; // COD DNI EN LA BD

            $Persona = $objPersona->BuscarUsuario($tipoDocPersonal, $nroDocPersonal);
            if ($Persona->rowCount() > 0) {
                $respuesta = 'fail';
            } else {
                if (!empty($nroDocPersonal)) {
                    $data = [
                        'id_tipodoc' => $tipoDocPersonal,
                        'nro_doc' => $nroDocPersonal,
                        'nombre' => $_POST['nombrePersonal'],
                        'grado' => $_POST['gradoPersonal'],
                        'nacionalidad' => 'Peruana',
                    ];
                    $idPersona = $objPersona->RegistrarConductor($data);

                    $pass = $_POST['passPersonal'];
                    $pass = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 7]);

                    $datosUser = [
                        'id_persona' => $idPersona,
                        'pass' => $pass,
                        'profesion' => $_POST['profesionPersonal'],
                        'id_perfil' => $_POST['perfilPersonal'],
                    ];
                    $respuesta = $objPersona->RegistrarUsuario($datosUser);
                    //$respuesta = 1;
                } else
                    $respuesta = 'fail';
            }
            $response = ['response' => $respuesta];
            echo json_encode($response);
            break;
        case 'UPDATE_PERSONAL':
            $idPersona = $_POST['idPersona'];
            $passPersonal = $_POST['passPersonal'];
            $parametros = [
                'id_persona' => $idPersona,
                'profesion' => $_POST['profesionPersonal'],
                'id_perfil' => $_POST['perfilPersonal'],
            ];
            $respuesta = $objPersona->UpdatePerfil($parametros);
            if ($respuesta > 0) {
                if (!empty($passPersonal)) {
                    $pass = password_hash($passPersonal, PASSWORD_DEFAULT, ['cost' => 7]);
                    $datosPass = [
                        'id_persona' => $idPersona,
                        'pass' => $pass,
                    ];
                    $objPersona->UpdatePass($datosPass);
                }
            } else $respuesta = 'fail';

            $response = ['response' => $respuesta];
            echo json_encode($response);
            break;
        case 'UPDATE_ESTADO':
            $idPersona = $_POST['idPersona'];
            $infoPersonal = $objPersona->BuscarPersonal($idPersona);
            $infoPersonal = $infoPersonal->fetch(PDO::FETCH_OBJ);
            $estado = $infoPersonal->estado;

            $newEstado = ($estado === 'A') ? 'I' : 'A';

            $parametros = [
                'id_persona' => $idPersona,
                'estado' => $newEstado,
            ];
            $respuesta = $objPersona->UpdateEstado($parametros);
            if ($respuesta < 1)
                $respuesta = 'fail';
            $response = ['response' => $respuesta];
            echo json_encode($response);
            break;
    }
}
/*
case 'CAMBIAR_PASS':
            $pass = $_POST['pass1'];
            $pass = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 7]);
            $usuario = [
                'dni' => $_POST['IdUsuario'],
                'pass' => $pass
            ];
            $objPersonal->CambiarPass($usuario);
            echo 'SE ACTUALIZÓ LA INFORMACIÓN';
            break;

case 'VALIDAR_LOGIN':
            $pass = $_POST['pass'];
            $usuario = ['user' => $_POST['user']];
            $user_existe = $objPersonal->validarUsuario($usuario);
            if ($user_existe->rowCount() > 0) {
                $user_existe = $user_existe->fetch(PDO::FETCH_NAMED);
                $userPass = $user_existe['pass'];
                if (password_verify($pass, $userPass)) {
                    session_start();
                    $_SESSION['active'] = true;
                    $_SESSION['nombre'] = $user_existe['nombre'];
                    $_SESSION['apellidos'] = $user_existe['apellidos'];
                    $_SESSION['iduser'] = $user_existe['dni'];
                    $_SESSION['cargo'] = $user_existe['idcargo'];
                    echo 'INICIO';
                } else echo 'CONTRASEÑA_INCORRECTA';
            } else {
                echo 'FAIL';
            }
            break;
        case 'LOGOUT':
            session_start();
            $_SESSION['active'] = false;
            session_destroy();
            echo '1';
            break;
*/