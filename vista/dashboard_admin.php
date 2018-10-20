Welcome to RoofServicenow Admin
<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
		<div class="btn-group mr-2" role="group" aria-label="First group">
            <button type="button" class="btn btn-primary active"  data-toggle="collapse" data-target="#mapDashBoard1" onclick="hideShowDivs('companyDashProfile1');hideShowDivs('companyDashBoard');setActiveItemMenu(this);">Orders</button>
            <button type="button" class="btn btn-primary "  data-toggle="collapse" data-target="#companyDashBoard" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('companyDashProfile1');getListCompany('table_list_company');setActiveItemMenu(this);">Company</button>
			<button type="button" class="btn btn-primary "  data-toggle="collapse" data-target="#companyDashProfile1" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('companyDashEmployee1');hideShowDivs('scheduleCompany');setActiveItemMenu(this);">Profile</button>
			<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#companyDashEmployee1" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('companyDashProfile1');hideShowDivs('scheduleCompany');setActiveItemMenu(this);" >Employee</button>
            <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#scheduleCompany" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('companyDashProfile1');hideShowDivs('companyDashEmployee1');setActiveItemMenu(this);">Scheduler</button>
            
            
            
        </div>
        <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Metrics
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a href="" class="list-group-item " onclick="" ><span class="glyphicon glyphicon-file"></span><span ></span><span name="emergencyRepair" class="badge badge-primary" style="background:black;">4</span>Emergency Repair</a>
                    <a href="" class="list-group-item " onclick="" ><span class="glyphicon glyphicon-file"></span><span></span><span  name="scheduleRepair" class="badge badge-primary" style="background:black;">4</span>Schedule Repair</a>
                    <a href="" class="list-group-item " onclick="" ><span class="glyphicon glyphicon-file"></span><span ></span><span name="reportRepair" class="badge badge-primary" style="background:black;">4</span>Report Repair</a>
                    <a href="" class="list-group-item " onclick="" ><span class="glyphicon glyphicon-file"></span><span ></span><span name="repairDone" class="badge badge-primary" style="background:black;">4</span>Repair Done</a>
                    <a href="" class="list-group-item " onclick="" ><span class="glyphicon glyphicon-file"></span><span ></span><span name="repairOpen" class="badge badge-primary" style="background:black;">4</span>Repair Open</a>
                </div>
            </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myFilterWindow" onclick="">Filter Options</button>
        </div>   
        <a href="#" data-toggle="collapse" data-target="#companyDashBoard1" onclick="hideShowDivs('mapDashBoard1');getListCompany('table_list_company');" >Company</a> 
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
                var iconBase = iconBase+'/img/img_maps/';
                

                var geocoder = new google.maps.Geocoder();
                infowindow = new google.maps.InfoWindow();

                //if(address != "" && address != null && address != " "){
                //    geocodeAddress(geocoder,map,address,iconBase);
                //}
                
                

                var ref = firebase.database().ref("Orders");
                ref.once("value", function(snapshot) {

                    datos=snapshot.val();
                    for(k in datos){
                        fila=datos[k];

                        switch (fila.RequestType) {
                            case "E":
                                emergencyRepairCount++;
                                break;
                            case "S":
                                scheduleRepairCount++;
                                break;
                            case "R":
                                reportRepairCount++;
                                break;
                            default:
                        }

                        switch (fila.Status) {
                            case "K":
                                closeService++;
                                break;
                            default:
                                openService++;
                                break;
                        }
                        var marker={
                            lat: parseFloat(fila.Latitude),
                            lng: parseFloat(fila.Longitude),
                            icon: iconBase+'library_maps.png',
                            text: fila.SchDate
                        };
                        var oMarket=addMarket(marker,fila,infowindow);
                        
                        marketrs.push(oMarket);     
                        /*orderOpenContractor.push(fila.ContractorID);
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
                        });*/
                    }
                });

                
                
                // Retrieve new orders as they are added to our database
                ref.limitToLast(1).on("child_added", function(snapshot, prevChildKey) {
                    var newOrder = snapshot.val();
                        row=validateExist(newOrder.OrderNumber)
						if(row==-1){
                                addOrderToTable(newOrder,companyID,map,infowindow,iconBase);
						}                        
                    
                    console.log("Data: " + newOrder);
                    
                });

                // Retrieve new orders as they are added to our database
                ref.on("child_changed", function(snapshot, prevChildKey) {
                    var updateOrder = snapshot.val();
                    
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

                    
                    console.log("Data: " + updateOrder.OrderNumber);
                    
                });

                // Remove orders that are deleted from database
					ref.on("child_removed", function(snapshot) {
					var deletedOrder = snapshot.val();
						row=validateExist(deletedOrder.OrderNumber);
                        if(row>-1){
                            removeOrderOnTable(deletedOrder);
                        }
                    console.log("Data: " + deletedOrder.OrderNumber);
                    
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
                        id:fila.OrderNumber,
                        typeService:fila.RequestType,
                        status:fila.Status
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
                    position: results[0].geometry.location
                    
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
                var companyActions="";
                
                                       

                if(dataOrder.ContractorID=="" || dataOrder.ContractorID==null){
                    if(dataOrder.CompanyStatus!='Acive'){
                        dataContractor='<a class="btn-danger btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the job"'+
                                'href="" '+
                                'onClick="alert(\'You can not take the job until the company is active\')"> '+
                                '<span class="glyphicon glyphicon-check"></span>Take work'+
                                '</a>';
                    }
                        dataContractor='<a class="btn-primary btn-sm" data-toggle="modal"'+
									'href="#myModalGetWork" '+
									'onClick="setOrderId(\''+dataOrder.FBID+'\')"> '+
                                    '<span class="glyphicon glyphicon-check"></span>Take work</a>';
                    
                }else{
                    getContractorName(dataOrder.ContractorID).then(function(contractorName){
                                dataContractor=contractorName; 
                        });
                }

                companyActions='<a class="btn-info btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Invoice Info" '+
                                'href="#" '+ 
                                'onClick="getInvoices(\''+dataOrder.FBID+'\')">'+ 
                                '<span class="glyphicon glyphicon-list-alt"></span>'+
                            '</a>';
                getCustomerData(dataOrder.CustomerFBID).then(function(customerDataX) {  
                    dataCustomer=customerDataX;
                });
                
                    
                companyActions+='<a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+
                                'href="" '+
                                'onClick="getCommentary(\''+dataOrder.FBID+'\')">'+ 
                                '<span class="glyphicon glyphicon-comment"></span>'+
                            '</a>';    
                
                companyActions+='<a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Upload Files" '+ 
                                'href="#" ' +
                                'onClick="getListReportFile(\''+dataOrder.FBID+'\')">'+ 
                                '<span class="glyphicon glyphicon-upload"></span>'+
                            '</a>';
                    
                    
                
                            
                

                t.row.add( [
                        dataOrder.OrderNumber,
                        dataOrder.SchDate,
                        dataOrder.SchTime,
                        dataCustomer,
                        dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water,
                        requestType,
                        status,
                        dataOrder.ETA,
                        dataOrder.EstAmtMat,
                        dataOrder.PaymentType,
                        dataContractor,
                        companyActions,
                    ] ).draw( false );
                
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
                                $row.find("td:eq(10)").html(dataCustomer);
                            }else{
                                getContractorName(dataOrder.ContractorID).then(function(contractorName){
                                    $row.find("td:eq(10)").html(contractorName);
                                });
                            }
                            getCustomerData(dataOrder.CustomerFBID).then(function(customerData) {  
                                $row.find("td:eq(3)").html(customerData);
                            });

                            
                            getCompanyStatus(dataOrder.CompanyID).then(function(companyStatus){
                                companyActions='<a class="btn-info btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Invoice Info" '+
                                    'href="#" '+ 
                                    'onClick="getInvoices(\''+$order['FBID']+'\')">'+ 
                                    '<span class="glyphicon glyphicon-list-alt"></span>'+
                                '</a>';
                                if(companyStatus!="Active"){    
                                companyActions+='<a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+ 
                                                'href="" '+
                                                'onClick="alert(\'You can not create comment until the company is active\')"> '+
                                                '<span class="glyphicon glyphicon-comment"></span>'+
                                                '</a>';
                                }else{ 
                                    if(dataOrder.ContractorID==null || dataOrder.ContractorID==""){ 
                                        companyActions+='<a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+
                                                        'href="" '+
                                                        'onClick="alert(\'You can not create comments to an order that you have not taken\')"> '+
                                                        '<span class="glyphicon glyphicon-comment"></span>'+
                                                    '</a>';
                                    }else{
                                        companyActions+='<a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+
                                                        'href="" '+
                                                        'onClick="getCommentary(\''+dataOrder.FBID+'\')">'+ 
                                                        '<span class="glyphicon glyphicon-comment"></span>'+
                                                    '</a>';    
                                    }
                                    companyActions+='<a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Upload Files" '+ 
                                        'href="#" ' +
                                        'onClick="getListReportFile(\''+dataOrder.FBID+'\')">'+ 
                                        '<span class="glyphicon glyphicon-upload"></span>'+
                                    '</a>';
                                } 
                                $row.find("td:eq(11)").html(companyActions);
                            });

                            $row.find("td:eq(1)").html(dataOrder.SchDate);
                            $row.find("td:eq(2)").html(dataOrder.SchTime);

                            $row.find("td:eq(4)").html(dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water);

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

             function removeMarket(idOrder){
                marketrs.map(function(marker) {
                    if(marker.id==idOrder){
                        marker.setVisible(false);
                        marketrs.splice( marketrs.indexOf(marker), 1 );
                    }
                })                
            }

            function hideShowMarketByTypeServiceAndSatus(listTypeService,listTypeStatus){
                marketrs.map(function(marker) {
                    if(listTypeService.indexOf(marker.typeService)>-1 || listTypeStatus.indexOf(marker.status)>-1){
                        marker.setVisible(true);
                    }else{
                        marker.setVisible(false);
                    }
                })                
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

            function getCustomerData(customerFBID) {
                return new Promise(function (resolve, reject) {
                   
                    var ref = firebase.database().ref("Customers/"+customerFBID);
                    ref.once('value').then(function(snapshot) {
							data=snapshot.val();
							return resolve(data.Fname+' '+data.Lname+' / '+data.Address+' / '+data.Phone);
						});
                        //return reject("Undefined");
                    });
                
            }

            function getCompanyStatus(companyID) {
                return new Promise(function (resolve, reject) {
                   
                    var ref = firebase.database().ref("Company/"+companyID);
                    ref.once('value').then(function(snapshot) {
							data=snapshot.val();
							return resolve(data.CompanyStatus);
						});
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
                        <th>Request Type</th>
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
												href="" 
												onClick="alert('You can not take the job until the company is active')"> 
												<span class="glyphicon glyphicon-check"></span>Take work
											</a>
                                <?php }else{ ?>
                                        <a class="btn-primary btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the job"  
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
                                href="" 
                                onClick="<?php echo "getInvoices('".$order['FBID']."')" ?>"> 
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </a>
                            <?php if(strcmp($_actual_company['CompanyStatus'],'Active')!==0){ ?>
                                <a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments"  
                                    href="" 
                                    onClick="alert('You can not create comment until the company is active')"> 
                                    <span class="glyphicon glyphicon-comment"></span>
                                </a>
                            <?php }else{ 
                                    if(!isset($order['ContractorID']) or empty($order['ContractorID'])){ 
                                ?>
                                    <a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments"  
                                        href="" 
                                        onClick="alert('You can not create comments to an order that you have not taken')"> 
                                        <span class="glyphicon glyphicon-comment"></span>
                                    </a>
                                    <?php }else{ ?>
                                        <a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments"  
                                        href="" 
                                        onClick="<?php echo "getCommentary('".$order['FBID']."')" ?>"> 
                                        <span class="glyphicon glyphicon-comment"></span>
                                    </a>
                            <?php 
                            }} ?>
                            <a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Upload Files"  
                                href="#" 
                                onClick="<?php echo "getListReportFile('".$order['FBID']."')" ?>"> 
                                <span class="glyphicon glyphicon-upload"></span>
                            </a>
                            </td>
                           
                           
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div> 
</div>
    
<div class="collapse container" id="companyDashBoard">
    

        <div class="table-responsive">          
            <table class="table" id="table_list_company">
                <thead>
                <tr>
                    <th>CompanyID</th>
                    <th>ComapnyLicNum</th>
                    <th>Address</th>
                    <th>CompanyEmail</th>
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
                                    <input disabled type="text" class="form-control"  id="companyID" name="companyID" value="" />
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Company Name</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Name" id="compamnyName" name="compamnyName" value="" />
                                </div>

                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" id="firstCompanyName" name="firstCompanyName" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" id="lastCompanyName" name="lastCompanyName" value="" />
                                </div>  
                                <div class="form-group">
                                    <label class="control-label ">Email</label>
                                    <input maxlength="100" disabled type="text" required="required" class="form-control" placeholder="Enter Email" id="companyEmail" name="companyEmail" value=""/>
                                </div> 
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="companyAddress1" name="companyAddress1" value=""/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">City</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="companyAddress2" name="companyAddress2" value=""/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Zip Code</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="companyAddress3" name="companyAddress3" value=""/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Phone number</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter phone number" id="companyPhoneNumber" name="companyPhoneNumber"  value=""/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Company Type</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Type" id="companyType" name="companyType" value=""/>
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
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address 1" id="compamnyPayAddress1" name="compamnyPayAddress1" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Billing Address</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address 2" id="compamnyPayAddress2" name="compamnyPayAddress2" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">City</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter City" id="compamnyPayCity" name="compamnyPayCity" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">State</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter State" id="compamnyPayState" name="compamnyPayState" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Zip Code</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Zip Code" id="compamnyPayZip" name="compamnyPayZip" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Credit Card Expiration Month (MM)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Month" id="compamnyPayMonth" name="compamnyPayMonth" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Credit Card Expiration Year (YYYY)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Year" id="compamnyPayYear" name="compamnyPayYear" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Credit Card Number</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Number" id="compamnyPayCCNum" name="compamnyPayCCNum" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Credit Card CSV</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card CSV" id="compamnyPaySecCode" name="compamnyPaySecCode" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Name on Cred Card</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Name on Cred Card" id="compamnyPayName" name="compamnyPayName" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">First Name on Credit Card</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name on Credit Card" id="compamnyPayFName" name="compamnyPayFName" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Last Name on Credit Card</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name on Credit Card" id="compamnyPayLName" name="compamnyPayLName" value="" />
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
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Insurance Name" id="compamnyAgencyName" name="compamnyAgencyName" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Insurance Agent's Name</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Insurance Agent's Name" id="compamnyAgtName" name="compamnyAgtName" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Insurance Agent's Phone Number</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Insurance Agent's Phone Number" id="compamnyAgtNum" name="compamnyAgtNum" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Insurance Policy Number</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Insurance Policy Number" id="compamnyPolNum" name="compamnyPolNum" value="" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Company Rating</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Rating" id="compamnyStatusRating" name="compamnyStatusRating" value="" />
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
                        <table class="table" id="table_drivers_dashboard_admin" name="table_drivers_dashboard_admin">
                            <thead>
                            <tr>
                                <th>ContractorID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Repair Crew Phone</th>
                                <th>Driver License</th>
                                <th>Driver Email</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Inactive</th>
                            </tr>
                            </thead>
                            <tbody>
                            
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
