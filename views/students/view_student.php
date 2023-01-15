<?php


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

require_once '../../utils/const.php';
require_once ROOTPATH . '/controller/SessionController.php';
SessionController::mustBeLoggedIn();


if (!empty($_GET)) {
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
    <title><?php echo HEAD; ?> | FT</title>
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/dist/img/dance.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dist/css/adminlte.min.css?v=3.2.0">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <?php require_once ROOTPATH . '/common/navbar.php' ?>

        <div class="content-wrapper">

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Ficha técnica</h1>
                        </div>

                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header bg-lime">
                                    <h3 class="card-title ">Alumno: <strong><?php echo $student['name'] . ' ' . $student['surname'] . '#' . $student['id']; ?></strong></h3>
                                </div>

                                <div class="card-body">
                                    <strong><i class="fas fa-book mr-1"></i> Datos personales</strong>
                                    <p>Fecha nacimiento: <span class="text-info"><?php echo $student['birth_date'] ?></span>&nbsp;-Número privado: <span class="text-info"><?php echo $student['private_phone_number'] ?></span>&nbsp;-Número de emergencia: <span class="text-info"><?php echo $student['emergency_phone_number'] ?></span>
                                        &nbsp;-Obra social: <span class="text-info"><?php echo $student['social_work'] ?></span>
                                        <br>N°afiliado: <span class="text-info"><?php echo $student['afiliate_number'] ?></span>
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-users mr-1"></i> Nombre y Email de padres/tutores</strong>
                                    <p>Padre/Tutor: <span class="text-info"><?php echo $student['father_name'] ?></span>&nbsp;-Madre/Tutora: <span class="text-info"><?php echo $student['mother_name'] ?></span>&nbsp;-Email: <span class="text-info"><?php echo $student['parents_email'] ?></span></p>
                                    <hr>
                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Domicilio</strong>
                                    <p class="text-info"><?php echo $student['address'] ?></p>
                                    <hr>
                                    <strong><i class="fas fa-pencil-alt mr-1"></i> Enfermedades</strong>
                                    <p>
                                        <span class="tag tag-danger text-danger"><?php echo (empty($student['diseases']) ? '' : ($student['diseases'] . ',')) . $student['other_disease_1'] . ',' . $student['other_disease_2'] ?></span>
                                    </p>
                                    <hr>
                                    <strong><i class="far fa-file-alt mr-1"></i> Historia clínica</strong>
                                    <p><span>¿Fué internado?: </span><span class="text-danger"><?php echo empty($student['internal']) ? 'No' : $student['internal'] ?></span>&nbsp;&nbsp;-¿Fué intervenido quirúrgicamente?: <span class="text-danger"><?php echo empty($student['surgery']) ? 'No' : $student['surgery'] ?></span>&nbsp;&nbsp;-¿Toma medicación?: <span class="text-danger"><?php echo empty($student['medication']) ? 'No' : $student['medication'] ?></span>&nbsp;&nbsp;-¿Vacuna del tétano?: <span class="text-danger"><?php echo empty($student['tetanus_vaccine']) ? 'No' : 'Fecha: ' . $student['tetanus_vaccine'] ?></span>&nbsp;&nbsp;-¿Tiene alergias?: <span class="text-danger"><?php echo empty($student['allergy']) ? 'No' : $student['allergy'] ?></span>&nbsp;&nbsp;-¿Hace alguna dieta?: <span class="text-danger"><?php echo empty($student['diet']) ? 'No' : $student['diet'] ?></span></p>
                                    <hr>
                                    <div class="container">
                                        <div class="row justify-content-between">
                                            <div class="col-6">
                                                <strong><i class="fas fa-money-check-alt mr-1"></i> Cuotas abonadas</strong>
                                            </div>
                                            <div class="col-2">
                                                <a type="button" href="<?php echo BASE_URL; ?>views/students/pay_social_fee.php?id=<?php echo $student['id'] ?>" class="btn btn-block btn-success"><i class="fas fa-money-check-alt mr-1"></i>Abonar cuota</a>
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <div class="card">

                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <?php if (!empty($student['shares'])) { ?>
                                                <table id="example1" class="table table-bordered table-striped table-hover table-sm">
                                                    <thead>
                                                        <tr>

                                                            <th>Fecha cuota</th>
                                                            <th>Importe abonado</th>
                                                            <th>Fecha pago</th>
                                                            <th>Descargar recibo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $shares = explode(",", $student['shares']);
                                                        foreach (explode(",", $student['shares']) as $share) {
                                                            $share = explode(":", $share); ?>
                                                            <tr>
                                                                <td><?php echo $share[0]; ?></td>
                                                                <td><?php echo '$' . $share[1]; ?></td>
                                                                <td><?php echo $share[2]; ?></td>
                                                                <td class="text-center"><a onclick="send_share_id('<?php echo $share[3] ?>');" type="button" class="btn btn-default bg-danger ">
                                                                        <i class="fas fa-file-pdf"></i>
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

                                    <div class="col-2"><a type="button" href="<?php echo BASE_URL; ?>views/students/students.php" class="btn btn-block bg-maroon btn-sm"><i class="fas fa-arrow-left"></i>Volver</a></div>
                                </div>


                            </div>


                        </div>



                    </div>

                </div>
            </section>

        </div>

        <?php require_once ROOTPATH . '/common/footer.php' ?>

    </div>


    <script src="<?php echo BASE_URL; ?>/plugins/jquery/jquery.min.js"></script>

    <script src="<?php echo BASE_URL; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="<?php echo BASE_URL; ?>/dist/js/adminlte.min.js?v=3.2.0"></script>
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
    <script src="<?php echo BASE_URL; ?>/dist/js/datatable.js"></script>
</body>



</html>