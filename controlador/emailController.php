<?php


if(!isset($_SESSION)) { 
    session_start(); 
} 
require $_SESSION['application_path'].'/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class emailController{

    var $_message_error="";

    function __construct()
	{		
    }

    public function sendMail($email,$code){
        $to      = $email; // Send email to our user
        $subject = 'Signup | Verification'; // Give the email a subject 
        $message = '
 
                    Thanks for signing up!
                    Your account has been created, please copy de code below into the verification input to activate your account.
 
                    
                    The code for activate your account:

                    -----------------------------------
                    '.$code.'
                    -----------------------------------
                    
                    '; // Our message above including the link
                     
                    $headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
                    mail($to, $subject, $message, $headers); // Send our email

    }

    public function sendMail2($email,$body,$attach){
        $mail = new PHPMailer;
        //$mail = new PHPMailer;
        $mail->From = "sell@roofadvisorz.com";
        $mail->FromName = "Roof Advisorz";

        $mail->addAddress($email, "Recipient Name");

        //Provide file path and name of the attachments
        if (!empty($attach)){
            $mail->addAttachment($attach, "Invoice RoofAdvisorz");        
            //$mail->addAttachment("images/profile.png"); //Filename is optional
        }

        $mail->isHTML(true);

        $mail->Subject = "RoofAdvisorz Invoice";
        $mail->Body = $body;
        $mail->AltBody = "This is the plain text version of the email content";
        
        if(!$mail->send()){
            $this->_message_error="Mailer Error: " . $mail->ErrorInfo;
            return false;
        }else{
            return "Message has been sent successfully";
            
        }
    }

    public function sendMailSMTP($toAddress,$subject,$body,$attachmentPath){
        /*$mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.viaplix.com"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
        $mail->Username = "donotreply@viaplix.com"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente. 
        $mail->Password = "xulqnxkamkpsadgr"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
        $mail->Port = 587; // Puerto de conexión al servidor de envio. 
        $mail->From = "donotreply@viaplix.com"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
        $mail->FromName = "RoofAdvizor"; //A RELLENAR Nombre a mostrar del remitente. 
        $mail->AddAddress("mauricio.rincon@gmail.com"); // Esta es la dirección a donde enviamos 
        $mail->IsHTML(true); // El correo se envía como HTML 
        $mail->Subject = "Titulo"; // Este es el titulo del email. 
        $body = "Hola mundo. Esta es la primer línea"; 
        $body .= "Aquí continuamos el mensaje"; 
        $mail->Body = $body; // Mensaje a enviar. 
        if(!$mail->send()){
            $this->_message_error="Mailer Error: " . $mail->ErrorInfo;
            return false;
        }else{
            return "Message has been sent successfully";
            
        }*/

        $email_user = "donotreply@viaplix.com";
        $email_password = "p6ssw0rd25";
        $the_subject = "Phpmailer prueba by Evilnapsis.com";
        $address_to = $toAddress;
        $from_name = "RoozAdvisorZ";
        $phpmailer = new PHPMailer();
        // ---------- datos de la cuenta de Gmail -------------------------------
        $phpmailer->Username = $email_user;
        $phpmailer->Password = $email_password; 
        //-----------------------------------------------------------------------
        //$phpmailer->SMTPDebug = 2;
        $phpmailer->SMTPSecure = 'tls';
        $phpmailer->Host = "smtp.viaplix.com"; // GMail
        $phpmailer->Port = 587;
        $phpmailer->IsSMTP(); // use SMTP
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = false;
        $phpmailer->SMTPAutoTLS = false;

        $phpmailer->setFrom($phpmailer->Username,$from_name);
        $phpmailer->AddAddress($address_to); // recipients email
        $phpmailer->Subject = $subject;	
        $phpmailer->Body =$body;
        $phpmailer->IsHTML(true);
        if(!empty($attachmentPath)){
            $phpmailer->AddAttachment($attachmentPath);
        }
        if(!$phpmailer->send()){
            $this->_message_error="<br>Mailer Error: " . $phpmailer->ErrorInfo.'<br>';
            return false;
        }else{
            return "<br>Message has been sent successfully<br>";
            
        }

        /*$email_user = "mauricio.rincon@gmail.com";
        $email_password = "xulqnxkamkpsadgr*";
        $the_subject = "Phpmailer prueba by Evilnapsis.com";
        $address_to = "hrinconb@cajaviviendapopular.gov.co";
        $from_name = "Evilnapsis";
        $phpmailer = new PHPMailer();
        // ---------- datos de la cuenta de Gmail -------------------------------
        $phpmailer->Username = $email_user;
        $phpmailer->Password = $email_password; 
        //-----------------------------------------------------------------------
        // $phpmailer->SMTPDebug = 1;
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->Host = "smtp.gmail.com"; // GMail
        $phpmailer->Port = 465;
        $phpmailer->IsSMTP(); // use SMTP
        $phpmailer->SMTPAuth = true;
        $phpmailer->setFrom($phpmailer->Username,$from_name);
        $phpmailer->AddAddress($address_to); // recipients email
        $phpmailer->Subject = $the_subject;	
        $phpmailer->Body .="<h1 style='color:#3498db;'>Hola Mundo!</h1>";
        $phpmailer->Body .= "<p>Mensaje personalizado</p>";
        $phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
        $phpmailer->IsHTML(true);
        if(!$phpmailer->send()){
            $this->_message_error="<br>Mailer Error: " . $phpmailer->ErrorInfo.'<br>';
            return false;
        }else{
            return "<br>Message has been sent successfully<br>";
            
        }

        /*$email_user = "hrinconb@cajaviviendapopular.gov.co";
        $email_password = "CVP1234*";
        $the_subject = "Phpmailer prueba by Evilnapsis.com";
        $address_to = "mauricio.rincon@gmail.com";
        $from_name = "Evilnapsis";
        $phpmailer = new PHPMailer();
        // ---------- datos de la cuenta de Gmail -------------------------------
        $phpmailer->Username = $email_user;
        $phpmailer->Password = $email_password; 
        //-----------------------------------------------------------------------
        // $phpmailer->SMTPDebug = 1;
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->Host = "smtp.gmail.com"; // GMail
        $phpmailer->Port = 465;
        $phpmailer->IsSMTP(); // use SMTP
        $phpmailer->SMTPAuth = true;
        $phpmailer->setFrom($phpmailer->Username,$from_name);
        $phpmailer->AddAddress($address_to); // recipients email
        $phpmailer->Subject = $the_subject;	
        $phpmailer->Body .="<h1 style='color:#3498db;'>Hola Mundo!</h1>";
        $phpmailer->Body .= "<p>Mensaje personalizado</p>";
        $phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
        $phpmailer->IsHTML(true);
        if(!$phpmailer->send()){
            $this->_message_error="<br>Mailer Error: " . $phpmailer->ErrorInfo.'<br>';
            return false;
        }else{
            return "<br>Message has been sent successfully<br>";
            
        }*/
        
    }
    public function getMessageError(){
        return $this->_message_error;
    }
}

?>