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
    private $table_name7 = "students_medical_history";
    private $table_name8 = "medical_history";
    private $table_name9 = "activities";

    public function __construct($db = null)
    {
        $this->conn = $db;
    }

    public function __destruct()
    {
    }

    function insert_student(&$student)
    {
        //return array(1, '<strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> dado de alta');
        try {
            $student['student_name'] = trim($student['student_name']);
            $student['student_surname'] = trim($student['student_surname']);
            $student['mother_name'] = trim($student['mother_name']);
            $student['father_name'] = trim($student['father_name']);
            $student['emergency_name'] = trim($student['emergency_name']);
            $student['address'] = trim($student['address']);
            $student['email'] = trim($student['email']);
            $student['affiliate_number'] = trim($student['affiliate_number']);

            if (empty($student['student_name']) || empty($student['student_surname']) || empty($student['date_birth']) || empty($student['emergency_number']) || empty($student['emergency_name']) || empty($student['dni'])) {
                return array(4, '<div class="text-danger">Todos los campos de esta sección deben completarse*</div>');
            }


            $query = " SELECT s.id FROM " . $this->table_name . " s 
            WHERE
                s.dni=:dni
            LIMIT 0,1
            ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":dni", $student['dni']);

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
            dni,
            authorized,
            changed " . $insert . ")
            VALUES
            ('{$student['student_name']}','{$student['student_surname']}','" . substr($student['date_birth'], 6, 4) . '-' . substr($student['date_birth'], 3, 2) . '-' . substr($student['date_birth'], 0, 2) . "','{$student['father_name']}','{$student['mother_name']}','{$student['private_number']}','{$student['emergency_number']}','{$student['emergency_name']}','{$student['address']}','{$student['email']}'," . ($student['medical_coverage'] == 0 ? "NULL" : $student['medical_coverage']) . ",'{$student['affiliate_number']}',{$student['dni']}," . (empty($student['authorized']) ? 0 : 1) . ',' . (empty($student['changed']) ? 0 : 1) .  $values . " );
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
            if (!empty($student['activities'])) {
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
            }

            return array(1, '<strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> dado de alta');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    function insert_adult_student(&$student)
    {
        //return array(1, '<strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> dado de alta');

        try {
            $student['student_name'] = trim($student['student_name']);
            $student['student_surname'] = trim($student['student_surname']);
            $student['emergency_name'] = trim($student['emergency_name']);
            $student['address'] = trim($student['address']);
            $student['email'] = trim($student['email']);
            $student['affiliate_number'] = trim($student['affiliate_number']);

            if (empty($student['student_name']) || empty($student['student_surname']) || empty($student['date_birth']) || empty($student['emergency_number']) || empty($student['emergency_name']) || empty($student['dni'])) {
                return array(4, '<div class="text-danger">Todos los campos de esta sección deben completarse*</div>');
            }


            $query = " SELECT s.id FROM " . $this->table_name . " s 
            WHERE
                s.dni=:dni
            LIMIT 0,1
            ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":dni", $student['dni']);


            $stmt->execute();


            if (!empty($stmt->fetch(PDO::FETCH_ASSOC))) {
                return array(2, 'El alumno <strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> ya se encuentra registrado en el sistema');
            }

            $insert = '';
            $values = '';


            if (!empty($student['medication'])) {
                $insert .= ',medication';
                $values .= ",'" . $student['medication'] . "'";
            }

            if (!empty($student['pathologies'])) {
                $insert .= ',other_disease_1';
                $values .= ",'" . $student['pathologies'] . "'";
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
            private_phone_number,
            emergency_phone_number,
            emergency_name,
            address,
            parents_email,
            social_work_id,
            afiliate_number,
            dni,
            internal,
            type
             " . $insert . ")
            VALUES
            ('{$student['student_name']}','{$student['student_surname']}','" . substr($student['date_birth'], 6, 4) . '-' . substr($student['date_birth'], 3, 2) . '-' . substr($student['date_birth'], 0, 2) . "','{$student['private_number']}','{$student['emergency_number']}','{$student['emergency_name']}','{$student['address']}','{$student['email']}'," . ($student['medical_coverage'] == 0 ? "NULL" : $student['medical_coverage']) . ",'{$student['affiliate_number']}',{$student['dni']}," . (empty($student['weight']) ? 0 : $student['weight']) . ",1 " .  $values . " );
        ";


            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $id = $this->conn->lastInsertId();

            if (!empty($student['medical_history'])) {
                $had_medical_history = [];
                foreach ($student['medical_history'] as $medical_history) {
                    $had_medical_history[] = "($id,$medical_history)";
                }

                $query = "INSERT INTO " . $this->table_name7 . " 
                        (student_id,medical_history_id)
                        VALUES
                        " . implode(",", $had_medical_history) . ";
                ";

                $stmt = $this->conn->prepare($query);

                $stmt->execute();
            }

            $query = "INSERT INTO " . $this->table_name7 . " 
                        (student_id,medical_history_id,count)
                        VALUES
                        ($id,27,{$student['physical_aptitude']});
                ";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();


            $activities = [];

            if (!empty($student['activities'])) {
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
            }

            return array(1, '<strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> dado de alta');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }


    function get_all_student_actives()
    {
        try {
            $query = " SELECT s.id,s.name,s.type,s.surname,s.dni,GROUP_CONCAT(a.name) as activities,s.private_phone_number FROM ". $this->table_name ." s 
            LEFT JOIN ". $this->table_name6 ." sa ON (s.id=sa.student_id)
            LEFT JOIN ". $this->table_name9 ." a ON (sa.activity_id=a.id)
            WHERE s.active=1 
            GROUP BY s.id
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

    function get_technical_sheet(&$student_id, &$student_type)
    {

        try {
            if (!$student_type) {
                $query = " SELECT s.id,
                        s.type as type,
                        s.name as student_name,
                        s.surname as student_surname,
                        s.birth_date as date_birth,
                        s.father_name,
                        s.mother_name,
                        s.private_phone_number as private_number,
                        s.emergency_phone_number as emergency_number,
                        s.emergency_name,
                        s.address,
                        s.parents_email as email,
                        s.social_work_id as medical_coverage,
                        s.afiliate_number as affiliate_number,
                        s.other_disease_1,
                        s.other_disease_2,
                        s.internal as internated,
                        s.surgery,
                        s.medication,
                        s.tetanus_vaccine as antitetano,
                        s.diet,
                        s.allergy,
                        s.changed,
                        s.authorized,
                        (SELECT GROUP_CONCAT(d.id)  FROM  " . $this->table_name2 . " sd
                        INNER JOIN " . $this->table_name5 . " d ON (sd.disease_id=d.id)
                        WHERE d.type=1 and sd.student_id = s.id ) AS diseases,
                        (SELECT GROUP_CONCAT(d.id)  FROM  " . $this->table_name2 . " sd
                        INNER JOIN " . $this->table_name5 . " d ON (sd.disease_id=d.id)
                        WHERE d.type=0 and sd.student_id = s.id ) AS had_disease
                        FROM " . $this->table_name . " s          
                        WHERE s.id=:id and s.active=1
                        GROUP BY s.id
                        LIMIT 0,1
                ";


                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':id', $student_id);
                $stmt->execute();

                $student = $stmt->fetch(PDO::FETCH_ASSOC);

                $student['diseases'] = explode(',', $student['diseases']);
                $student['had_disease'] = explode(',', $student['had_disease']);
            } else {

                $query = " SELECT s.id,
                                s.type as type,
                                s.name as student_name,
                                s.surname as student_surname,
                                s.birth_date as date_birth,
                                s.private_phone_number as private_number,
                                s.other_disease_1 as pathologies,
                                s.internal as weight,
                                s.medication as medication,
                                s.allergy as allergy,
                                (SELECT GROUP_CONCAT(mh.id)  FROM  " . $this->table_name7 . " smh
                                INNER JOIN " . $this->table_name8 . " mh ON (smh.medical_history_id=mh.id)
                                WHERE mh.id<>27 and smh.student_id = s.id ) AS medical_history,
                                (SELECT smh.count  FROM  " . $this->table_name7 . " smh
                                WHERE smh.medical_history_id=27 and smh.student_id = s.id LIMIT 1) AS physical_aptitude
                                FROM " . $this->table_name . " s          
                                WHERE s.id=:id and s.active=1
                                GROUP BY s.id
                                LIMIT 0,1
                ";


                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':id', $student_id);
                $stmt->execute();

                $student = $stmt->fetch(PDO::FETCH_ASSOC);
                $student['medical_history'] = explode(',', $student['medical_history']);
            }

            return  $student;
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

    function update_social_fee(&$social_fee_id, $share_date, &$import, &$student_id)
    {
        try {
            if (strpos($share_date, 'm') || strpos($share_date, 'y')) {
                return throw new Exception();
            }


            $share_date = substr($share_date, 3, 4) . '-' . substr($share_date, 0, 2) . '-' . '01';

            $query = " SELECT ss.id
            FROM " . $this->table_name4 . " ss
            WHERE ss.id!=:social_fee_id and ss.student_id=:student_id and ss.share_date BETWEEN :share_date AND LAST_DAY(:share_date)
            LIMIT 0,1
            ";


            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':social_fee_id', $social_fee_id);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':share_date', $share_date);


            $stmt->execute();


            if ($stmt->rowCount() == 1) {
                return array(2, 'La cuota del <strong>' .  substr($share_date, 5, 2) . '/' .  substr($share_date, 0, 4)   . '</strong> ya se encuentra abonada en el sistema');
            }


            $query = "UPDATE  " . $this->table_name4 . " 
            SET share_date='$share_date',import=$import
            WHERE id=$social_fee_id
            LIMIT 1
            ";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return array(1, 'La cuota del <strong>' .  substr($share_date, 5, 2) . '/' .  substr($share_date, 0, 4)   . '</strong> ha sido actualizada en el sistema');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }
    function generate_fee_pdf(&$share_id)
    {
        $query = " SELECT CONCAT (s.name, ' ', s.surname) as complete_name,s.dni as dni,s.address,s.private_phone_number,s.parents_email,DATE_FORMAT(ss.share_date,'%m/%Y') as share_date,DATE_FORMAT(ss.created_at,'%d/%m/%Y %H:%m:%s') as created_at, ss.import  
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
        $pdf->Image(BASE_URL . '/dist/img/logo_nati.jpg', 65, -5, 70, 60);
        $pdf->setY(12);
        $pdf->setX(10);
        // Agregamos los datos de la empresa

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setY(30);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "Alumno:");
        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(35);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, 'Nombre: ' . $share['complete_name']);
        $pdf->setY(40);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, 'Direccion: ' . $share['address']);
        $pdf->setY(45);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, 'Numero tel.: ' . $share['private_phone_number']);
        $pdf->setY(50);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, 'Email: ' . $share['parents_email']);
        $pdf->setY(55);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, 'Dni: ' . $share['dni']);

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

            $query = " SELECT s.type as type
            FROM " . $this->table_name . " s     
            WHERE s.active=1 and s.id=:student_id 
            LIMIT 0,1
                ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':student_id', $student_id);

            $stmt->execute();

            if (!$stmt->fetch(PDO::FETCH_ASSOC)['type']) {


                $query = " SELECT s.id as id,s.type as type,s.name AS student_name,  s.social_work_id as medical_coverage, s.afiliate_number AS affiliate_number,s.address AS address, s.surname AS student_surname,s.father_name as father_name,s.private_phone_number AS private_number,s.parents_email AS email,DATE_FORMAT(s.birth_date,'%d/%m/%Y') AS date_birth, s.mother_name AS mother_name,s.emergency_phone_number AS emergency_number,s.emergency_name AS emergency_name,s.changed as changed,s.other_disease_1 as other_diseases_1,s.other_disease_2 as other_diseases_2,s.tetanus_vaccine as antitetano,s.allergy as allergy,s.surgery as surgery,s.diet as diet,s.internal as internated,s.medication as medication,s.authorized as authorized,s.dni as dni,s.type as type,
                            GROUP_CONCAT(sd.disease_id) AS diseases,(SELECT GROUP_CONCAT(sa.activity_id) FROM " . $this->table_name6 . " sa WHERE sa.student_id=:student_id ) as activities
                            FROM " . $this->table_name . " s 
                            LEFT JOIN " . $this->table_name2 . " sd ON (s.id=sd.student_id)
                            WHERE s.active=1 and s.id=:student_id 
                            LIMIT 1
                ";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':student_id', $student_id);

                $stmt->execute();

                $student = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {

                $query = " SELECT s.id,
                s.type as type,
                s.name as student_name,
                s.surname as student_surname,
                DATE_FORMAT(s.birth_date,'%d/%m/%Y') AS date_birth,
                s.private_phone_number as private_number,
                s.other_disease_1 as pathologies,
                s.social_work_id as medical_coverage,
                s.dni as dni,
                s.parents_email as email,
                s.afiliate_number AS affiliate_number,
                s.address as address,
                s.emergency_phone_number AS emergency_number,
                s.emergency_name AS emergency_name,
                s.internal as weight,
                s.medication as medication,
                s.allergy as allergy,
                (SELECT GROUP_CONCAT(mh.id)  FROM  " . $this->table_name7 . " smh
                INNER JOIN " . $this->table_name8 . " mh ON (smh.medical_history_id=mh.id)
                WHERE mh.id<>27 and smh.student_id = s.id ) AS medical_history,
                (SELECT smh.count  FROM  " . $this->table_name7 . " smh
                WHERE smh.medical_history_id=27 and smh.student_id = s.id LIMIT 1) AS physical_aptitude,
                (SELECT GROUP_CONCAT(sa.activity_id) FROM " . $this->table_name6 . " sa WHERE sa.student_id=:student_id ) as activities
                FROM " . $this->table_name . " s          
                WHERE s.id=:student_id and s.active=1
                GROUP BY s.id
                LIMIT 0,1
                ";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':student_id', $student_id);

                $stmt->execute();

                $student = $stmt->fetch(PDO::FETCH_ASSOC);

                $student['diseases'] = explode(',', $student['diseases']);
                $student['had_disease'] = explode(',', $student['had_disease']);
                $student['medical_history'] = explode(',', $student['medical_history']);
            }

            if (empty($student)) {
                throw new Exception();
            }
            $student['activities'] = explode(',', $student['activities']);
            return $student;
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    function get_student_social_fee(&$social_fee)
    {

        try {
            $query = " SELECT ss.id, s.id as student_id,s.name, s.surname, DATE_FORMAT(ss.share_date,'%m/%Y') as share_date, ss.import
            FROM
            " . $this->table_name4 . " ss 
            INNER JOIN " . $this->table_name . " s ON (ss.student_id=s.id)
            WHERE ss.id=:social_fee
            LIMIT 1
                ";


            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':social_fee', $social_fee);

            $stmt->execute();

            if (empty($social_fee = $stmt->fetch(PDO::FETCH_ASSOC))) {
                throw new Exception();
            }

            return $social_fee;
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


            $insert = '';

            $query = " SELECT s.id FROM " . $this->table_name . " s 
                WHERE
                    s.dni=:dni AND s.id!=:id
                    LIMIT 0,1
                ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":dni", $student['dni']);
            $stmt->bindParam(":id", $student['id']);

            if (!$student['type_s']) {

                $student['student_name'] = trim($student['student_name']);
                $student['student_surname'] = trim($student['student_surname']);
                $student['mother_name'] = trim($student['mother_name']);
                $student['father_name'] = trim($student['father_name']);
                $student['emergency_name'] = trim($student['emergency_name']);
                $student['address'] = trim($student['address']);
                $student['email'] = trim($student['email']);
                $student['affiliate_number'] = trim($student['affiliate_number']);


                if (empty($student['student_name']) || empty($student['student_surname']) || empty($student['date_birth']) || empty($student['emergency_number']) || empty($student['emergency_name']) || empty($student['dni'])) {
                    return array(4, '<div class="text-danger">Todos los campos de esta sección deben completarse*</div>');
                }


                $stmt->execute();

                if (!empty($stmt->fetch(PDO::FETCH_ASSOC))) {
                    return array(2, 'El alumno <strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> ya se encuentra registrado en el sistema');
                }



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
                    s.father_name='{$student['father_name']}',s.dni={$student['dni']},s.mother_name='{$student['mother_name']}',s.private_phone_number='{$student['private_number']}',s.emergency_phone_number='{$student['emergency_number']}',s.emergency_name='{$student['emergency_name']}',s.address='{$student['address']}',s.authorized=" . (empty($student['authorized']) ? 0 : 1) . ",s.parents_email='{$student['email']}',s.social_work_id=" . ($student['medical_coverage'] == 0 ? "NULL" : $student['medical_coverage']) . ",
                    s.afiliate_number='{$student['affiliate_number']}'" . $insert . "
                WHERE 
                    s.id={$student['id']}
                LIMIT 1";


                $stmt = $this->conn->prepare($query);

                $stmt->execute();

                $query = "DELETE FROM  " . $this->table_name6 . " sa
                WHERE sa.student_id={$student['id']}
                ;";


                $stmt = $this->conn->prepare($query);

                $stmt->execute();

                $activities = [];
                if (!empty($student['activities'])) {
                    foreach ($student['activities'] as $activity) {
                        $activities[] = "({$student['id']},$activity)";
                    }

                    $query = "INSERT INTO " . $this->table_name6 . " 
                        (student_id,activity_id)
                        VALUES
                        " . implode(",", $activities) . ";
                ";

                    $stmt = $this->conn->prepare($query);

                    $stmt->execute();
                }



                return array(1, '<strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> ha sido actualizado');
            } else {

                $student['student_name'] = trim($student['student_name']);
                $student['student_surname'] = trim($student['student_surname']);
                $student['emergency_name'] = trim($student['emergency_name']);
                $student['address'] = trim($student['address']);
                $student['email'] = trim($student['email']);
                $student['affiliate_number'] = trim($student['affiliate_number']);


                if (empty($student['student_name']) || empty($student['student_surname']) || empty($student['date_birth']) || empty($student['emergency_number']) || empty($student['emergency_name']) || empty($student['dni'])) {
                    return array(4, '<div class="text-danger">Todos los campos de esta sección deben completarse*</div>');
                }

                $stmt->execute();

                if (!empty($stmt->fetch(PDO::FETCH_ASSOC))) {
                    return array(2, 'El alumno <strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> ya se encuentra registrado en el sistema');
                }

                if (!empty($student['medication'])) {
                    $insert .= ',medication=' . "'" . $student['medication'] . "'";
                }

                if (!empty($student['pathologies'])) {
                    $insert .= ',other_disease_1=' . "'" . $student['pathologies'] . "'";
                }


                if (!empty($student['allergy'])) {
                    $insert .= ',allergy=' . "'" . $student['allergy'] . "'";
                }

                $query = "UPDATE " . $this->table_name . " s SET
                s.name='{$student['student_name']}',s.surname='{$student['student_surname']}',s.birth_date='" . substr($student['date_birth'], 6, 4) . '-' . substr($student['date_birth'], 3, 2) . '-' . substr($student['date_birth'], 0, 2) . "',
                s.dni={$student['dni']},s.private_phone_number='{$student['private_number']}',s.emergency_phone_number='{$student['emergency_number']}',s.emergency_name='{$student['emergency_name']}',s.address='{$student['address']}',s.parents_email='{$student['email']}',s.social_work_id=" . ($student['medical_coverage'] == 0 ? "NULL" : $student['medical_coverage']) . ",
                s.afiliate_number='{$student['affiliate_number']}',s.internal=" . (empty($student['weight']) ? 0 : $student['weight']) . "" . $insert . "
                WHERE 
                    s.id={$student['id']}
                LIMIT 1
                ";


                $stmt = $this->conn->prepare($query);

                $stmt->execute();

                $id = $this->conn->lastInsertId();

                $query = "DELETE FROM  " . $this->table_name7 . " smh
                WHERE 
                    smh.student_id={$student['id']}
                ;";


                $stmt = $this->conn->prepare($query);

                $stmt->execute();
                if (!empty($student['medical_history'])) {
                    $had_medical_history = [];
                    foreach ($student['medical_history'] as $medical_history) {
                        $had_medical_history[] = "({$student['id']},$medical_history)";
                    }

                    $query = "INSERT INTO " . $this->table_name7 . " 
                        (student_id,medical_history_id)
                        VALUES
                        " . implode(",", $had_medical_history) . ";
                ";

                    $stmt = $this->conn->prepare($query);

                    $stmt->execute();
                }

                $query = "INSERT INTO " . $this->table_name7 . " 
                        (student_id,medical_history_id,count)
                        VALUES
                        ({$student['id']},27,{$student['physical_aptitude']});
                ";

                $stmt = $this->conn->prepare($query);

                $stmt->execute();


                $query = "DELETE FROM  " . $this->table_name6 . " sa
                WHERE sa.student_id={$student['id']}
                ;";


                $stmt = $this->conn->prepare($query);

                $stmt->execute();

                $activities = [];
                if (!empty($student['activities'])) {
                    foreach ($student['activities'] as $activity) {
                        $activities[] = "({$student['id']},$activity)";
                    }

                    $query = "INSERT INTO " . $this->table_name6 . " 
                        (student_id,activity_id)
                        VALUES
                        " . implode(",", $activities) . ";
                ";

                    $stmt = $this->conn->prepare($query);

                    $stmt->execute();
                }
                return array(1, '<strong>' .  $student['student_name'] . ' ' . $student['student_surname'] . '</strong> dado de alta');
            }
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }
}
