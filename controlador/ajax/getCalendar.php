<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/calendarController.php");

$month=$_POST['month'];
$year=$_POST['year'];
$curtomerId="";
if(isset($_POST['customerID'])){
    $curtomerId=$_POST['customerID'];
}
$_eventsArray=array();
$oCalendar =new calendar();
echo $oCalendar->draw_controls($month,$year,$curtomerId);
if(strlen($month)==1){
    $_eventsArrayAux=$oCalendar->getEvents("0".$month,$year);
}else{
    $_eventsArrayAux=$oCalendar->getEvents($month,$year);
}
if(!empty($curtomerId)){
    foreach($_eventsArrayAux as $key => $order){
        if(strcmp( $order['CustomerID'], $curtomerId) == 0){
            array_push($_eventsArray,$order);
        }
    }
}else{
    $_eventsArray=$_eventsArrayAux;
}

//print_r($_eventsArray);
echo $oCalendar->draw_calendar($month,$year,$_eventsArray);

?>