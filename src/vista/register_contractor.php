
<br>
<br>
<br>
<div class="container"style="margin-top: 30px;">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-4"> 
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small>About you</small></p>
            </div>
            <div class="stepwizard-step col-xs-4"> 
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small>Register your Employees/Drivers</small></p>
            </div>
            <div class="stepwizard-step col-xs-4"> 
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Email Verification</small></p>
            </div>
            
        </div>
    </div>
    
    <form role="form">
        <div class="panel panel-primary setup-content" id="step-1">
            <div class="panel-heading">
                 <h3 class="panel-title">Enter Company Information</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label labeltwht">Company Name</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Name" id="companyName" name="companyName" />
                </div>
                <div class="form-group">
                    <label class="control-label labeltwht">First Name</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" id="firstNameCompany" name="firstNameCompany" />
                </div>
                <div class="form-group">
                    <label class="control-label labeltwht">Last Name</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" id="lastNameCompany" name="lastNameCompany"/>
                </div>
                <div class="form-group">
                    <label class="control-label labeltwht">Email</label>
                    <input maxlength="100" type="email" required="required" class="form-control" placeholder="Email" id="emailValidation" name="emailValidation" onfocusout="validateEmail('company')"/>
                    <label class="control-label labeltwht" id="answerEmailValidate" name="answerEmailValidate">Answer</label>
                </div>

                <div class="form-group">
                        <label class="control-label labeltwht ">Password</label>
                        <input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Password" id="inputPassword" name="inputPassword" onblur="validInputPassword()"  />
                        <div class="help-block labeltwht">Minimum of 6 characters</div>
                        <label class="control-label labeltwht" id="answerPasswordValidateStep6" name="answerPasswordValidateStep6"></label>
                    </div>
                    <div class="form-group">
                        <label class="control-label labeltwht ">Confirm Password</label>
                        <input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Confirm Password" id="inputPasswordConfirm" name="inputPasswordConfirm" onblur="validInputRePassword()" />
                        <label class="control-label labeltwht" id="answerRePasswordValidateStep6" name="answerRePasswordValidateStep6"></label>
                    </div> 

                <div class="form-group">
                    <label class="control-label labeltwht">Phone of Primary Contact</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Phone of Primary Contact"  id="phoneContactCompany" name="phoneContactCompany"/>
                </div>
                <div class="form-group">
                    <label class="control-label labeltwht">Company Type</label>
                    <select id="typeCompany" name="typeCompany">
                        <option value="Corp">Corp</option>
                        <option value="LLC">LLC</option>
                        <option value="Sole Prope">Sole Prope</option>
                    </select>
                    <!--<input maxlength="100" type="text" required="required" class="form-control" placeholder="Company Type" />-->
                </div>
                
                <button class="btn btn-primary nextBtn pull-right" type="button" id="firstNextValidation" name="firstNextValidation">Next</button>
                
            </div>
        </div>
        
        <div class="panel panel-primary setup-content" id="step-2">
            <div class="panel-heading">
                 <h3 class="panel-title">Register your Employees/Drivers</h3>
            </div>
            <div class="panel-body">
            
                <div class="form-group">
                
                    <div class="table-responsive">          
                        <table class="table" id="table_drivers">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Contact Phone</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Profile</th>
                                <th>Driver License</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td><input maxlength="30" type="text" required="required" class="form-control" placeholder="First Name" id="driverFirstName[]" name="driverFirstName[]" /></td>
                                <td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Last Name" id="driverLastName[]" name="driverLastName[]" /></td>
                                <td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Repair Crew Phone" id="driverPhone[]" name="driverPhone[]" /></td>
                                <td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Email" id="driverEmail[]" name="driverEmail[]" /></td>
                                <td><select class="form-control" id="driverStatus[]" name="driverStatus[]" disabled >
                                        <option value="Active">Active</option>
                                        <option value="Inactive" selected>Inactive</option>
                                        <option value="Terminated">Terminated</option>
                                    </select>
                                </td>
                                <td><select class="form-control" id="driverProfile[]" name="driverProfile[]">
                                    <?php foreach ($_profileList as $key => $value1) { ?>
                                        <option value="<?php echo $value1 ?>"><?php echo $value1 ?></option>
                                    <?php } ?>
                                    </select>
                                </td>
                                <td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Driver License" id="driverLicense[]" name="driverLicense[]" /></td>
                                <td><a href="#" class="btn-danger form-control" role="button" data-title="johnny" id="deleteRowDriver" data-id="1">Delete</a></td>
                            </tr>
                            </tbody>
                        </table>
                        <button class=" btn-success nextBtn pull-left" type="button" id="addRowDriver">New Employees/Drivers</button>
                    </div>
                </div>
                
                <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtn pull-left" type="button">Previous</button>
            </div>

        </div>
        
        <div class="panel panel-primary setup-content" id="step-3">
            <div class="panel-heading">
                 <h3 class="panel-title">Email Verification</h3>
            </div>
            <div class="panel-body">
                

                <div class="list-group">
						<a href="#" class="list-group-item ">
							<span class="glyphicon glyphicon-info-sign"></span> Answer 
							<div class="d-flex w-100 justify-content-between">
								<span id="step3ContractorResponse"></span><br>
								<label class="control-label labeltwht text-center h1" id="validatingMessajeCode" name="validatingMessajeCode"><big></big></label>
							</div>
						</a>
				</div>
                
                
                <button class="btn btn-primary prevBtn pull-left" type="button">Previous</button>
            </div>
        </div>
        
        
    </form>
</div>

<div class="modal fade" id="myRegisterMessage" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerRegisterMessage">Register Info</h4> 
			</div> 
			<div class="modal-body" id="textRegisterMessage"> 
				<p >Some text in the modal.</p> 
			</div> 
			<div class="modal-footer" id="buttonRegisterMessage"> 
				<button type="button" class="btn btn-default" id="buttonCancelRegisterMessage" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

