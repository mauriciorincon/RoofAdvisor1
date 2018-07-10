<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

require $_SESSION['application_path'].'/vendor/autoload.php';

//require 'path-to-Stripe.php';

class paying_stripe{
    function __construct()
	{

    }
}
?>