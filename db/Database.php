<?php


//Create the database,construct,function

class Database {
 
    private $host = "localhost";
    private $db_name = "pvs_conciliaciones_TESTING";
    private $username = "user_conciliaciones";
    private $password = "!AntAFDasanjSAd1083";
    
    public $conn;

    function __construct() {
        if(PROFILE === 'DEV') {
            $this->host = "localhost";
            $this->db_name = "dance_studio";
            $this->username = "root";
            $this->password = "4509221m";
        }
     }
 
    // get the database connection
    public function getConnection() {
 
        $this->conn = null;
 
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password, 
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>