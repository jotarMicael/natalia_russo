<?php



class Teacher
{

    private $conn;
    private $table_name = "teachers";
    

    public function __construct($db = null)
    {
        $this->conn = $db;
    }

    public function __destruct()
    {
    }

    function insert_teacher(&$teacher)
    {
       // try {
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
            birth_date)
            VALUES
            ('{$teacher['name']}','{$teacher['surname']}','{$teacher['dni']}','{$teacher['address']}','{$teacher['private_phone_number']}','{$teacher['email']}','" . substr($teacher['date_birth'], 6, 4) . '-' . substr($teacher['date_birth'], 3, 2) . '-' . substr($teacher['date_birth'], 0, 2) . "' );
        ";


            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return array(1, '<strong>' .  $teacher['name'] . ' ' . $teacher['surname'] . '</strong> dado de alta');
      //  } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
       // }
    }
}