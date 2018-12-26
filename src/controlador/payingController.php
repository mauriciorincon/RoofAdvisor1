<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 


require_once($_SESSION['application_path']."/modelo/paying.class.php");
require_once($_SESSION['application_path']."/controlador/orderController.php");
require_once($_SESSION['application_path']."/controlador/userController.php");

class payingController{
    private $_payingModel=null;
    private $_orderController=null;
    private $_userController=null;

    function __construct()
	{		
    }

    public function setPaying(){
        $_payingModel=null;
        $_orderController=null;
        $_userController=null;
        if(!isset($_SESSION['application_path'])){
            $_SESSION['application_path']=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']);
            //echo "entro aca variable";
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

                $this->$_orderController=new orderController();
                if(strcmp($obj->action_type,'pay_take_service')==0){
                    $_order=null;
                    $obj->order_type_request='TS';    
                }else{
                    if(empty($obj->orderFBID)){
                        $_order=null;    
                    }else{
                        $_order=$this->$_orderController->getOrderByID($obj->orderFBID);
                    }
                }
                //if($_order==null){
                //    echo "Error, the order [".$orderFBID."] do not exists";
                //}else{
                    $token  = $obj->stripeToken;
                    $email  = $obj->stripeEmail;
                    $amount = intval($obj->totalAmount);
                    $currency='usd';
                    $order_type=$obj->order_type_request;
                    

                    $_result=$this->selectPaying($email,$token,$amount,$currency,$_order,$order_type);
                    echo "llego aca y el resultado es: ".$_result." tipo".$order_type;
                    print_r($_order);
                    if(is_object($_result) or is_array($_result)) {
                        $_objCharge=$_result;
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
                //}
                
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

    public function showPayingWindow1($buttonMessaje="Pay your service",$typePaying="pay_emergency_service"){
       
        
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
        if(strcmp($typePaying,'pay_company_roofreport')==0){
            
            $_amount=$this->getRoofReport();
        }else{
            $_amount=$this->getEmergencyValue();
        }
        $_email='';
        if(isset($_SESSION['email'])){
            $_email=$_SESSION['email'];
        }else{
            $_email='';
        }
        echo '
        <button id="customButton" class="btn">'.$buttonMessaje.'</button>
        <script>
            var amount_value='.$_amount.';
            var public_key=\''.$_key.'\';
            var action_type=\''.$typePaying.'\';
            var email_user_logued=\''.$_email.'\';
            var order_fbid=\''.'\';
            var order_type_request_val=\''.'\';
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
            $_emergency_value=$_emergency_value;
        }
        return $_emergency_value;
    }

    function getRoofReport(){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_emergency_value=$this->_payingModel->getNode('Parameters/AmountReport');
        if(is_null($_emergency_value) or $_emergency_value=="" ){
            $_emergency_value=0;
        }else{
            $_emergency_value=$_emergency_value;
        }
        return $_emergency_value;
    }

    public function createCustomer($email,$token){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_result=$this->_payingModel->createCustomer($email,$token);

        return $_result;
    }
    function createAccount($email){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_result=$this->_payingModel->createAccount($email);

        return $_result;
    }

    function getAccount($stripeID){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_result=$this->_payingModel->getAccount($stripeID);

        return $_result;
    }

    function create_bank_account($routing_number,$account_number,$account_holder_name,$account_holder_type){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_result=$this->_payingModel->create_bank_account($routing_number,$account_number,$account_holder_name,$account_holder_type);

        return $_result;
    }

    function update_file_stripe($file_name){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_result=$this->_payingModel->update_file_stripe($file_name);

        return $_result;
    }

    function get_token_bank_account($stripeID){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_result=$this->_payingModel->get_token_bank_account($stripeID);

        return $_result;
    }

    public function createTransfer($amount,$currency,$connectAcount){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_result=$this->_payingModel->createTransfer($amount,$currency,$connectAcount);

        return $_result;
    }

    public function createChargeOther($token,$amount,$currency,$account,$fee=0){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_result=$this->_payingModel->createChargeOther($token,$amount,$currency,$account,$fee);

        return $_result;
    }

    public function createChargeDestination($token,$amount,$currency,$account,$fee=0){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_result=$this->_payingModel->createChargeOtherFee($token,$amount,$currency,$account,$fee);

        return $_result;
    }

    public function create_token_for_charge($name,$card_number,$month,$year,$cvc_number){
        if(is_null($this->_payingModel)){
            $this->_payingModel= new paying_stripe();
        }
        $_result=$this->_payingModel->create_token_for_charge($name,$card_number,$month,$year,$cvc_number);

        return $_result;
    }

    public function selectPaying($email,$token,$amount,$currency,$_order,$order_type){
        $_payingModel=null;
        $_orderController=null;
        $_userController=null;
        $_stripe_fee=round($amount*2.9/100,2)+(30);
        $_fee=round($amount*2/100,2)+$_stripe_fee;
        $_ordet_type_selected='';
        if(empty($_order)){
            $_ordet_type_selected=$order_type;
        }else{
            $_ordet_type_selected=$_order['RequestType'];
        }
        switch($_ordet_type_selected){
            case 'S':
                //$_result=$this->_payingModel->createCharge($token,$amount,$currency,);
                $this->$_userController=new userController();
                $_company=$this->$_userController->getCompanyById($_order['CompanyID']);
                $_result=$this->_payingModel->createChargeDestination($token,$amount,$currency,$_company['stripeAccount'],$_fee);
                break;
            case 'E':
                if($_order==null){
                    $_result=$this->_payingModel->createCharge($token,$amount,$currency,'Emergency request Order number.');
                }else{
                    $this->$_userController=new userController();
                    $_company=$this->$_userController->getCompanyById($_order['CompanyID']);
                    $_result=$this->_payingModel->createChargeDestination($token,$amount,$currency,$_company['stripeAccount'],$_fee);
                }
                break;
            case 'R':
                $_result=$this->_payingModel->createCharge($token,$amount,$currency,'Roofreport request Order number.');
                break;
            case 'M':
                //$_result=$this->_payingModel->createCharge($token,$amount,$currency,);
                $this->$_userController=new userController();
                $_company=$this->$_userController->getCompanyById($_order['CompanyID']);
                $_result=$this->_payingModel->createChargeDestination($token,$amount,$currency,$_company['stripeAccount'],$_fee);
                break;
            case 'P':
                $_result=$this->_payingModel->createCharge($token,$amount,$currency,'Post-card request Order number.');
                break;
            case 'TS':
                $_result=$this->_payingModel->createCharge($token,$amount,$currency,'Taking service');
            default:
                $_result="Error, order type do not exists [".$_ordet_type_selected."]";
                break;
        }
        
        //$_result=$this->_payingModel->setPaying($email,$token,$amount,$currency,$_order);
        return $_result;
    }
    
}
?>