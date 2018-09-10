<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="box">
                <div class="box-icon">
                    <span class="fa fa-4x fa-unlock-alt"></span>
                </div>
                <div class="info">
                    <input type="hidden" id="typeUser" name="typeUser" value="<?php echo $_GET['id'] ?>" />
                    <h4 class="text-center">Reset your password</h4>
                    <p>Please enter the new password</p>
                    <div class="form-group">
                        <input maxlength="100" type="password" required="required" class="form-control" placeholder="New password" id="newpassword" name="newpassword" />
                    </div>
                    <div class="form-group">
                        <input maxlength="100" type="password" required="required" class="form-control" placeholder="Confirm password" id="retypepassword" name="retypepassword" />
                    </div>

                    <a href="#" onclick="resetPassword()" class="btn">Change my password</a>
                </div>
            </div>
        </div>
	</div>
</div>
<br>
<br>

<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
//if(!isset($_SESSION['application_path'])){
$_SESSION['application_path']=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']);
$_pos=strrpos($_SESSION['application_path'],"/");
//echo "Pos=".$_pos;
if($_pos===false){

}else{
    $_SESSION['application_path']=substr($_SESSION['application_path'],0,$_pos);
}

if(strcmp($_SERVER['HTTP_HOST'],'localhost')==0){
    $_dir=$_SERVER['REQUEST_URI'];
    $pos1 = strpos($_dir,"/");
    $pos2 = strpos($_dir,"/", $pos1 + 1);
    //echo "<br>hola:".substr($_dir,$pos1+1,$pos2-1);
    $_path2="/".substr($_dir,$pos1+1,$pos2-1);
    $_path1="http://" . $_SERVER['HTTP_HOST'].$_path2;
}else{
    $_path1="http://" . $_SERVER['HTTP_HOST'];
}


?>