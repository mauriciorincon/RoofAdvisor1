
	<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
		<div class="btn-group mr-2" role="group" aria-label="First group">
			<button type="button" class="btn btn-primary active"  data-toggle="collapse" data-target="#mapDashBoard1" onclick="hideShowDivs('customerDashProfile1');hideShowDivs('scheduleCompany');hideShowDivs('mapDashBoardOrder1');setActiveItemMenu(this);">Orders</button>
			<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#mapDashBoardOrder1" onclick="hideShowDivs('customerDashProfile1');hideShowDivs('scheduleCompany');hideShowDivs('mapDashBoard1');setActiveItemMenu(this);setFirstStep()" >New Order</button>
			<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#customerDashProfile1" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('scheduleCompany');hideShowDivs('mapDashBoardOrder1');setActiveItemMenu(this);">Profile</button>
			<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#scheduleCompany" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('customerDashProfile1');hideShowDivs('mapDashBoardOrder1');setActiveItemMenu(this);">Scheduler</button>
		</div>
		<div class="btn-group">
    		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
				Order Metrics <span class="caret"></span></button>
    			<ul class="dropdown-menu" role="menu">
      				<li><a href="#"><span class="badge" id="totalOrdersCustomer">0</span> Total Order Repairs</a></li>
					  <li><a href="#"><span class="badge" id="totalEmergencyRepair">0</span> Emergency Repairs</a></li>
					  <li><a href="#"><span class="badge" id="totalScheduleRepair">0</span> Schedule Repairs</a></li>
					  <li><a href="#"><span class="badge" id="totalEmergencyRepair">0</span> Repairs Pending</a></li>
    			</ul>
  		</div>
		
	</div>

	<br>

		<!-- Dashboard Orders -->
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
				function initialization(){
					
					initMap();
					initMap1();
					
				}
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
					var total_orders=0;
					var total_schedule_orders=0;
					var total_emergengy_orders=0;
					
					var marker="";
					var marketrs=[];
					var infowindow;

					var infowindow = new google.maps.InfoWindow();

					<?php echo 'var iconBase = "'. $_SESSION['application_path'].'"';?>
					

					var iconBase = iconBase+'/img/img_maps/';


					<?php echo 'var customerID = "'. $_actual_customer['CustomerID'].'"';?>

					var ref = firebase.database().ref("Orders");
					ref.orderByChild("CustomerID").equalTo(customerID).once("value", function(snapshot) {

						datos=snapshot.val();
								for(k in datos){
									fila=datos[k];

									var marker={
										lat: parseFloat(fila.Latitude),
										lng: parseFloat(fila.Longitude),
										icon: iconBase+'library_maps.png',
										text: fila.SchDate
									};
									var oMarket=addMarket(marker,map,fila,infowindow);
									marketrs.push(oMarket);

									
									
									total_orders++;
									if(fila.RequestType=='S'){
										total_schedule_orders++;
									}
									if(fila.RequestType=='E'){
										total_emergengy_orders++;
									}
								}
						$("#totalOrdersCustomer").html(total_orders);
						$("#totalEmergencyRepair").html(total_emergengy_orders);
						$("#totalScheduleRepair").html(total_schedule_orders);
						
					console.log(snapshot.val());
					
					});

					// Retrieve new orders as they are added to our database
					ref.limitToLast(1).on("child_added", function(snapshot, prevChildKey) {
						var newOrder = snapshot.val();
						if(newOrder.CustomerID==customerID){
							row=validateExist(newOrder.OrderNumber)
							if(row==-1){
								addOrderToTable(newOrder,customerID,map,infowindow,iconBase);
							}
						}
						console.log("Data: " + newOrder);
						
					});
					// Retrieve orders that are update in database
					ref.on("child_changed", function(snapshot, prevChildKey) {
						var updateOrder = snapshot.val();
						if(updateOrder.CustomerID==customerID){
							row=validateExist(updateOrder.OrderNumber);
							if(row==-1){
								addOrderToTable(updateOrder,customerID,map,infowindow,iconBase);
							}else{
								updateOrderOnTable(updateOrder,row);
							}
						}else{
							row=validateExist(updateOrder.OrderNumber);
							if(row>-1){
								removeOrderOnTable(updateOrder);
							}
						}
						//addOrderToTable(newOrder,companyID);
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
					}else if(fila.Status=='G'){
						image="open_service_g.png";
					}else{
						image="if_sign-error_299045.png";
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

				function addOrderToTable(dataOrder,companyID,map,infowindow,iconBase){
					var t = $('#table_orders_customer').DataTable();
					var requestType=getRequestType(dataOrder.RequestType);
					var status=getStatus(dataOrder.Status);
					var estimateAmount='';
					var finalAmount='';
					var valorTotal=0;
					var actions="";
					if(dataOrder.Status=="F"){
						valorTotal=(parseInt(dataOrder.EstAmtMat)+parseInt(dataOrder.EstAmtTime));
						
						estimateAmount='<a class="btn-warning btn-sm" data-toggle="modal"'+
											'href="#myEstimateAmount" '+
											'onClick="getEstimateAmount(\''+dataOrder.OrderNumber+'\')"> '+
											'<span class="glyphicon glyphicon-check"></span> Aprove Amount:'+valorTotal+
										'</a>';
					}else{
						estimateAmount=(parseInt(dataOrder.EstAmtMat)+parseInt(dataOrder.EstAmtTime));
						estimateAmount = estimateAmount ? estimateAmount : '$0';
					
						
					}
					if(dataOrder.Status=="J"){
						valorTotal=(parseInt(dataOrder.ActAmtMat)+parseInt(dataOrder.ActAmtTime));
						finalAmount='<a class="btn-success btn-sm" data-toggle="modal"'+
											'href="#myFinalAmount" '+
											'onClick="getFinalAmount(\''+dataOrder.OrderNumber+'\')"> '+
											'<span class="glyphicon glyphicon-check"></span> Aprove Amount:'+valorTotal+
										'</a>';
					}else{
						finalAmount=parseInt(dataOrder.ActAmtMat)+parseInt(dataOrder.ActAmtTime);
						finalAmount = finalAmount ? finalAmount : '$0';
					}
					
					if(dataOrder.Status=="A" || dataOrder.Status=="D" || dataOrder.Status=="E" || dataOrder.Status=="F" || dataOrder.Status=="P"){
						actions='<a class="btn-danger btn-sm" data-toggle="modal" '+  
								'href="" '+
								'onClick="cancelService(\''+dataOrder.FBID+'\',\'Status,Z\')">'+
								'<span class="glyphicon glyphicon-trash"></span> '+
							'</a>';
					}else{
						actions='<a class="btn-default btn-sm" data-toggle="modal" '+  
									'href="" '+
									'onClick="alert(\'Order cant be cancel\')">'+
									'<span class="glyphicon glyphicon-trash"></span> '+
								'</a>';
					}
					actions+='<a class="btn-primary btn-sm" data-toggle="modal" '+
								'href="#myScheduleChange" '+
								'onClick="getOrderScheduleDateTime(\''+dataOrder.OrderNumber+'\')"> '+ 
								'<span class="glyphicon glyphicon-calendar"></span> '+
							'</a>';
					if(dataOrder.Status=="S" || dataOrder.Status=="K"){
						actions+='<a class="btn-warning btn-sm" data-toggle="modal" '+
									'href="#myRatingScore" '+
									'onClick="setOrderSelected(\''+dataOrder.OrderNumber+'\',\''+dataOrder.FBID+'\')"> '+ 
									'<span class="glyphicon glyphicon-star"></span>'+
								'</a>';
					}else{
						actions+='<a class="btn-default btn-sm" data-toggle="modal" '+
									'href="" '+
									'onClick="alert(\'Order must be complete to make rating\')">'+ 
									'<span class="glyphicon glyphicon-star-empty"></span>'+
								'</a>';
					}
					actions+='<a class="btn-info btn-sm" data-toggle="modal" '+
								'href="" '+
								'onClick="getInvoices(\''+dataOrder.FBID+'\')"> '+
								'<span class="glyphicon glyphicon-list-alt"></span>'+
							'</a>';
					if(dataOrder.RequestType=='E'){
						dateValue=dataOrder.ETA.substring(0,10);
						timeValue=dataOrder.ETA.substring(11,20);
					}else{
						dateValue=dataOrder.SchDate;	
						timeValue=dataOrder.SchTime;
					}
					estimateAmount = estimateAmount ? estimateAmount : '$0';
					finalAmount = finalAmount ? finalAmount : '$0';
					getCompanyName(dataOrder.CompanyID,dataOrder.OrderNumber);
					getContractorName(dataOrder.ContractorID,dataOrder.OrderNumber)
					t.row.add( [
							dataOrder.OrderNumber,
							requestType,
							dataOrder.RepAddress,
							dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water,
							status,
							dataOrder.SchDate,
							dataOrder.SchTime,
							estimateAmount,
							finalAmount,
							'',
							'',
							actions
						] ).draw( );
						
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

				function updateOrderOnTable(dataOrder,numberRow){
					var orderID = dataOrder.OrderNumber;
					//var t = $('#table_orders_customer').DataTable();
					
					var value = orderID;
					var t = $('#table_orders_customer').DataTable();
					var row=t.rows( function ( idx, data, node ) {
						return data[0] === value;
					} ).indexes();

					var $row = t.row(row);

					var requestType=getRequestType(dataOrder.RequestType);
					var status=getStatus(dataOrder.Status);
					var companyName="Undefined";
					var contractorName="Undefined";
					var estimateAmount='';
					var finalAmount='';
					var valorTotal=0;
					var actions="";
					if(dataOrder.Status=="A" || dataOrder.Status=="D" || dataOrder.Status=="E" || dataOrder.Status=="F" || dataOrder.Status=="P"){
						actions='<a class="btn-danger btn-sm" data-toggle="modal" '+  
								'href="" '+
								'onClick="cancelService(\''+dataOrder.FBID+'\',\'Status,Z\')">'+
								'<span class="glyphicon glyphicon-trash"></span> '+
							'</a>';
					}else{
						actions='<a class="btn-default btn-sm" data-toggle="modal" '+  
									'href="" '+
									'onClick="alert(\'Order cant be cancel\')">'+
									'<span class="glyphicon glyphicon-trash"></span> '+
								'</a>';
					}
					/*actions+='<a class="btn-success btn-sm" data-toggle="modal" '+ 
								'href="#myPayment" '+
								'onClick="showChargePayment(\''+dataOrder.StripeID+'\')"> '+  
								'<span class="glyphicon glyphicon-usd"></span> '+
							'</a>';*/
					actions+='<a class="btn-primary btn-sm" data-toggle="modal" '+
								'href="#myScheduleChange" '+
								'onClick="getOrderScheduleDateTime(\''+dataOrder.OrderNumber+'\')"> '+ 
								'<span class="glyphicon glyphicon-calendar"></span> '+
							'</a>';
					if(dataOrder.Status=="S" || dataOrder.Status=="K"){
						actions+='<a class="btn-warning btn-sm" data-toggle="modal" '+
									'href="#myRatingScore" '+
									'onClick="setOrderSelected(\''+dataOrder.OrderNumber+'\',\''+dataOrder.FBID+'\')"> '+ 
									'<span class="glyphicon glyphicon-star"></span>'+
								'</a>';
					}else{
						actions+='<a class="btn-default btn-sm" data-toggle="modal" '+
									'href="" '+
									'onClick="alert(\'Order must be complete to make rating\')">'+ 
									'<span class="glyphicon glyphicon-star-empty"></span>'+
								'</a>';
					}
					actions+='<a class="btn-info btn-sm" data-toggle="modal" '+
								'href="" '+
								'onClick="getInvoices(\''+dataOrder.FBID+'\')"> '+
								'<span class="glyphicon glyphicon-list-alt"></span>'+
							'</a>';
							

					if(dataOrder.Status=="F"){
						valorTotal=(parseInt(dataOrder.EstAmtMat)+parseInt(dataOrder.EstAmtTime));
						estimateAmount='<a class="btn-warning btn-sm" data-toggle="modal"'+
											'href="#myEstimateAmount" '+
											'onClick="getEstimateAmount(\''+dataOrder.OrderNumber+'\')"> '+
											'<span class="glyphicon glyphicon-check"></span>Aprove Amount:'+valorTotal+
										'</a>';
					}else{

						estimateAmount=(parseInt(dataOrder.EstAmtMat)+parseInt(dataOrder.EstAmtTime));
						estimateAmount = estimateAmount ? estimateAmount : '$0';
					}
					if(dataOrder.Status=="J"){
						valorTotal=(parseInt(dataOrder.ActAmtMat)+parseInt(dataOrder.ActAmtTime));
						finalAmount='<a class="btn-success btn-sm" data-toggle="modal"'+
											'href="#myFinalAmount" '+
											'onClick="getFinalAmount(\''+dataOrder.OrderNumber+'\')"> '+
											'<span class="glyphicon glyphicon-check"></span>Aprove Amount:'+valorTotal+
										'</a>';
					}else{
						finalAmount=(parseInt(dataOrder.ActAmtMat)+parseInt(dataOrder.ActAmtTime));
						finalAmount = finalAmount ? finalAmount : '$0';
					}

					/*$("#table_orders_customer tr").each(function(index) {
							
							if (index !== 0) {
								$row = $(this);
								var id = $row.find("td:eq(0)").text();
								if (id.indexOf(orderID) !== 0) {
									
								}
								else {
									$row.find("td:eq(1)").text(requestType);
									$row.find("td:eq(2)").text(dataOrder.RepAddress);
									$row.find("td:eq(3)").text(dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water);
									$row.find("td:eq(4)").text(status);
									if(dataOrder.RequestType=='E'){
										$row.find("td:eq(5)").text(dataOrder.ETA.substring(0,10));
										$row.find("td:eq(6)").text(dataOrder.ETA.substring(11,20));
									}else{
										$row.find("td:eq(5)").text(dataOrder.SchDate);	
										$row.find("td:eq(6)").text(dataOrder.SchTime);
									}
									estimateAmount = estimateAmount ? estimateAmount : '$0';
									$row.find("td:eq(7)").text(estimateAmount);
									finalAmount = finalAmount ? finalAmount : '$0';
									$row.find("td:eq(8)").text(finalAmount);
									var companyName="";
									var ref = firebase.database().ref("Company/"+dataOrder.CompanyID+"/CompanyName");
									ref.on('value', function(snapshot) {
										companyName=snapshot.val();
										//console.log(companyName);
										$row.find("td:eq(9)").text(companyName);
									});
									
									var firstName="";
									var lastName="";
									//Contractors/CN0008/ContNameFirst
									//var path="Contractors/"+dataOrder.ContractorID+"/ContNameFirst";
									var path="Contractors/"+dataOrder.ContractorID;
									var ref = firebase.database().ref(path);
										ref.on('value', function(snapshot) {
											data=snapshot.val();
											$row.find("td:eq(10)").text(data.ContNameFirst+' '+data.ContNameLast);
										});
									
									$row.find("td:eq(11)").text(actions);
									return false;
								}
							}
						});*/

					
					
					$row.cell($row, 1).data(requestType).draw();
					$row.cell($row, 2).data(dataOrder.RepAddress).draw();
					$row.cell($row, 3).data(dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water).draw();
					$row.cell($row, 4).data(status).draw();
					if(dataOrder.RequestType=='E'){
						$row.cell($row, 5).data(dataOrder.ETA.substring(0,10)).draw();
						$row.cell($row, 6).data(dataOrder.ETA.substring(11,20)).draw();
					}else{
						$row.cell($row, 5).data(dataOrder.SchDate).draw();	
						$row.cell($row, 6).data(dataOrder.SchTime).draw();
					}
					estimateAmount = estimateAmount ? estimateAmount : '$0';
					$row.cell($row, 7).data(estimateAmount).draw();
					finalAmount = finalAmount ? finalAmount : '$0';
					$row.cell($row, 8).data(finalAmount).draw();
					var companyName="";
					var ref = firebase.database().ref("Company/"+dataOrder.CompanyID+"/CompanyName");
					ref.on('value', function(snapshot) {
						companyName=snapshot.val();
						//console.log(companyName);
						$row.cell($row, 9).data(companyName).draw();
					});
					//$row.cell($row, 9).data(getCompanyName(dataOrder.CompanyID)).draw();

					var firstName="";
					var lastName="";
					//Contractors/CN0008/ContNameFirst
					//var path="Contractors/"+dataOrder.ContractorID+"/ContNameFirst";
					var path="Contractors/"+dataOrder.ContractorID;
					var ref = firebase.database().ref(path);
						ref.on('value', function(snapshot) {
							data=snapshot.val();
							$row.cell($row, 10).data(data.ContNameFirst+' '+data.ContNameLast).draw();
						});
					
					//$row.cell($row, 10).data(contractorName).draw();
					$row.cell($row, 11).data(actions).draw();

					
					
					
					
							
				}

				function removeOrderOnTable(dataOrder){
					var value = dataOrder.OrderNumber;
					var t = $('#table_orders_customer').DataTable();
					t.rows( function ( idx, data, node ) {
						return data[0] === value;
					} )
					.remove()
					.draw();
            	}


				function validateExist(orderID){
				
					/*var value = orderID;
					var t = $('#table_orders_customer').DataTable();
					var row=t.rows( function ( idx, data, node ) {
						return data[0] === value;
					} ).indexes();
					alert(row);*/
					

						var value = orderID;
						var flag=false;
						var count=-1;
						$("#table_orders_customer tr").each(function(index) {
							
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
			
			function getCompanyName(companyID,orderID){
				
					var ref = firebase.database().ref("Company/"+companyID+"/CompanyName");
					ref.once('value').then(function(snapshot) {
						value=snapshot.val();
						//$("#table_orders_customer tr:last").find("td:eq(9)").text(snapshot.val());
						
						$("#table_orders_customer tr").each(function(index) {
							
							if (index !== 0) {
								$row = $(this);
								var id = $row.find("td:eq(0)").text();
								if (id.indexOf(orderID) !== 0) {
									
								}
								else {
									$row.find("td:eq(9)").text(value);
									return false;
								}
							}
						});
					}, function(error) {
						// The callback failed.
						console.error(error);
					});
			
				
			}
			function getContractorName(contractorID,orderID){
				var firstName="";
				var lastName="";
				var ref = firebase.database().ref("Contractors/"+contractorID);
					ref.once('value').then(function(snapshot) {
							data=snapshot.val();
							//$("#table_orders_customer tr:last").find("td:eq(10)").text(data.ContNameFirst+' '+data.ContNameLast);

							$("#table_orders_customer tr").each(function(index) {
							
								if (index !== 0) {
									$row = $(this);
									var id = $row.find("td:eq(0)").text();
									if (id.indexOf(orderID) !== 0) {
										
									}
									else {
										$row.find("td:eq(10)").text(data.ContNameFirst+' '+data.ContNameLast);
										return false;
									}
								}
							});

						});
				ref=null;
					
			}

			function updateOrderInfo(orderID,fieldNumber,value){
				row=validateExist(orderID);
				var t = $('#table_orders_customer').DataTable();	
				var $row = t.row(row);
				$row.cell($row, fieldNumber).data(value).draw();

			}
			</script>

			<script>
			// Initialize Firebase
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





			<br>
			<div class="table-responsive">          
				<table class="table table-striped table-bordered" id="table_orders_customer">
					<thead>
					<tr>
						<th>Order ID</th>
						<th>Order Type</th>
						<th>Address</th>
						<th>Description</th>
						<th>Status</th>
						<th>Date</th>
						<th>Time</th>
						<th>Estimate Amount</th>
                    	<th>Total Final Amount</th>
						<th>Company</th>
						<th>Driver</th>
						<th>Actions</th>
					</tr>
					</thead>
					<tbody>
						<?php foreach ($_array_customer_to_show as $key => $order) { ?>
							<tr>
								<td><?php echo $order['OrderNumber']?></td>
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
								<td><?php if(isset($order['RepAddress'])){echo $order['RepAddress'];} ?></td>
								<td><?php echo $order['Hlevels'].", ".$order['Rtype'].", ".$order['Water']?></td>
								<td><?php 
										switch ($order['Status']) {
											case "A":
												echo "Order Open";
												break;
											case "C":
												echo "Acepted Order";
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
											case "Z":
												echo "Cancel work";
												break;
											case "P":
												echo "Report In Progress";
												break;
											case "R":
												echo "Report In Progress";
												break;
											case "S":
												echo "Report Complete";
												break;
											default:
												echo "Undefined";
												break;
										}
									?>
								</td> 
								<td><?php 
										if(strcmp($order['RequestType'],"E")==0){
											echo substr($order['ETA'],0,10);
										}else{
											echo $order['SchDate'];
										}
										
									?>
								</td>                            
								<td><?php 
										if(strcmp($order['RequestType'],"E")==0){
											echo substr($order['ETA'],11,8);
										}else{
											echo $order['SchTime'];
										}
										
									?>
								</td>
								<td align="right"><?php 
										if($order['Status']=='F'){
									?>
											<a class="btn-warning btn-sm" data-toggle="modal"  
												href="#myEstimateAmount" 
												onClick="getEstimateAmount('<?php echo $order['OrderNumber']?>')"> 
												<span class="glyphicon glyphicon-check"></span> Aprove Amount: <?php echo "$".(intval($order['EstAmtMat'])+intval($order['EstAmtTime'])); ?> 
											</a>
									<?php
										}else{
											echo "$".(intval($order['EstAmtMat'])+intval($order['EstAmtTime']));
										}
										
									?>
								</td>                            
								<td align="right"><?php 
										if($order['Status']=='J'){											
									?>
										<a class="btn-success btn-sm" data-toggle="modal"  
												href="#myFinalAmount" 
												onClick="getFinalAmount('<?php echo $order['OrderNumber']?>')"> 
												<span class="glyphicon glyphicon-check"></span> Aprove Amount: <?php echo "$".(intval($order['ActAmtMat'])+intval($order['ActAmtTime'])); ?> 
											</a>
									<?php
										}else{
											echo "$".(intval($order['ActAmtMat'])+intval($order['ActAmtTime']));
										}
									?>
								</td>
								<td><?php if(isset($order['CompanyID'])){
											if(!isset($this->_userModel)){
												$this->_userModel=new userModel();
											}
											$_company_name=$this->_userModel->getNode('Company/'.$order['CompanyID'].'/CompanyName');
											echo $_company_name;
										}else{
										echo '';

										
									}?></td>
								<td><?php if(isset($order['ContractorID'])){
											if(!empty($order['ContractorID'])){
												if(!isset($this->_userModel)){
													$this->_userModel=new userModel();
												}
												$_driver_first=$this->_userModel->getNode('Contractors/'.$order['ContractorID'].'/ContNameFirst');
												$_driver_last=$this->_userModel->getNode('Contractors/'.$order['ContractorID'].'/ContNameLast');
												echo $_driver_first.' '.$_driver_last;
											}else{
												echo "";
											}
											echo "";
										}
									?></td>
								<td>
									<?php if(strcmp($order['Status'],"A")==0 or strcmp($order['Status'],"D")==0 or strcmp($order['Status'],"E")==0 or strcmp($order['Status'],"F")==0 or strcmp($order['Status'],"P")==0){?>

										<a class="btn-danger btn-sm" data-toggle="modal"  
											href="" 
											onClick="<?php echo "cancelService('".$order['FBID']."','Status,Z')"; ?>" > 
											<span class="glyphicon glyphicon-trash"></span>
										</a>
									<?php }else{ ?>
										<a class="btn-default btn-sm" data-toggle="modal"  
											href="" 
											onClick="alert('Order can\'t be cancel')" > 
											<span class="glyphicon glyphicon-trash"></span>
										</a>
									<?php } ?>
									<!--<a class="btn-success btn-sm" data-toggle="modal"  
										href="#myPayment" 
										onClick="" > 
										<span class="glyphicon glyphicon-usd"></span>
									</a>-->
									<a class="btn-primary btn-sm" data-toggle="modal"  
												href="#myScheduleChange" 
												onClick="<?php echo "getOrderScheduleDateTime('".$order['OrderNumber']."')" ?>"> 
												<span class="glyphicon glyphicon-calendar"></span>
									</a>
									<?php if(strcmp($order['Status'],"S")==0 or strcmp($order['Status'],"K")==0){ ?>
										<a class="btn-warning btn-sm" data-toggle="modal"  
													href="#myRatingScore" 
													onClick="<?php echo "setOrderSelected('".$order['OrderNumber']."','".$order['FBID']."')" ?>"> 
													<span class="glyphicon glyphicon-star"></span>
										</a>
									<?php }else{ ?>
										<a class="btn-default btn-sm" data-toggle="modal"  
													href="" 
													onClick="alert('Order must be complete to make rating')" > 
													<span class="glyphicon glyphicon-star-empty"></span>
										</a>
									<?php } ?>
								

										<a class="btn-info btn-sm" data-toggle="modal"  
													href="" 
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
		</div>

		<!-- Dashboard Profile -->
		<div class="collapse container" id="customerDashProfile1">
                <div class="form-group">
                    <label class="control-label">First Name</label>
                    <input  type="text" class="form-control" required="required" placeholder="Enter First Name" id="firstCustomerNameProfile" name="firstCustomerNameProfile" value="<?php echo $_actual_customer['Fname'] ?>" />
                </div> 
                <div class="form-group">
                    <label class="control-label">Last Name</label>
                    <input type="text" class="form-control" required="required"  placeholder="Enter Last Name" id="lastCustomerNameProfile" name="lastCustomerNameProfile"  value="<?php echo $_actual_customer['Lname'] ?>"/>
                </div>  
                <div class="form-group">
                    <label class="control-label ">Email</label>
                    <input type="text" class="form-control" required="required" readonly  placeholder="Enter Email" id="emailValidationProfile" name="emailValidationProfile" value="<?php echo $_actual_customer['Email'] ?>"/>
                </div> 
                <div class="form-group">
                    <label class="control-label">Address</label>
                    <input type="text" class="form-control" required="required"  placeholder="Enter address" id="customerAddressProfile" name="customerAddressProfile" value="<?php echo $_actual_customer['Address'] ?>"/>
                </div>
                <div class="form-group">
                    <label class="control-label">City</label>
                    <input type="text" class="form-control" required="required" placeholder="Enter city" id="customerCityProfile" name="customerCityProfile" value="<?php echo $_actual_customer['City'] ?>"/>
                </div> 
                <div class="form-group">
					<label class="control-label">State</label>
					<select id="customerStateProfile" name="customerStateProfile" required="required" class="form-control" placeholder="Select state" value="<?php echo $_actual_customer['State'] ?>">
                            <?php foreach ($_array_state as $key => $value1) { 
								if(strcmp($_actual_customer['State'],$value1)==0){?>
									<option value="<?php echo $value1 ?>" selected="selected"><?php echo $value1 ?></option>
								<?php }else{ ?>
									<option value="<?php echo $value1 ?>"><?php echo $value1 ?></option>
								<?php } ?>
                            <?php } ?>
						</select>
                </div>
                <div class="form-group">
                    <label class="control-label">Zip code</label>
                    <input type="text" class="form-control" required="required"  placeholder="Enter zip code" id="customerZipCodeProfile" name="customerZipCodeProfile"  value="<?php echo $_actual_customer['ZIP'] ?>"/>
                </div> 
                <div class="form-group">
                    <label class="control-label">Phone number</label>
                    <input type="text" class="form-control" required="required"  placeholder="Enter phone number" id="customerPhoneNumberProfile" name="customerPhoneNumberProfile"  value="<?php echo $_actual_customer['Phone'] ?>"/>
                </div>  
                <button type="button" class="btn-primary btn-sm" onClick="updateDataCustomer('<?php echo $_actual_customer['FBID']?>')" >Update Info</button>
            </div>
		</div>

		<!-- Dashboard Schedule -->
		<div class="collapse container" id="scheduleCompany">
            <?php   $_year=date("Y");
                    $_month=date("m");
                    echo "<h2>$_month $_year </h2>";
                    
                    $oCalendar=new calendar();
                    echo $oCalendar->draw_controls($_month,$_year);
                    if(strlen($_month)==1){
                        $_eventsArray=$oCalendar->getEvents("0".$_month,$_year);
                    }else{
                        $_eventsArray=$oCalendar->getEvents($_month,$_year);
                    }
                    //print_r($_eventsArray);
                    echo $oCalendar->draw_calendar($_month,$_year,$_eventsArray);

            ?>
		</div>

		<!-- Dashboard New Order -->
        <div class="collapse" id="mapDashBoardOrder1">
			<?php 

				include('vista/order_request.php');
				//echo $order_request
			?>
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


<div class="modal fade" id="myMensaje" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerTextAnswerOrder">Order Update</h4> 
			</div> 
			<div class="modal-body" id="textAnswerOrder"> 
				<p >Some text in the modal.</p> 
			</div> 
			<div class="modal-footer" id="buttonAnswerOrder"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myPayment" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerTextPayment">Playment Info</h4> 
			</div> 
			<div class="modal-body" id="textPayment"> 
				<p >Some text in the modal.</p> 
			</div> 
			<div class="modal-footer" id="buttonPayment"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myScheduleChange" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerScheduleChange">Change Schedule Order ID: </h4> 
			</div> 
			<div class="modal-body" id="textSchedule"> 
				<input type="hidden" value="" id="orderIDChangeSchedule" />
				<table>
					<tr><td>New Date</td><td><input type="text" id="newDateSchedule" name="newDateSchedule" class="datepicker"></td></tr>
					<tr><td>New Time</td><td>
						<select id="newTimeSchedule">
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
					</td></tr>
				</table>
			</div> 
			<div class="modal-footer" id="buttonSchedule"> 
				<button type="button" class="btn-primary btn-sm" onClick="changeSchedule()" >Update Info</button>
				<button type="button" class="btn-danger btn-sm"  data-dismiss="modal">Close</button>
				
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myEstimateAmount" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerEstimateAmount">Confirm Estimate Amount</h4> 
			</div> 
			<div class="modal-body" id="textEstimateAmount"> 
				<input type="hidden" value="" id="orderID" />
				<!-- <table>
					<tr><td>Order ID</td><td><input type="text" value="" id="estimatedAmountOrderID" readonly></td></tr>
					<tr><td>Estimate Time</td><td><input type="text" value="" id="estimatedTime" readonly></td></tr>
					<tr><td>Estimate Amount Materials</td><td><input type="text" value="" id="estimatedAmountMaterials" readonly></td></tr>
					<tr><td>Estimate Amount Time</td><td><input type="text" value="" id="estimatedAmountTime" readonly></td></tr>
					<tr><td><b>Total Amount</b></td><td><input type="text" value="" id="totalEstimatedAmount" readonly></td></tr>
					
				</table>--> 

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><strong>Order Summary</strong></h3>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-condensed" id="estimatedAmountTable">
										<thead>
											<tr>
												<td><strong>Item</strong></td>
												<td class="text-center"><strong>Price</strong></td>
												<td class="text-center"><strong>Quantity</strong></td>
												<td class="text-right"><strong>Totals</strong></td>
											</tr>
										</thead>
										<tbody>
											<!-- foreach ($order->lineItems as $line) or some such thing here -->
											<tr>
												<td>Estimate Amount Materials</td>
												<td class="text-center">$00.00</td>
												<td class="text-center">1</td>
												<td class="text-right">$00.00</td>
											</tr>
											<tr>
												<td>Estimate Amount Time</td>
												<td class="text-center">$00.00</td>
												<td class="text-center">1</td>
												<td class="text-right">$00.00</td>
											</tr>
											
											<tr>
												<td class="thick-line"></td>
												<td class="thick-line"></td>
												<td class="thick-line text-center"><strong>Subtotal</strong></td>
												<td class="thick-line text-right">$00.00</td>
											</tr>
											<tr>
												<td class="no-line"></td>
												<td class="no-line"></td>
												<td class="no-line text-center"><strong>Total</strong></td>
												<td class="no-line text-right">$00.00</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div> 
			<div class="modal-footer" id="buttonEstimateAmount"> 
				<button type="button" class="btn-primary btn-sm" onClick="acceptEstimateAmount()" >Accept</button>
				<button type="button" class="btn-danger btn-sm"  onClick="refuseEstimateAmount()">Decline</button>
				
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myFinalAmount" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerEstimateAmount">Confirm Final Amount</h4> 
			</div> 
			<div class="modal-body" id="textSchedule"> 
				<input type="hidden" value="" id="orderIDFinal" />
				<!--<table>
					<tr><td>Order ID</td><td><input type="text" value="" id="finalAmountOrderID" readonly></td></tr>
					<tr><td>Final Amount Materials</td><td><input type="text" value="" id="finalAmountMaterials" readonly></td></tr>
					<tr><td>Final Amount Time</td><td><input type="text" value="" id="finalAmountTime" readonly></td></tr>
					<tr><td>Final Time</td><td><input type="text" value="" id="finalime" readonly></td></tr>
				</table>-->

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><strong>Order summary</strong></h3>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-condensed" id="totalAmountTable">
										<thead>
											<tr>
												<td><strong>Item</strong></td>
												<td class="text-center"><strong>Price</strong></td>
												<td class="text-center"><strong>Quantity</strong></td>
												<td class="text-right"><strong>Totals</strong></td>
											</tr>
										</thead>
										<tbody>
											<!-- foreach ($order->lineItems as $line) or some such thing here -->
											<tr>
												<td>Final Amount Materials</td>
												<td class="text-center">$00.00</td>
												<td class="text-center">1</td>
												<td class="text-right">$00.00</td>
											</tr>
											<tr>
												<td>Final Amount Time</td>
												<td class="text-center">$00.00</td>
												<td class="text-center">1</td>
												<td class="text-right">$00.00</td>
											</tr>
											
											<tr>
												<td class="thick-line"></td>
												<td class="thick-line"></td>
												<td class="thick-line text-center"><strong>Subtotal</strong></td>
												<td class="thick-line text-right">$00.00</td>
											</tr>
											<tr>
												<td class="no-line"></td>
												<td class="no-line"></td>
												<td class="no-line text-center"><strong>Total</strong></td>
												<td class="no-line text-right">$00.00</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div> 
			<div class="modal-footer" id="buttonEstimateAmount"> 
				<button type="button" class="btn-primary btn-sm" onClick="acceptFinalAmount()" >Accept</button>
				<button type="button" class="btn-danger btn-sm"  onClick="refuseFinalAmount()">Decline</button>
				
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myPaymentType" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerPaymentType">How do you prefer to pay</h4> 
			</div> 
			<div class="modal-body" id="PaymentType"> 
				<input type="hidden" value="" id="orderIDPaymentType" />
				<div class="form-group">
				<label for="ContStatused">Payment Type</label>
					<div class="radio">
						<label><input type="radio" name="selectPaymnetType" id="selectPaymnetType" value="cash" checked>Cash</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="selectPaymnetType" id="selectPaymnetType" value="check" >Check</label>
					</div>
					<div class="radio disabled">
						<label><input type="radio" name="selectPaymnetType" id="selectPaymnetType" value="online">Online</label>
					</div>

					
					<!--<select id="selectPaymnetType" class="form-control" name="selectPaymnetType">
						<option value="cash">Cash</option>
						<option value="check">Check</option>
						<option value="online">Online</option>
					</select>-->
				</div>
				
			</div> 
			<div class="modal-footer" id="buttonPaymentType"> 
				<button type="button" class="btn-primary btn-sm" onClick="selectPaymentType()" >Accept</button>
				<button type="button" class="btn-danger btn-sm"  data-dismiss="modal">Close</button>
				
				
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myRatingScore" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerPaymentType">Rate your overall experience Order <b><span id="orderRatingId"></span></b></h4> 
			</div> 
			<div class="modal-body" id="PaymentType"> 
				<input type="hidden" value="" id="orderIDRating" />
				<input type="hidden" value="" id="orderFBID" />
				<div class="form-group">
					<label for="ratingQuestion">Would you like to recommend the service company?</label>
					<div class="radio">
						<label><input type="radio" name="ratingYesNo" id="ratingYesNo" value="Yes" >Yes</label>
					</div>
					<div class="radio disabled">
						<label><input type="radio" name="ratingYesNo" id="ratingYesNo" value="No">No</label>
					</div>
				</div>

				<div class="form-group">
					<label for="ratingQuestion">How would you rate the service company?</label>
					<div class="votable hide">
						<i class="fa fa-3x fa-star-o" data-vote-type="1"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="2"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="3"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="4"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="5"></i>
						
					</div>
					<div class="voted">
						<i class="fa fa-3x fa-star-o" data-vote-type="1"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="2"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="3"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="4"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="5"></i>
						
					</div>
					<i><label id="ratingCompany">Rating: 0</label></i>
				</div> 
				<div class="form-group">
					<label for="ratingQuestion">How would you rate the service professional?</label>
					<div class="votable1 hide">
						<i class="fa fa-3x fa-star-o" data-vote-type="1"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="2"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="3"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="4"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="5"></i>
					</div>
					<div class="voted1">
						<i class="fa fa-3x fa-star-o" data-vote-type="1"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="2"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="3"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="4"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="5"></i>
					</div>
					<i><label id="ratingProfessional">Rating: 0</label></i>
				</div> 
				<div class="form-group">
					<label for="ratingQuestion">What else would you like others to know?</label>
					<input type="text" class="form-control" id="ratingObservation" placeholder="What else would you like others to know?"/>
				</div>
				<div class="modal-footer" id="buttonPaymentType"> 
					<button type="button" class="btn-primary btn-sm" id="buttonRating" onClick="insertOrderRating()" >Rating</button>
					<button type="button" class="btn-danger btn-sm"  data-dismiss="modal">Close</button>
				</div> 
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
								<td class="text-center"><strong>Stripe ID</strong></td>
								<td class="text-center"><strong>View</strong></td>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div> 
			<div class="modal-footer" id="buttonPayment"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>