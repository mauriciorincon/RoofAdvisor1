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
       
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

        
        // CREATE A NEW SPREADSHEET + SET METADATA
        //$spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
        ->setCreator('YOUR NAME')
        ->setLastModifiedBy('YOUR NAME')
        ->setTitle('Demo Document')
        ->setSubject('Demo Document')
        ->setDescription('Demo Document')
        ->setKeywords('demo php spreadsheet')
        ->setCategory('demo php file');
        
        // NEW WORKSHEET
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Testing');
        $sheet->setCellValue('A1', 'Hello World !');
        $sheet->setCellValue('A2', 'Goodbye World !');

        // OUTPUT
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $_file_name = $this->generateRandomString();
        // THIS WILL SAVE TO A FILE ON THE SERVER
        $writer->save($_SESSION['temporal_path'].$_file_name.'.xlsx');

        // OR FORCE DOWNLOAD
        
        
        /*header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //header('Content-Type: application/excel');
        header('Content-Disposition: attachment;filename="demo.xlsx"');
        header('Cache-Control: max-age=0');
        header('Expires: Fri, 11 Nov 2011 11:11:11 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');*/
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //header('Content-Disposition: attachment; filename="file.xlsx"');
        //$writer->save("php://output");
        echo '<a href="'.$_SESSION['tmp_documents_path'].$_file_name.'.xlsx'.'"> download link</a>';
    }

    public function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

}
?>