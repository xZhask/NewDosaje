<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: login.php');
}
$perfil = $_SESSION['idperfil'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <link rel="stylesheet" href="resources/js/jquery-ui-1.13.2/jquery-ui.min.css">
    <link rel="stylesheet" href="resources/js/sweetalert2.min.css">
    <link rel="stylesheet" href="resources/css/style.css">
    <script src="https://kit.fontawesome.com/47b4aaa3bf.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="resources/img/test.svg" />
    <title>Dosaje</title>
</head>

<body>
    <div class="wrapper">
        <header class="header">
            <nav>
                <ul class="list_menu">
                    <li><a href="/muestra.html" class="lnk-menu" id="lnk-muestra">
                            <img src="resources/img/test.svg" alt="">
                            <p>Muestra</p>
                        </a>
                    </li>
                    <li><a class="lnk-menu">
                            <img src="resources/img/chart.svg" alt="">
                            <p>Reportes</p>
                        </a>
                        <ul class="list-toggle">
                            <li><a href="/reporteturno.html" id="lnk-reporteTurno">Consolidado</a></li>
                            <!--<li><a href="/reporteperiodo.html" id="lnk-reportePeriodo">Rep. por Periodo</a></li>-->
                            <li><a href="/reportegeneral.html" id="lnk-reporteGeneral">Rep. General</a></li>
                        </ul>
                    </li>
                    <? if ($perfil === '1') { ?>
                        <li><a href="/usuarios.html" class="lnk-menu" id="lnk-usuarios">
                                <img src="resources/img/users.svg" alt="">
                                <p>Usuarios</p>
                            </a>
                        </li>
                    <? } ?>
                </ul>
            </nav>
            <div class="cont_perfil">
                <div class="info_perfil">
                    <p><? echo $_SESSION['nombre']; ?></p>
                    <span class="cargo"><? echo $_SESSION['perfil']; ?></span>
                </div>
                <div class="avatar">
                    <img src="resources/img/UserConf.svg" alt="">
                </div>
                <div class="options_perfil">
                    <ul>
                        <li id="btnCambioPass">
                            <img src="resources/img/reset_pass.svg" alt="">
                            <p>Cambiar Contraseña</p>
                        </li>
                        <li id="btnOff">
                            <img src="resources/img/btn_off.svg" alt="">
                            <p>Cerrar sesión</p>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <div class="content">
            <div class="section_view" id="section_view">
            </div>
        </div>
        <div id="bg-modal" class="bg-modal">
            <div class="modal-dialog">
                <a href="" class="closeModal close-modal-area"></a>
                <div id="modal-content" class="modal-content">
                    <div class="modal_head">
                        <a href="" class="close_btn closeModal">x</a>
                    </div>
                    <div class="modal_form" id="modal_form">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="resources/js/jquery-3.6.0.min.js"></script>
    <script src="resources/js/jquery-ui-1.13.2/jquery-ui.min.js"></script>
    <script src="resources/js/sweetalert2.all.min.js"></script>
    <script src="resources/js/main.js"></script>
</body>

</html>