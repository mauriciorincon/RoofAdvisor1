<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");

if (isset($_POST['account'])){
    $_account=$_POST['account'];

    $_userController = new userController();
    $account = $_userController->getAccount($_account);
    if(is_object($account) or is_array($account)){
        $_result=$_userController->getValidateAccount($_account);
        if(is_array($_result)){
            echo "Error, It is neccesary to make payouts to your bank account, the next fields <br>";
            print_r($_result);
        }else{
            echo $_result;
        }
        
    }else{
        echo "Error, the account was not found";
    }
}elseif(isset($_POST['companyID'])){
    $_userController = new userController();
    $_companyID =$_POST['companyID'];
    $_comapnyInfo = $_userController->getCompanyById($_companyID);

    if(strcmp($_POST['companyID'],"CO000000")){
        $_account="";
    }else{
        $_account=$_comapnyInfo['stripeAccount'];
    }
    

    if(!empty($_account) or strcmp($_POST['companyID'],"CO000000")){
        $account = $_userController->getAccount($_account);
        if(is_object($account) or is_array($account)){
            $_result=$_userController->getValidateAccount($_account);
            if(is_array($_result)){
                echo "Error, for make payments to your company it is necessary to fill stripe info on your profile, the next fields <br>";
                print_r($_result);
            }else{
                echo $_result;
                //." account[$_account]";
                //print_r($account);
            }
            
        }else{
            echo "Error, the account was not found, for make payments to your company it is necessary to fill stripe info on your profile";
        }
    }else{
        echo "Error, the compamny [".$_comapnyInfo['CompanyName']."] does not have an account";   
    }
}else{    
    echo "Error, the account was not found, for make payments to your company it is necessary to fill stripe info on your profile";
}

?>