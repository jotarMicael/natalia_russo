<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);



require_once '../../utils/const.php';
require_once ROOTPATH . '/controller/SessionController.php';
SessionController::mustBeLoggedIn();

$nav = 'pc';

if (!empty($_POST)) {
  require_once ROOTPATH . '/controller/StudentController.php';
  $studentController = new StudentController();
  if (!empty($_POST['share_id'])) {
    $studentController->generate_fee_pdf($_POST['share_id']);
    die;
  } else {
    $result = $studentController->pay_social_fee($_GET['id'], $_POST['share_date'], $_POST['import']);
    $student = $studentController->get_information_student($_GET['id']);
  }
} elseif (!empty($_GET)) {
  require_once ROOTPATH . '/controller/StudentController.php';
  $studentController = new StudentController();
  $student = $studentController->get_information_student($_GET['id']);
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
  <title><?php echo HEAD; ?> | PC</title>
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/dist/img/logo_nati.jpg">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/adminlte.min.css?v=3.2.0">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/daterangepicker/daterangepicker.css">
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
              <div class="col-7">
                <div class="card card-maroon">
                  <div class="card-header">
                    <h3 class="card-title">Pagar cuota del alumno: <strong><?php echo $student['name'] . ' ' . $student['surname'] . ' #' .  $student['id'] ?></strong></h3>
                  </div>
                  <div class="card-body">
                    <div class="container">
                      <div class="row justify-content-around">
                        <div class="col-6">
                          <form id="pay_social_fee" method="post" href="#">
                            <div class="form-group">
                              <label>Fecha</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input required name="share_date" type="text" value="<?php echo $_POST ? $_POST['share_date'] : ''; ?>" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/yyyy" data-mask>
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
                              <input type="number" step="0.01" min="0" required name="import" value="<?php echo $_POST ? $_POST['import'] : ''; ?>" class="form-control">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">

                    </form>
                    <button onclick="return share_pay();" type="submit" class="btn bg-success"><i class="fas fa-money-check-alt mr-1"></i>Abonar</button>
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
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header"> <strong><i class="fas fa-money-check-alt mr-1"></i> Cuotas abonadas</strong></div>
                <!-- /.card-header -->
                <div class="card-body">
                  <?php if (!empty($student['shares'])) { ?>
                    <table id="example1" class="table table-bordered table-striped table-hover table-sm">
                      <thead>
                        <tr>
                          <th>Nombre completo</th>
                          <th>Fecha cuota</th>
                          <th>Importe abonado</th>
                          <th>Fecha pago</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $shares = explode(",", $student['shares']);
                        foreach (explode(",", $student['shares']) as $share) {
                          $share = explode(":", $share); ?>
                          <tr>
                            <td class="text-right"><?= $student['name'] . ' ' . $student['surname'] ?></td>
                            <td class="text-right"><?php echo $share[0]; ?></td>
                            <td class="text-right"><?php echo '$' . number_format($share[1],2,",","."); ?></td>
                            <td class="text-right"><?php echo $share[2]; ?></td>
                            <td class="text-center"><a onclick="send_share_id('<?php echo $share[3] ?>');" type="button" class="btn btn-default bg-danger ">
                                <i class="fas fa-file-pdf"></i>
                              </a><a onclick="return confirm('<?php echo BASE_URL ?>views/students/update_social_fee.php?id=<?php echo $share[3] ?>',true);" type="button" class="btn btn-default bg-warning ">
                              <i class="fas fa-pencil-alt"></i>
                              </a></td>

                          </tr>
                        <?php } ?>
                      </tbody>

                    </table>
                  <?php } else { ?>
                    <span class="text-danger">No posee ninguna cuota abonada</span>
                  <?php } ?>
                </div>
                <!-- /.card-body -->
                
              </div>


            </div>
          
          </div>
          
        </div>
        <div class="col-2 mb-2"><a type="button" href="<?php echo BASE_URL; ?>views/students/students.php" class="btn btn-block bg-maroon btn-sm"><i class="fas fa-arrow-left"></i>Volver</a></div>
      </section>
      <form id="pdf" method="post">
        <input id="share_id" name="share_id" type="hidden" id=''>
      </form>
      <form id="share_edit" method="post">
        <input id="share_id" name="share_id" type="hidden" id=''>
      </form>

    </div>
    <!-- /.content-wrapper -->

    <?php require_once ROOTPATH . '/common/footer.php' ?>

  </div>
  <script src="<?php echo BASE_URL; ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo BASE_URL; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?php echo BASE_URL; ?>/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/jszip/jszip.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <script src="<?php echo BASE_URL; ?>/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/moment/moment.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/inputmask/jquery.inputmask.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/dist/js/adminlte.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/dist/js/confirm.js"></script>
  <script src="<?php echo BASE_URL; ?>/dist/js/options_export_file.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/datatable.js"></script>
  <script src="<?php echo BASE_URL; ?>/dist/js/dont_forward.js"></script>




  <!-- Page specific script -->
  <script>
     datatable(':visible'); 
    function share_pay() {

      return confirm('#pay_social_fee', false);

    }

    function send_share_id(id) {
      $('#share_id').val(id);
      $('#pdf').submit();


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