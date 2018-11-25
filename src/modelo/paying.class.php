<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

require_once($_SESSION['application_path']."/modelo/conection.php");
require_once($_SESSION['application_path']."/modelo/others.class.php");
//require $_SESSION['application_path'].'/vendor/autoload.php';
require $_SESSION['library_path_autoload'];


//require 'path-to-Stripe.php';

class paying_stripe  extends connection{
    var $stripe;
    var $_last_charge;
    var $_error_message;

    function __construct()
	{
        parent::__construct();
        //paying mauricio
        /*$this->stripe = array(
            "secret_key"      => "sk_test_I4map4XuV7w5Dn5Ss8HGRDtn",
            "publishable_key" => "pk_test_iubKDaao3vNKYYrr45bJPUOl"
          );*/
          
          $_otherModel=new othersModel();
          $_public_key=$_otherModel->getParameterValue('Parameters/publishable_key');
          $_secret_key=$_otherModel->getParameterValue('Parameters/secret_key');
          //echo "public".$_public_key." secret:".$_secret_key;
       
          $this->stripe = array(
            "secret_key"      => $_secret_key,
            "publishable_key" => $_public_key
          );
          
          \Stripe\Stripe::setApiKey($this->stripe['secret_key']);
    }

    public function setPaying($customerID,$token,$amount,$currency){
        //echo "entro a setpaying ".$customerID." ".$token." ".$amount." ".$currency;
        $_customer=$this->createCustomer($customerID,$token);
        //echo "el resultado de customer es:".$_customer;
        if(is_object($_customer)){
            $_charge=$this->createCharge($_customer,$amount,$currency);
            if(is_object($_charge)){
                $this->_last_charge=$_charge;
                
                return true;
            }else{
                $this->_error_message=$_charge;
                return false;
            }
        }else{
            $this->_error_message=$_customer;
            return false;
        }
        

        
    }

    public function createCustomer($email,$token){
        $this->_error_message="";
        try{
            $customer = \Stripe\Customer::create(array(
                'email' => $email,
                'source'  => $token
            ));
        } catch(\Stripe\Error\Card $e) {
            $customer="Card error";
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $customer="Too many requests made to the API too quickly";
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $customer="Invalid parameters were supplied to Stripe's API";
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $customer="Authentication with Stripe's API failed";
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $customer="Network communication with Stripe failed";
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $customer="Display a very generic error to the user, and maybe send";
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $customer="Something else happened, completely unrelated to Stripe";
        }
        
        return $customer;
    }

    public function createCharge($customer,$amount,$currency){
        //echo "Customer:".$customer->id." amount:".$amount." currency:".$currency;
        $this->_error_message="";
        try{
            $charge = \Stripe\Charge::create(array(
                'customer' => $customer->id,
                'amount'   => $amount,
                'currency' => $currency
            ));
        } catch(\Stripe\Error\Card $e) {
            $charge="Card error";
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $charge="Too many requests made to the API too quickly ".$e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $charge="Invalid parameters were supplied to Stripe's API -chargue ".$e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $charge="Authentication with Stripe's API failed ".$e->getMessage();
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $charge="Network communication with Stripe failed ".$e->getMessage();
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $charge="Display a very generic error to the user, and maybe send ".$e->getMessage();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $charge="Something else happened, completely unrelated to Stripe ".$e->getMessage();
        }
        return $charge;
    }

    public function getPublishKey(){
        return $this->stripe['publishable_key'];
    }

    public function getCharge(){
        return $this->_last_charge;
    }

    public function getError(){
        return $this->_error_message;
    }

    public function getPayinStatus($chargeID){
        $_status= \Stripe\Charge::retrieve(
            $chargeID,
            array('api_key' => $this->stripe['secret_key'])
        );
        return $_status;
    }

    public function getNode($node){
        $result=$this->getDataTable($node);
        return $result;
    }

}
?>