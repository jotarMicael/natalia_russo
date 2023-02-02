<?php



class Art
{

    private $conn;
    private $table_name = "art";


    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function __destruct()
    {
    }

    function get_arts()
    {

        $query = "SELECT a.id,a.name,DATE_FORMAT(a.created_at,'%d/%m/%Y %H:%m:%s') as created_at
        FROM 
            " . $this->table_name . " a
        WHERE a.active=1
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    function insert_art(&$art)
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

            $stmt->bindParam(':name',strtoupper(trim($art['name'])),T_STRING);

            $stmt->execute();

            if (!empty($stmt->fetch(PDO::FETCH_ASSOC))) {
                return array(2, 'ART <strong>' .  $art['name'] . '</strong> ya se encuentra registrado en el sistema');
            }

            $query = "INSERT INTO " . $this->table_name . " (name)
            VALUES ('".trim($art['name'])."') 
            ";



            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return array(1, '<strong>ART registrada en el sistema.</strong>');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    
}
