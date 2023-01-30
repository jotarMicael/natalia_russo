<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);



require_once '../../utils/const.php';
require_once ROOTPATH . '/controller/SessionController.php';
SessionController::mustBeLoggedIn();

$nav = 'ct';

require_once ROOTPATH . '/controller/TeacherController.php';
$teacherController = new TeacherController();

if (!empty($_POST)) {


  $result = $teacherController->insert_teacher($_POST);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo HEAD; ?> | Alta profesor</title>
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/dist/img/logo_nati.jpg">


  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/adminlte.min.css?v=3.2.0">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/daterangepicker/daterangepicker.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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

      <div class="content-header">
        <?php
        if ($result[0] == 1) {

          include ROOTPATH . '/common/alert_success.php';
          unset($_POST);
        } elseif ($result[0] == 2) {

          include ROOTPATH . '/common/alert_warning.php';
        } elseif ($result[0] == 3) {

          include ROOTPATH . '/common/alert_danger.php';
        }

        ?>

      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">

              <div class="card card-lime">
                <div class="card-header">
                  <h3 class="card-title"><strong>Registro de profesor</strong> <i class="fas fa-chalkboard-teacher"></i></h3>
                </div>
                <div class="card-body">
                  <div class="container">
                    <div class="row justify-content-around">
                      <div class="col-4">
                        <form id="create_teacher" method="post" action="#">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Nombre</label>
                            <input required type="text" class="form-control" value="<?php echo $_POST ? $_POST['name'] : ''; ?>" id="name" name="name" placeholder="Ingrese un nombre">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Apellido</label>
                            <input required type="text" class="form-control" value="<?php echo $_POST ? $_POST['surname'] : ''; ?>" id="surname" name="surname" placeholder="Ingrese un apellido">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Dni</label>
                            <input required type="text" class="form-control" id="dni" value="<?php echo $_POST ? $_POST['dni'] : ''; ?>" name="dni" placeholder="Ingrese un dni">
                          </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label>Teléfono particular</label>

                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input required name="private_phone_number" value="<?php echo $_POST ? $_POST['private_phone_number'] : ''; ?>" type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email</label>
                          <input required type="text" class="form-control" value="<?php echo $_POST ? $_POST['email'] : ''; ?>" id="email" name="email" placeholder="Ingrese un email">
                        </div>
                        <div class="form-group">
                          <label>Fecha de nacimiento</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input required name="date_birth" type="text" value="<?php echo $_POST ? $_POST['date_birth'] : ''; ?>" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                          </div>
                          <!-- /.input group -->
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Dirección</label>
                          <input required type="text" class="form-control" id="address" name="address" value="<?php echo $_POST ? $_POST['address'] : ''; ?>" placeholder="Ingrese una dirección">
                        </div>
                        <div class="form-group">
                          <label>Actividades</label>
                          <div class="select2-maroon">
                            <select name="activities[]" class="select2 select2-hidden-accessible" multiple="multiple" data-placeholder="Seleccionar actividades" data-dropdown-css-class="select2-maroon" style="width: 100%;" tabindex="-1" aria-hidden="true">
                              <?php
                              require_once ROOTPATH . '/controller/ActivityController.php';
                              $activityController = new ActivityController();
                              if ($_POST['activities']) {
                                foreach ($activityController->get_activities() as $activity) {
                              ?>
                                  <option <?= in_array($activity['id'], $_POST['activities']) ? 'selected="selected"' : '' ?> value="<?= $activity['id'] ?>"><?= $activity['name'] ?></option>
                                <?php }
                              } else {
                                foreach ($activityController->get_activities() as $activity) { ?>
                                  <option value="<?= $activity['id'] ?>"><?= $activity['name'] ?></option>
                                <?php
                                }
                                ?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="exampleSelectBorderWidth2">Cobertura médica</label>

                          <select required name="art" class="custom-select" id="exampleSelectBorderWidth2">
                            <option value="0">Ninguna</option>
                            <?php require_once ROOTPATH . '/controller/ArtController.php';
                            $artController = new ArtController();
                            foreach ($artController->get_arts() as $art) {
                            ?>
                              <option <?= $_POST['art'] == $art['id'] ? ' selected="selected"' : ''; ?> value="<?php echo $art['id'] ?>"><?php echo $art['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                  if ($result[0] == 4) {

                    echo $result[1];
                  }
                  unset($result); ?>
                </div>
                <div class="card-footer">

                  </form>
                  <button onclick="return create_teacher();" type="submit" class="btn bg-orange">Registrar profesor</button>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card card-lime">
                <div class="card-header bg-lime">
                  <h3 class="card-title"><strong>Profesores</strong> <i class="fas fa-chalkboard-teacher"></i></h3>
                </div>

                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped table-hover table-sm">
                    <thead>
                      <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Nombre completo</th>
                        <th class="text-center">Dni</th>
                        <th class="text-center">Dirección</th>
                        <th class="text-center">Núm.Tel.</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Fecha Nac.</th>
                        <th class="text-center">Fecha alta</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($teacherController->get_all_teachers()  as $teacher) { ?>
                        <tr>
                          <td class="text-center"><?= $teacher['id'] ?></td>
                          <td class="text-center"><?= $teacher['name'] . ' ' .  $teacher['surname'] ?></td>
                          <td class="text-center"><?= $teacher['dni'] ?> </td>
                          <td class="text-center"><?= $teacher['address'] ?> </td>
                          <td class="text-center"><?= $teacher['private_phone_number'] ?> </td>
                          <td class="text-center"><?= $teacher['email'] ?> </td>
                          <td class="text-center"><?= $teacher['birth_date'] ?> </td>
                          <td class="text-center"><?= $teacher['created_at'] ?> </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>


              </div>

            </div>

          </div>
        </div>
      </div>

    </div>
    <!-- /.content-wrapper -->

    <?php require_once ROOTPATH . '/common/footer.php' ?>

  </div>
  <!-- ./wrapper -->

  <script src="<?php echo BASE_URL; ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo BASE_URL; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- bs-custom-file-input -->
  <script src="<?php echo BASE_URL; ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo BASE_URL; ?>/dist/js/adminlte.min.js"></script>
  <!-- Bootstrap 4 -->
  <!-- Select2 -->
  <script src="<?php echo BASE_URL; ?>/plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="<?php echo BASE_URL; ?>/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- InputMask -->
  <script src="<?php echo BASE_URL; ?>/plugins/moment/moment.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- date-range-picker -->
  <script src="<?php echo BASE_URL; ?>/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap color picker -->
  <script src="<?php echo BASE_URL; ?>/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?php echo BASE_URL; ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- BS-Stepper -->
  <script src="<?php echo BASE_URL; ?>/plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <!-- dropzonejs -->
  <script src="<?php echo BASE_URL; ?>/plugins/dropzone/min/dropzone.min.js"></script>
  <!-- AdminLTE App -->




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
  <script src="<?php echo BASE_URL; ?>/dist/js/datatable.js"></script>

  <script src="<?php echo BASE_URL; ?>/dist/js/confirm.js"></script>
  <script src="<?php echo BASE_URL; ?>/dist/js/dont_forward.js"></script>

  <script>
    function create_teacher() {

      return confirm('#create_teacher', false);

    }
    $(function() {


      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/yyyy'
      })
      //Money Euro
      $('[data-mask]').inputmask()

    })
  </script>
</body>

</html>