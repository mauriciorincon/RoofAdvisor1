<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="box">
                <div class="box-icon">
                    <span class="fa fa-4x fa-unlock-alt"></span>
                </div>
                <div class="info">
                    <input type="hidden" id="typeUser" name="typeUser" value="<?php echo $_user_type ?>" />
                    <h4 class="text-center">Reset your password</h4>
                    <p>Enter your email address and we will send you a link to reset your password.</p>
                    <div class="form-group">
                        
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Email" id="emailReset" name="emailReset" />
                    </div>

                    <a href="#" onclick="resetPassword()" class="btn">Reset password and send mail</a>
                </div>
            </div>
        </div>
	</div>
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
				<p >A message as send to your mail with instruccions to recover your password.</p> 
			</div> 
			<div class="modal-footer" id="buttonMessage"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>