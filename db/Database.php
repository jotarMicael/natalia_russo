<?php


//Create the database,construct,function

class Database {
 
    private $host;
    private $db_name;
    private $username;
    private $password; 
    public $conn;

    function __construct() {

        $this->host = "localhost";
        $this->db_name = "dance_studio";
        $this->username = "root";
        $this->password = ""; 
        $this->conn = null;
     }
 
    // get the database connection
    public function getConnection() {

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