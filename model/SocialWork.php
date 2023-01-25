<?php



class SocialWork
{

    private $conn;
    private $table_name = "social_works";

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

    function get_only_social_work(&$id)
    {

        $query = "SELECT sw.name 
        FROM 
            " . $this->table_name . " sw
        WHERE sw.id=:id LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id',$id);

        $stmt->execute();
        
        return  $stmt->fetch(PDO::FETCH_ASSOC)['name'];
    }
}
