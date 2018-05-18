
<br>
<br>
<br>
<div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small>About you</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small>Register your Employees/Drivers</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Email Verification</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                <p><small>Final</small></p>
            </div>
        </div>
    </div>
    
    <form role="form">
        <div class="panel panel-primary setup-content" id="step-1">
            <div class="panel-heading">
                 <h3 class="panel-title">About you</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">Company Name</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Name" id="companyName" name="companyName" />
                </div>
                <div class="form-group">
                    <label class="control-label">First Name</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" id="firstNameCompany" name="firstNameCompany" />
                </div>
                <div class="form-group">
                    <label class="control-label">Last Name</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" id="lastNameCompany" name="lastNameCompany"/>
                </div>
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input maxlength="100" type="email" required="required" class="form-control" placeholder="Email" id="emailValidation" name="emailValidation" onfocusout="validateEmail('company')"/>
                    <label class="control-label" id="answerEmailValidate" name="answerEmailValidate">Answer</label>
                </div>
                <div class="form-group">
                    <label class="control-label">Phone of Primary Contact</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Phone of Primary Contact"  id="phoneContactCompany" name="phoneContactCompany"/>
                </div>
                <div class="form-group">
                    <label class="control-label">Company Type</label>
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
                                <th>Repair Crew Phone</th>
                                <th>Driver License</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td><input maxlength="30" type="text" required="required" class="form-control" placeholder="First Name" id="driverFirstName[]" name="driverFirstName[]" /></td>
                                <td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Last Name" id="driverLastName[]" name="driverLastName[]" /></td>
                                <td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Repair Crew Phone" id="driverPhone[]" name="driverPhone[]" /></td>
                                <td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Driver License" id="driverLicense[]" name="driverLicense[]" /></td>
                                <td><select class="form-control" id="driverStatus[]" name="driverStatus[]" >
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Terminated">Terminated</option>
                                    </select>
                                </td>
                                <td><a href="#" class="btn-danger form-control" role="button" data-title="johnny" id="deleteRowDriver" data-id="1">Delete</a></td>
                            </tr>
                            </tbody>
                        </table>
                        <button class=" btn-success nextBtn pull-left" type="button" id="addRowDriver">New Employees/Drivers</button>
                    </div>
                </div>
                
                <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtn pull-left" type="button">Preview</button>
            </div>

        </div>
        
        <div class="panel panel-primary setup-content" id="step-3">
            <div class="panel-heading">
                 <h3 class="panel-title">Email Verification</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">Please enter the Code that was send to your Email</label>
                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Code verification" id="codeValidateField" name="codeValidateField" />
                    <label class="control-label" id="validatingMessajeCode" name="validatingMessajeCode">Answer</label>
                </div>
                
                <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtn pull-left" type="button">Preview</button>
            </div>
        </div>
        
        <div class="panel panel-primary setup-content" id="step-4">
            <div class="panel-heading">
                 <h3 class="panel-title">Final</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label" id="mensajeCorrecto" name="mensajeCorrecto">Welcome, the user was activated correctly</label>
                    
                </div>
                
                <button class="btn btn-success pull-right" type="submit">Finish!</button>
                <!--<button class="btn btn-primary prevBtn pull-left" type="button">Preview</button>-->
            </div>
        </div>
    </form>
</div>



