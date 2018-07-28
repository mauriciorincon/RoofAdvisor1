<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

require $_SESSION['application_path'].'/vendor/autoload.php';

class pdfController{
    
    function __construct(){
        
    }

    function paymentConfirmation1($_orderID){
        $pdf = new TCPDF();                 // create TCPDF object with default constructor args
        $pdf->AddPage();                    // pretty self-explanatory

        $pdf->SetMargins(25, 31 , 15); 
        $pdf->SetAutoPageBreak(TRUE, 35);
        $pdf -> SetX(25);
        $pdf -> SetY(31);
        
        $pdf->SetFont('times','',10);

        $_hmtl='
        <table>
            <tr>
                <td>RoofAdvisorz no-reply@roofadvisorz.com </td>
                <td></td>
                <td></td>
                <td></td>
                <td>Email Message to homeowner after they submit payment</td>
            </tr>
            <tr>
                <td colspan="5">'.$pdf->Image($_SESSION['application_path']."/img/logo.png",80,50,40).'</td>
            </tr>
            <tr>
                <td colspan="5"><br><br><br><br><br></td>
            </tr>
            <tr>
                <td colspan="5">Thank you! Here\'s your invoice for the emergency repair service. </td>
            </tr>
            <tr>
                <td colspan="5">Please review the information below.  Remember to return to RoofAdvisorZ.com to rate your service professional after the project is completed. </td>
            </tr>
        </table>
        <br>
        <br>
        <table border=".5">
            <tr>
                <td>Service Pro ID:</td><td></td><td>SP Name:</td><td></td><td>Customer Rating:</td><td></td>
            </tr>
            <tr>
                <td>License:</td><td></td><td>SP Phone:</td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td>Service Date:</td><td></td><td>SP Address:</td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td>Service Repair Address</td><td colspan="2"></td><td></td><td></td><td></td>
            </tr>
        </table>
        <br>
        <br>
        <table bgcolor="#dcdfe5">
            <tr>
                <td><b>Invoice</b></td><td>8690940_A</td><td></td><td></td><td>Repair ID</td><td align="rigth">8690940</td>
            </tr>
            <tr>
                <td><b>Summary</b></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td colspan="2">Emergency Roof Service</td><td></td><td></td><td></td><td align="rigth">$75,00</td>
            </tr>
            <tr>
                <td><b>Grand Total Paid</b></td><td></td><td></td><td></td><td></td><td align="rigth"><b>$75,00</b></td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td>Payment Date</td><td></td><td></td><td></td><td></td><td align="rigth">18/01/18</td>
            </tr>
            <tr>
                <td>Payment Amt</td><td></td><td></td><td></td><td></td><td align="rigth">$75,00</td>
            </tr>
            <tr>
                <td>***Approved***</td><td></td><td></td><td></td><td></td><td align="rigth">XXXXXXXXXXXX5020</td>
            </tr>
            <tr>
                <td>***Approved***</td><td></td><td></td><td></td><td>Exp. Date</td><td align="rigth">jul-19</td>
            </tr>
            <tr>
                <td colspan="6" align="center">Thank You for using RoofAdvisorZ</td>
            </tr>
        </table>
        <br>
        <br>
        <table>
            <tr>
                <td>http://www.roofadvisorz.com/idx/invoice1.html?verify=0f3c991b4507ade9d74828a1e6d9ec61c8e367sa</td>
            </tr>
            <tr>
                <td>Use the link above to return to rate the service professional.</td>
            </tr>
            <tr>
                <td>Is your  link not working? You can log in to RoofAdvisorZ.com and review the invoice.</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>If you have any questions about our website, please don\'t hesitate to contact us.</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table>
            <tr>
                <td>Viaplix LLC | Site : ww.viaplix.com | Viaplix © 2017 | info@viaplix.com</td>
            </tr>
        </table>
        ';
        
        $pdf->Image($_SESSION['application_path']."/img/logo.png",30,200,40);

        $pdf->writeHTML($_hmtl, true, 0, true, true);

        $pdf->Output('hello_world.pdf'); 
    }
}
?>