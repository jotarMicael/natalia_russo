<?php
require_once 'const.php';
include  ROOTPATH . "/fpdf/fpdf.php";

class PDF extends FPDF
{
// Cargar los datos
function LoadData($file)
{
    // Leer las líneas del fichero
}

function Header(){
        $this->SetFont('Arial','B',15);
        $this->setX(20);

// $this->Line(20, 6, 195, 6); // 20mm from each edge

//$this->Line(20, 260.5, 200, 260.5); // 20mm from each edge
//$this->Line(20, 261.5, 200, 261.5); // 20mm from each edge
// $this->Line(20, 262.5, 200, 262.5); // 20mm from each edge
        $this->SetFont('Arial','B',30);
        $this->Cell(200,10,"NatyRusso");
        $this->Ln();

        $this->setY(7);
        $this->SetFont('Arial','B',10);
        $this->setX(165-5);
        $this->Cell(39,6,"FECHA DE ALTA",1,0,'C');
        $this->setY(13);
        $this->setX(165-5);
        $this->Cell(39,6,date('Y-m-d'),1,0,'C');
       

}
// Tabla simple
function ImprovedTable($data)
{
    $this->setY(31);
    $this->setX(20);
    $this->SetFont('Arial','B',16);
    $this->Cell(0,10,"Datos Generales");
    $this->setY(39);
    $this->setX(20);
    $this->SetFont('Arial','B',8);
    $this->Cell(0,22,"",1);
    $this->setY(38);
    $this->setX(20);
    $this->Cell(0,10,utf8_decode(" NOMBRE COMPLETO:  {$_POST['student_name']} {$_POST['student_surname']}   FECHA DE NACIMIENTO: {$_POST['date_birth']}     COBERTURA MÉDICA: {$_POST['medical_coverage']} "));
    $this->setY(43);
    $this->setX(20);
    $this->Cell(0,10,utf8_decode(" NOMBRE PADRE/TUTOR: {$_POST['father_name']}      NOMBRE MADRE/TUTORA: {$_POST['mother_name']}     N°AFILIADO: {$_POST['affiliate_number']}"));
    $this->setY(48);
    $this->setX(20);
    $this->Cell(0,10,utf8_decode(" TELÉFONO PARTICULAR: {$_POST['private_number']}  NOMBRE DE CONTACTO DE URGENCIA: {$_POST['emergency_name']}     DOMICILIO: {$_POST['address']}"));
    $this->setY(53);
    $this->setX(20);
    $this->Cell(0,10,utf8_decode(" EMAIL DE PADRES: {$_POST['email']}          NÚMERO DE CONTACTO DE URGENCIA: {$_POST['emergency_number']}"));
    $this->setY(58);
    $this->setX(20);

       
        $this->SetFont('Arial','B',16);
        $this->setY(70);
        $this->setX(20);
        $this->Cell(0,10,utf8_decode("Historia Clínica"));
        $this->setY(78);
        $this->setX(20);
        $this->Cell(0,13,"",1);
        $this->setY(77);
        $this->setX(20);
        $this->SetFont('Arial','B',8);
        $this->Cell(0,10," Enfermedades:       Vacuna antitetanica:            Cuadro alergico: ");
        $this->setY(82);
        $this->setX(20);
        $this->Cell(0,10," Cuadro alergico:     Quirurgia:            Dieta:          Internacion: ");
        $this->SetFont('Arial','B',16);
        $this->setY(100);
        $this->setX(20);
        $this->Cell(0,10,"Firmas/Autorizaciones");
        $this->setY(108);
        $this->setX(20);
        $this->Cell(0,45,"",1);
        $this->setY(107);
        $this->setX(20);
        $this->SetFont('Arial','B',8);
        $this->setY(107);
        $this->setX(20);
        $this->Cell(0,10,utf8_decode(" ¿Autoriza a su hija/o a salir en fotos?:" ));
        $this->setY(112);
        $this->setX(20);
        $this->Cell(0,10,utf8_decode(" Firma y aclaración del mayor responsable:") );
        $this->setY(132);
        $this->setX(20);
        $this->Cell(0,10,utf8_decode(" Firma y sello del médico de cabecera:") );
}

// Tabla coloreada
}

$pdf = new PDF();
$pdf->AddPage();
// $pdf->Header();
$pdf->ImprovedTable("hola");

//echo $name;
$pdf->Output();
//print "<script>window.location=\"".$name."\";</script>";
?>