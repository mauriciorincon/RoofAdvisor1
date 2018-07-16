<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require $_SESSION['application_path'].'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


class connection{

    //Original database, where data is insert
    private $_firebase=null;
    private $_factory_firebase=null;

    //Only for store company login info
    private $_firebase_company=null;
    private $_factory_firebase_company=null;

    //Only for store driver login info
    private $_firebase_driver=null;
    private $_factory_firebase_driver=null;

    function __construct()
	{		
        //$serviceAccount = ServiceAccount::fromJsonFile($_SESSION['application_path'].'/vendor/pruebabasedatos-eacf6-firebase.json');
        $serviceAccount = ServiceAccount::fromJsonFile($_SESSION['application_path'].'/vendor/roofadvizorz-firebase.json');
        //echo "roofadvizorz-firebase.json";
        
        //->withDatabaseUri('https://pruebabasedatos-eacf6.firebaseio.com')
        $firebase_tmp = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://roofadvisorzapp.firebaseio.com')
            ->create();

        $this->_firebase = $firebase_tmp->getDatabase();
        $this->_factory_firebase=$firebase_tmp;
        
    }

    public function companyConnection(){
        $serviceAccount = ServiceAccount::fromJsonFile($_SESSION['application_path'].'/vendor/roofadvisorz-company-firebase.json');

        $firebase_tmp = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://roofadvisorz-company.firebaseio.com')
            ->create();

        $this->_firebase_company = $firebase_tmp->getDatabase();
        $this->_factory_firebase_company=$firebase_tmp;
    }

    public function driverConnection(){
        $serviceAccount = ServiceAccount::fromJsonFile($_SESSION['application_path'].'/vendor/roofadvisorz-driver-firebase.json');

        $firebase_tmp = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://roofadvisorz-driver.firebaseio.com')
            ->create();

        $this->_firebase_driver = $firebase_tmp->getDatabase();
        $this->_factory_firebase_driver=$firebase_tmp;
    }

    public function getConnection(){
        return $this->_firebase;
    }

    public function getQueryEqual($table,$field,$searchValue){
        $snapshot=$this->_firebase->getReference($table)
                        ->orderByChild($field)
                        ->equalTo($searchValue)
                        ->getSnapshot();

        $value = $snapshot->getValue();
        if(is_array($value)){
            foreach($value as $key => $value1){
                return $value1;
            }
            
        }else{
            return null;
        }
    }

    public function getQueryListEqualValue($table,$searchValue){
        $_flag=null;
        $snapshot=$this->_firebase->getReference($table)
                        ->orderByValue()
                        ->getSnapshot();
        $value = $snapshot->getValue();
        if(is_array($value)){
            foreach($value as $key => $value1){
                if(strcmp($value1,$searchValue)==0){
                    $_flag=$searchValue;
                    break;
                }
            }
            return $_flag;
        }else{
            return null;
        }
    }

    

    public function getQueryEqualKey($table,$field,$searchValue){
        $snapshot=$this->_firebase->getReference($table)
                        ->orderByChild($field)
                        ->equalTo($searchValue)
                        ->getSnapshot();
       
        $value = $snapshot->getValue();

        //print_r($value);
        if(is_array($value)){
            foreach($value as $key => $value1){
                return $key;
            }
        }else{
            return "null";
        }
    }

    public function getQueryEqualM($table,$field,$searchValue){
        $snapshot=$this->_firebase->getReference($table)
                        ->orderByChild($field)
                        ->equalTo($searchValue)
                        ->getSnapshot();

        $value = $snapshot->getValue();
        
        
        if(is_array($value)){
        
            return $value;
        }else{
            return "null";
        }
    }

    public function getDataByDate($table,$field,$startDate,$finishDate){
        $snapshot=$this->_firebase->getReference($table)
                        ->orderByChild($field)
                        ->startAt($startDate)
                        ->getSnapshot();

        $value = $snapshot->getValue();
        
        
        if(is_array($value)){
        
            return $value;
        }else{
            return "null";
        }
    }

    public function getDataTable($table){
        $snapshot=$this->_firebase->getReference($table)
                            ->getSnapshot();
        $value = $snapshot->getValue();
        $_array_data=$value;
        //$value = $this->_firebase->get($table."/");

        //$_array_company=json_decode($value,true);
        return $_array_data;
    }

    public function getQueryEqual2($table,$field,$searchValue,$field2,$searchValue2){
        $snapshot=$this->_firebase->getReference($table)
                            ->shallow()
                            ->getSnapshot();
        $value = $snapshot->getValue();

        //$value = $this->_firebase->get($table."/");
        //$_array_contractor=json_decode($value,true);
        $_array_company=$value;
        foreach ($_array_company as $key => $value1) {
            if(strcmp($value1["$field"],$searchValue)==0 and strcmp($value1["$field2"],$searchValue2)==0){
                return $value1;
            }
        }
        return "null";
    }

    public function getLastNodeTable($table,$field){
        $snapshot=$this->_firebase->getReference($table)
            ->orderByChild($field)
            ->limitToLast(1)
            ->getSnapshot();
            $value = $snapshot->getValue();

            
            //print_r($value);
            if(is_array($value)){
                foreach($value as $key => $value1){
                    return $value1;
                }
                //return $value;
            }else{
                return "null";
            }
        $_array_company=$value;
        return end($_array_company);

    }

   

    public function insertDataTable($table,$insertNode,$data,$key){
        
        if($key==true){
            try {
                    //echo "llegue aca insertDataTable $table $insertNode";
                    $_key=$this->_firebase->getReference($table)
                        ->push($data);
                    $this->updateDataTable($table.'/'.$_key->getKey(),$insertNode,$_key->getKey());
                    return $_key;
                }catch (Exception $e){
                    return $e->getMessage();
                }
        }else{
            try {
                //echo "llegue aca insertDataTable $table $insertNode";
                $_key=$this->_firebase->getReference($table.'/'.$insertNode)
                    ->set($data);
                return $_key;
            }catch (Exception $e){
                return $e->getMessage();
            }
        }
    }

    public function updateDataTable($table,$updateNode,$data){
        try{
            $updates = [
                $table.'/'.$updateNode => $data,
            ];
            
            $this->_firebase->getReference() // this is the root reference
               ->update($updates);
            return true;
        }catch (Exception $e){
                return "Error, ".$e->getMessage();
        }
        

        //$this->_firebase->set($table . "/$updateNode", $data);
    }

    

    public function createUserDatabse($_userProperties,$_profile){
        try {
            if(strcmp($_profile,"customer")==0){
                $auth = $this->_factory_firebase->getAuth();
            }else if(strcmp($_profile,"company")==0){
                if(is_null($this->_factory_firebase_company)){
                    $this->companyConnection();
                }
                $auth = $this->_factory_firebase_company->getAuth();
            }else if(strcmp($_profile,"driver")==0){
                if(is_null($this->_factory_firebase_driver)){
                    $this->driverConnection();
                }
                $auth = $this->_factory_firebase_driver->getAuth();
            }
            
            $createdUser = $auth->createUser($_userProperties);
            $auth->sendEmailVerification($createdUser->uid);
            return $createdUser;
        } catch (Kreait\Firebase\Exception\Auth\EmailExists $e) {
            return $e->getMessage();
        } catch (Kreait\Firebase\Exception\Auth\PhoneNumberExists $e) {
            return $e->getMessage();
        } catch (Kreait\Firebase\Exception\InvalidArgumentException $e){
            return $e->getMessage();
        } catch (Kreait\Firebase\Value\Email $e){
            return $e->getMessage();
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function validateUser($_user,$password,$_profile){
        //echo "<br>conexion validate";
        $auth=null;
        try {
            if(strcmp($_profile,"customer")==0){
                $auth = $this->_factory_firebase->getAuth();
            }else if(strcmp($_profile,"company")==0){
                //echo "<br>entro a company";
                if(is_null($this->_factory_firebase_company)){
                    $this->companyConnection();
                }
                //echo "<br>creo objeto company";
                $auth = $this->_factory_firebase_company->getAuth();
                //echo "<br>creo objeto autenticacion";
                //$users = $auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
                //foreach ($users as $user) {
                //   print_r($user);
                //}
            }else if(strcmp($_profile,"driver")==0){
                if(is_null($this->_factory_firebase_driver)){
                    $this->driverConnection();
                }
                $auth = $this->_factory_firebase_driver->getAuth();
            }
            //print_r($auth);
            //echo "<br>voy a validar usuario";
            $user = $auth->verifyPassword($_user, $password);
            //echo "<br>valido el usuario";

            //print_r($user);
            //echo "llego aca 2";
            return $user;
        } catch (Kreait\Firebase\Exception\Auth\InvalidPassword $e) {
            
            return $e->getMessage();
        } catch (Kreait\Firebase\Exception\InvalidArgumentException $e ){
            return $e->getMessage();
        } catch (Kreait\Firebase\Exception\Auth\EmailNotFound $e){
            return $e->getMessage();
        }catch (Exception $e){
            
            return $e->getMessage();
        }
        echo "no paso a ningun error";
    }

    public function getDateTime(){

        $ref = $$this->_firebase->getReference('posts/my-post')
          ->set('created_at', ['.sv' => 'timestamp']);
    }

    public function getCount($table,$field,$searchValue){
        $snapshot=$this->_firebase->getReference($table)
                        ->orderByChild($field)
                        ->equalTo($searchValue)
                        ->getSnapshot();

        $value = $snapshot->numChildren();
        return $value;
    }

    public function getKey($table){
        // Create a key for node
        //echo "entro a generar la key";
        //$newKey=$this->_firebase->getReference()->push()->getKey(); 
        $newKey=$this->_firebase->getReference()->push($table)->getKey();
        //$snapshot=$this->_firebase->getReference($table); 
        //$newKey=$snapshot->push()->getKey(); 
        //var newPostKey = firebase.database().ref().child('posts').push().key;

        //echo "la key fue $newKey";
        return $newKey;
    }

}

?>