<div class="panel panel-primary setup-contentCustomer" id="step-1">
            <div class="panel-heading mheadr">
                 <h3 class="panel-title">Register Here</h3>
            </div>
            <input type="hidden" value="Customer_register" id="source_call" name="source_call" />
            <div class="panel-body">
                    
                    <div class="form-group">
                        <label class="control-label labeltwht" for="firstCustomerName">First Name</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" id="firstCustomerName" name="firstCustomerName" oninvalid="this.setCustomValidity('Please Enter First Name')" oninput="setCustomValidity('')" value="<?php if(isset($_SESSION['post_info']['firstCustomerName'])){echo $_SESSION['post_info']['firstCustomerName']; } ?>"/>                        
                    </div>
                    <div class="form-group">
                        <label class="control-label labeltwht">Last Name</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" id="lastCustomerName" name="lastCustomerName" oninvalid="this.setCustomValidity('Please Enter Last Name')" oninput="setCustomValidity('')" 
                        value="<?php if(isset($_SESSION['post_info']['lastCustomerName'])){echo $_SESSION['post_info']['lastCustomerName']; } ?>" />
                        
                    </div>  
                    <div class="form-group">
                        <label class="control-label labeltwht ">Email</label>
                        <input maxlength="100"  type="email" required="required" class="form-control" placeholder="Enter Email" id="emailValidation" name="emailValidation" onfocusout="validateEmail('customer')" oninvalid="this.setCustomValidity('Please Enter Email')" oninput="setCustomValidity('')" 
                        value="<?php if(isset($_SESSION['post_info']['emailValidation'])){echo $_SESSION['post_info']['emailValidation']; } ?>" />
                        <label class="control-label labeltwht" id="answerEmailValidate" name="answerEmailValidate">Answer</label>
                    </div>
                    <div class="form-group">
                        <label class="control-label labeltwht ">Password</label>
                        <input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Password" id="inputPassword" name="inputPassword" onblur="validInputPassword()"  oninvalid="this.setCustomValidity('Please Enter Password')" oninput="setCustomValidity('')"/>
                        <div class="help-block labeltwht">Minimum of 6 characters</div>
                        <label class="control-label labeltwht" id="answerPasswordValidateStep6" name="answerPasswordValidateStep6"></label>
                    </div>
                    <div class="form-group">
                        <label class="control-label labeltwht ">Confirm Password</label>
                        <input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Confirm Password" id="inputPasswordConfirm" name="inputPasswordConfirm" onblur="validInputRePassword()"  oninvalid="this.setCustomValidity('Please Enter Confirm Password')" oninput="setCustomValidity('')" />
                        <label class="control-label labeltwht" id="answerRePasswordValidateStep6" name="answerRePasswordValidateStep6"></label>
                    </div> 
                    <!--<div class="form-group">
                        <label class="control-label labeltwht">Address</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="customerAddress" name="customerAddress" oninvalid="this.setCustomValidity('Please Enter Address')" oninput="setCustomValidity('')"
                        value="<?php if(isset($_SESSION['post_info']['customerAddress'])){echo $_SESSION['post_info']['customerAddress']; } ?>" />
                    </div>
                    <div class="form-group">
                        <label class="control-label labeltwht">City</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter city" id="customerCity" name="customerCity" oninvalid="this.setCustomValidity('Please Enter City')" oninput="setCustomValidity('')" 
                        value="<?php if(isset($_SESSION['post_info']['customerCity'])){echo $_SESSION['post_info']['customerCity']; } ?>" />
                    </div> 
                    <div class="form-group">
                        <label class="control-label labeltwht">State</label>
                        <select id="customerState" name="customerState" required="required" class="form-control" placeholder="Select state" oninvalid="this.setCustomValidity('Please Enter State')" oninput="setCustomValidity('')" 
                        value="<?php if(isset($_SESSION['post_info']['customerState'])){echo $_SESSION['post_info']['customerState']; } ?>" >
                            <?php foreach ($_array_state as $key => $value1) { ?>
                                <option value="<?php echo $value1 ?>"><?php echo $value1 ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label labeltwht">Zip code</label>
                        <input maxlength="100" type="number" min="0" onkeypress="return isNumber(event)" max="99999" required="required" class="form-control" placeholder="Enter zip code" id="customerZipCode" name="customerZipCode" oninvalid="this.setCustomValidity('Please Enter Zipcode,Max length 5')" oninput="setCustomValidity('')" 
                        value="<?php if(isset($_SESSION['post_info']['customerZipCode'])){echo $_SESSION['post_info']['customerZipCode']; } ?>" />
                    </div> -->
                    <div class="form-group">
                        <label class="control-label labeltwht">Phone number</label>
                        <input maxlength="100" type="number" min="1111111111" max="9999999999" onkeypress="return isNumber(event)" required="required" class="form-control" placeholder="Enter phone number" id="customerPhoneNumber" name="customerPhoneNumber"  oninvalid="this.setCustomValidity('Please Enter Phone Number, Phone must be of 10 digits ')" oninput="setCustomValidity('')" 
                        value="<?php if(isset($_SESSION['post_info']['customerPhoneNumber'])){echo $_SESSION['post_info']['customerPhoneNumber']; } ?>"/>
                    </div>    
                    <div  class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LeiZnkUAAAAAA6gqLw6IFIMuchbHXyiRRYyTC1n"></div>
                    </div>
                    <div  class="form-group">
                        
                        <label class="control-label labeltwht ">PLEASE READ THE TERMS THOROUGHLY AND CAREFULLY. BY USING THE PLATFORM, YOU AGREE TO BE BOUND BY THESE TERMS. IF YOU DO NOT AGREE TO THESE TERMS, THEN YOU MAY NOT ACCESS OR USE THE PLATFORM</label>
                        <input type="checkbox" name="termsServiceAgree" id="termsServiceAgree" value="1"><span style="color:white">I agree with the RoofServiceNow</span> <a href="?controller=termsconditions&accion=showinfo" data-toggle="modal" target="_blank"> Terms and Conditions</a>
                    </div>
                    
                <center><button class="btn btn-primary" type="submit" id="firstNextValidation" name="firstNextValidation">Register</button></center>
                <!--<center><button class="btn btn-primary nextBtnCustomer" type="submit" id="firstNextValidation" name="firstNextValidation">Register</button></center>-->
            </div>
        </div>