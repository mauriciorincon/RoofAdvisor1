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

    public function setPaying($customerID,$token,$amount,$currency,$order){
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

    //direct to the platform
    public function createCharge($token,$amount,$currency,$description){
        //echo "Customer:".$customer->id." amount:".$amount." currency:".$currency;
        $this->_error_message="";
        try{
            $charge = \Stripe\Charge::create(array(
                'source' => $token,
                'amount'   => $amount,
                'currency' => $currency,
                'description' =>$description,
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

    //direct to the platform to other account with fee
    public function createChargeOther($token,$amount,$currency,$account,$fee=0){
        //echo "Customer:".$customer->id." amount:".$amount." currency:".$currency;
        $this->_error_message="";
        try{
            if($fee==0){
                $charge = \Stripe\Charge::create(array(
                    "amount" => $amount,
                    "currency" => $currency,
                    "source" => "tok_visa",
                ), ["stripe_account" => $account]);
            }else{
                $charge = \Stripe\Charge::create(array(
                    "amount" => $amount,
                    "currency" => $currency,
                    "source" => "tok_visa",
                    "application_fee" => $fee,
                ), ["stripe_account" => $account]);
            }
            
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

    //direct to the platform
    public function createChargeDestination($token,$amount,$currency,$account,$fee=0){
        //echo "Customer:".$customer->id." amount:".$amount." currency:".$currency;
        $this->_error_message="";
        echo "entro aca";
        try{
            if($fee==0){
                $charge = \Stripe\Charge::create(array(
                    'amount' => $amount,
                    'currency' => $currency,
                    'source' => $token,
                    'description' =>'Paying order without fee',
                    "destination" => [
                        "account" => $account,
                      ],
                ));
            }else{
                $_total_without_fee=$amount-$fee;
                $charge = \Stripe\Charge::create(array(
                    'amount' => $amount,
                    'currency' => $currency,
                    'source' => $token,
                    'description' =>'Paying order with fee ['.$fee.'] ['.$_total_without_fee.']',
                    "destination" => [
                        "amount" => $_total_without_fee,
                        "account" => $account,
                      ],
                ));
            }
            
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

    public function createTransfer($amount,$currency,$connectAcount,$description){
        $this->_error_message="";
        try{
            $transfer = \Stripe\Transfer::create(array(
                'amount'   => $amount,
                'currency' => $currency,
                "destination" => $connectAcount,
                "transfer_group" => $description,
                'description' =>$description,
            ));
        } catch(\Stripe\Error\Card $e) {
            $transfer="Card error";
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $transfer="Too many requests made to the API too quickly ".$e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $transfer="Invalid parameters were supplied to Stripe's API -chargue ".$e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $transfer="Authentication with Stripe's API failed ".$e->getMessage();
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $transfer="Network communication with Stripe failed ".$e->getMessage();
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $transfer="Display a very generic error to the user, and maybe send ".$e->getMessage();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $transfer="Something else happened, completely unrelated to Stripe ".$e->getMessage();
        }
        return $transfer;
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

    public function createAccount($email){
        $this->_error_message="";
        try{
            $acct = \Stripe\Account::create([
                "country" => "US",
                "type" => "custom",
                "email" =>$email,
            ]);
        } catch(\Stripe\Error\Card $e) {
            $acct="Card error";
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $acct="Too many requests made to the API too quickly ".$e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $acct="Invalid parameters were supplied to Stripe's API -chargue ".$e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $acct="Authentication with Stripe's API failed ".$e->getMessage();
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $acct="Network communication with Stripe failed ".$e->getMessage();
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $acct="Display a very generic error to the user, and maybe send ".$e->getMessage();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $acct="Something else happened, completely unrelated to Stripe ".$e->getMessage();
        }
        return $acct;
    }

    public function getAccount($stripeID){
        $this->_error_message="";
        try{
            $acct = \Stripe\Account::retrieve($stripeID);
        } catch(\Stripe\Error\Card $e) {
            $acct="Card error";
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $acct="Too many requests made to the API too quickly ".$e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $acct="Invalid parameters were supplied to Stripe's API -chargue ".$e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $acct="Authentication with Stripe's API failed ".$e->getMessage();
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $acct="Network communication with Stripe failed ".$e->getMessage();
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $acct="Display a very generic error to the user, and maybe send ".$e->getMessage();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $acct="Something else happened, completely unrelated to Stripe ".$e->getMessage();
        }
        return $acct;
    }

    public function create_bank_account($routing_number,$account_number,$account_holder_name,$account_holder_type){
        $this->_error_message="";
        try{
            $b_acct = \Stripe\Token::create(
                array(
                    "bank_account" => array(
                        "country" => "US",
                        "currency" => "usd",
                        "routing_number" => $routing_number,
                        "account_number" => $account_number,
                        "account_holder_name" => $account_holder_name,
                        "account_holder_type" => $account_holder_type,
                    )
                )
            );
        } catch(\Stripe\Error\Card $e) {
            $b_acct="Card error";
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $b_acct="Too many requests made to the API too quickly ".$e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $b_acct="Invalid parameters were supplied to Stripe's API -chargue ".$e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $b_acct="Authentication with Stripe's API failed ".$e->getMessage();
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $b_acct="Network communication with Stripe failed ".$e->getMessage();
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $b_acct="Display a very generic error to the user, and maybe send ".$e->getMessage();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $b_acct="Something else happened, completely unrelated to Stripe ".$e->getMessage();
        }
        return $b_acct;
    }

    function get_token_bank_account($stripeID){
        $this->_error_message="";
        try{
            $b_acct= \Stripe\Token::retrieve($stripeID);
        } catch(\Stripe\Error\Card $e) {
            $b_acct="Card error";
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $b_acct="Too many requests made to the API too quickly ".$e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $b_acct="Invalid parameters were supplied to Stripe's API -chargue ".$e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $b_acct="Authentication with Stripe's API failed ".$e->getMessage();
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $b_acct="Network communication with Stripe failed ".$e->getMessage();
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $b_acct="Display a very generic error to the user, and maybe send ".$e->getMessage();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $b_acct="Something else happened, completely unrelated to Stripe ".$e->getMessage();
        }
        return $b_acct;
    }
    

    function update_file_stripe($file_name){
        $this->_error_message="";
        try{
            $fp = fopen($file_name, 'r');
            echo "<br><br>abrir archivo";
            $_file_response = \Stripe\FileUpload::create(array(
                'purpose' => 'identity_document',
                'file' => $fp
            ));
        } catch(\Stripe\Error\Card $e) {
            $_file_response="Card error";
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $_file_response="Too many requests made to the API too quickly ".$e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $_file_response="Invalid parameters were supplied to Stripe's API -chargue ".$e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $_file_response="Authentication with Stripe's API failed ".$e->getMessage();
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $_file_response="Network communication with Stripe failed ".$e->getMessage();
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $_file_response="Display a very generic error to the user, and maybe send ".$e->getMessage();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $_file_response="Something else happened, completely unrelated to Stripe ".$e->getMessage();
        }
        return $_file_response;
    }

    public function create_token_for_charge($name,$card_number,$month,$year,$cvc_number){
        $this->_error_message="";
        try{
            $_token= \Stripe\Token::create(array(
                "card" => array(
                "name" => $name,
                "number" => $card_number,
                "exp_month" => $month,
                "exp_year" => $year,
                "cvc" => $cvc_number,
                )
            ));
        } catch(\Stripe\Error\Card $e) {
            $_token="Card error";
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $_token="Too many requests made to the API too quickly ".$e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $_token="Invalid parameters were supplied to Stripe's API -chargue ".$e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $_token="Authentication with Stripe's API failed ".$e->getMessage();
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $_token="Network communication with Stripe failed ".$e->getMessage();
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $_token="Display a very generic error to the user, and maybe send ".$e->getMessage();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $_token="Something else happened, completely unrelated to Stripe ".$e->getMessage();
        }
        return $_token;
    }

  
}
?>