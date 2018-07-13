<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

require $_SESSION['application_path'].'/vendor/autoload.php';

//require 'path-to-Stripe.php';

class paying_stripe{
    var $stripe;
    var $_last_charge;

    function __construct()
	{
        $this->stripe = array(
            "secret_key"      => "sk_test_I4map4XuV7w5Dn5Ss8HGRDtn",
            "publishable_key" => "pk_test_iubKDaao3vNKYYrr45bJPUOl"
          );
          \Stripe\Stripe::setApiKey($this->stripe['secret_key']);
    }

    public function setPaying($customerID,$token,$amount,$currency){
        
        $_customer=$this->createCustomer($customerID,$token);
        if(is_object($_customer)){
            $_charge=$this->createCharge($_customer,$amount,$currency);
            if(is_object($_charge)){
                $this->_last_charge=$_charge;
                
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
        

        
    }

    public function createCustomer($email,$token){
        $customer = \Stripe\Customer::create(array(
            'email' => $email,
            'source'  => $token
        ));
        return $customer;
    }

    public function createCharge($customer,$amount,$currency){
        $charge = \Stripe\Charge::create(array(
            'customer' => $customer->id,
            'amount'   => $amount,
            'currency' => $currency
        ));
        return $charge;
    }

    public function getPublishKey(){
        return $this->stripe['publishable_key'];
    }

    public function getCharge(){
        return $this->_last_charge;
    }

    public function getPayinStatus($chargeID){
        $_status= \Stripe\Charge::retrieve(
            $chargeID,
            array('api_key' => $this->stripe['secret_key'])
        );
        return $_status;
    }

}
?>