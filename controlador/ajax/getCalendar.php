<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/calendarController.php");

$month=$_POST['month'];
$year=$_POST['year'];
$oCalendar =new calendar();
echo $oCalendar->draw_controls($month,$year);
if(strlen($month)==1){
    $_eventsArray=$oCalendar->getEvents("0".$month,$year);
}else{
    $_eventsArray=$oCalendar->getEvents($month,$year);
}

//print_r($_eventsArray);
echo $oCalendar->draw_calendar($month,$year,$_eventsArray);

?>