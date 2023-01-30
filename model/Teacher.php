<?php



class Teacher
{

    private $conn;
    private $table_name = "teachers";
    private $table_name2 = "teachers_activities";

    public function __construct($db = null)
    {
        $this->conn = $db;
    }

    public function __destruct()
    {
    }

    function insert_teacher(&$teacher)
    {
        try {
            
            if (empty($teacher['name']) || empty($teacher['surname']) || empty($teacher['dni']) || empty($teacher['private_phone_number']) || empty($teacher['email']) || empty($teacher['date_birth']) || empty($teacher['address']) || empty($teacher['activities']) || empty($teacher['art'])){
                return array(4, '<div class="text-danger">Todos los campos de esta sección deben completarse*</div>');
            }

            $query = " SELECT t.id FROM " . $this->table_name . " t
            WHERE
                t.dni = :dni
            LIMIT 0,1
            ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":dni", $teacher['dni']);

            $stmt->execute();


            if (!empty($stmt->fetch(PDO::FETCH_ASSOC))) {
                return array(2, 'El profesor <strong>' .  $teacher['name'] . ' ' . $teacher['surname'] . '</strong> ya se encuentra registrado en el sistema');
            }
            $query = "INSERT INTO " . $this->table_name . " 
            (
            name,
            surname,
            dni,
            address,
            private_phone_number,
            email,
            birth_date,
            art_id)
            VALUES
            ('{$teacher['name']}','{$teacher['surname']}','{$teacher['dni']}','{$teacher['address']}','{$teacher['private_phone_number']}','{$teacher['email']}','" . substr($teacher['date_birth'], 6, 4) . '-' . substr($teacher['date_birth'], 3, 2) . '-' . substr($teacher['date_birth'], 0, 2) . "',{$teacher['art']} );
        ";


            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $id = $this->conn->lastInsertId();


            $activities = [];
            foreach ($teacher['activities'] as $activity) {
                $activities[] = "($id,$activity)";
            }

            $query = "INSERT INTO " . $this->table_name2 . " 
                        (teacher_id,activity_id)
                        VALUES
                        " . implode(",", $activities) . ";
                ";
            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return array(1, '<strong>' .  $teacher['name'] . ' ' . $teacher['surname'] . '</strong> dado de alta');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    function get_all_teachers()
    {
        $query = "SELECT t.id,
            t.name,
            t.surname,
            t.dni,
            t.address,
            t.private_phone_number,
            t.email,
            DATE_FORMAT(t.birth_date,'%d/%m/%Y') as birth_date,
            DATE_FORMAT(t.created_at,'%d/%m/%Y %H:%m:%s') as created_at
        FROM " . $this->table_name . " t";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
