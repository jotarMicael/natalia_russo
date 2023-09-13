<?php 

function get_age($birthdate)
{

    
    return floor(abs(strtotime(date('Y-m-d')) - strtotime($birthdate)) / (365 * 60 * 60 * 24));
}



?>