<div class="alert alert-success">
  <strong>Welcome to RoofAdvisorz,</strong>  <?php echo $_actual_company['CompanyID']." - ".$_actual_company['CompanyName']; ?>
</div>
<?php if(strcmp($_actual_company['CompanyID'],'Active')!==0){?>
    <div class="alert alert-danger">
        <strong>Attention!</strong> Your company in not Active, please finish filling out the profile
    </div>
<?php } ?>
<div class="row">
    <div class="col-md-2">
        <div class="vertical-menu">
            <a href="#" class="active">Actions</a>
            <a href="#myModalProfile" data-toggle="modal" >Profile</a>
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
                var marketrs=[];
                var infowindow;
                <?php echo 'var iconBase = "'. $_SESSION['application_path'].'"';?>
                

                

                var iconBase = iconBase+'/img/img_maps/';
                <?php echo 'var address = "'. $_actual_company['CompanyAdd1']." ".$_actual_company['CompanyAdd2'].'"';?>

                var geocoder = new google.maps.Geocoder();
                var infowindow = new google.maps.InfoWindow();

                if(address != "" && address != null && address != " "){
                    geocodeAddress(geocoder,map,address,iconBase);
                }
                
                <?php echo 'var companyID = "'. $_actual_company['CompanyID'].'"';?>

                var ref = firebase.database().ref("Orders");
                ref.orderByChild("CompanyID").equalTo("<?php echo $_actual_company['CompanyID'] ?>").once("value", function(snapshot) {

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
                                var oMarket=addMarket(marker,map,fila,infowindow);
                                marketrs.push(oMarket);
                            }

                console.log(snapshot.val());
                
                });
                
                
                // Retrieve new orders as they are added to our database
                ref.limitToLast(1).on("child_added", function(snapshot, prevChildKey) {
                    var newOrder = snapshot.val();
                    if(newOrder.Status=='A' || newOrder.CompanyID==companyID){
                        if(validateExist(newOrder.OrderNumber)==false){
                            addOrderToTable(newOrder,companyID,map,infowindow,iconBase);
                        }
                    }
                    console.log("Data: " + newOrder);
                    
                });
                // Retrieve new orders as they are added to our database
                ref.on("child_changed", function(snapshot, prevChildKey) {
                    var updateOrder = snapshot.val();
                    if(updateOrder.Status=='A' || updateOrder.CompanyID==companyID){
                        if(validateExist(updateOrder.OrderNumber)==false){
                            addOrderToTable(updateOrder,companyID,map,infowindow,iconBase);
                        }else{
                            updateOrderOnTable(updateOrder);
                        }
                    }
                    //addOrderToTable(newOrder,companyID);
                    console.log("Data: " + updateOrder.OrderNumber);
                    
                });
 
                
            }

            function addMarket(data,map,fila,infowindow){
                var image="";
                    if(fila.Status==='A'){
                        image="open_service.png";
                    }else if(fila.Status=='D'){
                        image="open_service_d.png";
                    }else if(fila.Status=='E'){
                        image="open_service_e.png";
                    }else if(fila.Status=='F'){
                        image="open_service_f.png";
                    }
                    var oMarket= new google.maps.Marker({
                        position: new google.maps.LatLng(data.lat,data.lng),
                        map:map,
                        icon:'img/img_maps/'+image
                    });

                    oMarket.addListener('click', function() {
                                    infowindow.setContent('<p><b>Order #:</b>'+fila.OrderNumber+'  <br><b>Address:</b>'+fila.RepAddress+' '+fila.RepCity+' '+fila.RepState+
                                                            '</b><br><b>Customer:</b>'+fila.CustomerID+
                                                            '<br><b>Date:</b>'+fila.SchDate+' '+fila.SchTime+'</p>');
                                    infowindow.open(map, this);
                                });
                    return oMarket;
                }
            
            function geocodeAddress(geocoder, resultsMap,varAddress,path) {
                var address = varAddress;
                geocoder.geocode({'address': address}, function(results, status) {
                if (status === 'OK') {
                    resultsMap.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location,
                    label:"C"
                    
                    });
                    //console.log(results);
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
                });
            }

            function bindInfoWindow(marker, html) {
                google.maps.event.addListener(marker, 'click', function (event) {
                    infowindow.setContent(html);
                    infowindow.position = event.latLng;
                    infowindow.open(map, marker);
                });
            }

            function addOrderToTable(dataOrder,companyID,map,infowindow,iconBase){
                var t = $('#table_orders_company').DataTable();
                t.row.add( [
                        dataOrder.OrderNumber,
                        dataOrder.SchDate,
                        dataOrder.SchTime,
                        dataOrder.Hlevels,
                        dataOrder.Rtype,
                        dataOrder.Water,
                        dataOrder.RequestType,
                        dataOrder.Status,
                        dataOrder.ETA,
                        dataOrder.EstAmtMat,
                        dataOrder.PaymentType,
                        dataOrder.ContractorID
                    ] ).draw( false );
                /*$("#table_orders_company").append('<tr><td>'+dataOrder.OrderNumber+'</td><td>'+
                dataOrder.SchDate+'</td><td>'+dataOrder.SchTime+'</td><td></td><td>'+dataOrder.Hlevels+', '+
                dataOrder.Rtype+', '+dataOrder.Water+'</td><td>'+dataOrder.RequestType+'</td><td>'+dataOrder.Status+
                '</td><td>'+dataOrder.ETA+'</td><td>'+dataOrder.EstAmtMat+'</td><td>'+dataOrder.PaymentType+
                '</td><td>'+dataOrder.ContractorID+'</td></tr>');*/
                var marker={
                                    lat: parseFloat(dataOrder.Latitude),
                                    lng: parseFloat(dataOrder.Longitude),
                                    icon: iconBase+'library_maps.png',
                                    text: dataOrder.SchDate
                                };
                                var oMarket=addMarket(marker,map,dataOrder,infowindow);
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
                                return false;
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
       

         
        <div class="row">          
            <table class="table table-striped table-bordered" id="table_orders_company">
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
                                    <label class="control-label">Billing Address</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address" id="compamnyPayAddress1" name="compamnyPayAddress1" value="<?php echo $_actual_company['PayInfoBillingAddress1'] ?>" />
                                </div>
                                <div class="form-group">
<<<<<<< HEAD
<<<<<<< HEAD
                                    <label class="control-label">Billing Address 2</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address 2" id="compamnyPayAddress2" name="compamnyPayAddress2" value="<?php echo $_actual_company['PayInfoBillingAddress2'] ?>" />
=======
                                    <label class="control-label">Billing Address (Con't)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address (Con't)" id="compamnyPayAddress2" name="compamnyPayAddress2" value="<?php echo $_actual_company['PayInfoBillingAddress2'] ?>" />
>>>>>>> 299c41f913cf7d67e501f865b380e880099fb665
=======
                                    <label class="control-label">Billing Address (Con't)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address (Con't)" id="compamnyPayAddress2" name="compamnyPayAddress2" value="<?php echo $_actual_company['PayInfoBillingAddress2'] ?>" />
>>>>>>> 9807759c06247c158bc815e90c034f07bd80901a
                                </div>
                                <div class="form-group">
                                    <label class="control-label">City</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter City" id="compamnyPayCity" name="compamnyPayCity" value="<?php echo $_actual_company['PayInfoBillingCity'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">State</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter State" id="compamnyPayState" name="compamnyPayState" value="<?php echo $_actual_company['PayInfoBillingST'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Zip Code</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Zip Code" id="compamnyPayZip" name="compamnyPayZip" value="<?php echo $_actual_company['PayInfoBillingZip'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Credit Card Expiration Month (MM)</label>
<<<<<<< HEAD
<<<<<<< HEAD
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Month" id="compamnyPayMonth" name="compamnyPayMonth" value="<?php echo $_actual_company['PayInfoCCExpMon'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfCredit Card Expiration Year (YYYY)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Year" id="compamnyPayYear" name="compamnyPayYear" value="<?php echo $_actual_company['PayInfoCCExpYr'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfoCredit Card Number</label>
=======
=======
>>>>>>> 9807759c06247c158bc815e90c034f07bd80901a
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Month (MM)" id="compamnyPayMonth" name="compamnyPayMonth" value="<?php echo $_actual_company['PayInfoCCExpMon'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Credit Card Expiration Year (YYYY)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Year (YYYY)" id="compamnyPayYear" name="compamnyPayYear" value="<?php echo $_actual_company['PayInfoCCExpYr'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Credit Card Number</label>
<<<<<<< HEAD
>>>>>>> 299c41f913cf7d67e501f865b380e880099fb665
=======
>>>>>>> 9807759c06247c158bc815e90c034f07bd80901a
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Number" id="compamnyPayCCNum" name="compamnyPayCCNum" value="<?php echo $_actual_company['PayInfoCCNum'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Credit Card CSV</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card CSV" id="compamnyPaySecCode" name="compamnyPaySecCode" value="<?php echo $_actual_company['PayInfoCCSecCode'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Name on Cred Card</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Name on Cred Card" id="compamnyPayName" name="compamnyPayName" value="<?php echo $_actual_company['PayInfoName'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">First Name on Credit Card</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name on Credit Card" id="compamnyPayFName" name="compamnyPayFName" value="<?php echo $_actual_company['PrimaryFName'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Last Name on Credit Card</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name on Credit Card" id="compamnyPayLName" name="compamnyPayLName" value="<?php echo $_actual_company['PrimaryLName'] ?>" />
                                </div>
                            </div>
                        </form>
                    </div>

                    <!--Div orders-->
                    <div id="others" class="tab-pane fade">
                        <form role="form">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="control-label">Company Insurance Name</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Insurance Name" id="compamnyAgencyName" name="compamnyAgencyName" value="<?php echo $_actual_company['InsLiabilityAgencyName'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Insurance Agent's Name</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Insurance Agent's Name" id="compamnyAgtName" name="compamnyAgtName" value="<?php echo $_actual_company['InsLiabilityAgtName'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Insurance Agent's Phone Number</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Insurance Agent's Phone Number" id="compamnyAgtNum" name="compamnyAgtNum" value="<?php echo $_actual_company['InsLiabilityAgtNum'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Insurance Policy Number</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Insurance Policy Number" id="compamnyPolNum" name="compamnyPolNum" value="<?php echo $_actual_company['InsLiabilityPolNum'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Company Rating</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Rating" id="compamnyStatusRating" name="compamnyStatusRating" value="<?php echo $_actual_company['Status_Rating'] ?>" />
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
                <?php if(strcmp($_actual_company['CompanyID'],'Active')!==0){?>
                    <div class="alert alert-danger">
                        <strong>Attention!</strong> Your company in not Active, please finish filling out the profile
                    </div>
                <?php } ?>
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
                                <th>-Edit-</th>
                                <th>Action</th>
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
                                    <td><?php if (isset($contractor['ContEmail'])){echo $contractor['ContEmail'];}else{echo '';}?></td>
                                    <td><?php echo $contractor['ContStatus']?></td>
                                    <td>
                                        <a class="btn-info btn-sm" data-toggle="modal"  
                                            href="#myModal2" 
                                            onClick=""> 
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if(strcmp($contractor['ContStatus'],"Active")==0){?>
                                            <a href="#" class="inactivate-contractor-button btn-danger btn-sm" id="inactivate-contractor-button" name="inactivate-contractor-button" data-toggle="tooltip" title="Inactive Driver" onclick="disableEnableDriver('<?php echo $contractor['ContractorID']?>','Inactive')">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                        <?php } else{ ?>
                                            <a href="#" class="inactivate-contractor-button btn-success btn-sm" id="inactivate-contractor-button" name="inactivate-contractor-button" data-toggle="tooltip" title="Active Driver"  onclick="disableEnableDriver('<?php echo $contractor['ContractorID']?>','Active')">
                                                <span class="glyphicon glyphicon-ok"></span>
                                            </a>
                                        <?php } ?>
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

        <form role="form" method="post" action="" id="formInsertContractor">
            <div class="form-group">
                <label for="ContractorIDed">ContractorID</label>
                <input type="text" class="form-control" name="ContractorIDIn" id="ContractorIDIn" readonly>
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
                <input type="text" class="form-control" name="emailValidation" id="emailValidation" maxlength="60" required oninvalid="this.setCustomValidity('Write the email for the contractor')"
                oninput="setCustomValidity('')">
                <label class="control-label" id="answerEmailValidate" name="answerEmailValidate">Answer</label>
            </div>
            
            <div class="form-group">
            <label for="ContStatused">Status</label>
                    <select class="form-control" id="ContStatusIn" name="ContStatusIn" disabled>
                        <option value="Active">Active</option>
                        <option value="Inactive" selected>Inactive</option>
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