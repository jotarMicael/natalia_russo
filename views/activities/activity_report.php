<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);



require_once '../../utils/const.php';
require_once ROOTPATH . '/controller/SessionController.php';
require_once ROOTPATH . '/controller/ActivityController.php';

SessionController::mustBeLoggedIn();

$nav = 'axa';

$activityController = new ActivityController();

if (!empty($_POST)) {
    $result = $activityController->get_students_by_activity($_POST['activity']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo HEAD; ?> | Alumnos por actividad<?= !empty($_POST['activity']) ? ': '. $activityController->get_activity_name($_POST['activity']) : '';   ?></title>
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/dist/img/logo_nati.jpg">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/adminlte.min.css?v=3.2.0">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

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

                            <?php
                            if ($result[0] == 3) {

                                include ROOTPATH . '/common/alert_danger.php';
                                unset($result);
                            }

                            ?>


                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12 ">
                            <div class="card card-maroon">
                                <div class="card-header">
                                    <h3 class="card-title"><strong>Alumnos por actividad</strong> <i class="fas fa-chart-line"></i></strong></h3>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row justify-content-start">
                                            <div class="col-4">
                                                <form method="post" action="#">
                                                    <div class="form-group">
                                                        <label>Nombre</label>
                                                        <div class="input-group">
                                                            <select required name="activity" class="custom-select form-control-border border-width-2" id="exampleSelectBorderWidth2">
                                                                <?php require_once ROOTPATH . '/controller/ActivityController.php';
                                                                $activityController = new ActivityController();
                                                                foreach ($activityController->get_activities() as $activity) {
                                                                ?>
                                                                    <option <?= $_POST['activity'] == $activity['id'] ? ' selected="selected"' : ''; ?> value="<?= $activity['id'] ?>"><?= $activity['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">


                                    <button type="submit" class="btn bg-maroon">Ver alumnos <i class="fas fa-user"></i></button>
                                    </form>
                                </div>
                            </div>


                        </div>
                        <?php
                        if (!empty($result)) { ?>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header"> <strong><i class="fas fa-chart-line"></i> Alumnos por actividad</strong></div>
                                    <!-- /.card-header -->
                                    <div class="card-body">

                                        <table id="example1" class="table table-bordered table-striped table-hover table-sm">
                                            <thead>
                                                <tr>

                                                    <th>Nombre</th>
                                                    <th>Apellido</th>
                                                    <th>Dni</th>
                                                    <th>Cumpleaños</th>
                                                    <th>Fecha de Alta</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($result as $student) {
                                                ?>
                                                    <tr>

                                                        <td class="text-left"><?php echo $student['name']; ?></td>
                                                        <td class="text-right"><?php echo $student['surname']; ?></td>
                                                        <td class="text-right"><?php echo $student['dni']; ?></td>
                                                        <td class="text-right"><?php echo $student['date_birth']; ?></td>
                                                        <td class="text-right"><?php echo $student['created_at']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>

                                        </table>

                                    </div>
                                    <!-- /.card-body -->
                                </div>


                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>

        </div>
        <!-- /.content-wrapper -->

        <?php require_once ROOTPATH . '/common/footer.php' ?>

    </div>
    <!-- ./wrapper -->

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
    <script src="<?php echo BASE_URL; ?>/dist/js/datatable.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/dont_forward.js"></script>


</body>

</html>