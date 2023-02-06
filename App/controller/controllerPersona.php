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
                    $_SESSION['perfil'] =  $datosLogin->id_perfil;
                    $_SESSION['profesion'] =  $datosLogin->profesion;
                    echo 'OK';
                } else {
                    echo 'FAIL';
                }
            }
            //echo json_encode($datosLogin);
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