<br>
<br>
<br>
<div class="container">
    <h3>WELCOME TO ROOFADVISOR </h3>
    <p>Here you can view your orders and their state, also you can manage your profile</p>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#profile">Profile</a></li>
        <li><a data-toggle="tab" href="#contractor">Contractors</a></li>
        <li><a data-toggle="tab" href="#orders">Orders</a></li>
    </ul>

    <div class="tab-content">
        <!--Div profile-->
        <div id="profile" class="tab-pane fade in active">
        <h3>Profile</h3>
            <form role="form">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label ">Company ID</label>
                        <input maxlength="100" disabled type="text" class="form-control"  id="companyID" name="companyID" value="<?php echo $_actual_company['CompanyID'] ?>" />
                    </div>

                    <div class="form-group">
                        <label class="control-label">Company Name</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Name" id="compamnyName" name="compamnyName" value="<?php echo $_actual_company['CompanyName'] ?>" />
                    </div>

                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" id="firstCompanyName" name="firstCompanyName" value="<?php echo $_actual_company['PrimaryFName'] ?>" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" id="lastCustomerName" name="lastCustomerName" value="<?php echo $_actual_company['PrimaryLName'] ?>" />
                    </div>  
                    <div class="form-group">
                        <label class="control-label ">Email</label>
                        <input maxlength="100" disabled type="text" required="required" class="form-control" placeholder="Enter Email" id="companyEmail" name="companyEmail" value="<?php echo $_actual_company['CompanyEmail'] ?>"/>
                    </div> 
                    <div class="form-group">
                        <label class="control-label">Address 1</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="companyAddress1" name="companyAddress1" value="<?php echo $_actual_company['CompanyAdd1'] ?>"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Address 2</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="companyAddress2" name="companyAddress2" value="<?php echo $_actual_company['CompanyAdd2'] ?>"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Address 3</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="companyAddress3" name="companyAddress3" value="<?php echo $_actual_company['CompanyAdd13'] ?>"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Phone number</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter phone number" id="companyPhoneNumber" name="companyPhoneNumber"  value="<?php echo $_actual_company['CompanyPhone'] ?>"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Company Type</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Type" id="companyType" name="companyType" value="<?php echo $_actual_company['CompanyType'] ?>"/>
                    </div> 
                        
                </div>    
            </form>
        </div>

        <!--Div orders-->
        <div id="contractor" class="tab-pane fade">
            <h3>Contractor</h3>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table" id="table_drivers">
                        <thead>
                        <tr>
                            <th>ContractorID</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Repair Crew Phone</th>
                            <th>Driver License</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Inactive</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($_array_contractors_to_show as $key => $contractor) { ?>
                            <tr>
                                <td><?php echo $contractor['ContractorID']?></td>
                                <td><?php echo $contractor['ContNameFirst']?></td>
                                <td><?php echo $contractor['ContNameLast']?></td>
                                <td><?php echo $contractor['ContPhoneNum']?></td>
                                <td><?php echo $contractor['ContLicenseNum']?></td>
                                <td><?php echo $contractor['ContStatus']?></td>
                                <td>
                                    <a href="#" class=" btn-info btn-sm">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class=" btn-danger btn-sm">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--Div orders-->
        <div id="orders" class="tab-pane fade">
            <h3>Orders</h3>
            <div class="panel-body">
                <div class="table-responsive">          
                    <table class="table" id="table_drivers">
                        <thead>
                        <tr>
                            <th>OrderNumber</th>
                            <th>RepAddress</th>
                            <th>RepCity</th>
                            <th>RepState</th>
                            <th>RepZIP</th>
                            <th>RequestType</th>
                            <th>Status</th>
                            <th>ETA</th>
                            <th>Status</th>
                            <th>EstAmtMat</th>
                            <th>EstAmtTime</th>
                            <th>EstTime</th>
                            <th>ContractorId</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_array_orders_to_show as $key => $order) { ?>
                                <tr>
                                    <td><?php echo $order['OrderNumber']?></td>
                                    <td><?php echo $order['RepAddress']?></td>
                                    <td><?php echo $order['RepCity']?></td>
                                    <td><?php echo $order['RepState']?></td>
                                    <td><?php echo $order['RepZIP']?></td>
                                    <td><?php echo $order['RequestType']?></td>
                                    <td><?php echo $order['Status']?></td>
                                    <td><?php echo $order['ETA']?></td>
                                    <td><?php echo $order['Status']?></td>
                                    <td><?php echo $order['EstAmtMat']?></td>
                                    <td><?php echo $order['EstAmtTime']?></td>
                                    <td><?php echo $order['EstTime']?></td>
                                    <td><?php echo $order['ContractorID']?></td>
                                    <td><a href="#" class="btn-danger form-control" role="button" data-title="johnny" id="deleteRowDriver" data-id="1">Detail</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
        
    </div>

</div>