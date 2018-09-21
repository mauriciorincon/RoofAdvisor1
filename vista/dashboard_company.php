
<?php if(strcmp($_actual_company['CompanyStatus'],'Active')!==0){?>
    <div class="alert alert-danger">
        <strong>Welcome to RoofServicenow,</strong>  <?php echo $_actual_company['CompanyID']." - ".$_actual_company['CompanyName']; ?>  -  <strong>Attention!</strong> Your company in not Active, please finish filling out the profile
    </div>
<?php }else{ ?>
    <div class="alert alert-success">
        <strong>Welcome to RoofServicenow,</strong>  <?php echo $_actual_company['CompanyID']." - ".$_actual_company['CompanyName']; ?>
    </div>
<?php } ?>

<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
		<div class="btn-group mr-2" role="group" aria-label="First group">
            <button type="button" class="btn btn-primary active"  data-toggle="collapse" data-target="#mapDashBoard1" onclick="hideShowDivs('companyDashProfile1');hideShowDivs('companyDashEmployee1');hideShowDivs('scheduleCompany');setActiveItemMenu(this);">Orders</button>
			<button type="button" class="btn btn-primary "  data-toggle="collapse" data-target="#companyDashProfile1" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('companyDashEmployee1');hideShowDivs('scheduleCompany');setActiveItemMenu(this);">Profile</button>
			<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#companyDashEmployee1" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('companyDashProfile1');hideShowDivs('scheduleCompany');setActiveItemMenu(this);" >Employee</button>
            <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#scheduleCompany" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('companyDashProfile1');hideShowDivs('companyDashEmployee1');setActiveItemMenu(this);">Scheduler</button>
            
            
            
        </div>
        <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Metrics
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a class="dropdown-item" href="#">Emergency Repair</a>
                <a class="dropdown-item" href="#">Schedule Repair</a>
                <a class="dropdown-item" href="#">Report Repair</a>
                <a class="dropdown-item" href="#">Repair Done</a>
                <a class="dropdown-item" href="#">Repair Open</a>
                </div>
            </div>
		
</div>

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
            var marketrs=[];
            var contractorMarker=[];
            var mapObject;
            var infowindow;
            var orderOpenContractor=[];
            <?php echo 'var iconBase = "'. $_SESSION['application_path'].'"';?>
            // Initialize and add the map
            function initMap() {
                // The location of Uluru
                var uluru = {lat: 25.745693, lng: -80.375028};
                // The map, centered at Uluru
                mapObject = new google.maps.Map(
				document.getElementById('map'), {zoom: 11, center: uluru});

                // The marker, positioned at Uluru
                //var marker = new google.maps.Marker({position: uluru, map: map});
                var marker="";
                infowindow = new google.maps.InfoWindow();
                
                var iconBase = iconBase+'/img/img_maps/';

                <?php echo 'var address = "'. $_actual_company['CompanyAdd1']." ".$_actual_company['CompanyAdd2'].'"';?>

                var geocoder = new google.maps.Geocoder();
                

                if(address != "" && address != null && address != " "){
                    geocodeAddress(geocoder,map,address,iconBase);
                }
                
                <?php echo 'var companyID = "'. $_actual_company['CompanyID'].'"';?>

                var ref = firebase.database().ref("Orders");
                ref.orderByChild("CompanyID").equalTo("<?php echo $_actual_company['CompanyID'] ?>").once("value", function(snapshot) {

                    datos=snapshot.val();
                    for(k in datos){
                        fila=datos[k];

                        var marker={
                            lat: parseFloat(fila.Latitude),
                            lng: parseFloat(fila.Longitude),
                            icon: iconBase+'library_maps.png',
                            text: fila.SchDate
                        };
                        var oMarket=addMarket(marker,fila,infowindow);
                        
                        marketrs.push(oMarket);

                        if(fila.Status=='D'){
                            if(fila.ContractorID!="" || fila.ContractorID!=undefined){
                                orderOpenContractor.push(fila.ContractorID);
                                var refContractor = firebase.database().ref("/Contractors/"+fila.ContractorID);
                                refContractor.once("value", function(snapshot) {
                                    var updateContractor = snapshot.val();
                                    var marker={
                                        lat: parseFloat(updateContractor.CurrentLocation.latitude),
                                        lng: parseFloat(updateContractor.CurrentLocation.longitude),
                                        icon: iconBase+'library_maps.png'
                                    };
                                    var oMarket=addMarketContractor(marker,updateContractor);
                                    contractorMarker.push(oMarket);
                                });
                            }
                        }
                    }
                
                });
                
                
                // Retrieve new orders as they are added to our database
                ref.limitToLast(1).on("child_added", function(snapshot, prevChildKey) {
                    var newOrder = snapshot.val();
                    if(newOrder.Status=='A' || newOrder.CompanyID==companyID || newOrder.CompanyID=="" || newOrder.CompanyID==null){
                        row=validateExist(newOrder.OrderNumber)
						if(row==-1){
                                addOrderToTable(newOrder,companyID,map,infowindow,iconBase);
						}                        
                    }
                    console.log("Data: " + newOrder);
                    
                });

                // Retrieve new orders as they are added to our database
                ref.on("child_changed", function(snapshot, prevChildKey) {
                    var updateOrder = snapshot.val();
                    if(updateOrder.CompanyID==companyID){
                        row=validateExist(updateOrder.OrderNumber);
						if(row==-1){
								addOrderToTable(updateOrder,customerID,map,infowindow,iconBase);
						}else{
								updateOrderOnTable(updateOrder,row);
						}
                        removeMarket(updateOrder.OrderNumber);
                        var marker={
                            lat: parseFloat(updateOrder.Latitude),
                            lng: parseFloat(updateOrder.Longitude),
                            icon: iconBase+'library_maps.png',
                            text: updateOrder.SchDate
                        };
                        var oMarket=addMarket(marker,updateOrder,infowindow);
                        marketrs.push(oMarket);

                        //Function to paint driver position
                        if(updateOrder.Status=='D'){
                            if(updateOrder.ContractorID!="" || updateOrder.ContractorID!=undefined){
                                if (orderOpenContractor.indexOf(updateOrder.ContractorID)==-1){
                                    orderOpenContractor.push(fila.ContractorID);
                                }
                                var refContractor = firebase.database().ref("/Contractors/"+updateOrder.ContractorID);
                                refContractor.once("value", function(snapshot) {
                                    var updateContractor = snapshot.val();
                                    removeMarketContractor(updateContractor.ContractorID);
                                    var marker={
                                        lat: parseFloat(updateContractor.CurrentLocation.latitude),
                                        lng: parseFloat(updateContractor.CurrentLocation.longitude),
                                        icon: iconBase+'library_maps.png'
                                    };
                                    var oMarket=addMarketContractor(marker,updateContractor);
                                    contractorMarker.push(oMarket);
                                });
                            }
                        }else{
                            removeMarketContractor(updateOrder.ContractorID);
                        }

                    }else{
                        if(updateOrder.Status!='A'){
                            row=validateExist(updateOrder.OrderNumber);
                            if(row>-1){
                                removeOrderOnTable(updateOrder);
                            }
                        }
					}
                    console.log("Data: " + updateOrder.OrderNumber);
                    
                });

                // Remove orders that are deleted from database
                ref.on("child_removed", function(snapshot) {
                    var deletedOrder = snapshot.val();
                        if(validateExist(deletedOrder.OrderNumber)==true){
                            removeOrderOnTable(deletedOrder);
                        }
                    console.log("Data: " + deletedOrder.OrderNumber);
                    
                });

                var refOpen = firebase.database().ref("Orders");
                refOpen.orderByChild("CompanyID").equalTo("").once("value", function(snapshot) {
                    datos=snapshot.val();
                    for(k in datos){
                        fila=datos[k];

                        var marker={
                            lat: parseFloat(fila.Latitude),
                            lng: parseFloat(fila.Longitude),
                            icon: iconBase+'library_maps.png',
                            text: fila.SchDate
                        };
                        var oMarket=addMarket(marker,fila,infowindow);
                        marketrs.push(oMarket);
                    }
                });
                
            }

            function addMarket(data,fila,infowindow){
                var image="";
					if(fila.Status==='A'){
						image="open_service.png";
					}else if(fila.Status=='D'){
						image="open_service_d.png";
					}else if(fila.Status=='E'){
						image="open_service_e.png";
					}else if(fila.Status=='F'){
						image="open_service_f.png";
					}else if(fila.Status=='G'){
						image="open_service_g.png";
					}else if(fila.Status=='H'){
						image="open_service_h.png";
					}else if(fila.Status=='I'){
						image="open_service_i.png";
					}else if(fila.Status=='J'){
						image="open_service_j.png";
					}else if(fila.Status=='K'){
						image="open_service_k.png";
					}else if(fila.Status=='C'){
						image="open_service_c.png";
					}else if(fila.Status=='P'){
						image="open_service_p.png";
					}else if(fila.Status=='R'){
						image="open_service_r.png";
					}else if(fila.Status=='S'){
						image="open_service_s.png";
					}else{
						image="if_sign-error_299045.png";
					}
					var oMarket= new google.maps.Marker({
						position: new google.maps.LatLng(data.lat,data.lng),
						map:mapObject,
						icon:'img/img_maps/'+image,
						id:fila.OrderNumber
					});

                    
                    
                            
                        
					oMarket.addListener('click', function() {
                        var customerName="";
                        var contractorName="";
                        getContractorName(fila.ContractorID).then(function(contractorName){
                            getCustomerName(fila.CustomerFBID).then(function(customerName) {  
                            infowindow.setContent('<p><b>Order #:</b>'+fila.OrderNumber+'  <br><b>Address:</b>'+fila.RepAddress+' '+fila.RepCity+' '+fila.RepState+
                                                        '</b><br><b>Status:</b>'+getStatus(fila.Status)+
                                                        '<br><b>Date:</b>'+fila.SchDate+' '+fila.SchTime+
                                                        '<br><b>Customer:</b>'+customerName+
                                                        '<br><b>Contractor:</b>'+contractorName+'</p>');
                                infowindow.open(map, oMarket); 
                            });    
                        });
                        
                            
                        
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
                var requestType=getRequestType(dataOrder.RequestType);
                var status=getStatus(dataOrder.Status);
                
                var dataCustomer="";
                if(dataOrder.ContractorID=="" || dataOrder.ContractorID==null){
                    dataCustomer='<a class="btn-primary btn-sm" data-toggle="modal"'+
									'href="#myModalGetWork" '+
									'onClick="setOrderId("'+dataOrder.FBID+')"> '+
									'<span class="glyphicon glyphicon-check"></span>Take work</a>';
                }else{
                    dataCustomer=dataOrder.ContractorID;
                }
                t.row.add( [
                        dataOrder.OrderNumber,
                        dataOrder.SchDate,
                        dataOrder.SchTime,
                        dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water,
                        "",
                        requestType,
                        status,
                        dataOrder.ETA,
                        dataOrder.EstAmtMat,
                        dataOrder.PaymentType,
                        dataCustomer,
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
                var oMarket=addMarket(marker,dataOrder,infowindow);
                marketrs.push(oMarket);

            }

            function updateOrderOnTable(dataOrder){
                var value = dataOrder.OrderNumber;
                $("#table_orders_company tr").each(function(index) {
                    if (index !== 0) {

                        $row = $(this);

                        var id = $row.find("td:eq(0)").text();

                        if (id.indexOf(value) === 0) {
                            var requestType=getRequestType(dataOrder.RequestType);
                            var status=getStatus(dataOrder.Status);
                            var dataCustomer="";
                            if(dataOrder.ContractorID=="" || dataOrder.ContractorID==null){
                                dataCustomer='<a class="btn-primary btn-sm" data-toggle="modal"'+
                                                'href="#myModalGetWork" '+
                                                'onClick="setOrderId("'+dataOrder.FBID+')"> '+
                                                '<span class="glyphicon glyphicon-check"></span>Take work</a>';
                                $row.find("td:eq(10)").html(contractorName);
                            }else{
                                getContractorName(dataOrder.ContractorID).then(function(contractorName){
                                    $row.find("td:eq(10)").html(contractorName);
                                });
                            }
                            $row.find("td:eq(1)").html(dataOrder.SchDate);
                            $row.find("td:eq(2)").html(dataOrder.SchTime);
                            $row.find("td:eq(3)").html(dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water);
                            $row.find("td:eq(5)").html(requestType);
                            $row.find("td:eq(6)").html(status);
                            $row.find("td:eq(7)").html(dataOrder.ETA);
                            $row.find("td:eq(8)").html(dataOrder.EstAmtMat);
                            $row.find("td:eq(9)").html(dataOrder.PaymentType);
                            
                                
                            
                        }
                        
                    }
                });
            }

            function removeOrderOnTable(dataOrder){
                var value = dataOrder.OrderNumber;
					var t = $('#table_orders_company').DataTable();
					t.rows( function ( idx, data, node ) {
						return data[0] === value;
					} )
					.remove()
					.draw();
            }

            function validateExist(orderID){
                    var value = orderID;
                    var flag=false;
                    var count=-1;
                    $("#table_orders_company tr").each(function(index) {
                        
                        if (index !== 0) {
                            count++;
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

                if(flag==false){
                    count=-1;
                }
                return count;

            }

            function getRequestType(requestType){
                var RequestType="";
                switch (requestType) {
                    case "E":
                        RequestType = "Emergency";
                        break;
                    case "S":
                        RequestType = "Schedule";
                        break;
                    case "R":
                        RequestType = "RoofReport";
                        break;
                    default:
                        RequestType = "No value found";
                }
                return RequestType;
            }

            function getStatus(status){
                var orderStatus="";
                switch (status) {
                    case "A":
                        orderStatus = "Order Open";
                        break;
                    case "D":
                        orderStatus = "Order Assigned";
                        break;
                    case "E":
                        orderStatus = "Contractor Just Arrived";
                        break;
                    case "F":
                        orderStatus = "Estimate Sent";
                        break;
                    case "G":
                        orderStatus = "Estimate Approved";
                        break;
                    case "H":
                        orderStatus = "Work In Progress";
                        break;
                    case "I":
                        orderStatus = "Work Completed";
                        break;
                    case "J":
                        orderStatus = "Final Bill";
                        break;
                    case "K":
                        orderStatus = "Order Completed Paid";
                        break;
                    case "C":
                        orderStatus = "Cancel work";
                        break;
                    default:
                        orderStatus = "Undefined";
                }
                return orderStatus;
            }

            function addMarketContractor(data,fila){
                var image="contractor.png";
                var oMarket= new google.maps.Marker({
                    position: new google.maps.LatLng(data.lat,data.lng),
                    map:mapObject,
                    icon:'img/img_maps/'+image,
                    id:fila.ContractorID
                });

                oMarket.addListener('click', function() {
                                infowindow.setContent('<p><b>Name:</b>'+fila.ContNameFirst+' '+fila.ContNameLast+'<br><b>Tel:</b>'+fila.ContPhoneNum+
                                                        '<br><b>Status:</b>'+fila.ContWorkStatus+'</p>');
                                infowindow.open(map, this);
                            });
                return oMarket;
            }

            function removeMarket(idOrder){
                marketrs.map(function(marker) {
                    if(marker.id==idOrder){
                        marker.setVisible(false);
                        marketrs.splice( marketrs.indexOf(marker), 1 );
                    }
                })
                
            }

            function getStatus(status){
                var orderStatus="";
                switch (status) {
                    case "A":
						orderStatus = "Order Open";
						break;
					case "C":
						orderStatus = "Acepted Order";
						break;
                    case "D":
						orderStatus = "Order Assigned";
                        break;
                    case "E":
						orderStatus = "Contractor Just Arrived";
                        break;
                    case "F":
						orderStatus = "Estimate Sent";
                        break;
                    case "G":
						orderStatus = "Estimate Approved";
                        break;
                    case "H":
						orderStatus = "Work In Progress";
                        break;
                    case "I":
						orderStatus = "Work Completed";
                        break;
                    case "J":
						orderStatus = "Final Bill";
                        break;
                    case "K":
						orderStatus = "Order Completed Paid";
                        break;
                    case "Z":
						orderStatus = "Cancel work";
						break;
					case "P":
						orderStatus = "Report In Progress";
						break;
					case "R":
						orderStatus = "Report In Progress";
						break;
					case "S":
						orderStatus = "Report Complete";
						break;

                    default:
						orderStatus = "Undefined";
                }
                return orderStatus;
			}

            /*function getCustomerName(customerFBID){
				var firstName="";
				var lastName="";
				var ref = firebase.database().ref("Customers/"+customerFBID);
					ref.once('value').then(function(snapshot) {
							data=snapshot.val();
							return data.Fname+' '+data.Lname;
						});
				ref=null;
					
			}*/

            function getCustomerName(customerFBID) {
                return new Promise(function (resolve, reject) {
                   
                    var ref = firebase.database().ref("Customers/"+customerFBID);
                    ref.once('value').then(function(snapshot) {
							data=snapshot.val();
							return resolve(data.Fname+' '+data.Lname);
						});
                        //return reject("Undefined");
                    });
                
            }
            function getContractorName(ContractorID) {
                return new Promise(function (resolve, reject) {
                   
                    var ref = firebase.database().ref("Contractors/"+ContractorID);
                    ref.once('value').then(function(snapshot) {
							data=snapshot.val();
							return resolve(data.ContNameFirst+' '+data.ContNameLast);
						});
                        //return resolve("Undefined");
                    });
                
            }

        </script>

        <script>
            var config = {
                apiKey: "AIzaSyCJIT-8FqBp-hO01ZINByBqyq7cb74f2Gg",
                authDomain: "roofadvisorzapp.firebaseapp.com",
                databaseURL: "https://roofadvisorzapp.firebaseio.com",
                projectId: "roofadvisorzapp",
                storageBucket: "roofadvisorzapp.appspot.com",
                messagingSenderId: "480788526390"
            };
            firebase.initializeApp(config);
        </script>


        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&libraries=visualization&callback=initMap">
        </script>
        <br>
       

         
        <div class="table-responsive">          
            <table class="table table-striped table-bordered" id="table_orders_company">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Name/Addr/Phone</th>
                        <th>Description</th>
                        <th>Order Type</th>
                        <th>Status</th>
                        <th>Est Amt</th>
                        <th>Final Amt</th>
                        <th>Payment</th>
                        <th>Contractor</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($_array_orders_to_show as $key => $order) { ?>
                        <tr>
                            <td><?php echo $order['OrderNumber']?></td>
                            <td><?php echo $order['SchDate']?></td>
                            <td><?php echo $order['SchTime']?></td>
                            <td><?php  
                                    $_customerName=$this->_userModel->getNode('Customers/'.$order['CustomerFBID'].'/Fname');
                                    $_customerName.=" ".$this->_userModel->getNode('Customers/'.$order['CustomerFBID'].'/Lname');

                                    $_phone_number=$this->_userModel->getNode('Customers/'.$order['CustomerFBID'].'/Phone');
                                    $_phone_number=str_replace("+1","",$_phone_number);
                                    echo $_customerName.' / '.$order['RepAddress'].' / '.$_phone_number;
                                ?></td>
                            
                            <td><?php echo $order['Hlevels'].", ".$order['Rtype'].", ".$order['Water']?></td>
                            <td><?php 
                                    switch ($order['RequestType']) {
                                        case "E":
                                            echo "Emergency";
                                            break;
                                        case "S":
                                            echo "Schedule";
                                            break;
                                        case "R":
                                            echo "RoofReport";
                                            break;
                                        default:
                                            echo "Undefined";
                                            break;
                                    }
                                ?>
                            </td>
                            <td><?php 
                                switch ($order['Status']) {
                                    case "A":
                                        echo "Order Open";
                                        break;
                                    case "D":
                                        echo "Order Assigned";
                                        break;
                                    case "E":
                                        echo "Contractor Just Arrived";
                                        break;
                                    case "F":
                                        echo "Estimate Sent";
                                        break;
                                    case "G":
                                        echo "Estimate Approved";
                                        break;
                                    case "H":
                                        echo "Work In Progress";
                                        break;
                                    case "I":
                                        echo "Work Completed";
                                        break;
                                    case "J":
                                        echo "Final Bill";
                                        break;
                                    case "K":
                                        echo "Order Completed Paid";
                                        break;
                                    case "C":
                                        echo "Cancel work";
                                        break;
                                    default:
                                        echo "Undefined";
                                        break;
                                }
                                ?>
                            </td>                            

                            <td><?php echo $order['ETA']?></td>
                            <td><?php echo $order['EstAmtMat']?></td>
                            <td><?php echo $order['PaymentType']?></td>
                            <td><?php 
                                    if(!isset($order['ContractorID']) or empty($order['ContractorID'])){ 
                                        if(strcmp($_actual_company['CompanyStatus'],'Active')!==0){
                                        ?>
                                            <a class="btn-danger btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the job"  
												href="#" 
												onClick="alert('You can not take the job until the company is active')"> 
												<span class="glyphicon glyphicon-check"></span>Take work
											</a>
                                <?php }else{ ?>
                                        <a class="btn btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the job"  
												href="#myModalGetWork" 
												onClick="setOrderId('<?php echo $order['FBID']?>')"> 
												<span class="glyphicon glyphicon-check"></span>Take work
											</a>
                                   <?php }
                                    }else{
                                        $_contractorName=$this->_userModel->getNode('Contractors/'.$order['ContractorID'].'/ContNameFirst');
                                        $_contractorName.=" ".$this->_userModel->getNode('Contractors/'.$order['ContractorID'].'/ContNameLast');

                                        echo $_contractorName;
                                    } 
                                    
                                ?>
                            </td>
                            <td>
                            <a class="btn-info btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Invoice Info"  
													href="#" 
													onClick="<?php echo "getInvoices('".$order['FBID']."')" ?>"> 
													<span class="glyphicon glyphicon-list-alt"></span>
										</a>
                            </td>
                           
                           
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div> 
</div>




		<!-- Modal content--> 
        <div class="collapse container" id="companyDashProfile1"> 
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

                                    <label class="control-label">Billing Address 2</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address 2" id="compamnyPayAddress2" name="compamnyPayAddress2" value="<?php echo $_actual_company['PayInfoBillingAddress2'] ?>" />

                                    <label class="control-label">Billing Address (Con't)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address (Con't)" id="compamnyPayAddress2" name="compamnyPayAddress2" value="<?php echo $_actual_company['PayInfoBillingAddress2'] ?>" />

                                    <label class="control-label">Billing Address (Con't)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address (Con't)" id="compamnyPayAddress2" name="compamnyPayAddress2" value="<?php echo $_actual_company['PayInfoBillingAddress2'] ?>" />

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

                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Month" id="compamnyPayMonth" name="compamnyPayMonth" value="<?php echo $_actual_company['PayInfoCCExpMon'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfCredit Card Expiration Year (YYYY)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Year" id="compamnyPayYear" name="compamnyPayYear" value="<?php echo $_actual_company['PayInfoCCExpYr'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">PayInfoCredit Card Number</label>

                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Month (MM)" id="compamnyPayMonth" name="compamnyPayMonth" value="<?php echo $_actual_company['PayInfoCCExpMon'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Credit Card Expiration Year (YYYY)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Year (YYYY)" id="compamnyPayYear" name="compamnyPayYear" value="<?php echo $_actual_company['PayInfoCCExpYr'] ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Credit Card Number</label>

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
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Rating" id="compamnyStatusRating" name="compamnyStatusRating" value="<?php echo $_actual_company['Status_Rating'] ?>" readonly />
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




		<!-- Modal content--> 
<div class="collapse container" id="companyDashEmployee1"> 
			<div class="modal-header"> 
				
				<h4 class="modal-title" id="headerTextDriversCompany">Employee List</h4> 
			</div> 
			<div class="modal-body" id="textAnswerDriversCompany"> 
                <div class="table-responsive">
                <?php if(strcmp($_actual_company['CompanyStatus'],'Active')!==0){?>
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
                                <th>Employee Phone</th>
                                <th>Employee License</th>
                                <th>Employee Email</th>
                                <th>Profile</th>
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
                                    <td><?php if (isset($contractor['ContractorProfile'])){echo $contractor['ContractorProfile'];}else{echo '';}?></td>
                                    <td><?php echo $contractor['ContStatus']?></td>
                                    <td>
                                        <a class="btn-info btn-sm" data-toggle="modal"  
                                            href="#myModal2"  data-toggle1="tooltip"  title="Edit Employee"
                                            onClick=""> 
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                    </td>
                                    <td>
                                    <?php if(strcmp($_actual_company['CompanyStatus'],'Active')!==0){?>
                                        <a href="#" class="inactivate-contractor-button btn-default btn-sm"  data-toggle1="tooltip"  title="Active Employee"
                                            id="inactivate-contractor-button" name="inactivate-contractor-button" 
                                            data-toggle="tooltip" title="Inactive Driver" onclick="alert('You can not active the employee until the company is active')" >
                                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                            </a>
                                    <?php }else{ ?>
                                        <?php if(strcmp($contractor['ContStatus'],"Active")==0){?>
                                            <a href="#" class="inactivate-contractor-button btn-danger btn-sm"  data-toggle1="tooltip"  title="Inactive Employee"
                                             id="inactivate-contractor-button" name="inactivate-contractor-button" 
                                             data-toggle="tooltip" title="Inactive Driver" onclick="disableEnableDriver('<?php echo $contractor['ContractorID']?>','Inactive')">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                        <?php } else{ ?>
                                            <a href="#" class="inactivate-contractor-button btn-success btn-sm" id="inactivate-contractor-button" 
                                            name="inactivate-contractor-button" data-toggle="tooltip" title="Active Driver"   data-toggle1="tooltip"  title="Active Employee"
                                            onclick="disableEnableDriver('<?php echo $contractor['ContractorID']?>','Active')">
                                                <span class="glyphicon glyphicon-ok"></span>
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                    </td>
                                    
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        
                        <a class="btn btn-outline-primary" data-toggle="modal"  
                                            href="#myModalInsertContractor" 
                                            onClick="emptyTextNewDriver()"> 
                                            <span class="glyphicon glyphicon-file"></span>
                                            New Employee
                        </a>
                        
                </div>
            </div> 
			
</div> 




<!-- formulario Modal Actualizar datos-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit Employee Data</h4>
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
                <label for="ContPhoneNumed">Employee Phone</label>
                <input type="text" class="form-control" name="ContPhoneNumed" id="ContPhoneNumed" maxlength="60" required oninvalid="this.setCustomValidity('Por favor ingrese el plazo del cupo')"
                oninput="setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="ContLicenseNumed">Employee License</label>
                <input type="text" class="form-control" name="ContLicenseNumed" id="ContLicenseNumed" maxlength="60" required oninvalid="this.setCustomValidity('Por favor ingrese el plazo del cupo')"
                oninput="setCustomValidity('')">
            </div>
            
            <div class="form-group">
            <label for="ContStatused">Profile</label>
                    <select class="form-control" id="ContProfile" name="ContProfile">
                        <?php foreach ($_profileList as $key => $value1) { ?>
                            <option value="<?php echo $value1 ?>"><?php echo $value1 ?></option>
                        <?php } ?>
                    </select>
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
            <label for="ContStatused">Profile</label>
                    <select class="form-control" id="ContProfileIn" name="ContProfileIn">
                        <?php foreach ($_profileList as $key => $value1) { ?>
                            <option value="<?php echo $value1 ?>"><?php echo $value1 ?></option>
                        <?php } ?>
                    </select>
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
<div class="collapse container" id="scheduleCompany">
            <?php   echo '<h2>June 2018</h2>';
                    $oCalendar=new calendar();
                    echo $oCalendar->draw_controls(6,2018);
                    $_eventsArray=$oCalendar->getEvents(6,2018);
                    echo $oCalendar->draw_calendar(6,2018,$_eventsArray);
            ?>
     
</div><!-- /cierro modal -->

<!-- formulario Insertar contractor datos-->
<div class="modal" id="myModalGetWork" role="dialog" >
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Take work</h4>
      </div>
        <div class="modal-body"  id="myModalGetWorkBody">
            <input type="hidden" value="<?php echo $_actual_company['CompanyID'] ?>" id="companyIDWork" />
            <input type="hidden" value="" id="orderIDWork" />
            <div class="form-group">
                <label for="dateWork">Date for the work</label>
                <input type="text" class="form-control datepickers" name="dateWork" id="dateWork" required >
            </div>
            <div class="form-group">
                <label for="timeWork">Time for the work</label>
                <select name="timeWork" id="timeWork" class="form-control" required>
                    <option value="9:00 am">9:00 am</option>
                    <option value="10:00 am">10:00 am</option>
                    <option value="11:00 am">11:00 am</option>
                    <option value="12:00 pm">12:00 pm</option>
                    <option value="1:00 pm">1:00 pm</option>
                    <option value="2:00 pm">2:00 pm</option>
                    <option value="3:00 pm">3:00 pm</option>
                    <option value="4:00 pm">4:00 pm</option>
                    <option value="5:00 pm">5:00 pm</option>
                </select>
                
            </div>
            <div class="form-group">
                <label for="driverWork">Driver for the work</label>
                <select name="driverWork" id="driverWork" class="form-control" required>
                    <?php foreach ($_array_contractors_to_show as $key => $contractor) {?>
                        <option value="<?php echo $contractor['ContractorID']?>"><?php echo $contractor['ContNameFirst']." ".$contractor['ContNameLast']?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="button" class="btn-primary btn-sm" onClick="takeWork()" >Save</button>
            <button  type="button" class="btn-danger btn-sm" data-dismiss="modal">Cancel</button>
        </div>
    </div><!-- /cierro contenedor -->
  </div><!-- /cierro dialogo-->
</div><!-- /cierro modal -->


<div class="modal fade" id="myMensaje" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerMessage">Modal Header</h4> 
			</div> 
			<div class="modal-body" id="textMessage"> 
				<p >Some text in the modal.</p> 
			</div> 
			<div class="modal-footer" id="buttonMessage"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>


<div class="modal fade" id="myInvoiceInfo" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerMyInvoice">Invoice Info</h4> 
			</div> 
			<div class="modal-body" id="textMyInvoice"> 
				<div class="table-responsive">
					<table class="table table-condensed" id="invoiceInfo">
						<thead>
							<tr>
								<td><strong>Invoice Numbre</strong></td>
								<td class="text-center"><strong>Price</strong></td>
								<td class="text-center"><strong>Date</strong></td>
								<td class="text-center"><strong>Payment Type</strong></td>
								<td class="text-center"><strong>Stripe ID</strong></td>
								<td class="text-center"><strong>View</strong></td>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
				<div id="detailStripe">

				</div>
			</div>

			<div class="modal-footer" id="buttonPayment"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>