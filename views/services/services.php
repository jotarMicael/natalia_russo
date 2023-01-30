<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);



require_once '../../utils/const.php';
require_once ROOTPATH . '/controller/SessionController.php';
require_once ROOTPATH . '/controller/ServiceController.php';

SessionController::mustBeLoggedIn();

$nav = 's';

$serviceController = new ServiceController();

if (!empty($_POST)) {
    
    $result = $serviceController->insert_service_import($_POST);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo HEAD; ?> | Egresos</title>
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/dist/img/logo_nati.jpg">

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
                                    <h3 class="card-title"><strong>Registrar egreso</strong> <i class="fas fa-cash-register"></i></strong></h3>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row justify-content-around">
                                            <div class="col-4">
                                                <form id="create_service" method="post" href="#">
                                                    <div class="form-group">
                                                        <label for="exampleSelectRounded0">Servicio</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-wrench"></i></span>
                                                            </div>
                                                            <select id="service" name="service" class="custom-select rounded-0" id="exampleSelectRounded0">
                                                                <option value="0">Ninguno</option>
                                                                <?php foreach ($serviceController->get_services() as $service) { ?>
                                                                    <option value="<?= $service['id'] ?>"><?= $service['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Otro</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-wrench"></i></span>
                                                            </div>
                                                            <input disabled id="other" name="other" type="text" value="<?php echo $_POST ? $_POST['other'] : ''; ?>" class="form-control">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Fecha</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                        <input required name="service_date" type="text" value="<?php echo $_POST ? $_POST['service_date'] : ''; ?>" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>

                                            </div>
                                            <div class="col-4">
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
                                    <button onclick="create_service();" type="submit" class="btn bg-orange"><i class="fas fa-cash-register"></i> Registrar egreso</button>
                                </div>
                            </div>


                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header"> <strong><i class="fas fa-cash-register"></i> Egresos</strong></div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <?php $services = $serviceController->get_services_imports();
                                    if (!empty($services)) { ?>
                                        <table id="example1" class="table table-bordered table-striped table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Egreso</th>
                                                    <th>Importe</th>
                                                    <th>Fecha egreso</th>
                                                    <th>Fecha carga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($services as $service) {
                                                ?>
                                                    <tr>
                                                        <td class="text-left"><?php echo $service['name']; ?></td>
                                                        <td class="text-right"><?php echo '$' . $service['import']; ?></td>
                                                        <td class="text-right"><?php echo $service['service_date']; ?></td>
                                                        <td class="text-right"><?php echo $service['created_at']; ?></td>

                                                    </tr>
                                                <?php } ?>
                                            </tbody>

                                        </table>
                                    <?php } else { ?>
                                        <span class="text-danger">No posee ningún egreso</span>
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
    <script src="<?php echo BASE_URL; ?>/dist/js/datatable.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/dont_forward.js"></script>
    <!-- Page specific script -->
    <script src="<?php echo BASE_URL; ?>/plugins/moment/moment.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
        function create_service() {

            return confirm('#create_service', false);
        }

        $(function() {

            $("#service").change(function() {
                if ($(this).val() == 3) {
                    $("#other").prop("disabled", false);
                } else {
                    $("#other").prop("disabled", true);
                }
            });


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