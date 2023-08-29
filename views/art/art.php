<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);



require_once '../../utils/const.php';
require_once ROOTPATH . '/controller/SessionController.php';
require_once ROOTPATH . '/controller/ArtController.php';

SessionController::mustBeLoggedIn();

$nav = 'art';

$artController = new ArtController();

if (!empty($_POST)) {
    $result = $artController->insert_art($_POST);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo HEAD; ?> | ART</title>
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/dist/img/logo_nati.jpg">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/adminlte.min.css?v=3.2.0">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- daterange picker -->
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
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12 ">
                            <div class="card card-maroon">
                                <div class="card-header">
                                    <h3 class="card-title"><strong>Registrar ART</strong> <i class="fas fa-user-shield"></i></strong></h3>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row justify-content-start">
                                            <div class="col-4">
                                                <form id="create_art" method="post" href="#">
                                                    <div class="form-group">
                                                        <label>Nombre</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input required id="name" name="name" type="text" value="<?php echo $_POST ? $_POST['name'] : ''; ?>" class="form-control">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">

                                    </form>
                                    <button onclick="create_art();" type="submit" class="btn bg-orange"><i class="fas fa-user-shield"></i> Registrar ART</button>
                                </div>
                            </div>


                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header"> <strong><i class="fas fa-user-shield"></i> ART´s</strong></div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <?php $arts = $artController->get_arts();
                                    if (!empty($arts)) { ?>
                                        <table id="example1" class="table table-bordered table-striped table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Nombre</th>
                                                    <th>Fecha carga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($arts as $art) {
                                                ?>
                                                    <tr>
                                                        <td class="text-left"><?php echo $art['id']; ?></td>
                                                        <td class="text-left"><?php echo $art['name']; ?></td>
                                                        <td class="text-right"><?php echo $art['created_at']; ?></td>

                                                    </tr>
                                                <?php } ?>
                                            </tbody>

                                        </table>
                                    <?php } else { ?>
                                        <span class="text-danger">No posee ningúna ART</span>
                                    <?php } ?>
                                </div>
                                <!-- /.card-body -->
                            </div>


                        </div>
                    </div>
                </div>
            </section>

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
    <!-- AdminLTE App -->
    <script src="<?php echo BASE_URL; ?>/dist/js/adminlte.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/confirm.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/options_export_file.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/datatable.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/dont_forward.js"></script>

    <script>
        datatable(':visible');    
        function create_art() {

            if ($("#name").val() == '' ) {
                Swal.fire({
                    icon: 'warning',
                    confirmButtonColor: '#00A300',
                    confirmButtonText: 'OK',
                    html: '<b>Todos los campos deben estar completos</b>',

                })

            } else {

                return confirm('#create_art', false);
            }
        }

    </script>

</body>

</html>