<br>
<br>
<br>
		<!-- map-area start-->
		<div class="mobhead-area-reg contact-widget pb-80">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12" align="center">
						<div class="contact-form">
                            <h1>Welcome to the RoofServiceNow Customer Login</h1>
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12 col-sm-12" align="center">
						<div class="contact-form">
                            <h4><b><i>If new to RoofServiceNow, <a href="?controller=user&accion=showRegisterCustomer">Register Here</a></i></b></h4>
						</div>
                    </div>
                    
					<div class ="col-md-4">&nbsp;
						</div>

                    <div class="col-lg-4 col-md-4 col-sm-4" align="center">
						<div class="contact-form">
							<form action="?controller=user&accion=loginCustomer" method="post">
								<label>User Name<span class="required">*</span></label>
									<input type="text" placeholder="" required="true" id="userClient" name="userClient" />
								<label>Password<span class="required">*</span></label>
									<input type="password" placeholder="" required="true" id="passwordClient" name="passwordClient"/>
								
                                <button type="submit" id="submitLoginCustomer">Login</button><br><br>
								<a href="?controller=user&accion=resetPasswordCustomer">Forgot password?</a>    
							</form>
						</div>
					</div>

					<div class ="col-md-4">&nbsp;
						</div>
					
				</div>
			</div>
		</div>
		<!-- map-area end-->
<div class="modal fade" id="myModalRespuesta" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerTextAnswerOrder">Modal Header</h4> 
			</div> 
			<div class="modal-body" id="textAnswerOrder"> 
				<p >Some text in the modal. myModalRespuesta</p> 
			</div> 
			<div class="modal-footer" id="buttonAnswerOrder"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myModalChagePhoneEmail" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <input type="hidden" id="id_user_mail" value="" />
        <input type="hidden" id="id_change_type" value="" />
        <input type="hidden" id="id_table" value=""  />

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="headerTextAnswerOrder">Change Phone/Mail</h4>
            </div>
            <div class="modal-body" id="textAnswerOrder">
                <label class="control-label" for="actualidPhoneMail">Actual Phone/Email</label>
                <input class="form-control" type="text" id="actualidPhoneMail" disabled />
            </div>
            <div class="modal-body" id="textAnswerOrder">
                <label class="control-label" for="newidPhoneMail">New Phone/Email</label>
                <input class="form-control" type="text" id="newidPhoneMail" />
            </div>
            <div class="modal-footer" id="buttonAnswerOrder">
                <button type="button" class="btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn-primary" onclick="changeMailPhone()">Change</button>
            </div>
        </div>
    </div>
</div>