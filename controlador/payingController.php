<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 


require_once($_SESSION['application_path']."/modelo/paying.class.php");

class payingController{
    private $_payingModel=null;

    function __construct()
	{		
    }

    public function setPaying(){
        if(is_null($this->_payingModel)){
            $this->_payingModel=new paying_stripe();
        }
        if(isset($_POST['param'])){
            $obj = json_decode($_POST["param"], false);
            $token  = $obj->stripeToken;
            $email  = $obj->stripeEmail;
        }else{
            $token  = $_POST['stripeToken'];
            $email  = $_POST['stripeEmail'];
        }
        
        $amount = 1500;
        $currency='usd';

        //echo "Token:".$token;

        $_result=$this->_payingModel->setPaying($email,$token,$amount,$currency);
        

        if($_result==true){
            $_objCharge=$this->_payingModel->getCharge();
        
            $array_data=$this->getPayingStatus($_objCharge->id);
            
            $a=array(
                "id"=>$_objCharge->id,
                "message"=>$array_data->seller_message,
            );
            
            
            echo json_encode($a);
            //echo $array_data->seller_message;


        }else{
            echo "Error, the charge dotn't do.";
        }
        
        
    }

    public function showPayingWindow(){
        $this->_payingModel=new paying_stripe();
        $_key=$this->_payingModel->getPublishKey();
        echo '<form action="http://localhost/RoofAdvisor1/index.php?controller=paying&accion=setPaying" method="post" id="payingFormStripe">
            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="'.$_key.'"
                    data-description="Pay for your roof service"
                    data-amount="1500"
                    data-name="RoofAdvisorz"
                    data-locale="auto"
                    data-zip-code="true"
                    data-allow-remember-me="false"
                    data-label="Pay your service"></script>
            </form>';
    }

    public function showPayingWindow1(){
        echo '
        

        <button id="customButton" class="btn">Pay your service</button>

        <script src="vista/js/stripe_conf.js"></script>';

        /*echo '
        <script src="https://checkout.stripe.com/checkout.js"></script>

        <button id="customButton" class="btn">Pay your service</button>

        <script src="js/stripe_conf.js"></script>';*/

        $this->_payingModel=new paying_stripe();
        $_key=$this->_payingModel->getPublishKey();
        

        
    }

    public function getPayingStatus($chargeID){
        try {
            if(is_null($this->_payingModel)){
                $this->_payingModel=new paying_stripe();
            }
            $_result=$this->_payingModel->getPayinStatus($chargeID);
            if(is_array($_result) or is_object($_result)){
                return $_result->outcome;
            }
            
            // Use Stripe's library to make requests...
          } catch(\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err  = $body['error'];
          
            print('Status is:' . $e->getHttpStatus() . "\n");
            print('Type is:' . $err['type'] . "\n");
            print('Code is:' . $err['code'] . "\n");
            // param is '' in this case
            print('Param is:' . $err['param'] . "\n");
            print('Message is:' . $err['message'] . "\n");
          } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
          } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
          } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
          } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
          } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
          } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
          }

        
        
    }

    public function getPayingData($chargeID){
        try {
            if(is_null($this->_payingModel)){
                $this->_payingModel=new paying_stripe();
            }
            $_result=$this->_payingModel->getPayinStatus($chargeID);
            if(is_array($_result) or is_object($_result)){
                return $_result;
            }
            
            // Use Stripe's library to make requests...
          } catch(\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err  = $body['error'];
          
            print('Status is:' . $e->getHttpStatus() . "\n");
            print('Type is:' . $err['type'] . "\n");
            print('Code is:' . $err['code'] . "\n");
            // param is '' in this case
            print('Param is:' . $err['param'] . "\n");
            print('Message is:' . $err['message'] . "\n");
          } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            return $e;
          } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            return $e;
          } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return $e;
          } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            return $e;
          } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return $e;
          } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return $e;
          }
    }
}
?>