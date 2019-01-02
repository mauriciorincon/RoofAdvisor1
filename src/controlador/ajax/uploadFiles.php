<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    }
    require_once($_SESSION['application_path']."/controlador/userController.php");
    require_once($_SESSION['application_path']."/controlador/payingController.php");

    $_ext_msg="";
    
    $_action=$_POST['action'];
    $_id_action=$_POST['id_action'];
    $file_type = $_FILES['file']['type'];
    $file_size = $_FILES['file']['size'];
    $tmp_file = $_FILES['file']['tmp_name'];


    $_path_report=$_SESSION['temporal_path'];
    $file_name=$tmp_file;
    
    $upload_folder = $_path_report;

    $_pos=strrpos($tmp_file, '/', -1);
    if($_pos==false){
        $_pos=strrpos($tmp_file, '\\', -1);
    }
    $_path=substr($tmp_file,$_pos+1,strlen($tmp_file)-$_pos);
    $_path2="";
    
    /*echo $file_type."<br>";
    echo $file_size."<br>";
    echo $tmp_file."<br>";
    echo $_path."<br>";
    echo $_pos."<br>";*/

    $archivador = $upload_folder . $_path;

    if (!move_uploaded_file($tmp_file, $archivador)) {
        $return = Array('ok' => "FALSE", 'msg' => "An error occurred when uploading the file. It could not be saved.", 'status' => 'error');
    }else{
        switch($_action){
            case "documentIDFront":
                $_userController= new userController();
                $_payingController= new payingController();
                $_company=$_userController->getCompanyById($_id_action);
                if(is_object($_company) or is_array($_company)){
                    $_account=$_payingController->getAccount($_company['stripeAccount']);
                    if(is_object($_account) or is_array($_account)){
                        $_result=$_payingController->update_file_stripe_validation($archivador,$_action,$_company['stripeAccount']);
                        if(is_object($_result) or is_array($_result)){
                            $return = Array('ok'=>"TRUE",'msg' => "The file was uploaded correctly. name [".$archivador."]",'extmsg'=>"OK");
                        }else{
                            $return = Array('ok'=>"TRUE",'msg' => "The file was uploaded correctly. name [".$archivador."]",'extmsg'=>$_result);
                        }
                        
                    }else{
                        $return = Array('ok'=>"FALSE",'msg' => "Error, the account do not exist. account name [".$_company['stripeAccount']."]",'extmsg'=>$_ext_msg);
                    }
                }else{
                    $return = Array('ok'=>"FALSE",'msg' => "Error, the company do not exist. name [".$_id_action."]",'extmsg'=>$_ext_msg);
                }
                break;
            case "documentIDBack":
                $_userController= new userController();
                $_payingController= new payingController();
                $_company=$_userController->getCompanyById($_id_action);
                if(is_object($_company) or is_array($_company)){
                    $_account=$_payingController->getAccount($_company['stripeAccount']);
                    if(is_object($_account) or is_array($_account)){
                        $_result=$_payingController->update_file_stripe_validation($archivador,$_action,$_company['stripeAccount']);
                        if(is_object($_result) or is_array($_result)){
                            $return = Array('ok'=>"TRUE",'msg' => "The file was uploaded correctly. name [".$archivador."]",'extmsg'=>"OK");
                        }else{
                            $return = Array('ok'=>"FALSE",'msg' => "Error, uploading file. name [".$archivador."]",'extmsg'=>$_result);
                        }
                    }else{
                        $return = Array('ok'=>"FALSE",'msg' => "Error, the account do not exist. account name [".$_company['stripeAccount']."]",'extmsg'=>$_account);
                    }
                }else{
                    $return = Array('ok'=>"FALSE",'msg' => "Error, the company do not exist. name [".$_id_action."]",'extmsg'=>$_ext_msg);
                }
                break;
            default:
                $return = Array('ok'=>"TRUE",'msg' => "The file was uploaded correctly. name [".$file_name."]",'extmsg'=>$_ext_msg);
                break;
        }
        
    }

    echo json_encode($return);
?>