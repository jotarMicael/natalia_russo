<?php



class Disease
{

    private $conn;
    private $table_name = "diseases";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function __destruct()
    {
    }

    function get_diseases($type)
    {

        $query = "SELECT d.id,d.name 
        FROM 
            " . $this->table_name . " d 
        WHERE 
            d.type = :type";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":type", $type);

        $stmt->execute();

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
