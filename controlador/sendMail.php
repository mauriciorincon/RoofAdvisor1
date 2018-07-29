<?php

if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once $_SESSION['application_path']."/vendor/autoload.php";

class emailController{
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

    public function sendMail2(){

    }
}

?>