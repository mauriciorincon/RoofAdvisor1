<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require $_SESSION['library_path_autoload'];

class read_excel{


    function read_file_excel($file_path,$_id_company="CO000000"){
        
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file_path);

        $sheet = $spreadsheet->getActiveSheet();
        $n=2;
        $_array_new_customer=array();
        while(!empty($sheet->getCell('A'.$n)->getValue())){
            $_array_row=array(
                "firstCustomerName"=>$sheet->getCell('A'.$n)->getValue(),
                "lastCustomerName"=>$sheet->getCell('B'.$n)->getValue(),
                "emailValidation"=>$sheet->getCell('C'.$n)->getValue(),
                "customerPhoneNumber"=>$sheet->getCell('D'.$n)->getValue(),
                "customerAddress"=>$sheet->getCell('E'.$n)->getValue(),
                "customerState"=>$sheet->getCell('F'.$n)->getValue(),
                "customerCity"=>$sheet->getCell('G'.$n)->getValue(),
                "customerZipCode"=>$sheet->getCell('H'.$n)->getValue(),
                "password"=>"",
                "CompanyID"=>$_id_company,
            );
            array_push($_array_new_customer,$_array_row);
            $n++;
        }
        return $_array_new_customer;
    }

    public function generateExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'name-of-the-generated-file';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output'); // download file 
 
    }

}
?>