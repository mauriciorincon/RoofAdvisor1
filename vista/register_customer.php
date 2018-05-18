<br>
<br>
<br>
<div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panelCustomer">
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small>About you</small></p>
            </div>
            
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small>Email Verification</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Final</small></p>
            </div>
        </div>
    </div>
    
    <form role="form">
        <div class="panel panel-primary setup-contentCustomer" id="step-1">
            <div class="panel-heading">
                 <h3 class="panel-title">About you</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" id="firstCustomerName" name="firstCustomerName"  />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" id="lastCustomerName" name="lastCustomerName"  />
                    </div>  
                    <div class="form-group">
                        <label class="control-label ">Email</label>
                        <input maxlength="100"  type="text" required="required" class="form-control" placeholder="Enter Email" id="emailValidation" name="emailValidation" onfocusout="validateEmail('customer')"/>
                        <label class="control-label" id="answerEmailValidate" name="answerEmailValidate">Answer</label>
                    </div> 
                    <div class="form-group">
                        <label class="control-label">Address</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="customerAddress" name="customerAddress" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">City</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter city" id="customerCity" name="customerCity" />
                    </div> 
                    <div class="form-group">
                        <label class="control-label">State</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter state" id="customerState" name="customerState" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Zip code</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter zip code" id="customerZipCode" name="customerZipCode" />
                    </div> 
                    <div class="form-group">
                        <label class="control-label">Phone number</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter phone number" id="customerPhoneNumber" name="customerPhoneNumber"  />
                    </div>    
                
                <button class="btn btn-primary nextBtnCustomer pull-right" type="button" id="firstNextValidation" name="firstNextValidation">Next</button>
                
            </div>
        </div>
        
        
        
        <div class="panel panel-primary setup-contentCustomer" id="step-2">
            <div class="panel-heading">
                 <h3 class="panel-title">Email Verification</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">Please enter the Code that was send to your Email</label>
                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Code verification" id="codeValidateField" name="codeValidateField" />
                    <label class="control-label" id="validatingMessajeCode" name="validatingMessajeCode">Answer</label>
                </div>
                
                <button class="btn btn-primary nextBtnCustomer pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnCustomer pull-left" type="button">Preview</button>
            </div>
        </div>
        
        <div class="panel panel-primary setup-contentCustomer" id="step-3">
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



