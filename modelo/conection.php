<?php
//require 'vendor/autoload.php';
//use Kreait\Firebase\Configuration; 
//use Kreait\Firebase\Firebase;
include $_SERVER['DOCUMENT_ROOT'].'/RoofAdvisor/vendor/autoload.php';
include $_SERVER['DOCUMENT_ROOT'].'/RoofAdvisor/vendor/ktamas77/firebase-php/src/firebaseLib.php';

const DEFAULT_URL = 'https://pruebabasedatos-eacf6.firebaseio.com/';
const DEFAULT_TOKEN = '2r3VP6qms0ibMPC8ENJN3vOzr9dFaLexO5T9X3yZ';
const DEFAULT_PATH = 'pruebabasedatos-eacf6';

class connection{

    private $_firebase=null;

    function __construct()
	{		
        $this->_firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
        //echo "se conecto";
    }

    public function getConnection(){
        return $this->_firebase;
    }

    public function getQueryEqual($table,$field,$searchValue){
        //$value = $this->_firebase->get(DEFAULT_PATH.$table, array($field => $value));
        //$value = $this->_firebase->get("Users/", array('fistname' => 'mauricio'));
        $value = $this->_firebase->get($table."/");

        $_array_company=json_decode($value,true);
        //print_r($_array_company);

        //echo "<br><br>estoy aca<br><br>";
        
        //print_r($_array_company[0]);
        //print_r($_array_company['CO000001'][CompanyEmail] );
        //echo "Email ".$_array_company['CO000001'][CompanyEmail];

        //echo "<br><br>estoy aca<br><br>";
        
        foreach ($_array_company as $key => $value1) {
            //echo $value1["$field"]." ".strcmp($value1["$field"],$searchValue)." ".$searchValue."<br>";
            if(strcmp($value1["$field"],$searchValue)==0){
                return $value1;
            }
            //echo $value1["CompanyEmail"] . ", " . $value1["ComapnyLicNum"] . "<br>";
          }

        //$value = $this->_firebase->get('Users/0/age');
        
        /*$test = array(
            "foo" => "bar",
            "i_love" => "lamp",
            "id" => 42
        );
        $dateTime = new DateTime();
        
        $this->_firebase->set(DEFAULT_PATH . '/name/contact001', $test);
        
        // --- storing a string ---
        $this->_firebase->set(DEFAULT_PATH . '/name/contact001', $test);
        
        // --- reading the stored string ---
        $value = $this->_firebase->get(DEFAULT_PATH . '/name/contact001');*/

        
        
        return "null";

    }

    public function getQueryEqual2($table,$field,$searchValue,$field2,$searchValue2){
        $value = $this->_firebase->get($table."/");
        $_array_contractor=json_decode($value,true);
        foreach ($_array_company as $key => $value1) {
            if(strcmp($value1["$field"],$searchValue)==0 and strcmp($value1["$field2"],$searchValue2)==0){
                return $value1;
            }
        }
        return "null";
    }

    public function getLastNodeTable($table){
        $value = $this->_firebase->get($table."/");

        $_array_company=json_decode($value,true);
        return end($_array_company);

    }

   

    public function insertDataTable($table,$insertNode,$data){
        $this->_firebase->set($table . "/$insertNode", $data);
    }

    public function updateDataTable($table,$updateNode,$data){
        //echo $table."/$updateNode".$data;
        $this->_firebase->set($table . "/$updateNode", $data);
    }

    public function getDataTable($table){
        $value = $this->_firebase->get($table."/");

        $_array_company=json_decode($value,true);
        return $_array_company;
    }


}

?>