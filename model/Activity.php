<?php



class Activity
{

    private $conn;
    private $table_name = "activities";
    private $table_name2 = "students_activities";
    private $table_name3 = "students";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function __destruct()
    {
    }

    function get_activities()
    {

        $query = "SELECT a.id,a.name,a.created_at
        FROM 
            " . $this->table_name . " a
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    function insert_activity(&$activity)
    {
        try {
            $query = "SELECT a.id
                FROM 
            " . $this->table_name . " a
                WHERE
                UPPER(a.name)=:name
            LIMIT 0,1
            ";

            
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':name', strtoupper(trim($activity['name'])),T_STRING);

            $stmt->execute();

            if (!empty($stmt->fetch(PDO::FETCH_ASSOC))) {
                return array(2, 'La actividad <strong>' .  $activity['name'] . '</strong> ya se encuentra registrado en el sistema');
            }

            $query = "INSERT INTO " . $this->table_name . " (name)
            VALUES ('{$activity['name']}') 
            ";



            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return array(1, '<strong>Actividad registrada en el sistema.</strong>');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    function get_students_by_activities(&$activities)
    {
        try {
            if (empty($activities)) {
                return array(4, '<div class="text-danger">Debe seleccionar al menos una actividad*</div>');
            }

            $query = "SELECT s.id as id,s.name as name,s.surname as surname,GROUP_CONCAT(ac.name) as activities
            FROM 
                " . $this->table_name3 . " s        
            INNER JOIN 
            " . $this->table_name2 . " sa ON (s.id=sa.student_id)
            INNER JOIN 
            " . $this->table_name . " ac ON (sa.activity_id=ac.id)            
            WHERE s.active=1 and ac.id IN (".implode(',', $activities).")
            GROUP BY s.id
                
            ";

            $stmt = $this->conn->prepare($query);


            

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }
}
