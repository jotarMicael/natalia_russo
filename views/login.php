<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

require_once '../utils/const.php';

if (!empty($_POST)) {
 
  require_once ROOTPATH . '/controller/UserController.php';

  $userController = new UserController();

  $result = $userController->login();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/dist/img/logo_nati.jpg">
  <title><?php echo HEAD; ?> | Iniciar Sesión</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/colors.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#" style="color: #d81b60;"><b><?php echo substr(SYSTEM_NAME,0,4); ?></b><?php echo substr(SYSTEM_NAME,4); ?></a>
     
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
      <p class="login-box-msg">Iniciar Sesión<br><img src="<?php echo BASE_URL; ?>/dist/img/logo_nati.jpg" width="40%" alt="Naty"></p>
        
        
        <form action="#" method="post" class="form-horizontal">
          <div class="input-group mb-3">
            <input name="username" type="username" class="form-control" value="<?php echo $_POST ? $_POST['username'] : ''; ?>" placeholder="Usuario">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            <?php if (isset($result['username'])) { ?>
              <?php foreach ($result['username'] as $error) { ?>
                <div class="invalid-feedback d-block"><?php echo $error; ?></div>
              <?php } ?>
            <?php } ?>
          </div>
          <div class="input-group mb-3">
            <input name="password" type="password" class="form-control" value="<?php echo $_POST ? $_POST['password'] : ''; ?>" placeholder="Contraseña">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <?php if (isset($result['password'])) { ?>
              <?php foreach ($result['password'] as $error) { ?>
                <div class="invalid-feedback d-block"><?php echo $error; ?></div>
              <?php } ?>
            <?php } ?>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn bg-orange btn-block">Ingresar</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?php echo BASE_URL; ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo BASE_URL; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo BASE_URL; ?>/dist/js/adminlte.min.js"></script>
</body>

</html>