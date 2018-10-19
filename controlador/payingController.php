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
        if(!isset($_SESSION['application_path'])){
            $_SESSION['application_path']=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']);
            echo "entro aca variable";
        }
        $amount = 0;

        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        
        //echo "esto viene en el parametro estamos adentro ".$_POST['param'];
        if(isset($_POST['param'])){
            require_once($_SESSION['application_path']."/modelo/paying.class.php");
            
            
            $obj = $this->json_validate($_POST['param']);
            if(is_string($obj)){
                echo "Error, ".$obj."<br> string is:".$_POST['param'];
            }else{
                $token  = $obj->stripeToken;
                $email  = $obj->stripeEmail;
                $amount = intval($obj->totalAmount);
                $currency='usd';

                $_result=$this->_payingModel->setPaying($email,$token,$amount,$currency);
                //echo "llego aca y el resultado es:".$_result;
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
                    echo "Error, the charge don't do.".$this->_payingModel->getError();;
                }
            }
            //print_r($_POST["param"]);
            $obj = json_decode($_POST["param"], false);
            
        }else{
            $token  = $_POST['stripeToken'];
            $email  = $_POST['stripeEmail'];

            $currency='usd';
            $_result=$this->_payingModel->setPaying($email,$token,$amount,$currency);
            if($_result==true){
                $_objCharge=$this->_payingModel->getCharge();
                $array_data=$this->getPayingStatus($_objCharge->id);
                $a=array(
                    "id"=>$_objCharge->id,
                    "message"=>$array_data->seller_message,
                );
                echo json_encode($a);
            }else{
                echo "Error, the charge dotn't do.";
            }
        }
        
    }

    public function showPayingWindow(){
        $this->_payingModel= new paying_stripe();
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
        $this->_payingModel= new paying_stripe();
        $_key=$this->_payingModel->getPublishKey();
        
        //////////////////////////////////////////////////////////////////////////
        //Test
        /*echo '<script src="js/jquery-3.3.1.js"></script>';
        echo '<script src="https://checkout.stripe.com/checkout.js"></script>';
        echo '
        <button id="customButton" class="btn">Pay your service</button>
        <script>
            var amount_value=75000;
            var public_key=\''.$_key.'\'
        </script>
        <script src="js/stripe_conf.js"></script>';*/

        /////////////////////////////////////////////////////////////////
        //working
        ////////////////////////////////////////////////////////////////
        $_amount=$this->getEmergencyValue();
        echo '
        <button id="customButton" class="btn">Pay your service</button>
        <script>
            var amount_value='.$_amount.';
            var public_key=\''.$_key.'\';
            var action_type=\'pay_emergency_service\';
            var email_user_logued=\''.$_SESSION['email'].'\';
        </script>
        <script src="vista/js/stripe_conf.js"></script>';

        /*echo '
        <script src="https://checkout.stripe.com/checkout.js"></script>

        <button id="customButton" class="btn">Pay your service</button>

        <script src="js/stripe_conf.js"></script>';*/

        
        

        
    }

    public function getPayingStatus($chargeID){
        try {
            if(is_null($this->_payingModel)){
                $this->_payingModel= new paying_stripe();
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
                $this->_payingModel= new paying_stripe();
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

    function json_validate($string)
    {
        // decode the JSON data
        $result = json_decode($string);

        // switch and check possible JSON errors
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = ''; // JSON is valid // No error has occurred
                break;
            case JSON_ERROR_DEPTH:
                $error = 'The maximum stack depth has been exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Invalid or malformed JSON.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Control character error, possibly incorrectly encoded.';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON.';
                break;
            // PHP >= 5.3.3
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_RECURSION:
                $error = 'One or more recursive references in the value to be encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_INF_OR_NAN:
                $error = 'One or more NAN or INF values in the value to be encoded.';
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $error = 'A value of a type that cannot be encoded was given.';
                break;
            default:
                $error = 'Unknown JSON error occured.';
                break;
        }

        if ($error !== '') {
            // throw the Exception or exit // or whatever :)
            return $error;
        }

        // everything is OK
        return $result;
    }

    function getEmergencyValue(){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_emergency_value=$this->_payingModel->getNode('Parameters/AmountER');
        if(is_null($_emergency_value) or $_emergency_value=="" ){
            $_emergency_value=0;
        }else{
            $_emergency_value=$_emergency_value*100;
        }
        return $_emergency_value;
    }

    function getRoofReport(){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_emergency_value=$this->_payingModel->getNode('Parameters/AmountER');
        if(is_null($_emergency_value) or $_emergency_value=="" ){
            $_emergency_value=0;
        }else{
            $_emergency_value=$_emergency_value*100;
        }
        return $_emergency_value;
    }
}
?>