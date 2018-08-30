<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/modelo/others.class.php");

class calendar{

    function __construct()
	{		
    }

    /*draws calendar controls*/
    public function draw_controls($month,$year,$customerID=""){
        /* date settings */
        //$month = (int) ($_GET['month'] ? $_GET['month'] : date('m'));
        //$year = (int)  ($_GET['year'] ? $_GET['year'] : date('Y'));

        $month=intval($month);
        $year=intval($year);

        /* select month control */
        $select_month_control = '<select name="monthCalendar" id="monthCalendar">';
        for($x = 1; $x <= 12; $x++) {
            $select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
        }
        $select_month_control.= '</select>';

        /* select year control */
        $year_range = 7;
        $select_year_control = '<select name="yearCalendar" id="yearCalendar">';
        for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
            $select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
        }
        $select_year_control.= '</select>';

        /* "next month" control */
        $next_month_link = '<a href="#" onclick="refreshCalendar('.($month != 12 ? $month + 1 : 1).','.($month != 12 ? $year : $year + 1).')" class="control">Next Month >></a>';

        /* "previous month" control */
        $previous_month_link = '<a href="#" onclick="refreshCalendar('.($month != 1 ? $month - 1 : 12).','.($month != 1 ? $year : $year - 1).')" class="control"><< 	Previous Month</a>';

        /* bringing the controls together */
        $controls = '<form method="get">'.$select_month_control.$select_year_control.' <input type="button" name="go" value="Go" onclick="refreshCalendar(\''.$customerID.'\')" />      '.$previous_month_link.'     '.$next_month_link.' </form>';

        return $controls;
    }

    /* draws a calendar */
    public function draw_calendar($month,$year,$events = array()){

        $flag=false;
        /* draw table */
        $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

        /* table headings */
        $headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
        $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

        /* days and weeks vars now ... */
        $running_day = date('w',mktime(0,0,0,$month,1,$year));
        $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
        $days_in_this_week = 1;
        $day_counter = 0;
        $dates_array = array();

        /* row for week one */
        $calendar.= '<tr class="calendar-row">';

        /* print "blank" days until the first of the current week */
        for($x = 0; $x < $running_day; $x++):
            $calendar.= '<td class="calendar-day-np"> </td>';
            $days_in_this_week++;
        endfor;

        /* keep going with days.... */
        for($list_day = 1; $list_day <= $days_in_month; $list_day++):
            $calendar.= '<td class="calendar-day">';
                /* add in the day number */
                $calendar.= '<div class="day-number">'.$list_day.'</div>';

                /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
                if(strlen($list_day)==1){
                    $list_day = '0'.$list_day;
                }
                if(strlen($month)==1){
                    $event_day = '0'.$month.'/'.$list_day.'/'.$year;
                }else{
                    $event_day = $month.'/'.$list_day.'/'.$year;
                }
                $flag=false;

                foreach($events as $key => $event) {
                    //echo $event_day;
                    if(strcmp($event['SchDate'],$event_day)==0){
                        $calendar.= '<div class="event"><a onclick="showEventCalendar('.$event['OrderNumber'].')">Order Id: '.$event['OrderNumber'].'<br>'.'Customer: '.$event['CustomerID'].',Time: '.$event['SchTime'].'</a></div>';
                        $flag=true;
                    }
                }
                if($flag==false) {
                    $calendar.= str_repeat('<p>&nbsp;</p>',2);
                }
                
            $calendar.= '</td>';
            if($running_day == 6):
                $calendar.= '</tr>';
                if(($day_counter+1) != $days_in_month):
                    $calendar.= '<tr class="calendar-row">';
                endif;
                $running_day = -1;
                $days_in_this_week = 0;
            endif;
            $days_in_this_week++; $running_day++; $day_counter++;
        endfor;

        /* finish the rest of the days in the week */
        if($days_in_this_week < 8):
            for($x = 1; $x <= (8 - $days_in_this_week); $x++):
                $calendar.= '<td class="calendar-day-np"> </td>';
            endfor;
        endif;

        /* final row */
        $calendar.= '</tr>';

        /* end the table */
        $calendar.= '</table>';
        
        /* all done, return result */
        return $calendar;
    }

    public function getEvents($month,$year){
        $_otherModel=new othersModel();
        $_result=$_otherModel->getEventsByDate($year,$month,$year,$month);
        if (is_array($_result)){
            return $_result;
        }else{
            return null;
        }
    }
}
?>