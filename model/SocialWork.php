<?php



class SocialWork
{

    private $conn;
    private $table_name = "social_work";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function __destruct()
    {
    }

    function get_social_works()
    {

        $query = "SELECT sw.id,sw.name 
        FROM 
            " . $this->table_name . " sw ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
