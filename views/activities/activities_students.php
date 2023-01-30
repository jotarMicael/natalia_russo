<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);



require_once '../../utils/const.php';
require_once ROOTPATH . '/controller/SessionController.php';


SessionController::mustBeLoggedIn();

$nav = 'as';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo HEAD; ?> | Actividades</title>
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
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
                        <div class="col-12 ">
                            <div class="card card-maroon">
                                <div class="card-header">
                                    <h3 class="card-title"><strong>Alumnos de la actividad</strong> <i class="fas fa-chart-line"></i></strong></h3>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row justify-content-start">
                                            <div class="col-6">
                                                <form id="search_students" method="post" href="#">
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
                                            </div>


                                        </div>
                                        <?php

                                        if (($_SERVER['REQUEST_METHOD'] === 'POST')  && (empty($_POST['activities']))) { ?>

                                            <span class="text-danger">Debe seleccionar al menos una actividad*</span>
                                        <?php
                                        } ?>
                                    </div>

                                </div>
                                <div class="card-footer">

                                    </form>
                                    <button id="ss" onclick="search_students();" type="submit" class="btn bg-orange"><i class="fas fa-user"></i> Buscar alumnos</button>
                                </div>
                            </div>


                        </div>
                        <div class="col-12">
                            <?php
                            if ($_POST) { ?>
                                <div class="card">
                                    <div class="card-header"> <strong><i class="fas fa-chart-line"></i> Actividades</strong></div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <?php

                                        $activitys = $activityController->get_students_by_activities($_POST['activities']);

                                        if (!empty($activitys)) { ?>
                                            <table id="example1" class="table table-bordered table-striped table-hover table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Nombre completo</th>
                                                        <th>Actividades</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($activitys as $activity) {
                                                    ?>
                                                        <tr>
                                                            <td class="text-left"><?= $activity['id']; ?></td>
                                                            <td class="text-left"><?= $activity['name'] . ' ' . $activity['surname']; ?></td>

                                                            <td class="text-left"><?= $activity['activities']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>

                                            </table>
                                        <?php } else { ?>
                                            <span class="text-danger">No posee ningún estudiante</span>
                                        <?php
                                        } ?>
                                    </div>
                                    <!-- /.card-body -->
                                </div>

                            <?php
                            } ?>
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
    <!-- Page specific script -->
    <script>
        function search_students() {
            $('#ss').attr('disabled', true);
            $('#search_students').submit();
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

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })
        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>

</body>

</html>