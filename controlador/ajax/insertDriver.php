<?php

require_once("../driverController.php");



$_array_drivers=array();

for($n=0;$n<$_elementDivisor;$n++){
    $_array=array(
        "driverFirstName"=>$_arrayDivers[$n],
        "driverLastName"=>$_arrayDivers[$n+$_elementDivisor],
        "driverPhone"=>$_arrayDivers[$n+($_elementDivisor*2)],
        "driverLicense"=>$_arrayDivers[$n+($_elementDivisor*3)],
        "driverStatus"=>$_arrayDivers[$n+($_elementDivisor*4)],
    );
    array_push($_array_drivers,$_array);
}

?>