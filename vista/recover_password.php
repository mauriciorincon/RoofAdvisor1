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
                        
                        <input maxlength="100" type="mail" required="required" class="form-control" placeholder="Enter Email" id="emailReset" name="emailReset" />
                    </div>

                    <a href="#" onclick="resetPassword()" class="btn">Reset password and send mail</a>
                </div>
            </div>
        </div>
	</div>
</div>
<br>
<br>