<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

require_once '../../utils/const.php';
require_once ROOTPATH . '/controller/SessionController.php';
SessionController::mustBeLoggedIn();

if (!empty($_POST)) {
  require_once ROOTPATH . '/controller/StudentController.php';
  $studentController = new StudentController();
  $result = $studentController->update_social_fee($_GET['id'], $_POST['share_date'], $_POST['import'], $_POST['student_id']);
  $social_fee = $studentController->get_student_social_fee($_GET['id']);
} elseif (!empty($_GET)) {
  require_once ROOTPATH . '/controller/StudentController.php';
  $studentController = new StudentController();
  $social_fee = $studentController->get_student_social_fee($_GET['id']);
} else {

  header('Location: ' . BASE_URL . 'views/students/students.php');
  die();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo HEAD; ?> | AC</title>
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/dist/img/logo_nati.jpg">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/adminlte.min.css?v=3.2.0">
  <script src="<?php echo BASE_URL; ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

  <div class="wrapper">
    <!-- Navbar -->

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php require_once ROOTPATH . '/common/navbar.php' ?>

    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper">

      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">


            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">

          <div class="row">

            <div class="col-12 d-flex justify-content-around">
              <?php if ($social_fee[0] != 3) { ?>
                <div class="col-7">
                  <div class="card card-maroon">
                    <div class="card-header">
                      <h3 class="card-title">Actualizar cuota <strong><?= $social_fee['share_date'] ?></strong> del alumno: <strong><?= $social_fee['name'] . ' ' . $social_fee['surname'] . ' #' .  $social_fee['student_id'] ?></strong></h3>
                    </div>
                    <div class="card-body">
                      <div class="container">
                        <div class="row justify-content-around">
                          <div class="col-6">
                            <form id="update_social_fee" method="post" href="#">
                              <div class="form-group">
                                <label>Fecha</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                  </div>
                                  <input required name="share_date" type="text" value="<?= $social_fee['share_date'] ?>" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/yyyy" data-mask>
                                </div>
                                <!-- /.input group -->
                              </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label>Importe</label>

                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                </div>
                                <input type="number" step="0.01" min="0" required name="import" value="<?= $social_fee['import'] ?>" class="form-control">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <input type="hidden" name="student_id" id="student_id" value="<?= $social_fee['student_id'];  ?>">
                      </form>
                      <button onclick="return update_pay();" type="submit" class="btn bg-success"><i class="fas fa-money-check-alt mr-1"></i>Actualizar</button>
                    </div>
                  </div>
                </div>
                <div class="col-5">

                  <?php
                  
                  if ($result[0] == 1) {
                    include ROOTPATH . '/common/alert_success.php';
                    unset($_POST);
                  } elseif ($result[0] == 2) {

                    include ROOTPATH . '/common/alert_warning.php';
                  } elseif ($result[0] == 3) {

                    include ROOTPATH . '/common/alert_danger.php';
                  }
                  unset($result);
                  ?>
                </div>
              <?php } else {
                $result[1] = $social_fee[1];
              ?>
                <div class="col-12">
                <?php
                include ROOTPATH . '/common/alert_danger.php';
              } ?>
                </div>
            </div>
            <div class="col-2 mb-2"><a type="button" href="<?php echo BASE_URL; ?>views/students/pay_social_fee.php?id=<?= $social_fee['student_id']; ?>" class="btn btn-block bg-maroon btn-sm"><i class="fas fa-arrow-left"></i>Volver</a></div>
          </div>

        </div>

      </section>

    </div>
    <!-- /.content-wrapper -->

    <?php require_once ROOTPATH . '/common/footer.php' ?>

  </div>
  <script src="<?php echo BASE_URL; ?>/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/moment/moment.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/inputmask/jquery.inputmask.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/dist/js/adminlte.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/dist/js/confirm.js"></script>
  <script src="<?php echo BASE_URL; ?>/dist/js/dont_forward.js"></script>




  <!-- Page specific script -->
  <script>
    function update_pay() {

      return confirm('#update_social_fee', false);

    }
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('mm/yyyy', {
        'placeholder': 'mm/yyyy'
      })

      //Money Euro
      $('[data-mask]').inputmask()

    })
  </script>

</body>

</html>