<?php



class Activity
{

    private $conn;
    private $table_name = "activities";
    private $table_name2 = "students_activities";

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
            WHERE a.name=:name
            LIMIT 0,1
            ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':name', $activity['name']);

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
}
