<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require $_SESSION['application_path'].'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


class connection{

    private $_firebase=null;
    private $_factory_firebase=null;

    function __construct()
	{		
        $serviceAccount = ServiceAccount::fromJsonFile($_SESSION['application_path'].'/vendor/pruebabasedatos-eacf6-firebase.json');

        $firebase_tmp = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://pruebabasedatos-eacf6.firebaseio.com')
            ->create();

        $this->_firebase = $firebase_tmp->getDatabase();
        $this->_factory_firebase=$firebase_tmp;
        
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
            return "null";
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

    public function getDataTable($table){
        $snapshot=$this->_firebase->getReference($table)
                            ->getSnapshot();
        $value = $snapshot->getValue();
        $_array_company=$value;
        //$value = $this->_firebase->get($table."/");

        //$_array_company=json_decode($value,true);
        return $_array_company;
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

   

    public function insertDataTable($table,$insertNode,$data){
        if(empty($insertNode)){
            try {
                    //echo "llegue aca insertDataTable $table $insertNode";
                    $_key=$this->_firebase->getReference($table)
                        ->push($data);
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
        //echo $table."/$updateNode".$data;
        $updates = [
            $table.'/'.$updateNode => $data,
        ];
        
        $this->_firebase->getReference() // this is the root reference
           ->update($updates);

        //$this->_firebase->set($table . "/$updateNode", $data);
    }

    

    public function createUserDatabse($_userProperties){
        try {
            $auth = $this->_factory_firebase->getAuth();
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

    public function validateUser($_user,$password){
        try {
            $auth = $this->_factory_firebase->getAuth();
            $user = $auth->verifyPassword($_user, $password);
            //print_r($user);
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

}

?>