<?php



class MedicalHistory
{

    private $conn;
    private $table_name = "medical_history";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function __destruct()
    {
    }

    function get_medical_history($bool=false)
    {

        $where=($bool) ? 'WHERE mh.id NOT IN (11,27)' : '';
        $query = "SELECT mh.id,mh.name 
        FROM 
            " . $this->table_name . " mh
        ".$where."
        ";

    
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
