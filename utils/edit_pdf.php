<?php
require_once 'const.php';
include  ROOTPATH . "/fpdf/fpdf.php";
require_once(ROOTPATH . '/vendor/autoload.php');

use setasign\Fpdi\Fpdi;

$pdf = new Fpdi();
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile(ROOTPATH . "/dist/pdfs/child.pdf");
// import page 1
$tplId = $pdf->importPage(1);
// use the imported page and place it at point 10,10 with a width of 100 mm
$pdf->useTemplate($tplId, 0, 0);

$pdf->SetFont('Arial');
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(55, 61);
$pdf->Write(0, $_POST['student_surname'] . ' ' . $_POST['student_name']);
$pdf->SetXY(59, 68);
$pdf->Write(0, $_POST['date_birth']);
$pdf->SetXY(61, 75);
$pdf->Write(0, $_POST['father_name']);
$pdf->SetXY(69, 82);
$pdf->Write(0, $_POST['mother_name']);
$pdf->SetXY(56, 89);
$pdf->Write(0, $_POST['private_number']);
$pdf->SetXY(56, 96);
$pdf->Write(0, $_POST['emergency_number']);
$pdf->SetXY(42, 103);
$pdf->Write(0, $_POST['address']);
$pdf->SetXY(45, 110);
$pdf->Write(0, $_POST['email']);

require_once ROOTPATH . '/controller/SocialWorkController.php';
$socialWorkController = new SocialWorkController();
$pdf->SetXY(55, 117);
$pdf->Write(0, $socialWorkController->get_only_social_work($_POST['medical_coverage']));
unset($socialWorkController);

$pdf->SetXY(123, 117);
$pdf->Write(0, $_POST['affiliate_number']);
$pdf->SetXY(43, 142);

$pdf->Write(0, in_array(1, empty ($_POST['had_disease']) ? array() :  $_POST['had_disease']) ? 'X' : '');

$pdf->SetXY(84, 142);
$pdf->Write(0, in_array(2, empty ($_POST['had_disease']) ? array() :  $_POST['had_disease']) ? 'X' : '');
$pdf->SetXY(127, 142);
$pdf->Write(0, in_array(3, empty ($_POST['had_disease']) ? array() :  $_POST['had_disease']) ? 'X' : '');
$pdf->SetXY(163, 145);
$pdf->Write(0, in_array(4, empty ($_POST['had_disease']) ? array() :  $_POST['had_disease']) ? 'X' : '');

$pdf->SetXY(53, 149);
$pdf->Write(0, in_array(5, empty ($_POST['had_disease']) ? array() :  $_POST['had_disease']) ? 'X' : '');
$pdf->SetXY(84, 149);
$pdf->Write(0, in_array(6, empty ($_POST['had_disease']) ? array() :  $_POST['had_disease']) ? 'X' : '');
$pdf->SetXY(115, 150);
$pdf->Write(0, $_POST['other_diseases_1']);
$pdf->SetXY(43, 165);
$pdf->Write(0, in_array(7, empty ($_POST['diseases']) ? array() :  $_POST['diseases'] ) ? 'X' : '');
$pdf->SetXY(84, 165);
$pdf->Write(0, in_array(8, empty ($_POST['diseases']) ? array() :  $_POST['diseases']) ? 'X' : '');

$pdf->SetXY(123, 165);
$pdf->Write(0, in_array(9, empty ($_POST['diseases']) ? array() :  $_POST['diseases']) ? 'X' : '');


$pdf->SetXY(171, 168);
$pdf->Write(0, in_array(10, empty ($_POST['diseases']) ? array() :  $_POST['diseases']) ? 'X' : '');

$pdf->SetXY(34, 172);
$pdf->Write(0, $_POST['other_diseases_2']);

if (empty($_POST['internated'])) {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(91.5, 182.5);
    $pdf->Write(0, 'O');
    $pdf->SetFont('Arial','',12);
} else {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(83, 183);
    $pdf->Write(0, 'O');
    $pdf->SetFont('Arial','',12);
    $pdf->SetXY(128, 182);
    $pdf->Write(0, $_POST['internated']);
}

if (empty($_POST['surgery'])) {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(91.5, 190);
    $pdf->Write(0, 'O');
    $pdf->SetFont('Arial','',12);
} else {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(83, 190);
    $pdf->Write(0, 'O');
    $pdf->SetFont('Arial','',12);
    $pdf->SetXY(127, 190);
    $pdf->Write(0, $_POST['surgery']);
}


if (empty($_POST['medication'])) {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(91.5, 198);
    $pdf->Write(0, 'O');
    $pdf->SetFont('Arial','',12);
} else {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(83, 198);
    $pdf->Write(0, 'O');
    $pdf->SetFont('Arial','',12);
    $pdf->SetXY(115, 198);
    $pdf->Write(0, $_POST['medication']);
}

if (empty($_POST['antitetano'])) {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(91.5, 206);
    $pdf->Write(0, 'O');
    $pdf->SetFont('Arial','',12);
} else {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(83, 206);
    $pdf->Write(0, 'O');
    $pdf->SetFont('Arial','',12);
    $pdf->SetXY(114, 205.5);
    $pdf->Write(0, $_POST['antitetano']);
}

if (empty($_POST['diet'])) {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(91.5, 214);
    $pdf->Write(0, 'O');
    $pdf->SetFont('Arial','',12);
} else {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(83, 214);
    $pdf->Write(0, 'O');
    $pdf->SetFont('Arial','',12);
    $pdf->SetXY(151, 213.5);
    $pdf->Write(0, $_POST['diet']);
}

if (empty($_POST['allergy'])) {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(91.5, 221);
    $pdf->Write(0, 'O');
    $pdf->SetFont('Arial','',12);
} else {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(83, 221);
    $pdf->Write(0, 'O');
    $pdf->SetFont('Arial','',12);
    $pdf->SetXY(115, 221);
    $pdf->Write(0, $_POST['allergy']);
}



if (empty($_POST['authorized'])) {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(174, 239.5);
    $pdf->Write(0, 'O');

} else {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(161, 239.5);
    $pdf->Write(0, 'O');

}

if (empty($_POST['changed'])) {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(174, 247);
    $pdf->Write(0, 'O');

} else {
    $pdf->SetFont('Arial','', 25);
    $pdf->SetXY(161, 247);
    $pdf->Write(0, 'O');

}
$pdf->SetFont('Arial','',12);
$pdf->Output($_POST['student_surname'] . ' ' . $_POST['student_name'] . '.pdf','D');
