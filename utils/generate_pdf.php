<?php
require_once 'const.php';
include  ROOTPATH . "/fpdf/fpdf.php";

class PDF extends FPDF
{
        protected $B = 0;
        protected $I = 0;
        protected $U = 0;
        protected $HREF = '';
        // Cargar los datos
        function LoadData($file)
        {
                // Leer las líneas del fichero
        }

        function Header()
        {
                $this->SetFont('Arial', 'B', 15);
                $this->setX(20);

                // $this->Line(20, 6, 195, 6); // 20mm from each edge

                //$this->Line(20, 260.5, 200, 260.5); // 20mm from each edge
                //$this->Line(20, 261.5, 200, 261.5); // 20mm from each edge
                // $this->Line(20, 262.5, 200, 262.5); // 20mm from each edge
                $this->SetFont('Arial', 'B', 30);
                $this->Cell(200, 10, "NatyRusso");
                $this->Ln();

                $this->setY(7);
                $this->SetFont('Arial', 'B', 10);
                $this->setX(165 - 5);
                $this->Cell(39, 6, "FECHA DE ALTA", 1, 0, 'C');
                $this->setY(13);
                $this->setX(165 - 5);
                $this->Cell(39, 6, date('Y-m-d'), 1, 0, 'C');
        }


        // Tabla simple
        function ImprovedTable($data)
        {
                $this->setY(31);
                $this->setX(20);
                $this->SetFont('Arial', 'B', 16);
                $this->Cell(0, 10, "Datos Generales");
                $this->setY(39);
                $this->setX(20);
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(0, 22, "", 1);
                $this->setY(40);
                $this->setX(20);
                $this->WriteHTML(utf8_decode(" NOMBRE COMPLETO:  <u>{$_POST['student_name']} {$_POST['student_surname']}</u>   <b>FECHA DE NACIMIENTO:</b> <u>{$_POST['date_birth']}</u>     <b>COBERTURA MÉDICA:</b> <u>{$_POST['medical_coverage']}</u>"));

                $this->setY(45);
                $this->setX(20);
                $this->WriteHTML(utf8_decode(" <b>NOMBRE PADRE/TUTOR:</b> <u>{$_POST['father_name']}</u>      <b>NOMBRE MADRE/TUTORA:</b> <u>{$_POST['mother_name']}</u>     <b>N°AFILIADO:</b> <u>{$_POST['affiliate_number']}</u>"));
                $this->setY(50);
                $this->setX(20);
                $this->WriteHTML(utf8_decode(" <b>TELÉFONO PARTICULAR:</b> <u>{$_POST['private_number']}</u>  <b>NOMBRE DE CONTACTO DE URGENCIA:</b> <u>{$_POST['emergency_name']}</u>     <b>DOMICILIO:</b> <u>{$_POST['address']}</u>"));
                $this->setY(53);
                $this->setX(20);
                $this->Cell(0, 10, utf8_decode(" EMAIL DE PADRES: {$_POST['email']}          NÚMERO DE CONTACTO DE URGENCIA: {$_POST['emergency_number']}"));
                $this->setY(58);


                $this->SetFont('Arial', 'B', 16);
                $this->setY(70);
                $this->setX(20);
                $this->Cell(0, 10, utf8_decode("Historia Clínica"));
                $this->setY(78);
                $this->setX(20);
                $this->Cell(0, 13, "", 1);
                $this->setY(77);
                $this->setX(20);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 10, " Enfermedades:       Vacuna antitetanica:            Cuadro alergico: ");
                $this->setY(82);
                $this->setX(20);
                $this->Cell(0, 10, " Cuadro alergico:     Quirurgia:            Dieta:          Internacion: ");
                $this->SetFont('Arial', 'B', 16);
                $this->setY(100);
                $this->setX(20);
                $this->Cell(0, 10, "Firmas/Autorizaciones");
                $this->setY(108);
                $this->setX(20);
                $this->Cell(0, 45, "", 1);
                $this->setY(107);
                $this->setX(20);
                $this->SetFont('Arial', 'B', 8);
                $this->setY(107);
                $this->setX(20);
                $this->Cell(0, 10, utf8_decode(" ¿Autoriza a su hija/o a salir en fotos?:"));
                $this->setY(112);
                $this->setX(20);
                $this->Cell(0, 10, utf8_decode(" Firma y aclaración del mayor responsable:"));
                $this->setY(132);
                $this->setX(20);
                $this->Cell(0, 10, utf8_decode(" Firma y sello del médico de cabecera:"));
        }

        function WriteHTML($html)
        {
                // HTML parser
                $html = str_replace("\n", ' ', $html);
                $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
                foreach ($a as $i => $e) {
                        if ($i % 2 == 0) {
                                // Text
                                if ($this->HREF)
                                        $this->PutLink($this->HREF, $e);
                                else
                                        $this->Write(5, $e);
                        } else {
                                // Tag
                                if ($e[0] == '/')
                                        $this->CloseTag(strtoupper(substr($e, 1)));
                                else {
                                        // Extract attributes
                                        $a2 = explode(' ', $e);
                                        $tag = strtoupper(array_shift($a2));
                                        $attr = array();
                                        foreach ($a2 as $v) {
                                                if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
                                                        $attr[strtoupper($a3[1])] = $a3[2];
                                        }
                                        $this->OpenTag($tag, $attr);
                                }
                        }
                }
        }

        function OpenTag($tag, $attr)
        {
                // Opening tag
                if ($tag == 'B' || $tag == 'I' || $tag == 'U')
                        $this->SetStyle($tag, true);
                if ($tag == 'A')
                        $this->HREF = $attr['HREF'];
                if ($tag == 'BR')
                        $this->Ln(5);
        }

        function CloseTag($tag)
        {
                // Closing tag
                if ($tag == 'B' || $tag == 'I' || $tag == 'U')
                        $this->SetStyle($tag, false);
                if ($tag == 'A')
                        $this->HREF = '';
        }

        function SetStyle($tag, $enable)
        {
                // Modify style and select corresponding font
                $this->$tag += ($enable ? 1 : -1);
                $style = '';
                foreach (array('B', 'I', 'U') as $s) {
                        if ($this->$s > 0)
                                $style .= $s;
                }
                $this->SetFont('', $style);
        }

        function PutLink($URL, $txt)
        {
                // Put a hyperlink
                $this->SetTextColor(0, 0, 255);
                $this->SetStyle('U', true);
                $this->Write(5, $txt, $URL);
                $this->SetStyle('U', false);
                $this->SetTextColor(0);
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
