<?php

if(!isset($_SESSION)) { 
    session_start(); 
} 
//require $_SESSION['application_path'].'/vendor/autoload.php';
require $_SESSION['library_path_autoload'];

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
        $mail->From = "sell@roofservicenow.com";
        $mail->FromName = "Roof Service Now";

        $mail->addAddress($email, "Recipient Name");

        //Provide file path and name of the attachments
        if (!empty($attach)){
            $mail->addAttachment($attach, "Invoice RoofAdvisorz");        
            //$mail->addAttachment("images/profile.png"); //Filename is optional
        }

        $mail->isHTML(true);

        $mail->Subject = "Roof Service Now Invoice";
        $mail->Body = $body;
        $mail->AltBody = "This is the plain text version of the email content";
        
        if(!$mail->send()){
            $this->_message_error="Mailer Error: " . $mail->ErrorInfo;
            return false;
        }else{
            return "Message has been sent successfully";
            
        }
    }
 public function sendMail3($subject,$body){
        $mail = new PHPMailer;
        //$mail = new PHPMailer;
        $mail->From = "sales@roofservicenow.com";
        $mail->FromName = "Roof Service Now";

        $mail->addAddress("sales@roofservicenow.com", "Recipient Name");

        //Provide file path and name of the attachments

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = "Nothing to see here";

        if(!$mail->send()){
            $this->_message_error="Mailer Error: " . $mail->ErrorInfo;
            return false;
        }else{
            return "Message has been sent successfully";

        }
    }

    public function sendMailSMTP($toAddress,$subject,$body,$attachmentPath,$putLogo=""){
        

        $email_user = "donotreply@roofservicenow.com";
        $email_password = "Indy!@#hide@$%^";
        $the_subject = "Phpmailer prueba by Evilnapsis.com";
        $address_to = $toAddress;
        $from_name = "RoofServiceNow";
        $phpmailer = new PHPMailer();
        // ---------- datos de la cuenta de Gmail -------------------------------
        $phpmailer->Username = $email_user;
        $phpmailer->Password = $email_password; 
        //-----------------------------------------------------------------------
        $phpmailer->SMTPDebug = 2;
        $phpmailer->SMTPSecure = 'tls';
        $phpmailer->Host = "smtp-relay.gmail.com"; // GMail
        $phpmailer->Port = 587;
        $phpmailer->IsSMTP(); // use SMTP
        $phpmailer->SMTPAuth = true;
        

        $phpmailer->setFrom($phpmailer->Username,$from_name);
        $phpmailer->AddAddress($address_to); // recipients email
        $phpmailer->Subject = $subject;	
        $phpmailer->Body =$body;
        $phpmailer->IsHTML(true);

        if(!empty($putLogo)){
            $phpmailer->AddEmbeddedImage($putLogo, 'logoimg');
        }
        if(!empty($attachmentPath)){
            $phpmailer->AddAttachment($attachmentPath);
        }
        if(!$phpmailer->send()){
            $this->_message_error="<br>Mailer Error: " . $phpmailer->ErrorInfo.'<br>';
            return false;
        }else{
            return "<br>Message has been sent successfully<br>";
            
        }
        
    }
    public function getMessageError(){
        return $this->_message_error;
    }
}

?>


