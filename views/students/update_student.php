<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);



require_once '../../utils/const.php';
require_once ROOTPATH . '/controller/SessionController.php';
SessionController::mustBeLoggedIn();

require_once ROOTPATH . '/controller/StudentController.php';
$studentController = new StudentController();


if ($_POST) {
  $result = $studentController->update_student($_POST);

  if ($result[0] == 1) {

    if (!$_POST['type_s']) {
      require_once ROOTPATH . '/utils/edit_pdf.php';
    } else {
      $_POST['date_birth'] = substr($_POST['date_birth'], 6, 4) . '-' . substr($_POST['date_birth'], 3, 2) . '-' . substr($_POST['date_birth'], 0, 2);
      require_once ROOTPATH . '/utils/edit_adult_pdf.php';
    }
  }
}
if (!$_GET['id']) {
  header('Location: ' . BASE_URL . 'views/students/students.php');
  die();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo HEAD; ?> | Actualizar alumno</title>
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/dist/img/logo_nati.jpg">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/cards.css">
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
              if ($result[0] == 2) {

                include ROOTPATH . '/common/alert_warning.php';
              } elseif ($result[0] == 3) {

                include ROOTPATH . '/common/alert_danger.php';
              }
              ?><?php if ($result[0] != 3) {
                  if ($result[0] == 4) {

                    $error = $result[1];
                  }
                  $result = $studentController->get_only_student($_GET['id']);
                ?>
              <h1>Editar alumno: <strong><?php echo $result['student_name'] . ' ' . $result['student_surname'] . '#' . $result['id']; ?></strong></h1>
            <?php } ?>
            </div>

          </div>
        </div><!-- /.container-fluid -->
      </section>

      <?php if ($result[0] != 3) {
        if (!$result['type']) { ?>
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col">

                  <div class="card card-lime">
                    <div class="card-header">
                      <h3 class="card-title"><strong>Datos generales</strong></h3>
                    </div>
                    <div class="card-body">
                      <div class="container">
                        <div class="row justify-content-around">
                          <div class="col-4">
                            <form id="update_student" method="post" href="#">
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">Nombre</label>
                                <input required name="student_name" type="text" value="<?php echo $result['student_name']; ?>" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>

                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">DNI</label>
                                <input required value="<?php echo $result ? $result['dni'] : ''; ?>" name="dni" type="number" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>

                              <div class="form-group">
                                <label for="exampleSelectBorderWidth2">Cobertura médica</label>

                                <select required name="medical_coverage" class="custom-select form-control-border border-width-2" id="exampleSelectBorderWidth2">
                                  <option value="0">Ninguna</option>
                                  <?php require_once ROOTPATH . '/controller/SocialWorkController.php';
                                  $social_work = new SocialWorkController();
                                  foreach ($social_work->get_social_works() as $sw) {
                                  ?>
                                    <option value="<?php echo $sw['id'] ?>" <?= $result['medical_coverage'] == $sw['id'] ? ' selected="selected"' : ''; ?>><?php echo $sw['name'] ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">N° afiliado</label>
                                <input required value="<?php echo $result['affiliate_number']; ?>" name="affiliate_number" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">Domicilio</label>
                                <input required name="address" value="<?php echo $result['address']; ?>" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>
                              <div class="form-group">
                                <label>Actividades</label>
                                <div class="select2-maroon">
                                  <select name="activities[]" class="select2 select2-hidden-accessible" multiple="multiple" data-placeholder="Seleccionar actividades" data-dropdown-css-class="select2-maroon" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <?php
                                    require_once ROOTPATH . '/controller/ActivityController.php';
                                    $activityController = new ActivityController();
                                    if ($result['activities']) {
                                      foreach ($activityController->get_activities() as $activity) {
                                    ?>
                                        <option <?= in_array($activity['id'], $result['activities']) ? 'selected="selected"' : '' ?> value="<?= $activity['id'] ?>"><?= $activity['name'] ?></option>
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
                          <div class="col-4">
                            <div class="form-group">
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">Apellido/s</label>
                                <input required name="student_surname" type="text" value="<?php echo $result['student_surname']; ?>" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">Nombre de padre o tutor</label>
                                <input required name="father_name" value="<?php echo $result['father_name']; ?>" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>
                              <div class="form-group">
                                <label>Teléfono particular</label>

                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                  </div>
                                  <input required name="private_number" value="<?php echo $result['private_number']; ?>" type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">Email de padres</label>
                                <input required name="email" type="text" value="<?php echo $result['email']; ?>" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>
                              <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                  <input class="custom-control-input" type="checkbox" id="authorized" name="authorized" <?= (bool)$result['authorized'] ? ' checked="checked"' : '' ?> value="1">
                                  <label for="authorized" class="custom-control-label">¿Autoriza a que su hija/o aparezca en fotos?</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-group">
                              <label>Fecha de nacimiento</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input required name="date_birth" type="text" value="<?php echo $result['date_birth']; ?>" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                              </div>
                              <!-- /.input group -->
                            </div>
                            <div class="form-group">
                              <label for="exampleInputBorderWidth2">Nombre de madre o tutor</label>
                              <input required name="mother_name" value="<?php echo $result['mother_name']; ?>" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                            </div>
                            <div class="form-group">
                              <label>Nombre de contacto de urgencia</label>

                              <div class="input-group">

                                <input required name="emergency_name" value="<?php echo $result ? $result['emergency_name'] : ''; ?>" type="text" class="form-control form-control-border border-width-2" placeholder="...">
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Número de contacto de urgencia</label>

                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input required name="emergency_number" value="<?php echo $result ? $result['emergency_number'] : ''; ?>" type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                              </div>
                            </div>





                            <div class="form-group">
                              <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" <?= (bool)$result['changed'] ? ' checked="checked"' : '' ?> id="changed" name="changed" value="1">
                                <label for="changed" class="custom-control-label">¿Autoriza a que el niño sea cambiado por el docente en caso de ser necesario?</label>
                              </div>
                            </div>

                          </div>
                        </div><?php
                              if ($error) {

                                echo $error;
                                unset($error);
                              }  ?>
                      </div>
                    </div>
                  </div>
                  <div class="card card-maroon">
                    <div class="card-header">
                      <h3 class="card-title"><strong>Historia Clínica</strong></h3>
                    </div>
                    <div class="card-body">
                      <div class="container">
                        <div class="row justify-content-around">
                          <div class="col-4">
                            <div class="form-group">
                              <label for="exampleInputBorderWidth2">¿Ha padecido alguna de las siguientes enfermedades?</label>

                              <div class="row">
                                <div class="col-sm-6">
                                  <?php require_once ROOTPATH . '/controller/DiseaseController.php';
                                  $diseaseController = new DiseaseController();
                                  $actual_diseases = explode(',', $result['diseases']);
                                  $diseases = $diseaseController->get_diseases(0);
                                  foreach (array_slice($diseases, 0, count($diseases) / 2) as $disease) {
                                  ?>
                                    <div class="custom-control custom-checkbox">
                                      <input class="custom-control-input" <?= in_array($disease['id'], $actual_diseases) ? ' checked="checked"' : '' ?> type="checkbox" name="had_disease[]" id="<?php echo $disease['id']; ?>" value="<?php echo $disease['id']; ?>">
                                      <label for="<?php echo $disease['id']; ?>" class="custom-control-label"><?php echo $disease['name']; ?></label>
                                    </div>

                                  <?php } ?>

                                </div>
                                <div class="col-sm-6">

                                  <?php
                                  foreach (array_slice($diseases, count($diseases) / 2) as $disease) {
                                  ?>
                                    <div class="custom-control custom-checkbox">
                                      <input class="custom-control-input" type="checkbox" <?= in_array($disease['id'], $actual_diseases) ? ' checked="checked"' : '' ?> name="had_disease[]" id="<?php echo $disease['id']; ?>" value="<?php echo $disease['id']; ?>">
                                      <label for="<?php echo $disease['id']; ?>" class="custom-control-label"><?php echo $disease['name']; ?></label>
                                    </div>

                                  <?php } ?>

                                </div>
                              </div>

                            </div>
                            <div class="form-group">
                              <label for="exampleInputBorderWidth2">Otra/s enfermedades:</label>
                              <input name="other_diseases_1" value="<?= $result['other_diseases_1']; ?>" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                            </div>
                            <div class="form-group">

                              <label for="exampleInputBorderWidth2">¿Padece alguna de las siguientes enfermedades?</label>
                              <div class="row">
                                <div class="col-sm-6">
                                  <?php
                                  $diseases = $diseaseController->get_diseases(1);

                                  foreach (array_slice($diseases, 0, count($diseases) / 2) as $disease) {

                                  ?>
                                    <div class="custom-control custom-checkbox">
                                      <input class="custom-control-input" type="checkbox" <?= in_array($disease['id'], $actual_diseases) ? ' checked="checked"' : '' ?> name="diseases[]" id="<?php echo $disease['id']; ?>" value="<?php echo $disease['id']; ?>">
                                      <label for="<?php echo $disease['id']; ?>" class="custom-control-label"><?php echo $disease['name']; ?></label>
                                    </div>

                                  <?php } ?>

                                </div>
                                <div class="col-sm-6">

                                  <?php
                                  foreach (array_slice($diseases, count($diseases) / 2) as $disease) {
                                  ?>
                                    <div class="custom-control custom-checkbox">
                                      <input class="custom-control-input" type="checkbox" name="diseases[]" <?= in_array($disease['id'], $actual_diseases) ? ' checked="checked"' : '' ?> id="<?php echo $disease['id']; ?>" value="<?php echo $disease['id']; ?>">
                                      <label for="<?php echo $disease['id']; ?>" class="custom-control-label"><?php echo $disease['name']; ?></label>
                                    </div>

                                  <?php } ?>

                                </div>
                              </div>



                            </div>
                            <div class="form-group">
                              <label for="exampleInputBorderWidth2">Otra/s enfermedades:</label>
                              <input name="other_diseases_2" value="<?= $result['other_diseases_2']; ?>" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-group">
                              <label for="exampleInputBorderWidth2">¿Tiene vacuna antitetánica?:</label>
                              <div class="input-group">
                                <div class="input-group-prepend">

                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input placeholder="Fecha,complete en caso afirmativo" name="antitetano" value="<?= $result['antitetano']; ?>" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                              </div>
                            </div>
                            <div class="form-group"><label for="exampleInputBorderWidth2">¿Presenta algún cuadro alérgico?:</label>
                              <input name="allergy" value="<?= $result['allergy']; ?>" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="¿Cuál?,complete en caso afirmativo">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputBorderWidth2">¿Fué intervenido quirúrgicamente?:</label>
                              <input name="surgery" type="text" value="<?= $result['surgery']; ?>" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="¿Diagnóstico?,complete en caso afirmativo">
                            </div>
                            <div class="form-group"><label for="exampleInputBorderWidth2">¿Mantiene alguna dieta especial?:</label>
                              <input name="diet" type="text" value="<?= $result['diet']; ?>" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="¿Cuál?,complete en caso afirmativo">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputBorderWidth2">¿Estuvo alguna vez internado?:</label>
                              <input name="internated" value="<?= $result['internated']; ?>" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="¿Diagnóstico?,complete en caso afirmativo">
                              <!-- /.input group -->
                            </div>
                          </div>
                          <div class="col-4">

                            <div class="form-group">
                              <label for="exampleInputBorderWidth2">¿Toma alguna medicación?:</label>
                              <input name="medication" value="<?= $result['medication']; ?>" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="¿Cuál?,complete en caso afirmativo">
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                    <div class="card-footer">
                      <input type="hidden" name="type_s" id="type_s" value=''>
                      </form>
                      <button onclick="return update_student('<?= $result['type']; ?>');" type="button" class="btn bg-orange"><i class="fas fa-user-edit"></i> Actualizar datos</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-2 mb-2"><a type="button" href="<?php echo BASE_URL; ?>views/students/students.php" class="btn btn-block bg-maroon btn-sm"><i class="fas fa-arrow-left"></i>Volver</a></div>
          </div>
        <?php } else { ?>
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col">
                  <div class="card card-lime">
                    <div class="card-header">
                      <h3 class="card-title"><strong>Datos generales</strong></h3>
                    </div>
                    <div class="card-body">
                      <div class="container">
                        <div class="row justify-content-around">
                          <div class="col-4">
                            <form id="update_student" method="post" action="#">
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">Nombre</label>
                                <input required name="student_name" type="text" value="<?php echo $result ? $result['student_name'] : ''; ?>" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">DNI</label>
                                <input required value="<?php echo $result ? $result['dni'] : ''; ?>" name="dni" type="number" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">Peso</label>
                                <input required value="<?php echo $result ? $result['weight'] : ''; ?>" name="weight" type="number" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>
                              <div class="form-group">
                                <label for="exampleSelectBorderWidth2">Cobertura médica</label>

                                <select required name="medical_coverage" class="custom-select form-control-border border-width-2" id="exampleSelectBorderWidth2">
                                  <option value="0">Ninguna</option>
                                  <?php require_once ROOTPATH . '/controller/SocialWorkController.php';
                                  $social_work = new SocialWorkController();
                                  foreach ($social_work->get_social_works() as $sw) {
                                  ?>
                                    <option <?= $result['medical_coverage'] == $sw['id'] ? ' selected="selected"' : ''; ?> value="<?php echo $sw['id'] ?>"><?php echo $sw['name'] ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">N° afiliado</label>
                                <input required value="<?php echo $result ? $result['affiliate_number'] : ''; ?>" name="affiliate_number" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">Medicación</label>
                                <input name="medication" type="text" value="<?php echo $result ? $result['medication'] : ''; ?>" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>


                          </div>

                          <div class="col-4">
                            <div class="form-group">
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">Apellido/s</label>
                                <input required name="student_surname" type="text" value="<?php echo $result ? $result['student_surname'] : ''; ?>" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>

                              <div class="form-group">
                                <label>Teléfono particular</label>

                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                  </div>
                                  <input required name="private_number" value="<?php echo $result ? $result['private_number'] : ''; ?>" type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="exampleInputBorderWidth2">Email personal</label>
                                <input required name="email" type="text" value="<?php echo $result ? $result['email'] : ''; ?>" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Actividades</label>
                              <div class="select2-maroon">
                                <select name="activities[]" class="select2 select2-hidden-accessible" multiple="multiple" data-placeholder="Seleccionar actividades" data-dropdown-css-class="select2-maroon" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                  <?php
                                  require_once ROOTPATH . '/controller/ActivityController.php';
                                  $activityController = new ActivityController();
                                  if ($result['activities']) {
                                    foreach ($activityController->get_activities() as $activity) {
                                  ?>
                                      <option <?= in_array($activity['id'], $result['activities']) ? 'selected="selected"' : '' ?> value="<?= $activity['id'] ?>"><?= $activity['name'] ?></option>
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
                              <label for="exampleInputBorderWidth2">Patologías</label>
                              <input name="pathologies" type="text" value="<?php echo $result ? $result['pathologies'] : ''; ?>" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-group">
                              <label>Fecha de nacimiento</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input required name="date_birth" type="text" value="<?php echo $result ? $result['date_birth'] : ''; ?>" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                              </div>
                              <!-- /.input group -->
                            </div>

                            <div class="form-group">
                              <label>Nombre de contacto de urgencia</label>

                              <div class="input-group">

                                <input required name="emergency_name" value="<?php echo $result ? $result['emergency_name'] : ''; ?>" type="text" class="form-control form-control-border border-width-2" placeholder="...">
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Número de contacto de urgencia</label>

                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input required name="emergency_number" value="<?php echo $result ? $result['emergency_number'] : ''; ?>" type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputBorderWidth2">Domicilio</label>
                              <input required name="address" value="<?php echo $result ? $result['address'] : ''; ?>" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputBorderWidth2">Alergias</label>
                              <input name="allergy" type="text" value="<?php echo $result ? $result['allergy'] : ''; ?>" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" placeholder="...">
                            </div>
                          </div>
                        </div>
                        <?php
                        if ($error) {

                          echo $error;
                          unset($error);
                        }  ?>
                      </div>
                    </div>
                  </div>
                  <div class="card card-maroon">
                    <div class="card-header">
                      <h3 class="card-title"><strong>Historia Clínica</strong></h3>
                    </div>
                    <div class="card-body">
                      <div class="container">
                        <div class="row justify-content-around">
                          <div class="col-4">
                            <?php require_once '../../controller/MedicalHistoryController.php';
                            $medicalHistoryController = new MedicalHistoryController();
                            $mh = $medicalHistoryController->get_medical_history();
                            foreach (array_slice($mh, 0, 9)  as $medical_history) {
                            ?>
                              <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                  <input <?= in_array($medical_history['id'], empty($result['medical_history']) ? array() : $result['medical_history']) ? 'checked="checked"' : '' ?> class="custom-control-input" type="checkbox" id="<?= $medical_history['id'] ?>" name="medical_history[]" value="<?= $medical_history['id'] ?>">
                                  <label for="<?= $medical_history['id'] ?>" class="custom-control-label"><?= $medical_history['name'] ?></label>
                                </div>
                              </div>
                            <?php } ?>
                          </div>
                          <div class="col-4">
                            <?php
                            foreach (array_slice($mh, 9, 9)  as $medical_history) {
                            ?>
                              <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                  <input <?= in_array($medical_history['id'], empty($result['medical_history']) ? array() : $result['medical_history']) ? 'checked="checked"' : '' ?> class="custom-control-input" type="checkbox" id="<?= $medical_history['id'] ?>" name="medical_history[]" value="<?= $medical_history['id'] ?>">
                                  <label for="<?= $medical_history['id'] ?>" class="custom-control-label"><?= $medical_history['name'] ?></label>
                                </div>
                              </div>
                            <?php } ?>
                          </div>
                          <div class="col-4">
                            <?php
                            foreach (array_slice($mh, 18, 8)  as $medical_history) {
                            ?>
                              <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                  <input <?= in_array($medical_history['id'], empty($result['medical_history']) ? array() : $result['medical_history']) ? 'checked="checked"' : '' ?> class="custom-control-input" type="checkbox" id="<?= $medical_history['id'] ?>" name="medical_history[]" value="<?= $medical_history['id'] ?>">
                                  <label for="<?= $medical_history['id'] ?>" class="custom-control-label"><?= $medical_history['name'] ?></label>
                                </div>
                              </div>
                            <?php } ?>
                            <div class="form-group">
                              <label for="exampleSelectBorderWidth2">Del 1 al 10 como considera su aptitud física</label>

                              <select required name="physical_aptitude" class="custom-select form-control-border border-width-2" id="exampleSelectBorderWidth2">
                                <option value="0">Ninguna</option>
                                <?php
                                for ($i = 1; $i <= 10; $i++) {
                                ?>
                                  <option <?= $result['physical_aptitude'] == $i ? ' selected="selected"' : ''; ?> value="<?= $i ?>"><?= $i ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                    <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                      <input type="hidden" name="type_s" id="type_s" value=''>
                      </form>
                      <button onclick="return update_student('<?= $result['type']; ?>');" type="button" class="btn bg-orange"><i class="fas fa-user-edit"></i> Actualizar datos</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-2 mb-2"><a type="button" href="<?php echo BASE_URL; ?>views/students/students.php" class="btn btn-block bg-maroon btn-sm"><i class="fas fa-arrow-left"></i>Volver</a></div>
          </div>
        

      <?php }
      }
      unset($result); ?>

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
  <script src="<?php echo BASE_URL; ?>/dist/js/confirm.js"></script>
  <script src="<?php echo BASE_URL; ?>/dist/js/dont_forward.js"></script>

  <!-- Page specific script -->
  <script>
    function update_student($type) {
      $('#type_s').val($type);
      return confirm('#update_student', false);
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