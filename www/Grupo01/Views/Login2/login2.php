<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Abel OSH">
    <meta name="theme-color" content="#009688">
    <link rel="shortcut icon" href="<?= media();?>/images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/style.css">
    
    <title><?= $data['page_tag']; ?></title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1><?= $data['page_title']; ?></h1>
      </div>
      <div class="login-box">
        <div id="divLoading" >
          <div>
            <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
          </div>
        </div>
        <form class="login-form" name="formLogin" id="formLogin" action="">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>INICIAR SESIÓN</h3>
          <div class="form-group">
            <label class="control-label">USUARIO</label>
            <input id="txtUser" name="txtUser" class="form-control" type="text" placeholder="Usuario" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">CONTRASEÑA</label>
            <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Contraseña">
          </div>
          <div>
            <label class="control-label">Habilitar Google Authenticator</label>
            <input id="enableAuthenticator" type="checkbox">
          </div>
          <div id="authenticatorDiv" class="form-group" style="display:none;">
            <input id="clave" name="clave" class="form-control" type="password" placeholder="XXXXXX" maxlength="9" minlength="9" oninput="checkAuthenticatorCode()">
          </div>
          <div id="alertLogin" class="text-center"></div>
          <div class="form-group btn-container">
            <button id="loginButton" type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> INICIAR SESIÓN</button>
          </div>
        </form>
      </div>
    </section>
    <script>
        const base_url = "<?= base_url(); ?>";
    </script>

     <script>
      document.addEventListener('DOMContentLoaded', function () {
          var enableAuthenticatorCheckbox = document.getElementById('enableAuthenticator');
          var authenticatorDiv = document.getElementById('authenticatorDiv');
          var authenticatorInput = document.getElementById('clave');
          var loginButton = document.getElementById('loginButton');
          var validAuthenticatorCodes = ['L00406124', 'L00406001', 'L00405528'];

          enableAuthenticatorCheckbox.addEventListener('change', function () {
              authenticatorDiv.style.display = enableAuthenticatorCheckbox.checked ? 'block' : 'none';

              // Habilitar/deshabilitar el botón según el estado del checkbox y la clave
              if (!enableAuthenticatorCheckbox.checked || validAuthenticatorCodes.includes(authenticatorInput.value)) {
                  loginButton.disabled = false;
              } else {
                  loginButton.disabled = true;
              }
          });

          authenticatorInput.addEventListener('input', function () {
              // Habilitar/deshabilitar el botón según la clave
              if (!enableAuthenticatorCheckbox.checked || validAuthenticatorCodes.includes(authenticatorInput.value)) {
                  loginButton.disabled = false;
              } else {
                  loginButton.disabled = true;
              }
          });
      });
    </script>


    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/fontawesome.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>
    <script type="text/javascript" src="<?= media();?>/js/plugins/sweetalert.min.js"></script>
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
  </body>
</html>