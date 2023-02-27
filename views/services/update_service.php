<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);



require_once '../../utils/const.php';
require_once ROOTPATH . '/controller/SessionController.php';


SessionController::mustBeLoggedIn();

$nav = 'us';

if (!empty($_POST)) {
    require_once ROOTPATH . '/controller/ServiceController.php';
    $serviceController = new ServiceController();
    $result = $serviceController->update_service_import($_GET['id'], $_POST['other'], $_POST['service_date'], $_POST['import'], $_POST['type']);
    $service = $serviceController->get_service_import($_GET['id']);
} elseif (!empty($_GET)) {
    require_once ROOTPATH . '/controller/ServiceController.php';
    $serviceController = new ServiceController();
    $service = $serviceController->get_service_import($_GET['id']);
} else {

    header('Location: ' . BASE_URL . 'views/services/services.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo HEAD; ?> | AS</title>
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/dist/img/logo_nati.jpg">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/adminlte.min.css?v=3.2.0">

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
                                    <h3 class="card-title"><strong>Actualizar egreso: <?= $service['other'] ?></strong> <i class="fas fa-cash-register"></i></strong></h3>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row justify-content-around">
                                            <div class="col-4">
                                                <form id="update_service" method="post" href="#">
                                                    <!--<div class="form-group">
                                                        <label for="exampleSelectRounded0">Servicio</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-wrench"></i></span>
                                                            </div>
                                                            <select id="service" name="service" class="custom-select rounded-0" id="exampleSelectRounded0">
                                                                <option value="0">Ninguno</option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>-->
                                                    <?php if ($service['type']) { ?>
                                                        <div class="form-group">
                                                            <label>Otro</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-wrench"></i></span>
                                                                </div>
                                                                <input id="other" name="other" type="text" value="<?= $service['other']; ?>" class="form-control">
                                                            </div>
                                                            <!-- /.input group -->
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="form-group">
                                                            <label for="exampleSelectRounded0">Servicio</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-wrench"></i></span>
                                                                </div>
                                                                <select id="other" name="other" class="custom-select rounded-0" id="exampleSelectRounded0">
                                                                    <?php foreach (array_slice($serviceController->get_services(), 0, 2) as $s) { ?>
                                                                        <option <?= $service['service_id'] == $s['id'] ? ' selected="selected"' : ''; ?> value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Fecha</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                        <input required id="service_date" name="service_date" type="text" value="<?= $service['service_date']; ?>" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
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
                                                        <input type="number" step="0.01" min="0" required id="import" name="import" value="<?= $service['import']; ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" name="type" value="<?= $service['type'] ?>">
                                    </form>
                                    <button onclick="update_service();" type="submit" class="btn bg-orange"><i class="fas fa-cash-register"></i> Actualizar egreso</button>
                                </div>

                            </div>


                        </div>
                        <div class="col-2 mb-2"><a type="button" href="<?php echo BASE_URL; ?>views/services/services.php" class="btn btn-block bg-maroon btn-sm"><i class="fas fa-arrow-left"></i>Volver</a></div>
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

    <!-- AdminLTE App -->
    <script src="<?php echo BASE_URL; ?>/dist/js/adminlte.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/confirm.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/dont_forward.js"></script>
    <!-- Page specific script -->
    <script src="<?php echo BASE_URL; ?>/plugins/moment/moment.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
        function update_service() {


            if (($('#service_date').val() == '' || $('#import').val() == '' || $('#other').val() == '')) {
                Swal.fire({
                    icon: 'warning',
                    confirmButtonColor: '#00A300',
                    confirmButtonText: 'OK',
                    html: '<b>Todos los campos deben estar completos</b>',

                })

            } else {
                return confirm('#update_service', false);
            }
        }

        $(function() {

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