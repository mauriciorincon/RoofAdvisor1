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

    public function getMessageError(){
        return $this->_message_error;
    }
}

?>