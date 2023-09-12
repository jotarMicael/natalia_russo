<?php 

function get_age($birthdate)
{
    $fecha_nacimiento;
    $secondDate = date('Y-m-d');
    return floor(abs(strtotime($secondDate) - strtotime($birthdate)) / (365 * 60 * 60 * 24));
}



?>