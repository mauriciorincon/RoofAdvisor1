Welcome to RoofAdvisorz, <?php echo $_actual_company['CompanyID']." - ".$_actual_company['CompanyName']; ?>
<div class="row">
    <div class="col-md-2">
        <div class="vertical-menu">
            <a href="#" class="active">Actions</a>
            <a href="#myModalProfile" data-toggle="modal" >Profile</a>
            <a href="#myModalDrivers" data-toggle="modal" >Drivers</a>
           
            <a href="#">Scheduler</a>
            <a href="#">Metrics in your Service Area</a>
            <a href="#">34 Emergency Repairs </a>
            <a href="#">1 Emergency Repairs Pending</a>
            <a href="#">3 Assigned</a>
            <a href="#">1 RepairCrew Available</a>
            <a href="#">Complete Your Registration</a>
            
        </div>
    </div>
    <div class="col-md-10">

        <script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>

        <style>
        /* Set the size of the div element that contains the map */
        #map {
            height: 400px;  /* The height is 400 pixels */
            width: 100%;  /* The width is the width of the web page */
        }
        </style>

        <div id="map"></div>

        <script>
            // Initialize and add the map
            function initMap() {
                // The location of Uluru
                var uluru = {lat: 25.745693, lng: -80.375028};
                // The map, centered at Uluru
                var map = new google.maps.Map(
                    document.getElementById('map'), {zoom: 11, center: uluru});
                // The marker, positioned at Uluru
                //var marker = new google.maps.Marker({position: uluru, map: map});
                var marker="";
                /*var ref = firebase.app().database().ref("Orders");
                ref.once('value').then(function (snap) {
                            datos=snap.val();
                            for(k in datos){
                                fila=datos[k];
                                pos={lat:parseFloat(fila.Latitude),lng:parseFloat(fila.Longitude)};
                                marker = new google.maps.Marker({position: pos, map: map});
                            }

                
                        
                        
                        console.log('snap.val()', snap.val());
                        });*/

                var ref = firebase.database().ref("Orders");
                ref.orderByChild("CompanyID").equalTo("<?php echo $_actual_company['CompanyID'] ?>").once("value", function(snapshot) {

                    datos=snapshot.val();
                            for(k in datos){
                                fila=datos[k];
                                pos={lat:parseFloat(fila.Latitude),lng:parseFloat(fila.Longitude)};
                                marker = new google.maps.Marker({position: pos, map: map});
                            }

                console.log(snapshot.val());
                
                });
            }
        </script>

        <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyB5HnjwLpr-WqknpRRU5WhrHCg6feVaYss",
            authDomain: "pruebabasedatos-eacf6.firebaseapp.com",
            databaseURL: "https://pruebabasedatos-eacf6.firebaseio.com",
            projectId: "pruebabasedatos-eacf6",
            storageBucket: "pruebabasedatos-eacf6.appspot.com",
            messagingSenderId: "120748340913"
        };
        firebase.initializeApp(config);
        //const dbRef = firebase.database().ref();
        //const usersRef = dbRef.child('Orders');

        
        /*var ref = firebase.database().ref("Orders");
            
                ref.on('value',function(snapshot){
                    snapshot.forEach(function(childSnapshot){
                        var childData=childSnapshot.val();
                    });
                });*/

        </script>


        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&libraries=visualization&callback=initMap">
        </script>

        <div class="table-responsive">          
            <table class="table" id="table_drivers">
                <thead>
                <tr>
                    <th>Repair Type</th>
                    <th>Repair ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($_array_orders_to_show as $key => $order) { ?>
                        <tr>
                            <td><?php echo $order['RequestType']?></td>
                            <td><?php echo $order['OrderNumber']?></td>
                            <td><?php echo "" ?></td>
                            <td><?php if(isset($order['RepAddress'])){echo $order['RepAddress'];} ?></td>
                            <td><?php echo "" ?></td>
                            <td><?php echo $order['Hlevels'].", ".$order['Rtype'].", ".$order['Water']?></td>
                            <td><?php echo $order['Status']?></td>                            
                            <td><?php echo $order['EstAmtTime']?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
              
</div>



<div class="modal" id="myModalProfile" role="dialog" style="height: 800px;">
	<div class="modal-dialog modal-dialog-centered" role="document"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<!--<button type="button" class="close" data-dismiss="modal">&times;</button> -->
				<h4 class="modal-title" id="headerTextProfileCompany">Company Profile</h4> 
			</div> 
			<div class="modal-body" id="textProfileCompany"> 
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
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" id="lastCompanyName" name="lastCompanyName" value="<?php echo $_actual_company['PrimaryLName'] ?>" />
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
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="companyAddress3" name="companyAddress3" value="<?php echo $_actual_company['CompanyAdd3'] ?>"/>
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
                    <button type="button" class="btn-primary btn-sm" onClick="updateDataCompany()" >Update Info</button>        
                </form>
			</div> 
			<div class="modal-footer" id="buttonrating"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myModalDrivers" role="dialog" style="height: 600px;width: 90%;">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<!--<button type="button" class="close" data-dismiss="modal">&times;</button> -->
				<h4 class="modal-title" id="headerTextDriversCompany">Modal Header</h4> 
			</div> 
			<div class="modal-body" id="textAnswerDriversCompany"> 
                <div class="table-responsive">
                        <table class="table" id="table_drivers_dashboard_company" name="table_drivers_dashboard_company">
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
                                        <a class="btn-info btn-sm" data-toggle="modal"  
                                            href="#myModal2" 
                                            onClick=""> 
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="inactivate-contractor-button btn-danger btn-sm" id="inactivate-contractor-button" name="inactivate-contractor-button">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        
                        <a class="btn btn-outline-primary" data-toggle="modal"  
                                            href="#myModalInsertContractor" 
                                            onClick="emptyTextNewDriver()"> 
                                            <span class="glyphicon glyphicon-file">New Contractor</span>
                        </a>
                        
                    </div>
                </div> 
			<div class="modal-footer" id="buttonrating"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>