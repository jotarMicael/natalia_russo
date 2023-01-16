<?php



class Service
{

    private $conn;
    private $table_name = "services";
    private $table_name2 = "services_imports";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function __destruct()
    {
    }

    function get_services()
    {

        $query = "SELECT s.id,s.name 
        FROM 
            " . $this->table_name . " s
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_services_imports()
    {

        $query = "SELECT s.name as name ,si.import as import ,si.service_date as service_date ,si.created_at as created_at
        FROM 
            " . $this->table_name2 . " si
        INNER JOIN  " . $this->table_name . " s ON (si.service_id=s.id)
        ORDER BY 
            si.id DESC
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function insert_service_import(&$service)
    {
        try {
            if ($service['service'] == 0) {
                throw new Exception();
            }

            $query = "INSERT INTO " . $this->table_name2 . " (service_id,import,service_date)
            VALUES ({$service['service']},{$service['import']},'" . substr($service['service_date'], 6, 4) . '-' . substr($service['service_date'], 3, 2) . '-' . substr($service['service_date'], 0, 2) . "') 
            ";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return array(1, '<strong>Servicio registrado en el sistema.</strong>');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }
}
