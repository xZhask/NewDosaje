<?php
session_start();
if (!empty($_SESSION['active']) == true) {
  header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,800;1,100&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="resources/js/jquery-ui-1.13.2/jquery-ui.min.css" />
  <link rel="stylesheet" href="resources/js/sweetalert2.min.css">
  <script language="javascript" src="resources/js/jquery-3.6.0.min.js"></script>
  <script language="javascript" src="resources/js/jquery-ui-1.13.2/jquery-ui.min.js"></script>

  <link rel="stylesheet" href="resources/css/style.css" />
  <script src="https://kit.fontawesome.com/47b4aaa3bf.js" crossorigin="anonymous"></script>
  <title>LOGIN</title>
  <link rel="icon" type="image/png" href="resources/img/test.svg" />
</head>

<body>
  <div class="wrapper-login">
    <div class="cont-login">
      <div class="cont-logo">
        <h1>DOSAJE ETÍLICO</h1>
        <h2>H. AUGUSTO B. LEGUÍA</h2>
      </div>
      <form class="formlogin" id="frmlogin" method="post" autocomplete="off">
        <h2>INICIO DE SESIÓN</h2>
        <input type="hidden" name="accion" value="VALIDAR_LOGIN">
        <div class="form-control cont-user">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="user" id="user" placeholder="Username" />
        </div>
        <div class="form-control user">
          <i class="fa-solid fa-unlock-keyhole"></i>
          <input type="password" name="pass" id="pass" placeholder="Contraseña" autocomplete="new-password" />
        </div>
        <button type="submit">Ingresar</button>
      </form>
    </div>
    <? //echo password_hash('123', PASSWORD_DEFAULT, ['cost' => 7]);
    ?>
  </div>
  <script src="resources/js/sweetalert2.all.min.js"></script>
  <script language="javascript" src="resources/js/login.js" type="module"></script>
</body>

</html>