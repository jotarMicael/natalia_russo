<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);



require_once '../../utils/const.php';
require_once ROOTPATH . '/controller/SessionController.php';
SessionController::mustBeLoggedIn();

$nav = 'aa';

if (!empty($_POST)) {
  require_once ROOTPATH . '/controller/StudentController.php';
  $studentController = new StudentController();
  if (!empty($_POST['delete_id'])) {
    $result = $studentController->delete_student($_POST['delete_id']);
  } elseif (!empty($_POST['student_id'])) {
    $_POST = $studentController->get_technical_sheet($_POST['student_id'], $_POST['student_type']);

    if (!$_POST['type']) {

      require_once '../../utils/edit_pdf.php';
    } else {
      require_once '../../utils/edit_adult_pdf.php';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo HEAD; ?> | Alumnos</title>
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/dist/img/logo_nati.jpg">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/adminlte.min.css">


  <script src="<?php echo BASE_URL; ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php require_once ROOTPATH . '/common/navbar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
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
              <h1>Todos los alumnos</h1>
            </div>

          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header bg-lime">
                  <h3 class="card-title"><strong>Datos personales</strong></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Actividades</th>
                        <th>Número privado</th>
                        <th>Mes corriente abonado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php require_once ROOTPATH . '/controller/StudentController.php';
                      $studentController = new StudentController();
                      /*&nbsp;&nbsp;&nbsp;<a class="btn btn-info btn-sm" href='<?php //echo BASE_URL ?>views/students/view_student.php?id=<?php //echo $student["id"] ?>'>
                              <i class="fas fa-eye"></i>
                              </i>
                            </a>*/
                      foreach ($studentController->get_all_student_actives() as $student) { ?>
                        <tr>
                          <td><?php echo $student['name'] ?>


                          </td>
                          <td><?php echo $student['surname'] ?></td>
                          <td><?php echo $student['dni'] ?></td>
                          <td><?php echo $student['activities'] ?></td>
                          <td><?php echo $student['private_phone_number'] ?></td>
                          <?php if ($student['share_pay'] != '') { ?>
                            <td align="center" width="12%" style="background-color: #90EE90" ><strong>Si</strong></td>
                            <?php } else{?>
                            <td  align="center" width="12%" style="background-color: #E4605E" ><strong>No</strong></td>
                            <?php } ?>
                          <td class="project-actions text-center">
                            <a onclick="open_technical_sheet('<?= $student['id'] ?>','<?= $student['type'] ?>');" type="button" class="btn btn-sm bg-danger ">
                              <i class="fas fa-file-pdf">

                              </i>
                              Ficha
                            </a>
                            <a type="button" href="<?php echo BASE_URL; ?>views/students/pay_social_fee.php?id=<?php echo $student['id'] ?>" class="btn btn-sm bg-success">
                              <i class="fas fa-money-check-alt">
                              </i>
                              Abonar
                            </a>
                            <a onclick="return confirm('<?php echo BASE_URL ?>views/students/update_student.php?id=<?php echo $student['id'] ?>',true);" class="btn btn-info btn-sm">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Editar
                            </a>
                            <!--<a onclick="return send_delete_id('<?php echo $student['id'] ?>');" class="btn btn-danger btn-sm" href="#">
                              <i class="fas fa-trash">
                              </i>
                              Borrar
                            </a>-->
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <form id="delete_student" method="post">
        <input id="delete_id" name="delete_id" type="hidden" id=''>
      </form>
      <form id="technical_sheet" method="post">
        <input id="student_id" name="student_id" type="hidden" id=''>
        <input id="student_type" name="student_type" type="hidden" id=''>
      </form>
    </div>

    <?php require_once ROOTPATH . '/common/footer.php' ?>



  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
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
  <!-- AdminLTE App -->
  <script src="<?php echo BASE_URL; ?>/dist/js/adminlte.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/dist/js/confirm.js"></script>

  

  <script src="<?php echo BASE_URL; ?>/dist/js/options_export_file.js"></script>
  <script src="<?php echo BASE_URL; ?>/dist/js/datatable.js"></script>
  <script src="<?php echo BASE_URL; ?>/dist/js/dont_forward.js"></script>
  <script>

     datatable([0,1,2,3,4,5]);              
    
    function send_delete_id(id) {
      $('#delete_id').val(id);
      return confirm('#delete_student', false);
    }

    function open_technical_sheet(id, type) {
      $('#student_id').val(id);
      $('#student_type').val(type);
      $('#technical_sheet').submit();
    }
  </script>
</body>

</html>