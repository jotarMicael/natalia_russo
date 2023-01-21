<?php



class Student
{

    private $conn;
    private $table_name = "students";
    private $table_name2 = "students_diseases";
    private $table_name3 = "social_works";
    private $table_name4 = "students_share";
    private $table_name5 = "diseases";
    private $table_name6 = "students_activities";

    public function __construct($db = null)
    {
        $this->conn = $db;
    }

    public function __destruct()
    {
    }

    function insert_student(&$student)
    {
        #return array(1, '<strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> dado de alta');


        try {

            if (empty($student['student_name']) || empty($student['student_surname']) || empty($student['date_birth']) || empty($student['father_name']) || empty($student['mother_name']) || empty($student['private_number']) || empty($student['emergency_number']) || empty($student['address']) || empty($student['email']) || empty($student['medical_coverage']) || empty($student['affiliate_number']) || empty($student['emergency_name']) || empty($student['activities']) ) {
                return array(4, '<div class="text-danger">Todos los campos de esta sección deben completarse*</div>');
            }


            $query = " SELECT s.id FROM " . $this->table_name . " s 
            WHERE
                s.name=:name and s.surname=:surname
            LIMIT 0,1
        ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":name", $student['student_name']);
            $stmt->bindParam(":surname", $student['student_surname']);

            $stmt->execute();


            if (!empty($stmt->fetch(PDO::FETCH_ASSOC))) {
                return array(2, 'El alumno <strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> ya se encuentra registrado en el sistema');
            }

            $insert = '';
            $values = '';

            if (!empty($student['other_diseases_1'])) {
                $insert .= ',other_disease_1';
                $values .= ",'" . $student['other_diseases_1'] . "'";
            }

            if (!empty($student['other_diseases_2'])) {
                $insert .= ',other_disease_2';
                $values .= ",'" . $student['other_diseases_2'] . "'";
            }

            if (!empty($student['internated'])) {
                $insert .= ',internal';
                $values .= ",'" . $student['internated'] . "'";
            }

            if (!empty($student['surgery'])) {
                $insert .= ',surgery';
                $values .= ",'"  . $student['surgery'] . "'";
            }

            if (!empty($student['medication'])) {
                $insert .= ',medication';
                $values .= ",'" . $student['medication'] . "'";
            }

            if (!empty($student['antitetano'])) {
                $insert .= ',tetanus_vaccine';
                $values .= ",'"  . substr($student['antitetano'], 6, 4) . '-' . substr($student['antitetano'], 3, 2) . '-' . substr($student['antitetano'], 0, 2) . "'";
            }

            if (!empty($student['diet'])) {
                $insert .= ',diet';
                $values .= ",'" .  $student['diet'] . "'";
            }

            if (!empty($student['allergy'])) {
                $insert .= ',allergy';
                $values .= ",'" . $student['allergy'] . "'";
            }

            $query = "INSERT INTO " . $this->table_name . " 
            (
            name,
            surname,
            birth_date,
            father_name,
            mother_name,
            private_phone_number,
            emergency_phone_number,
            emergency_name,
            address,
            parents_email,
            social_work_id,
            afiliate_number,
            authorized " . $insert . ")
            VALUES
            ('{$student['student_name']}','{$student['student_surname']}','" . substr($student['date_birth'], 6, 4) . '-' . substr($student['date_birth'], 3, 2) . '-' . substr($student['date_birth'], 0, 2) . "','{$student['father_name']}','{$student['mother_name']}','{$student['private_number']}','{$student['emergency_number']}','{$student['emergency_name']}','{$student['address']}','{$student['email']}',{$student['medical_coverage']},'{$student['affiliate_number']}'," . (empty($student['authorized']) ? 0 : 1) .  $values . " );
        ";


            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $id = $this->conn->lastInsertId();

            if (!empty($student['had_disease'])) {
                $had_diseases = [];
                foreach ($student['had_disease'] as $disease) {
                    $had_diseases[] = "($id,$disease)";
                }

                $query = "INSERT INTO " . $this->table_name2 . " 
                        (student_id,disease_id)
                        VALUES
                        " . implode(",", $had_diseases) . ";
                ";

                $stmt = $this->conn->prepare($query);

                $stmt->execute();
            }

            if (!empty($student['diseases'])) {
                $diseases = [];
                foreach ($student['diseases'] as $disease) {
                    $diseases[] = "($id,$disease)";
                }

                $query = "INSERT INTO " . $this->table_name2 . " 
                        (student_id,disease_id)
                        VALUES
                        " . implode(",", $diseases) . ";
                ";

                $stmt = $this->conn->prepare($query);

                $stmt->execute();
            }

            
                $activities = [];
                foreach ($student['activities'] as $activity) {
                    $activities[] = "($id,$activity)";
                }

                $query = "INSERT INTO " . $this->table_name6 . " 
                        (student_id,activity_id)
                        VALUES
                        " . implode(",", $activities) . ";
                ";

                $stmt = $this->conn->prepare($query);

                $stmt->execute();
            

            return array(1, '<strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> dado de alta');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    function get_all_student_actives()
    {
        try {
            $query = " SELECT * FROM " . $this->table_name . " s 
            WHERE s.active=1
        ";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }


    function get_information_student(&$student_id)
    {

        try {
            $query = " SELECT s.id,
            s.name,
            s.surname,
            s.birth_date,
            s.father_name,
            s.mother_name,
            s.private_phone_number,
            s.emergency_phone_number,
            s.emergency_name,
            s.address,
            s.parents_email,
            sw.name as social_work,
            s.afiliate_number,
            s.other_disease_1,
            s.other_disease_2,
            s.internal,
            s.surgery,
            s.medication,
            s.tetanus_vaccine,
            s.diet,
            s.allergy,
            (SELECT GROUP_CONCAT(d.name)  FROM  " . $this->table_name2 . " sd
            INNER JOIN " . $this->table_name5 . " d ON (sd.disease_id=d.id)
            WHERE sd.student_id = s.id ) AS diseases,
            (SELECT GROUP_CONCAT(DISTINCT CONCAT(DATE_FORMAT(ss.share_date, '%m/%Y'),':',ss.import,':',DATE_FORMAT(ss.created_at, '%d/%m/%Y'),':',ss.id) ORDER BY ss.share_date DESC SEPARATOR ',') 
             FROM " . $this->table_name4 . "  ss 
             WHERE ss.student_id = s.id) AS shares
             FROM " . $this->table_name . " s 
                INNER JOIN " . $this->table_name3 . " sw ON (s.social_work_id=sw.id)
            WHERE s.id=:id and s.active=1
            GROUP BY s.id
            LIMIT 0,1
        ";


            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $student_id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    function pay_social_fee(&$student_id, $share_date, &$import)
    {
        try {
            if (strpos($share_date, 'm') || strpos($share_date, 'y')) {
                return throw new Exception();
            }

            $share_date = substr($share_date, 3, 4) . '-' . substr($share_date, 0, 2) . '-' . '01';

            $query = " SELECT ss.id
            FROM " . $this->table_name4 . " ss
            WHERE ss.student_id=:student_id and ss.share_date BETWEEN :share_date AND LAST_DAY(:share_date)
            LIMIT 0,1
            ";


            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':share_date', $share_date);


            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                return array(2, 'La cuota del <strong>' .  substr($share_date, 5, 2) . '/' .  substr($share_date, 0, 4)   . '</strong> ya se encuentra abonada en el sistema');
            }

            $query = " INSERT INTO  " . $this->table_name4 . " (student_id,share_date,import)
            VALUES($student_id,'$share_date',$import)
            ";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return array(1, 'La cuota del <strong>' .  substr($share_date, 5, 2) . '/' .  substr($share_date, 0, 4)   . '</strong> ha sido registrada en el sistema');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    function generate_fee_pdf(&$share_id)
    {
        $query = " SELECT CONCAT (s.name, ' ', s.surname) as complete_name,s.address,s.private_phone_number,s.parents_email,DATE_FORMAT(ss.share_date,'%m/%Y') as share_date,DATE_FORMAT(ss.created_at,'%d/%m/%Y %H:%m:%s') as created_at, ss.import  
        FROM " . $this->table_name4 . " ss
        INNER JOIN " . $this->table_name . " s ON (ss.student_id=s.id)
        WHERE ss.id=:share_id
        LIMIT 0,1
            ";


        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':share_id', $share_id);

        $stmt->execute();

        $share = $stmt->fetch(PDO::FETCH_ASSOC);

        include "../../fpdf/fpdf.php";

        $pdf = new FPDF($orientation = 'P', $unit = 'mm');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 20);
        $textypos = 5;
        $pdf->setY(12);
        $pdf->setX(10);
        // Agregamos los datos de la empresa
        $pdf->Cell(5, $textypos, "Estudio de danza: Natalia Russo");
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setY(30);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "De:");
        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(35);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "Natalia Russo");


        // Agregamos los datos del cliente
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setY(30);
        $pdf->setX(65);
        $pdf->Cell(5, $textypos, "Alumno:");
        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(35);
        $pdf->setX(65);
        $pdf->Cell(5, $textypos, 'Nombre: ' . $share['complete_name']);
        $pdf->setY(40);
        $pdf->setX(65);
        $pdf->Cell(5, $textypos, 'Direccion: ' . $share['address']);
        $pdf->setY(45);
        $pdf->setX(65);
        $pdf->Cell(5, $textypos, 'Numero tel.: ' . $share['private_phone_number']);
        $pdf->setY(50);
        $pdf->setX(65);
        $pdf->Cell(5, $textypos, 'Email padres: ' . $share['parents_email']);

        // Agregamos los datos del cliente
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setY(30);
        $pdf->setX(135);
        $pdf->Cell(5, $textypos, "Recibo #" . $share_id);
        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(35);
        $pdf->setX(135);
        $pdf->Cell(5, $textypos, 'Fecha de cuota: ' . $share['share_date']);
        $pdf->setY(40);
        $pdf->setX(135);
        $pdf->Cell(5, $textypos, 'Fecha de pago: ' . $share['created_at']);
        $pdf->setY(45);
        $pdf->setX(135);
        $pdf->Cell(5, $textypos, "");
        $pdf->setY(50);
        $pdf->setX(135);
        $pdf->Cell(5, $textypos, "");

        /// Apartir de aqui empezamos con la tabla de productos
        $pdf->setY(60);
        $pdf->setX(135);
        $pdf->Ln();
        /////////////////////////////
        //// Array de Cabecera
        $header = array("Fecha de cuota", "Importe", "Fecha de pago");
        //// Arrar de Productos
        $products = array(
            array($share['share_date'], $share['import'], $share['created_at']),
        );
        // Column widths
        $w = array(30, 30, 40);
        // Header
        for ($i = 0; $i < count($header); $i++)
            $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        $pdf->Ln();
        // Data
        $total = 0;
        foreach ($products as $row) {
            $pdf->Cell($w[0], 5, $row[0],  '1', 0, 'R');
            $pdf->Cell($w[1], 5, "$ " . number_format($row[1], 2, ",", "."), '1', 0, 'R');
            $pdf->Cell($w[2], 5, $row[2],  '1', 0, 'R');

            $pdf->Ln();
        }
        /////////////////////////////
        //// Apartir de aqui esta la tabla con los subtotales y totales
        $yposdinamic = 60 + (count($products) * 10);

        $pdf->setY($yposdinamic);
        $pdf->setX(235);
        $pdf->Ln();
        /////////////////////////////
        $header = array("", "");
        $data2 = array(
            array("Subtotal", $share['import']),
            array("Descuento", 0),
            array("Impuesto", 0),
            array("Total", $share['import']),
        );
        // Column widths
        $w2 = array(40, 40);
        // Header

        $pdf->Ln();
        // Data
        foreach ($data2 as $row) {
            $pdf->setX(115);
            $pdf->Cell($w2[0], 6, $row[0], 1);
            $pdf->Cell($w2[1], 6, "$ " . number_format($row[1], 2, ",", "."), '1', 0, 'R');

            $pdf->Ln();
        }
        /////////////////////////////

        $yposdinamic += (count($data2) * 10);
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->setY($yposdinamic);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "TERMINOS Y CONDICIONES");
        $pdf->SetFont('Arial', '', 10);

        $pdf->setY($yposdinamic + 10);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "Se deja constancia que el cliente ha abonado la cuota mensual.");
        $pdf->setY($yposdinamic + 20);
        $pdf->setX(10);


        $pdf->output($share['complete_name'] . '-' . $share['share_date'] . '.pdf', 'D');


        return true;
    }

    public function delete_student(&$student_id)
    {


        try {
            $query = " UPDATE
            " . $this->table_name . " s 
            SET s.active=0
            WHERE s.id=:student_id
            LIMIT 1
                ";


            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':student_id', $student_id);

            $stmt->execute();

            return array(1, 'Alumno eliminado correctamente');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    public function get_only_student(&$student_id)
    {

        try {
            $query = " SELECT s.id as id,s.name AS student_name, sw.id AS medical_coverage, s.afiliate_number AS affiliate_number,s.address AS address, s.surname AS student_surname,s.father_name as father_name,s.private_phone_number AS private_number,s.parents_email AS parents_email,DATE_FORMAT(s.birth_date,'%dd/%mm/%Y') AS date_birth, s.mother_name AS mother_name,s.emergency_phone_number AS emergency_number,s.other_disease_1 as other_diseases_1,s.other_disease_2 as other_diseases_2,s.tetanus_vaccine as antitetano,s.allergy as allergy,s.surgery as surgery,s.diet as diet,s.internal as internated,s.medication as medication,s.authorized as authorized,
            GROUP_CONCAT(sd.disease_id) AS diseases 
            FROM " . $this->table_name . " s 
            INNER JOIN " . $this->table_name3 . " sw ON (s.social_work_id = sw.id) 
            LEFT JOIN " . $this->table_name2 . " sd ON (s.id=sd.student_id)
            WHERE s.active=1 and s.id=:student_id 
            LIMIT 1
                ";



            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':student_id', $student_id);

            $stmt->execute();

            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($student)) {
                throw new Exception();
            }
            return $student;

            return array(1, 'Alumno eliminado correctamente');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    function get_students_birthdate()
    {
        try {
            $query = " SELECT s.id as id, s.name as name, s.surname as surname, DATE_FORMAT(s.birth_date,'%m/%d') as birth_date
            FROM " . $this->table_name . " s 
            WHERE s.active=1 AND DAY(s.birth_date)<=DAY(DATE_ADD(CURRENT_DATE(), INTERVAL 7 DAY)) AND DAY(s.birth_date)>=DAY(NOW()) 
            AND MONTH(s.birth_date)=MONTH(CURRENT_DATE())
            ORDER BY s.birth_date DESC ";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    function update_student(&$student)
    {
        try {


            if (empty($student['student_name']) || empty($student['student_surname']) || empty($student['date_birth']) || empty($student['father_name']) || empty($student['mother_name']) || empty($student['private_number']) || empty($student['emergency_number']) || empty($student['address']) || empty($student['parents_email']) || empty($student['medical_coverage']) || empty($student['affiliate_number']) ) {
 
                return array(4, '<div class="invalid-feedback d-block">Todos los campos de esta sección deben completarse*</div>');
            }

            $insert = '';

            if (!empty($student['other_diseases_1'])) {
                $insert .= ',s.other_disease_1=' . "'" . $student['other_diseases_1'] . "'";
            }

            if (!empty($student['other_diseases_2'])) {
                $insert .= ',s.other_disease_2=' . "'" . $student['other_diseases_2'] . "'";
            }

            if (!empty($student['internated'])) {
                $insert .= ',s.internal=' . "'" . $student['internated'] . "'";
            }

            if (!empty($student['surgery'])) {
                $insert .= ',s.surgery=' . "'" . $student['surgery'] . "'";
            }

            if (!empty($student['medication'])) {
                $insert .= ',s.medication=' . "'" . $student['medication'] . "'";
            }

            if (!empty($student['antitetano'])) {
                $antitetano_date = "'" . substr($student['antitetano'], 6, 4) . '-' . substr($student['antitetano'], 3, 2) . '-' . substr($student['antitetano'], 0, 2) . "'";
                $insert .= ',s.tetanus_vaccine=' . $antitetano_date;
            }

            if (!empty($student['diet'])) {
                $insert .= ',s.diet=' . "'" . $student['diet'] . "'";
            }

            if (!empty($student['allergy'])) {
                $insert .= ',s.allergy=' . "'" . $student['allergy'] . "'";
            }

            $query = "DELETE FROM  " . $this->table_name2 . " ss
            WHERE ss.student_id={$student['id']}
            ;
            ";


            $stmt = $this->conn->prepare($query);

            $stmt->execute();


            if (!empty($student['had_disease'])) {
                $had_diseases = [];
                foreach ($student['had_disease'] as $disease) {
                    $had_diseases[] = "({$student['id']},$disease)";
                }

                $query = "INSERT INTO " . $this->table_name2 . " 
                        (student_id,disease_id)
                        VALUES
                        " . implode(",", $had_diseases) . ";
                ";

                $stmt = $this->conn->prepare($query);

                $stmt->execute();
            }

            if (!empty($student['diseases'])) {
                $diseases = [];
                foreach ($student['diseases'] as $disease) {
                    $diseases[] = "({$student['id']},$disease)";
                }

                $query = "INSERT INTO " . $this->table_name2 . " 
                        (student_id,disease_id)
                        VALUES
                        " . implode(",", $diseases) . ";
                ";



                $stmt = $this->conn->prepare($query);

                $stmt->execute();
            }

            $query = "UPDATE " . $this->table_name . " s
            SET 
                s.name='{$student['student_name']}',s.surname='{$student['student_surname']}',s.birth_date='" . substr($student['date_birth'], 6, 4) . '-' . substr($student['date_birth'], 3, 2) . '-' . substr($student['date_birth'], 0, 2) . "',
                s.father_name='{$student['father_name']}',s.mother_name='{$student['mother_name']}',s.private_phone_number='{$student['private_number']}',s.emergency_phone_number='{$student['emergency_number']}',s.address='{$student['address']}',s.authorized=". (empty($student['authorized']) ? 0 : 1) .",s.parents_email='{$student['parents_email']}',s.social_work_id={$student['medical_coverage']},
                s.afiliate_number='{$student['affiliate_number']}'" . $insert . "
            WHERE 
                s.id={$student['id']}
            LIMIT 1
            ";


            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return array(1, '<strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> ha sido actualizado');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    
}
