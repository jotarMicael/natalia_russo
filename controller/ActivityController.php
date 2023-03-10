<?php

require_once ROOTPATH . '/model/Activity.php';
require_once ROOTPATH . '/db/Database.php';

class ActivityController
{

    function get_activities()
    {


        $database = new Database();
        $db = $database->getConnection();

        $activity = new Activity($db);


        return $activity->get_activities();
    }

    function insert_activity(&$activity_)
    {


        $database = new Database();
        $db = $database->getConnection();

        $activity = new Activity($db);


        return $activity->insert_activity($activity_);
    }

    function get_students_by_activities(&$activities)
    {


        $database = new Database();
        $db = $database->getConnection();

        $activity = new Activity($db);


        return $activity->get_students_by_activities($activities);
    }

    function get_students_by_activity(&$activity_)
    {


        $database = new Database();
        $db = $database->getConnection();

        $activity = new Activity($db);


        return $activity->get_students_by_activity($activity_);
    }

    function get_activity_name(&$activity_)
    {

        $database = new Database();
        $db = $database->getConnection();

        $activity = new Activity($db);


        return $activity->get_activity_name($activity_);
    }
}
