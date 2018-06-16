<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/calendarController.php");

$month=$_POST[''];
$calendar =new calendar();
echo $oCalendar->draw_controls();
echo $oCalendar->draw_calendar(6,2018);

?>