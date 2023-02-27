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

        $query = "SELECT si.id as id, IF(s.id=3,si.other,s.name) as name ,si.import as import ,DATE_FORMAT(si.service_date,'%d/%m/%Y') as service_date ,DATE_FORMAT(si.created_at,'%d/%m/%Y %H:%m:%s') as created_at
        FROM 
            " . $this->table_name2 . " si
        INNER JOIN  
            " . $this->table_name . " s ON (si.service_id=s.id)
        ORDER BY 
            si.id DESC
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_service_import(&$id)
    {

        $query = "SELECT si.service_id as service_id,IF(si.service_id=3,true,false) as type, si.other as other ,si.import as import ,DATE_FORMAT(si.service_date,'%d/%m/%Y') as service_date ,DATE_FORMAT(si.created_at,'%d/%m/%Y') as created_at
        FROM 
            " . $this->table_name2 . " si
        WHERE 
            si.id=:id
        LIMIT 0,1
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        return  $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function update_service_import($id, $other, $service_date, $import, $type)
    {
        try {

            if ($type) {
                $query = "UPDATE 
            " . $this->table_name2 . " si
        
        SET
            si.other='" . trim($other) . "',si.service_date='" . substr($service_date, 6, 4) . '-' . substr($service_date, 3, 2) . '-' . substr($service_date, 0, 2) . "',si.import=$import
        WHERE si.id=:id
        ";
            } else {
                $query = "UPDATE 
                " . $this->table_name2 . " si
            
            SET
                si.service_id='" . intval($other) . "',si.service_date='" . substr($service_date, 6, 4) . '-' . substr($service_date, 3, 2) . '-' . substr($service_date, 0, 2) . "',si.import=$import
            WHERE si.id=:id
            ";
            }

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":id", $id);

            $stmt->execute();

            return array(1, '<strong>Egreso actualizado en el sistema.</strong>');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }

    function insert_service_import(&$service)
    {
        try {
            if ($service['service'] == 0) {
                throw new Exception();
            }

            if ($service['service'] == 3) {
                $query = "INSERT INTO " . $this->table_name2 . " (service_id,import,service_date,other)
            VALUES ({$service['service']},{$service['import']},'" . substr($service['service_date'], 6, 4) . '-' . substr($service['service_date'], 3, 2) . '-' . substr($service['service_date'], 0, 2) . "','" . trim($service['other']) . "') 
            ";
            } else {
                $query = "INSERT INTO " . $this->table_name2 . " (service_id,import,service_date)
            VALUES ({$service['service']},{$service['import']},'" . substr($service['service_date'], 6, 4) . '-' . substr($service['service_date'], 3, 2) . '-' . substr($service['service_date'], 0, 2) . "') 
            ";
            }
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return array(1, '<strong>Egreso registrado en el sistema.</strong>');
        } catch (Exception) {
            return array(3, 'Ha ocurrido un error inesperado, por favor reinténtelo nuevamente');
        }
    }
}
