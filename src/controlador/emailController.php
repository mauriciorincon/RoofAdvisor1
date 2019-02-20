<?php

if(!isset($_SESSION)) { 
    session_start(); 
} 
require $_SESSION['library_path_autoload'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


use PHPMailer\PHPMailer\OAuth;
//include PHPMailer/
// Alias the League Google OAuth2 provider class
use League\OAuth2\Client\Provider\Google;

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
/*
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
*/
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
        $phpmailer->SMTPDebug = 0;
        $phpmailer->SMTPSecure = 'tls';
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->Port = 587;
        $phpmailer->IsSMTP(); // use SMTP
        $phpmailer->SMTPAuth = true;
        
        $phpmailer->AuthType = 'XOAUTH2';
        //Fill in authentication details here
        //Either the gmail account owner, or the user that gave consent
        $email = 'donotreply@roofservicenow.com';
        $clientId = '205040843222-m127fks3ogm0opu1tuhpv7473a55fu25.apps.googleusercontent.com';
        $clientSecret = 'opFR7ie2XafKtJGVcSg9tnYg';
        //Obtained by configuring and running get_oauth_token.php
        //after setting up an app in Google Developer Console.
        $refreshToken = '1/q0M4RLkCFHPoNxlVhIW41CFJryltPZxby7fqe7AIqkM';

        $provider = new Google(
            [
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
            ]
        );
        //Pass the OAuth provider instance to PHPMailer
        $phpmailer->setOAuth(
            new OAuth(
                [
                    'provider' => $provider,
                    'clientId' => $clientId,
                    'clientSecret' => $clientSecret,
                    'refreshToken' => $refreshToken,
                    'userName' => $email,
                ]
            )
        );


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