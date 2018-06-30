Welcome to RoofAdvisorz Admin
<div class="row">
    <div class="col-md-2">
        <div class="vertical-menu">
            <a href="#" class="active">Actions</a>
            <a href="#myModalProfile" data-toggle="collapse" data-target="#mapDashBoard1" onclick="hideShowDivs('companyDashBoard1')" >Orders</a>
            <a href="#myModalProfile" data-toggle="collapse" data-target="#companyDashBoard1" onclick="hideShowDivs('mapDashBoard1');getListCompany('table_list_company');" >Company</a>
            <a href="#myModalDrivers" data-toggle="modal" >Drivers</a>
            <a href="#myModalSchedyleCompany" data-toggle="modal">Scheduler</a>
            <a href="#">Metrics in your Service Area</a>
            <a href="#">Orders for the week</a>
            <a href="#">Rechedule Order</a>
            <a href="#">Repair Crew Offline</a>
            <a href="#">Repair Crew Avalible</a>
            <a href="#">Complete Your Registration</a>
            
        </div>
    </div>
    <div class="col-md-10" id="mapDashBoard">
        <div id="mapDashBoard1" class="collapse in">

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
                var marketrs=[];
                var infowindow;
                <?php echo 'var iconBase = "'. $_SESSION['application_path'].'"';?>
                

                

                var iconBase = iconBase+'/img/img_maps/';
                

                var geocoder = new google.maps.Geocoder();
                var infowindow = new google.maps.InfoWindow();

                //if(address != "" && address != null && address != " "){
                //    geocodeAddress(geocoder,map,address,iconBase);
                //}
                
                

                var ref = firebase.database().ref("Orders");
                ref.once("value", function(snapshot) {

                    datos=snapshot.val();
                            for(k in datos){
                                fila=datos[k];
                                //pos={lat:parseFloat(fila.Latitude),lng:parseFloat(fila.Longitude)};
                                //marker = new google.maps.Marker({position: pos, map: map});
                                var marker={
                                    lat: parseFloat(fila.Latitude),
                                    lng: parseFloat(fila.Longitude),
                                    icon: iconBase+'library_maps.png',
                                    text: fila.SchDate
                                };
                                marketrs.push(addMarket(marker,map));
                                //console.log(iconBase+'library_maps.png');
                            }

                console.log(snapshot.val());
                
                });
                
                
                // Retrieve new orders as they are added to our database
                ref.limitToLast(1).on("child_added", function(snapshot, prevChildKey) {
                    var newOrder = snapshot.val();
                    
                        if(validateExist(newOrder.OrderNumber)==false){
                            addOrderToTable(newOrder,companyID);
                        }
                    
                    console.log("Data: " + newOrder);
                    
                });
                // Retrieve new orders as they are added to our database
                ref.on("child_changed", function(snapshot, prevChildKey) {
                    var updateOrder = snapshot.val();
                    
                        if(validateExist(updateOrder.OrderNumber)==false){
                            addOrderToTable(updateOrder,companyID);
                        }else{
                            updateOrderOnTable(updateOrder);
                        }
                    
                    //addOrderToTable(newOrder,companyID);
                    console.log("Data: " + newOrder.OrderNumber);
                    
                });
 
                
            }

            function addMarket(data,map){
                    new google.maps.Marker({
                        position: new google.maps.LatLng(data.lat,data.lng),
                        map:map,
                        icon:'img/img_maps/open_service.png'
                    });
                    
                }
            
            function geocodeAddress(geocoder, resultsMap,varAddress,path) {
                var address = varAddress;
                geocoder.geocode({'address': address}, function(results, status) {
                if (status === 'OK') {
                    resultsMap.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location
                    
                    });
                    //console.log(results);
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
                });
            }

            function addOrderToTable(dataOrder,companyID){
                        $("#table_orders_company").append('<tr><td>'+dataOrder.OrderNumber+'</td><td>'+dataOrder.SchDate+'</td><td>'+dataOrder.SchTime+'</td><td></td><td>'+dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water+'</td><td>'+dataOrder.RequestType+'</td><td>'+dataOrder.Status+'</td><td>'+dataOrder.ETA+'</td><td>'+dataOrder.EstAmtMat+'</td><td>'+dataOrder.PaymentType+'</td><td>'+dataOrder.ContractorID+'</td></tr>');
            }

            function updateOrderOnTable(dataOrder){
                var value = dataOrder.OrderNumber;
                $("#table_orders_company tr").each(function(index) {
                        if (index !== 0) {

                            $row = $(this);

                            var id = $row.find("td:eq(0)").text();

                            if (id.indexOf(value) === 0) {
                                $row.find("td:eq(1)").html(dataOrder.SchDate);
                                $row.find("td:eq(2)").html(dataOrder.SchTime);
                                $row.find("td:eq(3)").html(dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water);
                                $row.find("td:eq(5)").html(dataOrder.RequestType);
                                $row.find("td:eq(6)").html(dataOrder.Status);
                                $row.find("td:eq(7)").html(dataOrder.ETA);
                                $row.find("td:eq(8)").html(dataOrder.EstAmtMat);
                                $row.find("td:eq(9)").html(dataOrder.PaymentType);
                                $row.find("td:eq(10)").html(dataOrder.ContractorID);
                            }
                            
                        }
                    });
            }

            function validateExist(orderID){
               
                    var value = orderID;
                    var flag=false;
                    $("#table_orders_company tr").each(function(index) {
                        if (index !== 0) {

                            $row = $(this);

                            var id = $row.find("td:eq(0)").text();

                            if (id.indexOf(value) !== 0) {
                                flag=false;
                            }
                            else {
                                flag=true;
                                return;
                            }
                        }
                    });
                return flag;

            }
        </script>

        <script>
        // Initialize Firebase
        /*var config = {
            apiKey: "AIzaSyB5HnjwLpr-WqknpRRU5WhrHCg6feVaYss",
            authDomain: "pruebabasedatos-eacf6.firebaseapp.com",
            databaseURL: "https://pruebabasedatos-eacf6.firebaseio.com",
            projectId: "pruebabasedatos-eacf6",
            storageBucket: "pruebabasedatos-eacf6.appspot.com",
            messagingSenderId: "120748340913"
        };*/
        var config = {
            apiKey: "AIzaSyCJIT-8FqBp-hO01ZINByBqyq7cb74f2Gg",
            authDomain: "roofadvisorzapp.firebaseapp.com",
            databaseURL: "https://roofadvisorzapp.firebaseio.com",
            projectId: "roofadvisorzapp",
            storageBucket: "roofadvisorzapp.appspot.com",
            messagingSenderId: "480788526390"
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
        <br>
        <form class="form-inline">
        <div class="form-group mb-2">
            
            <input type="text" id="datepickerFilterDashboard" class="form-control" placeholder="Select a date">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <select class="form-control" id="optionStateFilterDashboard">
                <option value="0">-Select State-</option>
                <option value="A">Order Open</option>
                <option value="D">Order Assigned</option>
                <option value="E">Contractor Just Arrived</option>
                <option value="F">Estimate Sent</option>
                <option value="G">Estimate Approved</option>
                <option value="H">Work In Progress</option>
                <option value="I">Work Completed</option>
                <option value="J">Final Bill</option>
                <option value="K">Order Completed Paid</option>
            </select>
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <select class="form-control" id="selectDriverFilterDashboard">
                <option value="0">-Select Driver-</option>
                <?php foreach ($_array_contractors_to_show as $key => $contractor) { ?>
                    <option value="<?php echo $contractor['ContractorID']?>"><?php echo $contractor['ContNameFirst']." ".$contractor['ContNameLast']?></option>     
                <?php } ?>
            </select>
        </div>
        <button type="button" class="btn-primary btn-sm" onClick="filterDashboard('table_orders_company')" >Search</button>
        
        </form>

         
        <div class="table-responsive">          
            <table class="table" id="table_orders_company">
                <thead>
                <tr>
                    <th>Repair ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Name/Addr/Phone</th>
                    
                    <th>Description</th>
                    <th>Request Type</th>
                    <th>Status</th>

                    <th>Est Amt</th>
                    <th>Final Amt</th>
                    <th>Payment</th>
                    <th>Contractor</th>
                </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($_array_orders_to_show as $key => $order) { ?>
                        <tr>
                            <td><?php echo $order['OrderNumber']?></td>
                            <td><?php echo $order['SchDate']?></td>
                            <td><?php echo $order['SchTime']?></td>
                            <td><?php  
                                $_comapny=$this->_userModel->getCompanyByID($order['CompanyID']); 
                                echo $_comapny['CompanyName'];
                                ?></td>
                            
                            <td><?php echo $order['Hlevels'].", ".$order['Rtype'].", ".$order['Water']?></td>
                            <td><?php echo $order['RequestType']?></td>
                            <td><?php echo $order['Status']?></td>                            

                            <td><?php echo $order['ETA']?></td>
                            <td><?php echo $order['EstAmtMat']?></td>
                            <td><?php echo $order['PaymentType']?></td>
                            <td><?php echo $order['ContractorID']?></td>
                           
                           
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>

    <div class="col-md-10" id="companyDashBoard"  >
        <div class="table-responsive collapse" id="companyDashBoard1">          
            <table class="table" id="table_list_company">
                <thead>
                <tr>
                    <th>ComapnyLicNum</th>
                    <th>Address</th>
                    <th>CompanyEmail</th>
                    <th>CompanyID</th>
                    <th>CompanyName</th>
                    <th>CompanyPhone</th>
                    <th>CompanyStatus</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

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
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#profile">Basic</a></li>
                    <li><a data-toggle="tab" href="#paying">Paying</a></li>
                    <li><a data-toggle="tab" href="#others">Others</a></li>
                </ul>

                <div class="tab-content">
                    <!--Div profile-->
                    <div id="profile" class="tab-pane fade in active">
                        
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
                                    <label class="control-label">Address</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="companyAddress1" name="companyAddress1" value="<?php echo $_actual_company['CompanyAdd1'] ?>"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">City</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="companyAddress2" name="companyAddress2" value="<?php echo $_actual_company['CompanyAdd2'] ?>"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Zip Code</label>
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
                            
                        </form>
                    </div>

                    <!--Div paying-->
                    <div id="paying" class="tab-pane fade">
                        
                        <form role="form">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="control-label">PayInfoBillingAddress1</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter PayInfoBillingAddress1" id="compamnyPayAddress1" name="compamnyPayAddress1" value="<?php echo $_actual_company['PayInfoBillingAddress1'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfoBillingAddress2</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter PayInfoBillingAddress2" id="compamnyPayAddress2" name="compamnyPayAddress2" value="<?php echo $_actual_company['PayInfoBillingAddress2'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfoBillingCity</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter PayInfoBillingCity" id="compamnyPayCity" name="compamnyPayCity" value="<?php echo $_actual_company['PayInfoBillingCity'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfoBillingST</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter PayInfoBillingST" id="compamnyPayState" name="compamnyPayState" value="<?php echo $_actual_company['PayInfoBillingST'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfoBillingZip</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter PayInfoBillingZip" id="compamnyPayZip" name="compamnyPayZip" value="<?php echo $_actual_company['PayInfoBillingZip'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfoCCExpMon</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter PayInfoCCExpMon" id="compamnyPayMonth" name="compamnyPayMonth" value="<?php echo $_actual_company['PayInfoCCExpMon'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfoCCExpYr</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter PayInfoCCExpYr" id="compamnyPayYear" name="compamnyPayYear" value="<?php echo $_actual_company['PayInfoCCExpYr'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfoCCNum</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter PayInfoCCNum" id="compamnyPayCCNum" name="compamnyPayCCNum" value="<?php echo $_actual_company['PayInfoCCNum'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfoCCSecCode</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter PayInfoCCSecCode" id="compamnyPaySecCode" name="compamnyPaySecCode" value="<?php echo $_actual_company['PayInfoCCSecCode'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfoName</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter PayInfoName" id="compamnyPayName" name="compamnyPayName" value="<?php echo $_actual_company['PayInfoName'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PrimaryFName</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter PrimaryFName" id="compamnyPayFName" name="compamnyPayFName" value="<?php echo $_actual_company['PrimaryFName'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PrimaryLName</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter PrimaryLName" id="compamnyPayLName" name="compamnyPayLName" value="<?php echo $_actual_company['PrimaryLName'] ?>" />
                                </div>
                            </div>
                        </form>
                    </div>

                    <!--Div orders-->
                    <div id="others" class="tab-pane fade">
                        <form role="form">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="control-label">InsLiabilityAgencyName</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter InsLiabilityAgencyName" id="compamnyAgencyName" name="compamnyAgencyName" value="<?php echo $_actual_company['InsLiabilityAgencyName'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">InsLiabilityAgtName</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter InsLiabilityAgtName" id="compamnyAgtName" name="compamnyAgtName" value="<?php echo $_actual_company['InsLiabilityAgtName'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">InsLiabilityAgtNum</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter InsLiabilityAgtNum" id="compamnyAgtNum" name="compamnyAgtNum" value="<?php echo $_actual_company['InsLiabilityAgtNum'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">InsLiabilityPolNum</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter InsLiabilityPolNum" id="compamnyPolNum" name="compamnyPolNum" value="<?php echo $_actual_company['InsLiabilityPolNum'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Status_Rating</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Status_Rating" id="compamnyStatusRating" name="compamnyStatusRating" value="<?php echo $_actual_company['Status_Rating'] ?>" />
                                </div>
                            
                            </div>
                        </form>
                    </div>

                </div> 
            
                <button type="button" class="btn-primary btn-sm" onClick="updateDataCompany()" >Update Info</button>        
                <div class="modal-footer" id="buttonrating"> 
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div> 
            </div>
		</div> 
	</div>
</div>

<div class="modal fade" id="myModalDrivers" role="dialog" style="height: 600px;width: 90%;">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerTextDriversCompany">Driver List</h4> 
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
                                <th>Driver Email</th>
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
                                    <td><?php if (isset($contractor['driverEmail'])){echo $contractor['driverEmail'];}else{echo '';}?></td>
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


<!-- formulario Modal Actualizar datos-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit Contrator Data</h4>
      </div>
      <div class="modal-body">

        <form role="form" method="post" action="?controlador=precontrato&accion=editaCupo">
            <div class="form-group">
                <label for="ContractorIDed">ContractorID</label>
                <input type="text" class="form-control" name="ContractorIDed" id="ContractorIDed"  required readonly>
            </div>
            <div class="form-group">
                <label for="ContNameFirsted">First name</label>
                <input type="text" class="form-control" name="ContNameFirsted" id="ContNameFirsted"  required oninvalid="this.setCustomValidity('Por favor ingrese el valor del cupo')"
                oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="ContNameLasted">Last Name</label>
                <input type="text" class="form-control" name="ContNameLasted" id="ContNameLasted" maxlength="60" required oninvalid="this.setCustomValidity('Por favor ingrese el plazo del cupo')"
                oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="ContPhoneNumed">Repair Crew Phone</label>
                <input type="text" class="form-control" name="ContPhoneNumed" id="ContPhoneNumed" maxlength="60" required oninvalid="this.setCustomValidity('Por favor ingrese el plazo del cupo')"
                oninput="setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="ContLicenseNumed">Driver License</label>
                <input type="text" class="form-control" name="ContLicenseNumed" id="ContLicenseNumed" maxlength="60" required oninvalid="this.setCustomValidity('Por favor ingrese el plazo del cupo')"
                oninput="setCustomValidity('')">
            </div>
            
            <div class="form-group">
            <label for="ContStatused">Status</label>
                    <select class="form-control" id="ContStatused" name="ContStatused" readonly>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Terminated">Terminated</option>
                    </select>
            </div>
          

          <button type="button" class="btn-primary btn-sm" onClick="updateContractor()" >Save</button>
          <button  type="button" class="btn-danger btn-sm" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div><!-- /cierro contenedor -->
  </div><!-- /cierro dialogo-->
</div><!-- /cierro modal -->


<!-- formulario Insertar contractor datos-->
<div class="modal fade" id="myModalInsertContractor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Contrator Data</h4>
      </div>
      <div class="modal-body">

        <form role="form" method="post" action="?controlador=precontrato&accion=editaCupo">
            <div class="form-group">
                <label for="ContractorIDed">ContractorID</label>
                <input type="text" class="form-control" name="ContractorIDIn" id="ContractorIDIn"  required readonly>
            </div>
            <div class="form-group">
                <label for="ContNameFirsted">First name</label>
                <input type="text" class="form-control" name="ContNameFirstIn" id="ContNameFirstIn"  required oninvalid="this.setCustomValidity('Write the First name of contractor')"
                oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="ContNameLasted">Last Name</label>
                <input type="text" class="form-control" name="ContNameLastIn" id="ContNameLastIn" maxlength="60" required oninvalid="this.setCustomValidity('Write the Last name of contractor')"
                oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="ContPhoneNumed">Repair Crew Phone</label>
                <input type="text" class="form-control" name="ContPhoneNumIn" id="ContPhoneNumIn" maxlength="60" required oninvalid="this.setCustomValidity('Write the phone number of contractor')"
                oninput="setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="ContLicenseNumed">Driver License</label>
                <input type="text" class="form-control" name="ContLicenseNumIn" id="ContLicenseNumIn" maxlength="60" required oninvalid="this.setCustomValidity('Write the license number of contractor')"
                oninput="setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="ContLicenseNumed">Driver Email</label>
                <input type="text" class="form-control" name="ContEmail" id="ContEmail" maxlength="60" required oninvalid="this.setCustomValidity('Write the email for the contractor')"
                oninput="setCustomValidity('')">
            </div>
            
            <div class="form-group">
            <label for="ContStatused">Status</label>
                    <select class="form-control" id="ContStatusIn" name="ContStatusIn">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Terminated">Terminated</option>
                    </select>
            </div>
          

            <button type="button" class="btn-primary btn-sm" onClick="insertDriver()" >Save</button>
            <button  type="button" class="btn-danger btn-sm" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div><!-- /cierro contenedor -->
  </div><!-- /cierro dialogo-->
</div><!-- /cierro modal -->


<!-- formulario Insertar contractor datos-->
<div class="modal" id="myModalSchedyleCompany" role="dialog" style="height: 1000px;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Service Schedule</h4>
      </div>
        <div class="modal-body"  id="scheduleCompany">
            <?php   echo '<h2>June 2018</h2>';
                    $oCalendar=new calendar();
                    echo $oCalendar->draw_controls(6,2018);
                    $_eventsArray=$oCalendar->getEvents(6,2018);
                    echo $oCalendar->draw_calendar(6,2018,$_eventsArray);
            ?>
        </div>
    </div><!-- /cierro contenedor -->
  </div><!-- /cierro dialogo-->
</div><!-- /cierro modal -->