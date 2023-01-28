<?php

require_once 'const.php';
include  ROOTPATH . "/fpdf/fpdf.php";
require_once(ROOTPATH . '/vendor/autoload.php');
require_once 'get_age.php';

use setasign\Fpdi\Fpdi;

$pdf = new Fpdi();
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile(ROOTPATH . "/dist/pdfs/adult.pdf");
// import page 1
$tplId = $pdf->importPage(1);
// use the imported page and place it at point 10,10 with a width of 100 mm
$pdf->useTemplate($tplId, 0, 0);

$pdf->SetFont('Arial');
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(53, 67.5);
$pdf->Write(0, $_POST['student_surname'] . ' ' . $_POST['student_name']);
$pdf->SetXY(158, 67.5);
$pdf->Write(0, $_POST['private_number']);
$pdf->SetXY(40, 75.5);
$pdf->Write(0, get_age($_POST['date_birth']));
$pdf->SetXY(110, 75.5);
$pdf->Write(0, $_POST['weight'].'KG');
$pdf->SetXY(42, 83);
$pdf->Write(0, $_POST['pathologies']);
$pdf->SetXY(38, 106.3);
$pdf->Write(0, $_POST['allergy']);
$pdf->SetXY(124, 106.3);
$pdf->Write(0, $_POST['medication']);




$pdf->SetFont('Arial', '', 25);
require_once ROOTPATH . '/controller/MedicalHistoryController.php';
$medicalHistoryController = new MedicalHistoryController();
$x1 = 167;
$x2 = 182;
$y = 125;

foreach ($medicalHistoryController->get_medical_history(true) as $medical_history) {

    if (in_array($medical_history['id'], empty($_POST['medical_history']) ? array() :  $_POST['medical_history'])) {
        $pdf->SetXY($x1, $y);
        $pdf->Write(0, 'O');
    } else {
        $pdf->SetXY($x2, $y);
        $pdf->Write(0, 'O');
    }
    $y = $y + 5.65;
}

if (in_array(11, empty($_POST['medical_history']) ? array() :  $_POST['medical_history'])) {
    $pdf->SetXY(71.5, 176);
    $pdf->Write(0, 'O');
} else {
    $pdf->SetXY(84.5, 176);
    $pdf->Write(0, 'O');
}

$pdf->SetFont('Arial', '', 15);
$pdf->SetXY(80, 275);
$pdf->Write(0, $_POST['physical_aptitude']);


$pdf->Output($_POST['student_surname'] . ' ' . $_POST['student_name'] . '.pdf','D');
