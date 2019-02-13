<?php

    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    require $_SESSION['library_path_autoload'];


  use SignalWire\Rest\Client;

  $_ENV['SIGNALWIRE_API_HOSTNAME'] = "example.signalwire.com";

  class smsController{

    private $_cliente;
    function __construct()
	{		
    }

    public function createClientSms(){
        try{
            $project = '0d749ea3-2462-4c4e-bc54-1385d0eb84b2';
            $token = 'PT7dafd8692ae5456e2099d0d0f58eaad4ce1b379364bc3115';
            $this->_cliente = new Client($project, $token);
            echo "Creacion cliente:<br>";
            print_r($this->_cliente);
        }catch(Exception $e){
            $this->_cliente = $e;
            echo "error creacion cliente Creacion cliente:<br>";
            print_r($this->_cliente);
        }
    }

    public function sendMessage($_from,$_to,$_message){
        try{
            if(is_object($this->_cliente)){
                $message = $this->_cliente->messages
                        ->create($_to, // to
                                 array("from" => $_from, "body" => $_message)
                        );
    
                print($message->sid);
            }else{
                echo "No se ha creado el cliente para enviar el mensaje";
            }
        }catch(\Twilio\Exceptions\EnvironmentException $e){
            echo "<br>Error: EnvironmentException ".$e."<br>";
        }catch(\Twilio\Exceptions\ConfigurationException $e){
            echo "<br>Error: ConfigurationException ".$e."<br>";
        }catch(\Twilio\Exceptions\DeserializeException $e){
            echo "<br>Error: DeserializeException ".$e."<br>";
        }catch(\Twilio\Exceptions\HttpException $e){
            echo "<br>Error: HttpException ".$e."<br>";
        }catch(\Twilio\Exceptions\RestException $e){
            echo "<br>Error: RestException ".$e."<br>";
        }catch(\Twilio\Exceptions\TwilioException $e){
            echo "<br>Error: TwilioException ".$e."<br>";
        }catch(\Twilio\Exceptions\TwimlException $e){
            echo "<br>Error: TwimlException ".$e."<br>";
        }
        
        
    }

    public function getAllTallNumbers(){
        try{
            if(is_object($this->_cliente)){
            $numbers = $this->_cliente->availablePhoneNumbers('US')->tollFree->read(array("areaCode" => "310"));

            $number = $this->_cliente->incomingPhoneNumbers
                ->create(
                    array(
                        "phoneNumber" => $numbers[0]->phoneNumber
                    )
                );

            echo $number->sid;
            }else{
                echo "No se ha creado el cliente para enviar el mensaje";
            }
        }catch(\Twilio\Exceptions\EnvironmentException $e){
            echo "<br>Error: EnvironmentException ".$e."<br>";
        }catch(\Twilio\Exceptions\ConfigurationException $e){
            echo "<br>Error: ConfigurationException ".$e."<br>";
        }catch(\Twilio\Exceptions\DeserializeException $e){
            echo "<br>Error: DeserializeException ".$e."<br>";
        }catch(\Twilio\Exceptions\HttpException $e){
            echo "<br>Error: HttpException ".$e."<br>";
        }catch(\Twilio\Exceptions\RestException $e){
            echo "<br>Error: RestException ".$e."<br>";
        }catch(\Twilio\Exceptions\TwilioException $e){
            echo "<br>Error: TwilioException ".$e."<br>";
        }catch(\Twilio\Exceptions\TwimlException $e){
            echo "<br>Error: TwimlException ".$e."<br>";
        }
    }
    
  }
  
?>