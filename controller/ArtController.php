<?php

require_once ROOTPATH . '/model/Art.php';
require_once ROOTPATH . '/db/Database.php';

class ArtController
{

    function get_arts()
    {


        $database = new Database();
        $db = $database->getConnection();

        $art = new Art($db);


        return $art->get_arts();
    }

    function insert_art(&$art_)
    {


        $database = new Database();
        $db = $database->getConnection();

        $art = new Art($db);


        return $art->insert_art($art_);
    }
}
