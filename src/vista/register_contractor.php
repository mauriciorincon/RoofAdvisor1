
<br>
<br>
<br>
<div class="container"style="margin-top: 30px;" align="center">
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
    
    <form role="form"  align="left" style="background-image: url('img/roof.home.wiz.bg.png'); width: 50%; height: 100%;">
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
                        <input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Password" id="inputPassword" name="inputPassword" onblur="validInputPassword(this)"  />
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
                <!--<div class="form-group">
                    <label class="control-label labeltwht">Company Type</label>
                    <select id="typeCompany" name="typeCompany">
                        <option value="Corp">Corp</option>
                        <option value="LLC">LLC</option>
                        <option value="Sole Prope">Sole Prope</option>
                    </select>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Company Type" />
                </div>-->
                <!--
                <div class="form-group">
                    <label class="control-label labeltwht">In business since</label>
                    <input maxlength="100" type="text" required="required" class="form-control datepickerdob" placeholder="Enter In business since" id="inBusinessSinceCompany" name="inBusinessSinceCompany"/>
                </div>
                <div class="form-group">
                    <label class="control-label labeltwht">License Number</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter License Number" id="licenseNumberCompany" name="licenseNumberCompany"/>
                </div>
                <div class="form-group">
                    <label class="control-label labeltwht">Expiration Date</label>
                    <input maxlength="100" type="text" required="required" class="form-control datepickerdob" placeholder="Enter Expiration Date" id="expirationDateCompany" name="expirationDateCompany"/>
                </div>
                -->
                

                <div  class="form-group">
                        <input type="checkbox" name="termsServiceAgree" id="termsServiceAgree" value="1"><span style="color:white">I agree with the RoofServiceNow</span> <a href="#termsServiceWindow" data-toggle="modal"> Terms and Conditions</a>
                    </div>
                
                
                <button class="btn btn-primary nextBtn pull-right" type="button" id="firstNextValidation" name="firstNextValidation">Register</button>
                
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



<div class="modal fade" id="termsServiceWindow" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerTexttermsServiceWindow" >RoofServiceNow TERMS OF USE ("TERMS")</h4> 
			</div> 
			<div class="modal-body" id="texttermsServiceWindow"> 
                <p>January 1, 2019</p>
                <p><b>IMPORTANT NOTICE: THIS AGREEMENT CONTAINS A BINDING ARBITRATION PROVISION AND CLASS ACTION WAIVER. IT AFFECTS YOUR LEGAL RIGHTS AS DETAILED IN THE ARBITRATION AND CLASS ACTION WAIVER SECTION BELOW. PLEASE READ CAREFULLY.</b></p> 
                <p><b>ACCEPTANCE OF THESE TERMS</b></p>
                <p>This Terms of Use Agreement ("Terms"), including the BINDING ARBITRATION AND CLASS ACTION WAIVER CONTAINED HEREIN govern your access to, use of, and participation in the Platform made available by RoofServiceNow, Inc. ("RoofServiceNow," "we," "our," or "us") or through RoofServiceNow and the entirety of your relationship with RoofServiceNow. AS DETAILED IN THE ELIGIBILITY, SERVICE MEMBER REPRESENTATIONS, WARRANTIES, AND USE OF THE PLATFORM SECTION BELOW, IF YOU ARE A SERVICE MEMBER, YOU UNDERSTAND AND AUTHORIZE ROOFSERVICENOW TO USE YOUR INFORMATION TO OBTAIN BACKGROUND CHECKS AND BUSINESS CREDIT CHECKS FROM ITS VENDORS THROUGHOUT THE USE OF THE SERVICE.</p>
                <p>PLEASE READ THE TERMS THOROUGHLY AND CAREFULLY. BY USING THE PLATFORM, YOU AGREE TO BE BOUND BY THESE TERMS. IF YOU DO NOT AGREE TO THESE TERMS, THEN YOU MAY NOT ACCESS OR USE THE PLATFORM.</p>
                <p>All references to "you" or "your," as applicable, mean the person who accesses, uses, and/or participates in the Platform in any manner, and each of your heirs, assigns, and successors. If you use the Platform on behalf of an entity, you represent and warrant that you have the authority to bind that entity, your acceptance of the Terms will be deemed an acceptance by that entity, and "you" and "your" herein shall refer to that entity, its directors, officers, employees, and agents.</p>
                <p><b>MODIFICATIONS</b></p>
                <p>RoofServiceNow reserves the right, in its sole discretion, to modify these Terms, and any other documents incorporated by reference herein, at any time and without prior notice. RoofServiceNow will notify you of changes by posting on the RoofServiceNow Terms of Use website, sending you a message, and/or otherwise notifying you when you are logged into your account. Modifications will become effective thirty (30) days after the earliest of: (a) modifications being posted on the Platform; (b) RoofServiceNow’s transmission of a message to you about the modifications; or (c) you are otherwise notified when you are logged into your account. Your use of the Platform after the expiration of the thirty (30) days shall constitute your consent to the changes. If you do not agree, you may not access or use the Platform.</p>
                <p><b>ADDITIONAL TERMS AND POLICIES</b></p>
                <p>Please review RoofServiceNow's Privacy Policy, incorporated herein by reference, for information and notices concerning RoofServiceNow's collection and use of your information. The provision and delivery of text messages by RoofServiceNow or our text message service providers is governed by our SMS Terms and Conditions, which are expressly incorporated herein. The RoofServiceNow Guarantee is governed by the RoofServiceNow Guarantee Terms and Conditions, which are expressly incorporated herein. Please review the full set of key RoofServiceNow policies that govern your use of the Platform and our interactions with you and third parties. Certain areas of and/or products on the Platform may have different terms and conditions posted or may require you to agree with and accept additional terms and conditions or policies. If there is a conflict between these Terms and the terms and conditions or policies posted for a specific area or product, the latter take precedence with respect to your use of that area or product.</p>
                <p><b>KEY TERMS</b></p>
                <p>"Collective Content" means User Content and RoofServiceNow Content together.</p>
                <p>"Content" means text, graphics, images, music, software, audio, video, information or other materials, including but not limited to profile information, Pro Services requests, quotes, message threads, reviews, scheduling and calendar information, and other information or materials available on or through the Platform.</p>
                <p>"Customer Member" means a Member who is registered to receive quotes for Pro Services, requests quotes for Pro Services, or otherwise uses the Platform to receive, pay for, review, or facilitate the receipt of Pro Services.</p>
                <p>"Member" means a person or entity who completes RoofServiceNow's account registration process or a person or entity who submits or receives a request through RoofServiceNow, including but not limited to Service Professionals Members and Customer Members.</p>
                <p>"Platform" means all RoofServiceNow websites, mobile or other applications, software, processes and any other services provided by or through RoofServiceNow.</p>
                <p>"Pro Services" means the services listed, quoted, scheduled, offered or provided by Service Professional Members, or sought, scheduled or received by Customer Members, through the Platform.</p>
                <p>"Service Professional Member" means a Member who is registered to send quotes for Pro Services, sends quotes for Pro Services, or otherwise uses the Platform to offer, provide, receive payment for, or facilitate the provision of Pro Services.</p>
                <p>"RoofServiceNow Content" means all Content RoofServiceNow makes available on or through the Platform, including any Content licensed from a third party, but excluding User Content.</p>
                <p>"User Content" means all Content submitted, posted, uploaded, published, or transmitted on or through the Platform by any Member or other user of the Platform, including but not limited to photographs, profile information, descriptions, postings, reviews, requests, messages, and payments made through the Platform, but excluding RoofServiceNow Content and Feedback.</p>
                <p><b>ELIGIBILITY, SERVICE PROFESSIONAL MEMBER REPRESENTATIONS, WARRANTIES, AND USE OF THE PLATFORM</b></p>
                <p>Access to and use of the Platform is available only to individuals who are at least 18 years old and can form legally binding contracts under applicable law. By accessing or using the Platform, you represent and warrant that you are eligible.</p>
                <p>By registering or using the Platform to offer, post, or provide Pro Services, Service Professionals Members represent and warrant that they, and the employees, agents, contractors, and subcontractors who may perform work for them, are properly and fully qualified and experienced, and licensed, certified, bonded, and insured, as required by applicable laws or regulations to which they may be subject in the jurisdiction(s) in which they offer their Pro Services and in relation to the specific job they are performing.</p>
                <p>RoofServiceNow is not in the business of providing Pro Services. Service Professionals Members understand and agree that by creating and maintaining an account on the Platform, they receive only the ability to use the RoofServiceNow Platform to access persons interested in receiving Pro Services and related tools, including but not limited to the ability to message those persons or schedule appointments, that facilitate the provision of Pro Services. Service Professionals Members understand and agree that using the Platform does not guarantee that anyone will engage them for Pro Services.</p>
                <p>Service Professionals Members understand and agree that they are customers of RoofServiceNow, and are not RoofServiceNow employees, joint venturers, partners, or agents. Service Professionals Members acknowledge that they set or confirm their own prices, provide their own equipment, and determine their own work schedule. RoofServiceNow does not control, and has no right to control, the services a Service Member provides (including how the Service Member provides such services) if the Service Member is engaged by a Customer Member or any other person, except as specifically noted herein.</p>
                <p>RoofServiceNow, as permitted by applicable laws, obtains reports regarding Service Members, which may include history of criminal convictions or sex offender registration, and we may limit, block, suspend, deactivate, or cancel a Service Member’s account based on the results of such a check. As a Service Member, you agree and authorize us to use your personal information, such as your full name and date of birth, to obtain such reports from RoofServiceNow’s vendors.</p>
                <p><b>ACCOUNT REGISTRATION AND OTHER SUBMISSIONS</b></p>
                <p>Users may access the Platform without registering for an account. To access and participate in certain features of the Platform, you will need to create a password-protected account ("Account"). You may register for an Account using certain third-party account and log-in credentials (your "Third-Party Site Password"), such as your Facebook or Google credentials. You agree to provide accurate, current, and complete information during the registration or request submission process and at all other times when you use the Platform, and to update information to keep it accurate, current, and complete. You are solely responsible for safeguarding your RoofServiceNow password and, if applicable, your Third-Party Site Password. You are solely responsible for all activity that occurs on your Account, and you will notify RoofServiceNow immediately of any unauthorized use. RoofServiceNow is not liable for any losses by any party caused by an unauthorized use of your Account. Notwithstanding the foregoing, you may be liable for the losses of RoofServiceNow or others due to such unauthorized use. Your account is nontransferable except with RoofServiceNow’s written permission and in line with RoofServiceNow policies and procedures.</p>
                <p><b>YOUR LICENSE TO USE THE PLATFORM</b></p>
                <p>Subject to your compliance with these Terms, RoofServiceNow grants you a limited, non-exclusive, revocable, nontransferable, and non-sublicensable license to reproduce and display Collective Content (excluding any software source code) solely for your personal and non-commercial use and only in connection with your access to and participation in the Platform. You will not use, copy, adapt, modify, prepare derivative works based upon, distribute, license, sell, transfer, publicly display, publicly perform, transmit, stream, broadcast or otherwise exploit the Platform or Collective Content, except as expressly permitted in these Terms. The Platform and Collective Content are provided to you AS IS. If you download or print a copy of Collective Content for personal use, you must retain all copyright and other proprietary notices contained thereon. No licenses or rights are granted to you by implication or otherwise under any intellectual property rights owned or controlled by RoofServiceNow or its licensors, except for the licenses and rights expressly granted in these Terms.</p>
                <p><b>USER CONTENT</b></p>
                <p>We may, in our sole discretion, permit you to post, upload, publish, submit or transmit User Content. By making available any User Content on or through the Platform, you hereby grant to RoofServiceNow a worldwide, irrevocable, perpetual, non-exclusive, transferable, royalty-free license, with the right to sublicense, to use, copy, adapt, modify, distribute, license, sell, transfer, publicly display, publicly perform, transmit, stream, broadcast, access, view, and otherwise exploit such User Content on, through, by means of or to promote, market or advertise the Platform or Pro Services, or for any other purpose in our sole discretion, except that the contents of private messaging through the Platform will not be used by RoofServiceNow in public advertising. In the interest of clarity, the license granted to RoofServiceNow shall survive termination of the Platform or your Account. RoofServiceNow does not claim ownership rights in your User Content and nothing in these Terms will be deemed to restrict rights that you may have to use and exploit any such User Content submitted, posted, uploaded, published, or transmitted on or through the Platform by you.</p>
                <p>You acknowledge and agree that you are solely responsible for all User Content that you make available on or through the Platform. Accordingly, you represent and warrant that: (a) you either are the sole and exclusive owner of all User Content that you make available on or through the Platform or you have all rights, licenses, consents and releases that are necessary to grant to RoofServiceNow the rights in such User Content, as contemplated under these Terms; and (b) neither the User Content nor your posting, uploading, publication, submission or transmittal of the User Content or RoofServiceNow's use of your User Content (or any portion thereof) on, through or by means of the Platform will infringe, misappropriate or violate a third party's patent, copyright, trademark, trade secret, moral rights or other proprietary or intellectual property rights, or rights of publicity or privacy, or result in the violation of any applicable law or regulation. While it has no obligation to do so, you agree that RoofServiceNow may proofread, summarize or otherwise edit and/or withdraw your User Content, and you understand it remains your sole responsibility to monitor your User Content and ensure that such edited Content is accurate and consistent with your representations and warranties in these Terms.</p>
                <p>RoofServiceNow reserves the right, at any time and without prior notice, to remove or disable access to User Content that we, in our sole discretion, consider to be objectionable for any reason, in violation of these Terms or otherwise harmful to the Platform or users, or for any other reason.</p>
                <p><b>PROHIBITIONS</b></p>
                <p><b>As a user of the Platform, you may not:</b></p>
                <p>Use another person's Account, misrepresent yourself or Pro Services offered through the Platform, misrepresent your identity or qualifications, misrepresent a project or other information in a quote request, or post Content in any inappropriate category or areas on the Platform;</p>
                <p>Use any automated system including but not limited to robots, spiders, offline readers, or scrapers to access the Platform for any purpose without RoofServiceNow's prior written approval; provided, however, that the operators of public search engines may use spiders or robots to copy materials from the Platform for the sole purpose of creating publicly available searchable indices of the materials, but not caches or archives of such material (RoofServiceNow reserves the right to revoke these exceptions either generally or in specific cases);</p>
                <p>In any manual or automated manner copy copyrighted text, or otherwise misuse or misappropriate Platform information or Content including but not limited to, for use on a mirrored, competitive, or third-party site;</p>
                <p>Transmit more request messages through the Platform in a given period of time than a human can reasonably produce in the same period by using a conventional online web browser;</p>
                <p>Take any action that (a) may unreasonably encumber the Platform's infrastructure; (b) interferes or attempts to interfere with the proper working of the Platform or any third-party participation; (c) bypasses measures that are used to prevent or restrict access to the Platform; (d) circumvents, disables or otherwise interferes with security features of the Platform; (e) distributes viruses or any other technologies that may harm RoofServiceNow or users; (f) uses the Platform in a way that violates any copyrights, trade secrets, or other rights of any third party, including privacy or publicity rights; or (g) circumvents or manipulates Fee (defined herein) structure, billing, or Fees owed;</p>
                <p>As a Service Member, use the Platform in any manner that circumvents your obligation to pay RoofServiceNow for access to services provided by the Platform;</p>
                <p>Collect, harvest, or publish any personally identifiable data including but not limited to names or other account information, from the Platform, or use the communication systems provided by the Platform for any reason not explicitly authorized by these Terms, including commercial solicitation purposes;</p>
                <p>Recruit, solicit, or contact in any form Service Professionals Members or Customer Members for employment or any other use not specifically intended by the Platform;</p>
                <p>Take any inappropriate or unlawful actions, including the submission of inappropriate or unlawful Content to or through the Platform, including Content that is harassing, hateful, illegal, profane, obscene, defamatory, threatening, or discriminatory, or that advocates, promotes, or encourages inappropriate activity, conduct that would be considered a criminal offense, or conduct that would give rise to civil liability or violate any law;</p>
                <p>Violate any key RoofServiceNow policies that govern your use of the Platform and our interactions with you and third parties;</p>
                <p>Advertise or solicit a Pro Service not related to or appropriate for the Platform including, but not limited to any Pro Service that (a) is not in supported categories or provides only products; (b) provides directories or referrals; (c) offers lending; (d) offers rental space; (e) promotes events (such as a party or professional convention); (f) competes with the business of RoofServiceNow; (g) is based outside the United States; (h) promotes or offers Ponzi schemes, junk mail, spam, chain letters, pyramid schemes, affiliate marketing or unsolicited commercial content, discount cards, credit counseling, online surveys or contests, raffles, prizes, bonuses, games of chance or giveaways; or (i) offers a Pro Service not reasonably available to a Customer Member or other individual in that Customer Member or individual’s location;</p>
                <p>Submit User Content that damages the experience of any user including but not limited to (a) requests to download non-RoofServiceNow mobile applications and/or links that direct the user to mirrored websites where the user must enter information that is redundant with what has already been entered on RoofServiceNow, (b) offers to purchase a Pro Service or any other service outside of RoofServiceNow, or (c) using a profile page or user name to promote services not offered on or through the Platform;</p>
                <p>Take any action that may undermine the efficacy or accuracy of reviews or ratings systems;</p>
                <p>Fail to perform Pro Services purchased from you as promised, unless the Customer Member or other individual fails to materially meet the terms of the mutually agreed-upon agreement for the Pro Services or refuses to pay, or a clear typographical error is made, or you cannot authenticate the Customer Members or other individual’s identity;</p>
                <p>Engage in fraudulent conduct including but not limited to offering to make money transfers with intent to request a refund of any portion of the payment or soliciting users to mail cash or use other payment methods prohibited by RoofServiceNow;</p>
                <p>Sign up for, negotiate a price for, use, or otherwise solicit a Pro Service with no intention of following through with your use of or payment for the Pro Service;</p>
                <p>Agree to purchase a Pro Service when you do not meet a Service Member's requirements;</p>
                <p>Undertake any activity or engage in any conduct that is inconsistent with the business or purpose of the Platform; and</p>
                <p>Attempt to indirectly undertake any of the foregoing.</p>
                <p><b>ROOFSERVICENOW BUDGET, FEES, AND TAXES</b></p>
                <p>In connection with use of RoofServiceNow's Platform, RoofServiceNow charges certain fees ("RoofServiceNow Fees" or "Fees").</p>
                <p>Service Professionals Members can pay Fees to RoofServiceNow in order to receive certain services on the Platform, including but not limited to monthly subscription fee, roof report fee, being matched with and receiving contacts from Customer Members or other individuals. As a Service Member, RoofServiceNow will automatically charge your stored payment method when you choose a Customer Members job order or other leads. Fees for additional products or services, including ongoing products or services, will be presented to you before you use such products or services. In order to use RoofServiceNow, you must have at least one valid payment method stored on file. As described more fully below, you may also be required to set a Budget (as defined below) for at least one service category (which may also apply to contacts in jobs related to your preferences). Except as otherwise described herein, all sales on RoofServiceNow are final and non-refundable.</p>
                <p>Wallet for Service Members. As a Service Member, you can set a wallet (“Wallet”) for how much you are willing to spend to take customer’s job orders. The Wallet serves as a predefined spending limit to charge or “draw” down against taking customer’s job orders or requesting of services. If your Wallet has a Zero-dollar value, RoofServiceNow will prompt you when you attempt to take a Customer’s job order. You will be required to provide a valid payment method or credit card to take the job order. You agree that RoofServiceNow can charge your payment method up to the dollar amount set in your Wallet. You further agree RoofServiceNow is authorized to charge your payment method in excess of your wallet for the sole purpose of collecting any applicable taxes. You will be charged the “lead” Fees when Customer Members or other individuals submit job orders (as further described below). Unless explicitly specified, RoofServiceNow will not charge your payment method for job orders submitted by a Customer Member or other individual in excess of your Wallet unless you adjust your Wallet upward before the charges are incurred.</p>
                <p>
                    <table class="table">
                        <tr><td colspan="5">Lead Type Pricing Comparison</td></tr>
                        <tr><td rowspan="2">Roof Type</td><td colspan="2">RoofServiceNow</td><td colspan="2">HomeAdvisor</td></tr>
                        <tr><td>Repair</td><td>New/Reroof</td><td>Repair</td><td>New/Reroof</td></tr>
                        <tr><td>Asphalt Shingle</td><td>$ 21.00</td><td>$ 95.00</td><td>$ 31.00</td><td>$ 143.00</td></tr>
                        <tr><td>Tile</td><td>$ 21.00</td><td>$ 99.00</td><td>$ 26.80</td><td>$ 160.00</td></tr>
                        <tr><td>Metal</td><td>$ 21.00</td><td>$ 91.00</td><td>$ 28.00</td><td>$ 132.00</td></tr>
                        <tr><td>Wood/Slate</td><td>$ 21.00</td><td>$ 89.00</td><td>$ 29.00</td><td>$ 129.00</td></tr>
                        <tr><td>Flat</td><td>$ 21.00</td><td>$ 85.00</td><td>$ 28.50</td><td>$ 128.00</td></tr>
                        <tr><td>Do not Know/Mix</td><td>$ 21.00</td><td>$ 85.00</td><td></td><td></td></tr>
                    </table>
                </p>
                <p>You can add more value to your Wallet at any time.  If you adjust your Wallet upward, the new Wallet will take effect immediately. If you discontinue services or removed from the Platform, RoofServiceNow will refund the Value of you Wallet within a timely manner. </p>
                <p>Timing of Charges for Service Professionals Members on RoofServiceNow. As a Service Member using RoofServiceNow, there are different points at which your payment method may be charged:</p>
                <p>Unlike other lead services, RoofServiceNow believes in forging a win-win partnership with you and charges a single, low rate for all job orders and a fixed, low rate for new/reroofs types. Unlike other lead service price leads based on a variable cost models, with RoofServiceNow you know exactly the cost of the qualified lead when you take it. </p>
                <p>You pay when you take the qualified job order submitted by the customer or the customer chooses you when they submit the job order and you take it. You will be able to chat with customer, call them, share pictures and documents, provide estimates, and payments all via the job order. </p>
                <p>As part of using RoofServiceNow software to manage your crew and business, we charge your payment method based on the license usage each month. The Monthly Subscription fee will be automatically charging each month until we receive a cancellation notice to support@roofservicenow.com. </p>
                <p>RoofServiceNow may also, in its sole and absolute discretion, revert to charging your payment method each time a Customer Member chooses you for the job order and you take the job order, and you do not have an adequate balance to cover the cost of that lead. </p>
                <p>Default Payment Method. For ordinary charges of Service Members, RoofServiceNow will first attempt to charge the default payment method. In the event that RoofServiceNow is unable to charge that payment method for any reason--including but not limited to exceeding a payment method’s credit limit, payment method cancellation, a payment method being out of date, or payment method details being incorrect--you agree that RoofServiceNow may charge any other payment method associated with your account. If your payment details change, your card provider may provide us with updated card details. We may use these new details in order to help prevent any interruption to the Pro Services. If RoofServiceNow is unable to charge the default payment method, RoofServiceNow will attempt to charge any other payment methods associated with your Account in the order in which they were most recently provided, used, or updated on the Platform, charging the most recently provided, used, or updated valid payment method first.</p>
                <p>Penalty Fees for All Members. RoofServiceNow may also charge penalty Fees for fraud, misconduct or other violations of these Terms, as determined in our sole discretion. Information about current penalty Fees is available in the help center.</p>
                <p>You agree to pay all applicable Fees or charges based on the Fee and billing terms then in effect, regardless of whether you have an active Account. Charges shall be made to the payment method designated at the time you accrue a Fee. If you do not pay on time or if RoofServiceNow cannot charge a payment method for any reason, RoofServiceNow reserves all rights permissible under law to recover payment and all costs and expenses incurred, including reasonable attorneys' fees, in our pursuit of payment. If any Fee is not paid in a timely manner, or we are unable to process your transaction using the payment method provided, we reserve the right to terminate or suspend your Account.</p>
                <p>You explicitly agree that all communication in relation to delinquent accounts or Fees due will be made by electronic mail or by phone. You agree that all notices, disclosures, and other communications that we provide to you electronically satisfy any legal requirement that such communications be in writing. You agree that you have the ability to store such electronic communications such that they remain accessible to you in an unchanged form. You agree to keep your contact information, including, but not limited to, email address and phone number current. Such communication may be made by RoofServiceNow or by anyone on its behalf, including but not limited to a third-party collection agent. If you cancel your Account at any time, you will not receive any refund. If you have a balance due on any Account, you agree that RoofServiceNow may charge such unpaid Fees to any payment method or otherwise bill you for such unpaid Fees.</p>
                <p>Taxes. Payments required by these Terms may be stated exclusive of all taxes, duties, levies, imposts, fines or similar governmental assessments, including sales and use taxes, value-added taxes, goods and services taxes, excise, business, service, and similar transactional taxes imposed by any jurisdiction and the interest and penalties thereon (collectively, “Taxes”). Certain jurisdictions, however, may require us to collect Taxes from you in connection with the purchase of, payment for, access to, or use of the Pro Services, and you shall be responsible for and bear Taxes associated with the purchase of, payment for, access to, or use of the Pro Services. Charges are inclusive of applicable Taxes where required by law. You hereby confirm that RoofServiceNow can determine your appropriate jurisdiction for tax purposes however it deems appropriate or as required by law, and you agree to pay taxes to RoofServiceNow when RoofServiceNow includes a charge for taxes on any invoice. You also understand and agree that you are solely responsible for determining your own tax reporting and sales and use tax collection requirements in consultation with your own tax advisers, and that we cannot and do not offer specific tax advice to either Service Professionals Members or Customer Members.</p>
                <p><b>TRACKING COMMUNICATIONS AND TAKING JOB ORDERS</b></p>
                <p>In order to ensure appropriate charging of Fees and to enforce these Terms, RoofServiceNow may track the occurrence of communications between Customer Members and Service Professionals Members that occur off of the Platform via email, phone call, SMS text message, third-party websites, or any other means, whether initiated by a Customer Member or Service Member. In order to track the occurrence of such communications, RoofServiceNow may obscure Service Member contact information in a Service Member profile, replace Service Member contact information in a Service Member profile with a different piece of contact information that will forward to the Service Member, or take any other step reasonably calculated to track the occurrence of such communications. Except as explicitly stated herein, we will not record or review the content of any communications that do not come into contact with the RoofServiceNow Platform unless we first obtain your permission.</p>
                <p>If you send text messages with a Customer Member or Service Member using the telephone number for that Member available on the Platform, we may use a third-party service provider to track these text messages. We track these text messages for fraud prevention, to ensure appropriate charging of Fees, to enforce these Terms, and for quality and training purposes. As part of this process, RoofServiceNow and its service provider will receive in real time and store data about your text message, including the date and time of the text message, your phone number, and the content of the text message.</p>
                <p>Once you take the Customer Member’s job order, you will be prompted to pay, if you do not have a positive balance in your Wallet equal to and greater than the value of the job order.</p>
                <p><b>INTEGRATED MARKETPLACE PAYMENTS</b></p>
                <p>The RoofServiceNow platform may facilitate payments between Customer Members and Service Professionals Members (“Integrated Marketplace Payments”) through our payment processing partner Stripe, but RoofServiceNow is not a party to any such Integrated Marketplace Payments and does not handle funds on behalf of its Members. Service Professionals Members who receive Integrated Marketplace Payments from Customer Members on RoofServiceNow must agree to the Stripe Connected Account Agreement, which includes the Stripe Services Agreement. As a Service Member, by agreeing to these terms or continuing to operate as a Service Member on RoofServiceNow, you agree to be bound by the Stripe Connected Account Agreement and Stripe Services Agreement, as those agreements may be modified by Stripe from time to time. As a condition of receiving payment processing services through Stripe, you agree to provide RoofServiceNow with accurate and complete information about you and your business, you agree and authorize RoofServiceNow to collect a payment service fee, and you authorize RoofServiceNow to share this information and transaction information related to your use of the payment processing services provided by Stripe.</p>
                <p>As a Customer Member making an Integrated Marketplace Payment through Stripe, you agree to pay all amounts you owe when due using your preferred payment method. You further authorize Stripe to charge your preferred payment method for amounts you owe when they are due, whether they are recurring or one-time payments. You must keep all payment information you provide us up-to-date, accurate and complete. Do not share your payment card, bank account or other financial information with any other Member. We take steps to secure all payment method and other personal financial information, but we expressly disclaim any liability to you, and you agree to hold us harmless for any damages you may suffer as a result of the disclosure of your personal financial information to any unintended recipients. </p>
                <p>RoofServiceNow may enable you to make Integrated Marketplace Payments using credit, debit, or prepaid cards, by linking your bank account, or by any other payment method we support. We reserve the right to cancel your ability to make payments with one or more of the payment methods you have authorized in our sole and absolute discretion.</p>
                <p>If you choose your bank account as your Integrated Marketplace Payment method, you authorize Stripe to make Automated Clearing House (“ACH”) withdrawals from your bank account, and to make any inquiries we consider necessary to validate any dispute involving payments you make to us or to a Member, which may include ordering a credit report and performing other credit checks or verifying the information you provide us against third-party databases. You authorize RoofServiceNow or its provider to initiate one or more ACH debit entries (withdrawals) or the creation of an equivalent bank draft for the specified amount(s) from your bank account, and you authorize the financial institutions that holds you bank account to deduct such payments. You also authorize the bank that holds your bank account to deduct any such payments in the amounts and frequency designated in your Account.</p>
                <p>If your full order is not processed by us at the same time, you hereby authorize partial debits from your bank account, not to exceed the total amount of your order You agree to pay any ACH fees or fines you or we incur associated with transactions you authorize. This return fee will vary based on which state you are located in. The return fee may be added to your payment amount and debited from your bank account if we resubmit an ACH debit due to insufficient funds. We may initiate a collection process or legal action to collect any money owed to us. You agree to pay all our costs for such action, including any reasonable attorneys' fees. Federal law limits your liability for any fraudulent, erroneous, or unauthorized transactions from your bank account based on how quickly you report it to your financial institution. You must report any fraudulent, erroneous or unauthorized transactions to your bank no more than 60 days after the disputed transaction appeared on your bank account statement. Please contact your bank for more information about the policies and procedures that apply unauthorized transactions and the limits on your liability.</p>
                <p>Integrated Marketplace Payment Disputes: All requests for Marketplace Payment chargebacks, errors, claims, refunds and disputes (“Payment Disputes”) will be subject to review by RoofServiceNow in accordance with the rules applicable to the payment method you used to make the Integrated Marketplace Payment and will be in RoofServiceNow’s absolute discretion. RoofServiceNow is not liable to you under any circumstances for Payment Disputes we are unable to resolve in your favor. We will normally process your valid written Payment Dispute request within thirty (30) days after we receive it, unless a shorter period is required by law. You may file a Payment Dispute by emailing it to RoofServiceNow support at support@RoofServiceNow.com. If you close or deactivate your Account before we adjudicate your Payment Dispute, we will not be able to issue you any amounts you are owed. We will attempt to pay you any Payment Disputed amounts you are owed using the method with which you made the disputed payment, but we cannot guarantee that we will be able to do so if your payment method information is inaccurate, incomplete, or has been cancelled.</p>
                <p>If your actions result, or are likely to result in a Payment Dispute, a violation of these Terms of Use or create other risks to RoofServiceNow or our payment processing partners, or if we determine that your Account has been used to engage in deceptive, fraudulent, or illegal activity, then we may permanently withhold any amounts owed to you in our sole discretion. If you have a past due balance due on any Account, or for any additional amounts that we determine you owe us, we may, without limiting any other rights or remedies: (a) charge one or more of your payment methods; (b) offset any amounts you owe us against amounts you may be owed; (c) invoice you for amounts due to us, which such amounts will be due upon receipt; (d) reverse or block any credits to your bank account; or (e) collect payment from you by any other lawful means.</p>
                <p>If you fail to make Integrated Marketplace Payments you owe when due, or if RoofServiceNow is unable to charge one of your payment methods for any reason, RoofServiceNow reserves all rights permissible under law to recover payment and all costs and expenses incurred, including reasonable attorneys' fees, in our pursuit of payment. You explicitly agree that all communication in relation to delinquent accounts or overdue payments will be made by electronic mail or by phone. Such communication may be made by RoofServiceNow or by anyone on its behalf, including but not limited to a third-party collections agent.</p>
                <p><b>ROOFSERVICENOW PROMOTIONS</b></p>
                <p>You may receive certain offers from RoofServiceNow (“Promotions”), including but not limited to discounted or free use of the Platform for a limited period. Any Promotions are offered at RoofServiceNow’s discretion, and may be revoked at any time and for any reason.</p>
                <p>You are only eligible for any benefits described in the Promotion if (a) you received a communication directly from RoofServiceNow offering you that Promotion, (b) you satisfy all the requirements identified in that communication; and (c) you maintain an account in good standing with RoofServiceNow. We may condition receipt of a benefit described in a Promotion in any manner we see appropriate, including limiting eligibility to a subset of Members, to specific categories, or to certain dates. To be eligible for a benefit described in a Promotion, you may need to take a specific action (including but not limited to signing up for a service) or make a payment for specific services.</p>
                <p>To the extent you are eligible for multiple promotions that discount a Fee, we will apply those promotions sequentially. For instance, if you are eligible for both a 15% and 10% discount on a $10 Fee, you will pay $7.65.</p>
                <p>Any benefits from participating in the Promotion, requirements of accepting the offer, and any other conditions to receive any benefit described in the Promotion will be disclosed to you. After a Promotion ends, regardless of whether you have already satisfied the requirements, you will be ineligible to receive those benefits. Notwithstanding anything to the contrary, RoofServiceNow may revoke a benefit if we believe that you have not satisfied the Promotion requirements, including maintaining an Account in good standing.</p>
                <p><b>DISPUTES BETWEEN OR AMONG USERS</b></p>
                <p>RoofServiceNow values our Service Professionals Pros and Customers, and we understand that occasionally disputes may arise between or among them. Our goal is to provide tools to help users resolve such disputes independently. In the rare event a dispute regarding an interaction related to the Platform cannot be resolved independently, you agree, at RoofServiceNow's request, to participate with good faith, to the extent you are reasonably able to do so, in a neutral resolution or mediation conducted by RoofServiceNow or a neutral third-party mediator or arbitrator selected by RoofServiceNow. Notwithstanding the foregoing, you acknowledge and agree that RoofServiceNow is under no obligation to become involved in or impose resolution in any dispute between or among users or any third party.</p>
                <p><b>INTELLECTUAL PROPERTY RIGHTS</b></p>
                <p>RoofServiceNow Content is protected by copyright, trademark, and other laws of the United States, foreign countries, and international conventions. Except as expressly provided in these Terms, RoofServiceNow and its licensors exclusively own all right, title, and interest in and to the Platform and RoofServiceNow Content, including all associated intellectual property rights. All trademarks, service marks, logos, trade names and any other proprietary designations of RoofServiceNow used herein are trademarks or registered trademarks of RoofServiceNow. Any other trademarks, service marks, logos, trade names and any other proprietary designations are the trademarks or registered trademarks of their respective owners.</p>
                <p><b>FEEDBACK</b></p>
                <p>By sending us any feedback, comments, questions, or suggestions concerning RoofServiceNow or our services, including the Platform (collectively, “Feedback”) you represent and warrant (a) that you have the right to disclose the Feedback, (b) that the Feedback does not violate the rights of any other person or entity, and (c) that your Feedback does not contain the confidential or proprietary information of any third party or parties. By sending us any Feedback, you further (i) agree that we are under no obligation of confidentiality, express or implied, with respect to the Feedback, (ii) acknowledge that we may have something similar to the Feedback already under consideration or in development, (iii) grant us an irrevocable, non-exclusive, royalty-free, perpetual, worldwide license to use, modify, prepare derivative works, publish, distribute and sublicense the Feedback, and (iv) irrevocably waive, and cause to be waived, against RoofServiceNow and its users any claims and assertions of any moral rights contained in such Feedback. This Feedback section shall survive any termination of your Account or the Platform.</p>
                <p><b>COPYRIGHT POLICY</b></p>
                <p>We expect users to respect copyright law. In appropriate circumstances we will terminate the Account of any user who repeatedly infringes or is believed to be repeatedly infringing the rights of copyright holders. Please see our Copyright & DMCA Policy for more information.</p>
                <p><b>NO ENDORSEMENT</b></p>
                <p>RoofServiceNow does not endorse any Member, user, or any Pro Services, and RoofServiceNow is not a party to any agreements between or among users, Members, or third parties. No agency, partnership, joint venture, or employment is created as a result of the Terms or any user's or Member's use of any part of the Platform, including but not limited to any scheduling or other services. Neither RoofServiceNow nor any Members or users of the Platform may direct or control the day-to-day activities of the other, or create or assume any obligation on behalf of the other. Members are required by these Terms to provide accurate information, and although RoofServiceNow may undertake additional checks and processes designed to help verify or check the identities or backgrounds of users, we do not make any representations about, confirm, or endorse any user or their purported identity or background, regardless of the specific RoofServiceNow services they are using or any involvement by RoofServiceNow personnel in providing or scheduling those services.</p>
                <p>Any reference on the Platform to a user being licensed or credentialed in some manner, or "badged," "best of," "top," "background checked" (or similar language) designations indicates only that the user has completed a relevant account process or met user review standards, and does not represent anything else. Any such description is not an endorsement, certification or guarantee by RoofServiceNow and is not verification of their identity and whether they or their Pro Services are licensed, insured, trustworthy, safe or suitable. Instead, any such description is intended to be useful information for you to evaluate when you make your own decisions about the identity and suitability of others whom you contact or interact with via the Platform. You should always exercise responsibility, due diligence and care when deciding whether to have any interaction with any other user. RoofServiceNow offers a non-exhaustive list of safety tips to consider when hiring a Service Member. Except as specifically described in the RoofServiceNow Guarantee and including its exclusions and limitations, RoofServiceNow has no responsibility for any damage or harm resulting from for your interactions with other users.</p>
                <p>The Collective Content may contain links to third-party websites, offers, or other events/activities not owned or controlled by RoofServiceNow. We do not endorse or assume any responsibility for any such links, and if you access them, you do so at your own risk.</p>
                <p>By using the Platform, you understand and agree that any legal remedy or liability that you seek to obtain for actions or omissions of other users or other third parties will be limited to a claim against those particular users or other third parties. You agree not to attempt to impose liability on or seek any legal remedy from RoofServiceNow with respect to such actions or omissions.</p>
                <p><b>SANCTIONS FOR VIOLATIONS OF THESE TERMS</b></p>
                <p>Without limiting any other rights reserved herein, RoofServiceNow may, in its sole discretion, take any action permitted by law for any violation of these Terms or any other policy or agreement between you and RoofServiceNow, including but not limited to removing User Content you posted, limiting your Account access, requiring you to forfeit certain funds or paid Fees, assessing monetary penalties or costs, terminating your Account, notifying other Members of the termination of your Account and/or the violation of these Terms, decreasing your status or search rank, canceling quotes or postings, blocking access, investigating you, and/or cooperating with law enforcement agencies in investigation or prosecution.</p>
                <p><b>ACCOUNT SUSPENSION OR TERMINATION</b></p>
                <p>We may, in our discretion, with or without cause, with or without prior notice and at any time, decide to limit, block, suspend, deactivate or cancel your RoofServiceNow Account in whole or in part. If we exercise our discretion under these Terms to do so, any or all of the following can occur with or without prior notice or explanation to you: (a) your Account will be deactivated or suspended, your password will be disabled, and you will not be able to access the Platform or your User Content, or receive assistance from RoofServiceNow support teams; (b) if appropriate in our sole discretion, we may communicate to other users that your Account has been terminated, blocked, suspended, deactivated, cancelled, or otherwise penalized in any way, and why this action has been taken; and (c) you will not be entitled to any compensation for Platform services or Pro Services cancelled or delayed as a result of Account termination. You may cancel your use of the Platform and/or terminate your Account at any time by following the "Settings" link in in your profile, clicking "Account," and clicking "Deactivate Account." Please note that if your Account is cancelled, we do not have an obligation to delete or return to you any Content you have posted to the Platform, including, but not limited to, any reviews.</p>
                <p><b>ARBITRATION AND CLASS ACTION WAIVER</b></p>
                <p><b>PLEASE READ THIS SECTION CAREFULLY. IT AFFECTS YOUR LEGAL RIGHTS, INCLUDING YOUR RIGHT TO FILE A LAWSUIT IN COURT.</b></p>
                <p>You and RoofServiceNow agree that these Terms affect interstate commerce and that the Federal Arbitration Act governs the interpretation and enforcement of these arbitration provisions.</p>
                <p>This Section is intended to be interpreted broadly and governs any and all disputes between us, including but not limited to claims arising out of or relating to any aspect of the relationship between us, whether based in contract, tort, statute, fraud, misrepresentation or any other legal theory; claims that arose before this Agreement or any prior agreement (including, but not limited to, claims related to advertising); and claims that may arise after the termination of this Agreement. The only disputes excluded from this broad prohibition are the litigation of certain intellectual property and small court claims, as provided below.</p>
                <p>By agreeing to these Terms, you agree to resolve any and all disputes with RoofServiceNow as follows:</p>
                <p>Initial Dispute Resolution: Most disputes can be resolved without resort to litigation. You can reach RoofServiceNow's support department at support@RoofServiceNow.com. Except for intellectual property and small claims court claims, the parties agree to use their best efforts to settle any dispute, claim, question, or disagreement directly through consultation with the RoofServiceNow support department, and good faith negotiations shall be a condition to either party initiating a lawsuit or arbitration.</p>
                <p>Binding Arbitration: If the parties do not reach an agreed-upon solution within a period of thirty (30) days from the time informal dispute resolution is initiated under the Initial Dispute Resolution provision above, then either party may initiate binding arbitration as the sole means to resolve claims, subject to the terms set forth below. Specifically, all claims arising out of or relating to these Terms or previous versions of these Terms (including the Terms' or Privacy Policy's formation, performance, and breach), the parties' relationship with each other, and/or your use of the Platform shall be finally settled by binding arbitration, as described below.</p>
                <p>Where the relief sought is $10,000 or less and you do not wish to bring the claim in small claims court, the arbitration will be conducted online by an online arbitration provider of our choosing in accordance with their applicable Arbitration Rules & Procedures effective at the time a claim is made. Currently, to start, you may initiate arbitration proceedings on the FairClaims website. You are responsible for your own attorneys' fees unless the arbitration rules and/or applicable law provide otherwise.</p>
                <p>Where the relief sought is $10,001 or more, resolution shall be in accordance with the JAMS Streamlined Arbitration Procedure Rules for claims that do not exceed $250,000 and the JAMS Comprehensive Arbitration Rules and Procedures for claims exceeding $250,000 in effect at the time the arbitration is initiated, excluding any rules or procedures governing or permitting class actions. To start an arbitration with JAMS, you must do the following: (a) write a Demand for Arbitration that includes a description of the claim and the amount of damages you seek to recover (you may find a copy of a Demand for Arbitration at www.jamsadr.com); (b) send three copies of the Demand for Arbitration, plus the appropriate filing fee, to JAMS, Two Embarcadero Center, Suite 1500, San Francisco, California 94111; and (c) send one copy of the Demand for Arbitration to RoofServiceNow at P.O BOX 653, Warren, RI 02885, ATTN: Legal. You will be required to pay $250 to initiate an arbitration against us. If the arbitrator finds the arbitration to be non-frivolous, RoofServiceNow will pay all other fees invoiced by JAMS, including filing fees and arbitrator and hearing expenses. You are responsible for your own attorneys' fees unless the arbitration rules and/or applicable law provide otherwise.</p>
                <p>The arbitrator, and not any federal, state, or local court or agency, shall have exclusive authority to resolve all disputes arising out of or relating to the interpretation, applicability, enforceability, or formation of these Terms or the Privacy Policy, including but not limited to any claim that all or any part of these Terms or Privacy Policy is void or voidable, whether a claim is subject to arbitration, or the question of waiver by litigation conduct. The arbitrator shall be empowered to grant whatever relief would be available in a court under law or in equity. The arbitrator's award shall be written and shall be binding on the parties and may be entered as a judgment in any court of competent jurisdiction.</p>
                <p>The parties understand that, absent this mandatory arbitration provision, they would have the right to sue in court and have a jury trial. They further understand that, in some instances, the costs of arbitration could exceed the costs of litigation and the right to discovery may be more limited in arbitration than in court.</p>
                <p>If you are a resident of the United States, arbitration may take place in the county where you reside at the time of filing. For individuals residing outside the United States, arbitration shall be initiated in the State of California, United States of America. You and RoofServiceNow further agree to submit to the personal jurisdiction of any federal or state court in Miami-Dade County, Florida in order to compel arbitration, to stay proceedings pending arbitration, or to confirm, modify, vacate, or enter judgment on the award entered by the arbitrator.</p>
                <p>Class Action Waiver: The parties further agree that the arbitration shall be conducted in their individual capacities only and not as a class action or other representative action, and the parties expressly waive their right to file a class action or seek relief on a class basis. YOU AND ROOFSERVICENOW AGREE THAT EACH MAY BRING CLAIMS AGAINST THE OTHER ONLY IN YOUR OR ITS INDIVIDUAL CAPACITY, AND NOT AS A PLAINTIFF OR CLASS MEMBER IN ANY PURPORTED CLASS OR REPRESENTATIVE PROCEEDING. If any court or arbitrator determines that the class action waiver set forth in this paragraph is void or unenforceable for any reason or that an arbitration can proceed on a class basis, then the arbitration provisions set forth above shall be deemed null and void in their entirety and the parties shall be deemed to have not agreed to arbitrate disputes.</p>
                <p>Exception: Litigation of Intellectual Property and Small Claims Court Claims: Notwithstanding the parties' decision to resolve all disputes through arbitration, either party may bring enforcement actions, validity determinations or claims arising from or relating to theft, piracy or unauthorized use of intellectual property in state or federal court or in the U.S. Patent and Trademark Office to protect its intellectual property rights ("intellectual property rights" means patents, copyrights, moral rights, trademarks, and trade secrets, but not privacy or publicity rights). Either party may also seek relief in a small claims court for disputes or claims within the scope of that court's jurisdiction.</p>
                <p>30-Day Right to Opt Out: You have the right to opt out and not be bound by the arbitration and class action waiver provisions set forth above by sending (from the email address you use on RoofServiceNow) written notice of your decision to opt out to support@RoofServiceNow.com with the subject line, "ARBITRATION AND CLASS ACTION WAIVER OPT-OUT." The notice must be sent within thirty (30) days of the later of the Effective Date of these Terms or your first use of the Platform; otherwise, you shall be bound to arbitrate disputes in accordance with the terms of those paragraphs. If you opt out of these arbitration provisions, RoofServiceNow also will not be bound by them.</p>
                <p>Changes to This Section: RoofServiceNow will provide thirty (30) days' notice of any changes affecting the substance of this Arbitration and Class Action Waiver section by posting on the RoofServiceNow Terms of Use website, sending you a message, or otherwise notifying you when you are logged into your account. Amendments will become effective thirty (30) days after they are posted on the RoofServiceNow Terms of Use website or sent to you.</p>
                <p>Changes to this section will otherwise apply prospectively only to claims arising after the thirtieth (30th) day. If a court or arbitrator decides that this subsection on "Changes to This Section" is not enforceable or valid, then this subsection shall be severed from the section entitled “Arbitration and Class Action Waiver,” and the court or arbitrator shall apply the first Arbitration and Class Action Waiver section in existence after you began using the Platform.</p>
                <p>Survival: This Arbitration and Class Action Waiver section shall survive any termination of your Account or the Platform.</p>
                <p>Third-Party Beneficiary: You and RoofServiceNow acknowledge that any third party consumer reporting agency that RoofServiceNow uses to perform background checks on Service Professionals Members is an express and intended third party beneficiary of this arbitration provision and as such, the terms of this Arbitration provision will inure to the benefit of the consumer reporting agencies and may be enforced by them. Accordingly, you agree that any dispute that arises between you and a consumer reporting agency that relates to or arises out of this Agreement or any aspect of your relationship with RoofServiceNow will be resolved by binding arbitration. If any court or arbitrator determines that this third-party beneficiary subsection is void or unenforceable for any reason, then this subsection shall be severed from the section entitled “Arbitration and Class Action Waiver,” and the remainder of the section shall remain enforceable, meaning that the class action waiver and the mutual obligation to resolve disputes between you and RoofServiceNow through binding arbitration remains enforceable.</p>
                <p><b>GOVERNING LAW</b></p>
                <p>The Terms and the relationship between you and RoofServiceNow shall be governed in all respects by the laws of the State of Florida, without regard to its conflict of law provisions. You agree that any claim or dispute you may have against RoofServiceNow that is not subject to arbitration must be resolved by a court located in Miami-Dade County, Florida, except as otherwise agreed by the parties. You agree to submit to the personal jurisdiction of the courts located within Miami-Dade County, Florida or the United States District Court, of Florida located in Miami-Dade County, Florida, for the purpose of litigating all such claims or disputes that are not subject to arbitration. You hereby waive any and all jurisdictional and venue defenses otherwise available.</p>
                <p><b>DISCLAIMERS</b></p>
                <p>YOUR USE OF THE PLATFORM, PRO SERVICES, OR COLLECTIVE CONTENT SHALL BE SOLELY AT YOUR OWN RISK. YOU ACKNOWLEDGE AND AGREE THAT ROOFSERVICENOW DOES NOT HAVE AN OBLIGATION, BUT RESERVES THE RIGHT FOR ANY REASON, TO (A) MONITOR OR REVIEW USER CONTENT; OR (B) FOR ANY PERMISSIBLE PURPOSE, CONDUCT IDENTITY VERIFICATION, BACKGROUND (INCLUDING CRIMINAL BACKGROUND) OR REGISTERED SEX OFFENDER CHECKS ON ANY MEMBER, INCLUDING BUT NOT LIMITED TO SERVICE PROFESSIONALS MEMBERS AND CUSTOMER MEMBERS. THE PLATFORM IS PROVIDED "AS IS," WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESS OR IMPLIED. WITHOUT LIMITING THE FOREGOING, ROOFSERVICENOW AND ITS AFFILIATES AND SUBSIDIARIES, AND THEIR RESPECTIVE OFFICERS, DIRECTORS, EMPLOYEES AND AGENTS EXPLICITLY DISCLAIM ANY WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, QUIET ENJOYMENT OR NON-INFRINGEMENT; ANY WARRANTIES ARISING OUT OF COURSE OF DEALING OR USAGE OF OR IN TRADE; ANY WARRANTIES, REPRESENTATIONS, OR GUARANTEES IN CONNECTION WITH THIS PLATFORM OR THE PRO SERVICES OFFERED ON OR THROUGH THIS PLATFORM; AND ANY WARRANTIES RELATING TO THE QUALITY, SUITABILITY, TRUTH, ACCURACY OR COMPLETENESS OF ANY INFORMATION OR MATERIAL CONTAINED OR PRESENTED ON THE PLATFORM, INCLUDING WITHOUT LIMITATION ALL COLLECTIVE CONTENT. ROOFSERVICENOW MAKES NO WARRANTY THAT THE PLATFORM OR PRO SERVICES WILL MEET YOUR REQUIREMENTS OR BE AVAILABLE ON AN UNINTERRUPTED, SECURE, OR ERROR-FREE BASIS. ROOFSERVICENOW ASSUMES NO RESPONSIBILITY, AND SHALL NOT BE LIABLE FOR ANY DAMAGES TO YOUR COMPUTER EQUIPMENT OR OTHER PROPERTY ON ACCOUNT OF YOUR ACCESS TO OR USE OF THE PLATFORM. ROOFSERVICENOW SHALL NOT BE LIABLE FOR ANY DEFAMATORY, OFFENSIVE, OR ILLEGAL CONDUCT OF ANY THIRD PARTY, OR ANY LOSS OR DAMAGE OF ANY KIND INCURRED AS A RESULT OF THE USE OF ANY DATA, INFORMATION, MATERIALS, SUBSTANCE, OR COLLECTIVE CONTENT POSTED, TRANSMITTED, OR MADE AVAILABLE VIA THE PLATFORM. NO ADVICE OR INFORMATION, WHETHER ORAL OR WRITTEN, OBTAINED FROM ROOFSERVICENOW OR THROUGH THE PLATFORM, WILL CREATE ANY WARRANTY NOT EXPRESSLY MADE HEREIN.</p>
                <p>YOU ARE SOLELY RESPONSIBLE FOR ALL OF YOUR COMMUNICATIONS AND INTERACTIONS WITH OTHER USERS OR MEMBERS OF THE PLATFORM AND WITH OTHER PERSONS WITH WHOM YOU COMMUNICATE OR INTERACT AS A RESULT OF YOUR USE OF THE PLATFORM, INCLUDING BUT NOT LIMITED TO ANY CUSTOMER MEMBERS, SERVICE PROFESSIONALS MEMBERS OR SERVICE RECIPIENTS. YOU UNDERSTAND THAT ROOFSERVICENOW DOES NOT MAKE ANY ATTEMPT TO VERIFY THE STATEMENTS OF USERS OF THE PLATFORM OR TO REVIEW OR VET ANY PRO SERVICES. ROOFSERVICENOW MAKES NO REPRESENTATIONS OR WARRANTIES AS TO THE CONDUCT OF USERS OF THE PLATFORM OR THEIR COMPATIBILITY WITH ANY CURRENT OR FUTURE USERS OF THE PLATFORM. YOU AGREE TO TAKE REASONABLE PRECAUTIONS IN ALL COMMUNICATIONS AND INTERACTIONS WITH OTHER USERS OF THE PLATFORM AND WITH OTHER PERSONS WITH WHOM YOU COMMUNICATE OR INTERACT AS A RESULT OF YOUR USE OF THE PLATFORM, PARTICULARLY IF YOU DECIDE TO MEET OFFLINE OR IN PERSON AND GIVE OR RECEIVE PRO SERVICES. ROOFSERVICENOW EXPLICITLY DISCLAIMS ALL LIABILITY FOR ANY ACT OR OMISSION OF ANY USERS OR THIRD PARTIES.</p>
                <p><b>LIMITATION OF LIABILITY</b></p>
                <p>YOU ACKNOWLEDGE AND AGREE THAT, TO THE MAXIMUM EXTENT PERMITTED BY LAW, THE ENTIRE RISK ARISING OUT OF YOUR ACCESS TO AND USE OF THE PLATFORM AND COLLECTIVE CONTENT, YOUR OFFERING OR PROVIDING PRO SERVICES OR REQUESTING OR RECEIVING PRO SERVICES THROUGH THE PLATFORM, AND ANY CONTACT YOU HAVE WITH OTHER USERS OF ROOFSERVICENOW OR THIRD PARTIES, WHETHER IN PERSON OR ONLINE, REMAINS WITH YOU. NEITHER ROOFSERVICENOW NOR ANY OTHER PARTY INVOLVED IN CREATING, PRODUCING, OR DELIVERING THE PLATFORM WILL BE LIABLE (WHETHER BASED ON WARRANTY, CONTRACT, TORT (INCLUDING NEGLIGENCE), PRODUCT LIABILITY OR ANY OTHER LEGAL THEORY, AND WHETHER OR NOT ROOFSERVICENOW HAS BEEN INFORMED OF THE POSSIBILITY OF SUCH DAMAGE, EVEN IF A LIMITED REMEDY SET FORTH HEREIN IS FOUND TO HAVE FAILED OF ITS ESSENTIAL PURPOSE) FOR: (A) ANY INCIDENTAL, SPECIAL, EXEMPLARY OR CONSEQUENTIAL DAMAGES, INCLUDING LOST PROFITS, LOSS OF DATA OR LOSS OF GOODWILL; (B) SERVICE INTERRUPTION, COMPUTER DAMAGE OR SYSTEM FAILURE; (C) THE COST OF SUBSTITUTE PRODUCTS OR SERVICES; (D) ANY DAMAGES FOR PERSONAL OR BODILY INJURY OR EMOTIONAL DISTRESS ARISING OUT OF OR IN CONNECTION WITH THESE TERMS; (E) THE USE OF OR INABILITY TO USE THE PLATFORM, PRO SERVICES OR COLLECTIVE CONTENT; (F) ANY COMMUNICATIONS, INTERACTIONS OR MEETINGS WITH OTHER USERS OF THE PLATFORM OR OTHER PERSONS WITH WHOM YOU COMMUNICATE OR INTERACT AS A RESULT OF YOUR USE OF THE PLATFORM; OR (G) YOUR OFFERING OR PROVIDING PRO SERVICES OR REQUESTING OR RECEIVING PRO SERVICES THROUGH THE PLATFORM.</p>
                <p>IN NO EVENT SHALL THE TOTAL, AGGREGATE LIABILITY OF ROOFSERVICENOW AND ITS AFFILIATES AND SUBSIDIARIES, AND THEIR RESPECTIVE OFFICERS, DIRECTORS, EMPLOYEES AND AGENTS, ARISING FROM OR RELATING TO THE TERMS, PLATFORM, PRO SERVICES, AND/OR COLLECTIVE CONTENT, OR FROM THE USE OF OR INABILITY TO USE THE PLATFORM OR COLLECTIVE CONTENT OR IN CONNECTION WITH ANY PRO SERVICES OR INTERACTIONS WITH ANY OTHER USERS EXCEED THE TOTAL AMOUNT OF FEES ACTUALLY PAID TO ROOFSERVICENOW BY YOU HEREUNDER, OR ONE HUNDRED US DOLLARS IF NO SUCH PAYMENTS HAVE BEEN MADE, AS APPLICABLE.</p>
                <p>THE LIMITATION OF LIABILITY DESCRIBED ABOVE SHALL APPLY FULLY TO RESIDENTS OF NEW JERSEY.</p>
                <p><b>INDEMNIFICATION AND RELEASE</b></p>
                <p>You agree to release, defend, indemnify, and hold RoofServiceNow and its affiliates and subsidiaries, and their respective officers, directors, employees and agents, harmless from and against any claims, liabilities, damages, losses, and expenses, including without limitation reasonable legal and accounting fees, arising out of or in any way connected with (a) your violation of these Terms; (b) your User Content; (c) your interaction with any Member or user; and (d) the request or receipt or offer or provision of Pro Services by you, including but not limited to any injuries, losses, or damages (compensatory, direct, incidental, consequential or otherwise) of any kind arising in connection with such Pro Services.</p>
                <p>Notwithstanding the foregoing paragraph, if you are a resident of New Jersey, you only agree to release, defend, indemnify, and hold RoofServiceNow and its affiliates and subsidiaries, and their respective officers, directors, employees and agents, harmless from and against any third-party claims, liabilities, damages, losses, and expenses, including without limitation reasonable legal and accounting fees, arising out of or in any way connected with your violation of these Terms.</p>
                <p>If you are a California resident, you waive California Civil Code Section 1542, which provides:</p>
                <p>A general release does not extend to claims which the creditor does not know or suspect to exist in his or her favor at the time of executing the release, which if known by him or her must have materially affected his or her settlement with the debtor.</p>
                <p>If you are not a California resident, you waive your rights under any statute or common law principle similar to Section 1542 that governs your rights in the jurisdiction of your residence.</p>
                <p><b>GENERAL</b></p>
                <p>Force Majeure: Other than payment obligations, neither RoofServiceNow nor you shall be liable to the other for any delay or failure in performance under the Terms arising out of a cause beyond its control and without its fault or negligence. Such causes may include but are not limited to fires, floods, earthquakes, strikes, unavailability of necessary utilities, blackouts, acts of God, acts of declared or undeclared war, acts of regulatory agencies, or national disasters.</p>
                <p>No Third-Party Beneficiaries: You agree that, except as otherwise expressly provided in these Terms, there shall be no third-party beneficiaries to these Terms.</p>
                <p>Contacting You and E-SIGN Consent: You agree that RoofServiceNow may provide you with notices, including those regarding changes to the Terms, by email, regular mail, or postings on the Platform. With your consent, RoofServiceNow, Customer Members, Service Members, or other individuals may also contact you by telephone or through text messages. If you have agreed to receive text messages or telephone calls from RoofServiceNow, Customer Members, Service Members, or other individuals you also consent to the use of an electronic record to document your agreement. You may withdraw your consent to the use of the electronic record by sending an email to support@RoofServiceNow.com with "Revoke Electronic Consent" in the subject line. To view and retain a copy of this disclosure or any information regarding your enrollment in this program, you will need (a) a device (such as a computer or mobile phone) with a web browser and Internet access; and (b) either a printer or storage space on such device. For a free paper copy, or to update our records of your contact information, send an email to support@RoofServiceNow.com with contact information and the address for delivery.</p>
                <p>Entire Agreement: These Terms, together with the Privacy Policy and any other legal notices or additional terms and conditions or policies published by RoofServiceNow on the Platform, shall constitute the entire agreement between you and RoofServiceNow concerning the Platform or Pro Services obtained through the Platform. Except as explicitly stated herein, if any provision of the Terms is deemed invalid by a court of competent jurisdiction, the invalidity of such provision shall not affect the validity of the remaining provisions of the Terms, which shall remain in full force and effect.</p>
                <p>Waiver: No waiver of any provision of these Terms shall be deemed a further or continuing waiver of such term or any other term, and RoofServiceNow's failure to assert any right or provision under these Terms shall not constitute a waiver of such right or provision.</p>
                <p>Statute of Limitations: You agree that regardless of any statute or law to the contrary, any claim arising out of or related to the Platform or the Pro Services offered therein must commence within one (1) year after the cause of action accrues. Otherwise, such cause of action is permanently barred. Notwithstanding the foregoing, this statute of limitations shall not apply to residents of New Jersey.</p>
                <p>Section Headings: The section headings in these Terms are for convenience only and have no legal or contractual effect.</p>
                <p>Contact Information: If you have any questions about these Terms or the Platform, please contact us by sending an email to support@RoofServiceNow.com, or by writing to RoofServiceNow, Inc., P.O. Box 653, Warren, RI 02285.</p>

			</div> 
			<div class="modal-footer" id="buttontermsServiceWindow"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myModalRespuesta" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="headerTextAnswerOrder">Modal Header</h4>
            </div>
            <div class="modal-body" id="textAnswerOrder">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer" id="buttonAnswerOrder">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#login-modal">Close</button> -->
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

<div class="modal fade" id="myModalRespuesta2" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="headerTextAnswerOrder2">Modal Header</h4>
            </div>
            <div class="modal-body" id="textAnswerOrder2">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer" id="buttonAnswerOrder2">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#login-modal">Close</button> -->
            </div>
        </div>
    </div>
</div>