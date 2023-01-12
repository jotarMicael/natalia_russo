<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

require_once '../utils/const.php';


$nav = 'ce';

if (!empty($_POST)) {
  var_dump($_POST);die;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo HEAD; ?> | Alta alumno</title>
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/dist/img/dance.png">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/adminlte.min.css">

  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/dropzone/min/dropzone.min.css">
  <!-- Theme style -->

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php require_once ROOTPATH . '/common/navbar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Alta de alumno</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-12">
              <!-- general form elements -->

              <!-- /.card -->

              <!-- general form elements -->
              <div class="card card-maroon">
                <div class="card-header">
                  <h3 class="card-title">Ficha de salud y autorización infantil</h3>
                </div>

                <!-- /.card-header -->
                <div class="card-body">

                  <div class="row">
                    <div class="col-4">
                      <h3><b>Datos Grales.</b></h3><br>
                      <form action="#" method="post">
                        <div class="form-group">
                          <label for="exampleInputBorderWidth2">Nombre</label>
                          <input name="student_name" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputBorderWidth2">Apellido/s</label>
                          <input name="student_surname" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                        </div>
                        <div class="form-group">
                          <label>Fecha de nacimiento</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input name="date_birth" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                          </div>
                          <!-- /.input group -->
                        </div>
                        <div class="form-group">
                          <label for="exampleInputBorderWidth2">Nombre de padre o tutor</label>
                          <input type="father_name" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputBorderWidth2">Nombre de madre o tutor</label>
                          <input type="mother_name" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                        </div>
                        <div class="form-group">
                          <label>Teléfono particular</label>

                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input name="private_number" type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Teléfono de urgencia</label>

                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input name="emergency_number" type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputBorderWidth2">Domicilio</label>
                          <input name="address" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputBorderWidth2">Email de padres</label>
                          <input name="email" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                        </div>

                        <div class="form-group">
                          <label for="exampleSelectBorderWidth2">Cobertura médica</label>

                          <select name="medical_coverage" class="custom-select form-control-border border-width-2" id="exampleSelectBorderWidth2">
                            <option value="0">Ninguna</option>
                            <?php require_once ROOTPATH . '/controller/SocialWorkController.php';
                            $social_work = new SocialWorkController();
                            foreach ($social_work->get_social_works() as $sw) {
                            ?>
                              <option value="<?php echo $sw['id'] ?>"><?php echo $sw['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputBorderWidth2">N° afiliado</label>
                          <input name="affiliate_number" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                        </div>
                    </div>
                    <div class="col-4">
                      <h3><b>Antecedentes clínicos</b></h3><br>
                      <div class="form-group">

                        <label for="exampleInputBorderWidth2">¿Ha padecido alguna de las siguientes enfermedades?</label>

                        <div class="container">
                          <div class="row">
                            <div class="col-sm-6">
                              <?php require_once ROOTPATH . '/controller/DiseaseController.php';
                              $diseaseController = new DiseaseController();
                              $diseases = $diseaseController->get_diseases(0);
                              foreach (array_slice($diseases, 0, count($diseases) / 2) as $disease) {
                              ?>
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" name="had_disease[]" id="<?php echo $disease['id']; ?>" value="<?php echo $disease['id']; ?>">
                                  <label for="<?php echo $disease['id']; ?>" class="custom-control-label"><?php echo $disease['name']; ?></label>
                                </div>

                              <?php } ?>

                            </div>
                            <div class="col-sm-6">

                              <?php
                              foreach (array_slice($diseases, count($diseases) / 2) as $disease) {
                              ?>
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" name="had_disease[]" id="<?php echo $disease['id']; ?>" value="<?php echo $disease['id']; ?>">
                                  <label for="<?php echo $disease['id']; ?>" class="custom-control-label"><?php echo $disease['name']; ?></label>
                                </div>

                              <?php } ?>

                            </div>
                          </div>

                        </div><br>
                        <label for="exampleInputBorderWidth2">Otra/s enfermedades:</label>
                        <input name="other_diseases_1" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                      </div>
                      <div class="form-group">

                        <label for="exampleInputBorderWidth2">¿Padece alguna de las siguientes enfermedades?</label>

                        <div class="container">
                          <div class="row">
                            <div class="col-sm-6">
                              <?php
                              $diseases = $diseaseController->get_diseases(1);

                              foreach (array_slice($diseases, 0, count($diseases) / 2) as $disease) {
                              ?>
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" name="diseases[]" id="<?php echo $disease['id']; ?>" value="<?php echo $disease['id']; ?>">
                                  <label for="<?php echo $disease['id']; ?>" class="custom-control-label"><?php echo $disease['name']; ?></label>
                                </div>

                              <?php } ?>

                            </div>
                            <div class="col-sm-6">

                              <?php
                              foreach (array_slice($diseases, count($diseases) / 2) as $disease) {
                              ?>
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" name="diseases[]" id="<?php echo $disease['id']; ?>" value="<?php echo $disease['id']; ?>">
                                  <label for="<?php echo $disease['id']; ?>" class="custom-control-label"><?php echo $disease['name']; ?></label>
                                </div>

                              <?php } ?>

                            </div>
                          </div>

                        </div><br>
                        <label for="exampleInputBorderWidth2">Otra/s enfermedades:</label>
                        <input name="other_diseases_2" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorderWidth2">¿Estuvo alguna vez internado?:</label>
                        <input name="internated" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="¿Diagnóstico?,complete en caso afirmativo">
                        <br><label for="exampleInputBorderWidth2">¿Fué intervenido quirúrgicamente?:</label>
                        <input name="surgery" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="¿Diagnóstico?,complete en caso afirmativo">
                        <br><label for="exampleInputBorderWidth2">¿Toma alguna medicación?:</label>
                        <input name="medication" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="¿Cuál?,complete en caso afirmativo">
                        <br><label for="exampleInputBorderWidth2">¿Tiene vacuna antitetánica?:</label>
                        <div class="input-group">
                          <div class="input-group-prepend">

                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input placeholder="Fecha,complete en caso afirmativo" name="antitetano" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                        </div>
                        <br><label for="exampleInputBorderWidth2">¿Mantiene alguna dieta especial?:</label>
                        <input name="diet" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="¿Cuál?,complete en caso afirmativo">
                        <br><label for="exampleInputBorderWidth2">¿Presenta algún cuadro alérgico?:</label>
                        <input name="allergy" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="¿Cuál?,complete en caso afirmativo">

                      </div>



                    </div>
                    <div class="col-4">
                      <h3><b>Firmas/Autorizaciones</b></h3><br>
                      <div class="form-group">
                        <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="authorized" name="authorized[]" value="1">
                          <label for="authorized" class="custom-control-label">¿Autoriza a que su hija/o aparezca en fotos?</label>
                          

                        </div>
                      </div>
                    </div>
                  </div>




                </div>
                <div class="card-footer">
                  <button type="submit" class="btn bg-maroon">Registrar</button>
                </div>
                </form>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->



              <!-- Horizontal Form -->

              <!-- /.card -->

            </div>
            <!--/.col (left) -->
            <!-- right column -->

            <!--/.col (right) -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require_once ROOTPATH . '/common/footer.php' ?>


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="<?php echo BASE_URL; ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo BASE_URL; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- bs-custom-file-input -->
  <script src="<?php echo BASE_URL; ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo BASE_URL; ?>/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo BASE_URL; ?>/dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      bsCustomFileInput.init();
    });
  </script>
  <script src="<?php echo BASE_URL; ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo BASE_URL; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
  <script src="<?php echo BASE_URL; ?>/dist/js/adminlte.min.js"></script>

  <!-- Page specific script -->
  <script>
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

      //Date picker
      $('#reservationdate').datetimepicker({
        format: 'L'
      });

      //Date and time picker
      $('#reservationdatetime').datetimepicker({
        icons: {
          time: 'far fa-clock'
        }
      });

      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'MM/DD/YYYY hh:mm A'
        }
      })
      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )

      //Timepicker
      $('#timepicker').datetimepicker({
        format: 'LT'
      })

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