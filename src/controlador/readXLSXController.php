<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require $_SESSION['library_path_autoload'];

class read_excel{


    function read_file_excel($file_path){
        
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file_path);

        $sheet = $spreadsheet->getActiveSheet();
        $cellValue = $sheet->getCell('A1')->getValue();
        /*$_string='<ol>';
        foreach ($spreadsheet as $worksheet) {
            $_string.='<li>'. $worksheet['worksheetName']. '<br />';
            $_string.='Rows: '. $worksheet['totalRows'].
                ' Columns: '. $worksheet['totalColumns']. '<br />';
                $_string.='Cell Range: A1:'.
            $worksheet['lastColumnLetter']. $worksheet['totalRows'];
            $_string.='</li>';
        }
        $_string.='</ol>';*/
        return $cellValue;
    }

}
?>