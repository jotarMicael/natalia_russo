<?php

require_once ROOTPATH . '/model/Service.php';
require_once ROOTPATH . '/db/Database.php';

class ServiceController
{

    function get_services()
    {


        $database = new Database();
        $db = $database->getConnection();

        $service = new Service($db);


        return $service->get_services();
    }

    function get_services_imports()
    {


        $database = new Database();
        $db = $database->getConnection();

        $service = new Service($db);


        return $service->get_services_imports();
    }


    function get_service_import(&$id)
    {


        $database = new Database();
        $db = $database->getConnection();

        $service = new Service($db);


        return $service->get_service_import($id);
    }

    function update_service_import(&$id,&$other,&$service_date,&$import,&$type)
    {


        $database = new Database();
        $db = $database->getConnection();

        $service = new Service($db);


        return $service->update_service_import($id,$other,$service_date,$import,$type);
    }

    function insert_service_import(&$service_)
    {


        $database = new Database();
        $db = $database->getConnection();

        $service = new Service($db);


        return $service->insert_service_import($service_);
    }
}
