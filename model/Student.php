<?php



class Student
{

    private $conn;
    private $table_name = "students";
    private $table_name2 = "students_diseases";
    private $table_name3 = "social_works";
    private $table_name4 = "students_share";
    private $table_name5 = "diseases";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function __destruct()
    {
    }

    function insert_student(&$student)
    {
        try {
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
            address,
            parents_email,
            social_work_id,
            afiliate_number,
            authorized " . $insert . ")
            VALUES
            ('{$student['student_name']}','{$student['student_surname']}','" . substr($student['date_birth'], 6, 4) . '-' . substr($student['date_birth'], 3, 2) . '-' . substr($student['date_birth'], 0, 2) . "','{$student['father_name']}','{$student['mother_name']}','{$student['private_number']}','{$student['emergency_number']}','{$student['address']}','{$student['email']}',{$student['medical_coverage']},'{$student['affiliate_number']}'," . (empty($student['authorized']) ? 0 : 1) .  $values . " );
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


    function get_information_student(&$student_id){

        try {
            $query = " SELECT s.id,
            s.name,
            s.surname,
            s.birth_date,
            s.father_name,
            s.mother_name,
            s.private_phone_number,
            s.emergency_phone_number,
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
            GROUP_CONCAT(d.name) AS diseases,
            (SELECT GROUP_CONCAT(DISTINCT CONCAT(DATE_FORMAT(ss.share_date, '%m/%Y'),':',ss.import) ORDER BY ss.share_date DESC SEPARATOR ',') 
             FROM " . $this->table_name4 . "  ss 
             WHERE ss.student_id = s.id) AS shares   
             FROM " . $this->table_name . " s 
                INNER JOIN ".$this->table_name3." sw ON (s.social_work_id=sw.id)
                LEFT JOIN ".$this->table_name2." sd ON (s.id=sd.student_id)
                LEFT JOIN ".$this->table_name5." d ON (sd.id=d.id)
            WHERE s.id=:id and s.active=1
            GROUP BY s.id
            LIMIT 0,1
        ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id',$student_id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }

    }
}
