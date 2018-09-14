<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 


require_once($_SESSION['application_path']."/modelo/driver.class.php");
require_once($_SESSION['application_path']."/controlador/userController.php");

class driverController{

    private $_driverModel=null;
    private $_userController=null;

    function __construct()
	{		
    }

    public function getDriver($firstName,$lastName){
        $this->_driverModel=new driverModel();
        $_driver=$this->_driverModel->getDriver($firstName,$lastName);
        return $_driver;
    }

    public function getDrivers($companyID){
        $this->_driverModel=new driverModel();
        $_array_drivers=$this->_driverModel->getDrivers("Contractors");
        $_array_drivers_company=array();
        if (is_array($_array_drivers)){
            foreach ($_array_drivers as $key => $driver) {
                if(strcmp($driver["CompanyID"],$companyID)==0){
                    push($_array_drivers_company,$driver);
                }
              }
              return $_array_drivers_company;
        }else{
            $_drivers=null;
        }
        return $_driver;
    }

    public function insertDrivers($companyID,$array_drivers){
        $this->_driverModel=new driverModel();
        $this->_userController=new userController();
        
        $_company=$this->_userController->getCompany($companyID);
        
        $_lastDriverID=$this->_driverModel->getLastNodeDriver("Contractors","ContractorID");

        if (is_null($_lastDriverID)){
            $_newDriverId="CN0001";
        }else{
            $_tmp=substr($_lastDriverID,2);
            $_tmp=intval($_tmp)+1;
            $_newDriverId="CN".str_pad($_tmp, 4, "0", STR_PAD_LEFT);
        }

        
        foreach ($array_drivers as $key => $driverInsert) {
            $_driver=array(
                "CompanyID" => "$companyID",
                "CompanyName" => $_company['CompanyName'],
                "ContEmail" => $driverInsert['driverEmail'],
                "ContFBID" => "",
                "ContLicenseNum" => $driverInsert['driverLicense'],
                "ContNameFirst" => $driverInsert['driverFirstName'],
                "ContNameLast" => $driverInsert['driverLastName'],
                "ContPhoneNum" => $driverInsert['driverPhone'],
                "ContRating" => "0",
                "ContStatus" => $driverInsert['driverStatus'],
                "ContractorID" => "$_newDriverId",
                "ContractorProfile" => $driverInsert['driverProfile'],
            );
            $this->_driverModel->insertDriver($_newDriverId,$_driver);
            $_tmp=substr($_newDriverId,2);
            $_tmp=intval($_tmp)+1;
            $_newDriverId="CN".str_pad($_tmp, 4, "0", STR_PAD_LEFT);
        }
        return $_newDriverId;
        
    }

    public function updateDriver($_contractorID,$_contratorFirstName,$_contratorLastName,
    $_contratorPhoneNumber,$_contratorLinceseNumber){
        $this->_driverModel=new driverModel();
        $this->_driverModel->updateDriver($_contractorID.'/ContNameFirst',$_contratorFirstName);
        $this->_driverModel->updateDriver($_contractorID.'/ContNameLast',$_contratorLastName);
        $this->_driverModel->updateDriver($_contractorID.'/ContPhoneNum',$_contratorPhoneNumber);
        $this->_driverModel->updateDriver($_contractorID.'/ContLicenseNum',$_contratorLinceseNumber);

        return "The contractor identify by ".$_contractorID." was updated corretly";
    }

    public function updateDriverState($_contractorID,$_contractorState){
        $this->_driverModel=new driverModel();
        $this->_driverModel->updateDriver($_contractorID.'/ContStatus',$_contractorState);

        return "The contractor identify by ".$_contractorID." was updated corretly";
    }

    public function disableDriver($_contractorID){
        $this->_driverModel=new driverModel();
        $this->_driverModel->updateDriver($_contractorID.'/ContStatus','Inactive');

        
        return "The contractor identify by ".$_contractorID." was updated corretly";
    }

    public function enableDriver($_contractorID){
        $_message="";
        $_flag=false;
        $this->_driverModel=new driverModel();
        $_actual_driver=$this->_driverModel->getDriverByID($_contractorID);

        $this->_userController=new userController();
        $_user_created=$this->_userController->insertUserDatabase($_actual_driver['ContEmail'],$_actual_driver['ContPhoneNum'],$_actual_driver['ContNameFirst'].' '.$_actual_driver['ContNameLast'],'',$_contractorID,'driver');
        if(is_array($_user_created) or is_object($_user_created)){
            $_message="User driver created correctly.";
            
            $this->_driverModel->updateDriver($_contractorID.'/ContStatus','Active');
            $_flag=true;
        }else{
            $_message="Error creating the driver. $_user_created";
            $_flag=false;
        }

        
        

        if($_flag==false){
            return "The contractor identify by ".$_contractorID." can`t be updated correctly, $_message";
        }else{
            return "The contractor identify by ".$_contractorID." was updated correctly, $_message";
        }
        //print_r($_user_created);
        

    }

}



?>