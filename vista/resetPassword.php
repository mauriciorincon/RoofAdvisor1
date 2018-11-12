

<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

$code = $_GET['verify'];
$table = $_GET['t'];
$email = $_GET['u'];

if(strcmp($table,"c")==0){
    $table="customer";
}else if(strcmp($table,"co")==0){
    $table="company";
}
?>


<div class="container">

    <div id="step1contain">
        <div class="panel" id="step-111">
            <div id="zip-panel-heading" class="panel-heading wizhead">
                 <h3 class="panel-title">Reset your password</h3>
            </div>
            <div class="panel-body pbody-white">
                <div class="form-group">
                    <input type="hidden" id="typeUser" name="typeUser" value="<?php echo $table ?>" />

                    
                    <center><p>Please enter the new password</p></center>
                    <div class="form-group">
                        <center><input maxlength="100" type="password" required="required" class="form-control" placeholder="New password" id="newpassword" name="newpassword" /></center>
                    </div>
                    <div class="form-group">
                        <center><input maxlength="100" type="password" required="required" class="form-control" placeholder="Confirm password" id="retypepassword" name="retypepassword" /></center>
                    </div>

                    <center><a href="#" onclick="changePaswword('<?php echo $table ?>','<?php echo $email ?>','<?php echo $code ?>')" class="btn">Change my password</a></center>
                </div>
            </div>
        </div>
    </div>

    <!--<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="box">
                <div class="box-icon">
                    <span class="fa fa-4x fa-unlock-alt"></span>
                </div>
                <div class="info">
                    <input type="hidden" id="typeUser" name="typeUser" value="<?php echo $table ?>" />

                    <center><h4 class="text-center">Reset your password</h4></center>
                    <center><p>Please enter the new password</p></center>
                    <div class="form-group">
                        <center><input maxlength="100" type="password" required="required" class="form-control" placeholder="New password" id="newpassword" name="newpassword" /></center>
                    </div>
                    <div class="form-group">
                    <center><input maxlength="100" type="password" required="required" class="form-control" placeholder="Confirm password" id="retypepassword" name="retypepassword" /></center>
                    </div>

                    <center><a href="#" onclick="changePaswword('<?php echo $table ?>','<?php echo $email ?>','<?php echo $code ?>')" class="btn">Change my password</a></center>
                </div>
            </div>
        </div>
	</div>-->
</div>
<br>
<br>
<div class="modal fade" id="myMensaje1" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerMessage1">Reset Password</h4> 
			</div> 
			<div class="modal-body" id="textMessage1"> 
                <p >your password has been changed, now you will redirect to RoofServiceNow page.</p> 
			</div> 
			<div class="modal-footer" id="buttonMessage"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>