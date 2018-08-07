
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
					ref.orderByChild("CustomerID").equalTo(<?php echo $_actual_customer['CustomerID'] ?>).once("value", function(snapshot) {

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
							if(validateExist(newOrder.OrderNumber)==false){
								addOrderToTable(newOrder,customerID,map,infowindow,iconBase);
							}
						}
						console.log("Data: " + newOrder);
						
					});
					// Retrieve orders that are update in database
					ref.on("child_changed", function(snapshot, prevChildKey) {
						var updateOrder = snapshot.val();
						if(updateOrder.CustomerID==customerID){
							if(validateExist(updateOrder.OrderNumber)==false){
								addOrderToTable(updateOrder,customerID,map,infowindow,iconBase);
							}else{
								updateOrderOnTable(updateOrder);
							}
						}
						//addOrderToTable(newOrder,companyID);
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
					companyName=getCompanyName(dataOrder.CompanyID);
					contractorName=gerContractorName(dataOrder.ContractorID);
					t.row.add( [
							dataOrder.OrderNumber,
							requestType,
							dataOrder.RepAddress,
							dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water,
							status,
							dataOrder.SchDate,
							dataOrder.SchTime,
							dataOrder.ETA,
							dataOrder.EstAmtMat,
							companyName,
							contractorName,
							'<a class="btn-danger btn-sm" data-toggle="modal"  href="" onClick="updateOrder("'+
							dataOrder.FBID+
							'","Status,C")" > <span class="glyphicon glyphicon-trash"></span></a>'+
							'<a class="btn-success btn-sm" data-toggle="modal" href="#myPayment" onClick="showChargePayment("'+
							dataOrder.StripeID+'"><span class="glyphicon glyphicon-usd"></span></a>'+
							'<a class="btn-warning btn-sm" data-toggle="modal" href="#myScheduleChange" onClick="getOrderScheduleDateTime("'+
							dataOrder.OrderNumber+'"><span class="glyphicon glyphicon-calendar"></span></a>'
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
					$("#table_orders_customer tr").each(function(index) {
							if (index !== 0) {

								$row = $(this);

								var id = $row.find("td:eq(0)").text();
								
								if (id.indexOf(value) === 0) {
									var requestType=getRequestType(dataOrder.RequestType);
                                	var status=getStatus(dataOrder.Status);
									$row.find("td:eq(1)").html(requestType);
									$row.find("td:eq(2)").html(dataOrder.RepAddress);
									$row.find("td:eq(3)").html(dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water);
									$row.find("td:eq(4)").html(status);
									$row.find("td:eq(5)").html(dataOrder.SchDate);
									$row.find("td:eq(6)").html(dataOrder.SchTime);
									$row.find("td:eq(7)").html(dataOrder.ETA);
									$row.find("td:eq(8)").html(dataOrder.EstAmtMat);
									companyName=getCompanyName(dataOrder.CompanyID);
									$row.find("td:eq(9)").html(companyName);
									contractorName=gerContractorName(dataOrder.ContractorID);
									$row.find("td:eq(10)").html(contractorName);
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
						$("#table_orders_customer tr").each(function(index) {
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
			
			function getCompanyName(companyID){
				var ref = firebase.database().ref("Company/"+companyID+"/CompanyName");
					ref.on('value', function(snapshot) {
						return snapshot.val();
					});

			}
			function gerContractorName(contractorID){
				var firstName="";
				var lastName="";
				var ref = firebase.database().ref("Contractors/"+contractorID+"/ContNameFirst");
					ref.on('value', function(snapshot) {
						firstName=snapshot.val();
					});
				var ref = firebase.database().ref("Contractors/"+contractorID+"/ContNameLast");
					ref.on('value', function(snapshot) {
						lastName=snapshot.val();
					});
				return firstName+' '+lastName;
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
						<th>Est Amt</th>
                    	<th>Final Amt</th>
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
								<td><?php echo $order['SchDate']?></td>                            
								<td><?php echo $order['SchTime']?></td>
								<td><?php echo $order['ETA']?></td>                            
								<td><?php echo $order['EstAmtMat']?></td>
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
								<td><a class="btn-danger btn-sm" data-toggle="modal"  
										href="" 
										onClick="<?php echo "cancelService('".$order['FBID']."','Status,C')"; ?>" > 
										<span class="glyphicon glyphicon-trash"></span>
									</a>
									<a class="btn-success btn-sm" data-toggle="modal"  
										href="#myPayment" 
										onClick="<?php 
												if(isset($order['StripeID'])){
													echo "showChargePayment('".$order['StripeID']."')";
												}else{
													echo "showChargePayment('"."')";
												}
												 ?>" > 
										<span class="glyphicon glyphicon-usd"></span>
									</a>
											<a class="btn-warning btn-sm" data-toggle="modal"  
												href="#myScheduleChange" 
												onClick="<?php echo "getOrderScheduleDateTime('".$order['OrderNumber']."')" ?>"> 
												<span class="glyphicon glyphicon-calendar"></span>
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
                    <input  type="text" class="form-control" required="required" placeholder="Enter First Name" id="firstCustomerName" name="firstCustomerName" value="<?php echo $_actual_customer['Fname'] ?>" />
                </div> 
                <div class="form-group">
                    <label class="control-label">Last Name</label>
                    <input type="text" class="form-control" required="required"  placeholder="Enter Last Name" id="lastCustomerName" name="lastCustomerName"  value="<?php echo $_actual_customer['Lname'] ?>"/>
                </div>  
                <div class="form-group">
                    <label class="control-label ">Email</label>
                    <input type="text" class="form-control" required="required" readonly  placeholder="Enter Email" id="emailValidation" name="emailValidation" value="<?php echo $_actual_customer['Email'] ?>"/>
                </div> 
                <div class="form-group">
                    <label class="control-label">Address</label>
                    <input type="text" class="form-control" required="required"  placeholder="Enter address" id="customerAddress" name="customerAddress" value="<?php echo $_actual_customer['Address'] ?>"/>
                </div>
                <div class="form-group">
                    <label class="control-label">City</label>
                    <input type="text" class="form-control" required="required" placeholder="Enter city" id="customerCity" name="customerCity" value="<?php echo $_actual_customer['City'] ?>"/>
                </div> 
                <div class="form-group">
					<label class="control-label">State</label>
					<select id="customerState" name="customerState" required="required" class="form-control" placeholder="Select state" value="<?php echo $_actual_customer['State'] ?>">
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
                    <input type="text" class="form-control" required="required"  placeholder="Enter zip code" id="customerZipCode" name="customerZipCode"  value="<?php echo $_actual_customer['ZIP'] ?>"/>
                </div> 
                <div class="form-group">
                    <label class="control-label">Phone number</label>
                    <input type="text" class="form-control" required="required"  placeholder="Enter phone number" id="customerPhoneNumber" name="customerPhoneNumber"  value="<?php echo $_actual_customer['Phone'] ?>"/>
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
				<h4 class="modal-title" id="headerTextAnswerOrder">Modal Header</h4> 
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





