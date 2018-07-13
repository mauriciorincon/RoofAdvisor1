<div id="wrapper">

	<!-- Sidebar -->
	<div id="sidebar-wrapper">
		<ul class="sidebar-nav">
			<li class="sidebar-brand">
				<a href="#">
					Actions
				</a>
			</li>
			<li>
			<a href="#" class="active" data-toggle="collapse" data-target="#mapDashBoard1" onclick="hideShowDivs('customerDashProfile1');hideShowDivs('scheduleCompany');hideShowDivs('mapDashBoardOrder1');setActiveItemMenu(this);" >Orders</a>
			</li>
			<li>
			<a href="#" data-toggle="collapse" data-target="#mapDashBoardOrder1" onclick="hideShowDivs('customerDashProfile1');hideShowDivs('scheduleCompany');hideShowDivs('mapDashBoard1');setActiveItemMenu(this);" >New Order</a>
			</li>
			<li>
			<a href="#" data-toggle="collapse" data-target="#customerDashProfile1" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('scheduleCompany');hideShowDivs('mapDashBoardOrder1');setActiveItemMenu(this);">Profile</a>
			</li>
			<li>
			<a href="#" data-toggle="collapse" data-target="#scheduleCompany" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('customerDashProfile1');hideShowDivs('mapDashBoardOrder1');setActiveItemMenu(this);">Scheduler</a>
			</li>
			<li>
			<a href="#">Estimating Wizard</a>
			</li>
			<li>
			<a href="#">Order Metrics</a>
			</li>
			<li>
			<a href="#"><span class="badge" id="totalOrdersCustomer">0</span> Total Order Repairs </a>
			</li>
			<li>
			<a href="#"><span class="badge" id="totalEmergencyRepair">0</span> Emergency Repairs </a>
			</li>
			<li>
			<a href="#"><span class="badge" id="totalScheduleRepair">0</span> Schedule Repairs </a>
			</li>
			<li>
			<a href="#"><span class="badge" id="totalEmergencyRepair">0</span> Repairs Pending</a>
			</li>
		</ul>
	</div>
	<!-- /#sidebar-wrapper -->


<!-- Page Content -->
<div id="page-content-wrapper">
	<div class="container-fluid">
		
		<a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Show Actions</a>

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
						<th>Repair Type</th>
						<th>Repair ID</th>
						
						<th>Address</th>
						
						<th>Description</th>
						<th>Status</th>
						<th>Date</th>
						<th>Time</th>
						<th>Actions</th>
					</tr>
					</thead>
					<tbody>
						<?php foreach ($_array_customer_to_show as $key => $order) { ?>
							<tr>
								<td><?php echo $order['RequestType']?></td>
								<td><?php echo $order['OrderNumber']?></td>
								
								<td><?php if(isset($order['RepAddress'])){echo $order['RepAddress'];} ?></td>
								
								<td><?php echo $order['Hlevels'].", ".$order['Rtype'].", ".$order['Water']?></td>
								<td><?php echo $order['Status']?></td> 
								<td><?php echo $order['SchDate']?></td>                            
								<td><?php echo $order['SchTime']?></td>
								<td><a class="btn-danger btn-sm" data-toggle="modal"  
												href="" 
												onClick="<?php echo "cancelOrder('".$order['OrderNumber']."','{\"Status\":\"C\"}')"; ?>" > 
												<span class="glyphicon glyphicon-trash"></span>
											</a>
									<a class="btn-success btn-sm" data-toggle="modal"  
												href="#" 
												onClick="" > 
												<span class="glyphicon glyphicon-usd"></span>
											</a>
											<a class="btn-warning btn-sm" data-toggle="modal"  
												href="#" 
												onClick=""> 
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
                    echo '<h2>June '.$_year.'</h2>';
                    
                    $oCalendar=new calendar();
                    echo $oCalendar->draw_controls($_month,$_year);
                    if(strlen($month)==1){
                        $_eventsArray=$oCalendar->getEvents("0".$_month,$_year);
                    }else{
                        $_eventsArray=$oCalendar->getEvents($_month,$_year);
                    }
                    
                    echo $oCalendar->draw_calendar($_month,$_year,$_eventsArray);

            ?>
		</div>

		<!-- Dashboard New Order -->
        <div class="collapse" id="mapDashBoardOrder1">
        	<div class="container">
				<div class="stepwizard">
					<div class="stepwizard-row setup-panelOrder">
						<div class="stepwizard-step col-xs-2"> 
							<a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
							<p><small>Zip Code</small></p>
						</div>
						<div class="stepwizard-step col-xs-2"> 
							<a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
							<p><small>What would you like to do?</small></p>
						</div>
						<div class="stepwizard-step col-xs-1"> 
							<a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
							<p><small>Address</small></p>
						</div>
						<div class="stepwizard-step col-xs-1"> 
							<a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
							<p><small>Time</small></p>
						</div>
						<div class="stepwizard-step col-xs-2"> 
							<a href="#step-5" type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
							<p><small>Professional</small></p>
						</div>
						<div class="stepwizard-step col-xs-2"> 
							<a href="#step-6" type="button" class="btn btn-default btn-circle" disabled="disabled">6</a>
							<p><small>Review</small></p>
						</div>
						<div class="stepwizard-step col-xs-2"> 
							<a href="#step-7" type="button" class="btn btn-default btn-circle" disabled="disabled">7</a>
							<p><small>Validate user</small></p>
						</div>
					</div>
				</div>
    
				<form role="form">
					<div class="panel panel-primary setup-contentOrder" id="step-1">
						<div class="panel-heading">
							<h3 class="panel-title">ZIP CODE</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="control-label text-center h1"><big>ZIP CODE</big></label>
								<input maxlength="100" type="text" required="required" class="form-control input-lg" placeholder="Enter your zip code" id="zipCodeBegin" name="zipCodeBegin" />
								<label class="control-label text-center h1" id="answerZipCode"><big></big></label>
							</div>
							
							
						
							<button class="btn btn-primary nextBtnOrder pull-right" type="button" id="firstNextBegin" name="firstNextBegin">Next</button>
							
						</div>
					</div>
					
					<div class="panel panel-primary setup-contentOrder" id="step-2">
						<div class="panel-heading">
							<h3 class="panel-title">What would you like to do? </h3>
						</div>
						<div class="panel-body">
							<div class="list-group-item ">
								<span class="glyphicon glyphicon-info-sign"></span> What would you like to do?		
							</div>

							<div class="list-group-item ">
								<div class="form-group">
						
									<div class ="col-md-1">
										<input class="form-check-input" type="radio" name="typeServiceOrder" id="exampleRadios1" value="S" checked>
									</div>
									<div class="col-md-11"> 
										<label class="form-check-label" for="exampleRadios1">Repair existing roof leak (scheduled a week in advance) - S</label>
									</div>
								</div>

								<div class="form-group">
									<div class ="col-md-1">
										<input class="form-check-input" type="radio" name="typeServiceOrder" id="exampleRadios2" value="E">
									</div>
									<div class="col-md-11">
										<label class="form-check-label" for="exampleRadios2">
										Emergency roof repair leak sameday service (repair today) - E
										</label>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label">S-Scheduled Repair prices start from $300-$400 per square and will increase depending on the size, material and time needed to complete the  scheduled repair.</label>
								</div> 
								<div class="form-group">
									<label class="control-label">E-Emergency Repair price includes a $75 Emergency Repair Service Fee, $150 per hour for time plus the materials needed to complete the emergency repair.</label>
								</div>
											
							</div>
							
							<div class="list-group-item ">
								<span class="glyphicon glyphicon-info-sign"></span> Best select the type of roofing material on your property		
							</div>
							<div class="list-group-item ">
								<div class="form-group">
									<div class ="col-md-5">
									</div>
									<div class ="col-md-1">
										<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option1" value="Flat, Single Ply" checked>
									</div>
									<div class="col-md-6"> 
										<label class="form-check-label" for="estep3Option1">
											Flat, Single Ply
										</label>
									</div>
								</div>

								<div class="form-group">
								<div class ="col-md-5">
									</div>
									<div class ="col-md-1">
											<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option2" value="Asphalt">
										</div>
										<div class="col-md-6">
											<label class="form-check-label" for="estep3Option2">
											Asphalt
											</label>
										</div>
									
								</div>

								<div class="form-group">
								<div class ="col-md-5">
									</div>
									<div class ="col-md-1">
											<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option3" value="Wood Shake/Composite">
										</div>
										<div class="col-md-6">
											<label class="form-check-label" for="estep3Option3">
											Wood Shake/Composite
											</label>
										</div>
									
								</div>
								<div class="form-group">
									<div class ="col-md-5">
									</div>
									<div class ="col-md-1">
											<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option4" value="Metal">
									</div>
									<div class="col-md-6">
										<label class="form-check-label" for="estep3Option4">
										Metal
										</label>
									</div>
										
								</div>
								<div class="form-group">
									<div class ="col-md-5">
									</div>
									<div class ="col-md-1">
											<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option5" value="Tile">
									</div>
									<div class="col-md-6">
											<label class="form-check-label" for="estep3Option5">
											Tile
											</label>
									</div>
									
								</div>	
								<label>&nbsp;</label>

							</div>
							
							<div class="list-group-item ">
								<span class="glyphicon glyphicon-info-sign"></span> Are you aware of any leaks or damage to the roof?		
							</div>

							<div class="list-group-item ">
								<div class="form-group">
									<div class ="col-md-5"></div>
									<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep4Option" id="estep4Option1" value="water" checked></div>
									<div class="col-md-6"><label class="form-check-label" for="estep4Option1">Yes</label></div>
								</div>

								<div class="form-group">
									<div class ="col-md-5"></div>
									<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep4Option" id="estep4Option2" value=""></div>
									<div class="col-md-6"><label class="form-check-label" for="estep4Option2">No</label></div>
								</div>
								<label>&nbsp;</label>
							</div>

							<div class="list-group-item ">
								<span class="glyphicon glyphicon-info-sign"></span> How many stories is your home?		
							</div>

							<div class="list-group-item ">
								<div class="form-group">
									<div class ="col-md-5"></div>
									<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep5Option" id="estep5Option1" value="One" checked></div>
									<div class="col-md-6"><label class="form-check-label" for="estep5Option1">One</label></div>
								</div>

								<div class="form-group">
									<div class ="col-md-5"></div>
									<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep5Option" id="estep5Option2" value="Two"></div>
									<div class="col-md-6"><label class="form-check-label" for="estep5Option2">Two</label></div>
								</div>

								<div class="form-group">
									<div class ="col-md-5"></div>
									<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep5Option" id="estep5Option3" value="Three or More"></div>
									<div class="col-md-6"><label class="form-check-label" for="estep5Option3">Three or More</label></div>
								</div>
								<label>&nbsp;</label>
							</div>


							<button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
							<button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
						</div>

					</div>
					
					<div class="panel panel-primary setup-contentOrder" id="step-3">
						<div class="panel-heading">
							<h3 class="panel-title">What would you like to do? </h3>
						</div>
						<div class="panel-body">
							<span class="glyphicon glyphicon-info-sign"></span> Select the place for the service
								<input type="hidden" id="step5Logintud" name="step5Logintud"/>
								<input type="hidden" id="step5Latitude" name="step5Latitude"/>
								<input type="hidden" id="step5Address" name="step5Address"/>
								<input type="hidden" id="step5ZipCode" name="step5ZipCode"/>
								<div class="list-group">
								
										<input id="pac-input" class="controls" type="text"
											placeholder="Enter a location" style="margin-left: 20px;margin-top:10px;">
										<!--<div id="type-selector" class="controls">
											<input type="radio" name="type" id="changetype-all" checked="checked">
											<label for="changetype-all">All</label>

											<input type="radio" name="type" id="changetype-establishment">
											<label for="changetype-establishment">Establishments</label>

											<input type="radio" name="type" id="changetype-address">
											<label for="changetype-address">Addresses</label>

											<input type="radio" name="type" id="changetype-geocode">
											<label for="changetype-geocode">Geocodes</label>
										</div>-->
										
										<style>
						/* Set the size of the div element that contains the map */
						#map1 {
							height: 400px;  /* The height is 400 pixels */
							width: 100%;  /* The width is the width of the web page */
						}
						</style>
										<div id="map1"></div>

										<script>
										// This example requires the Places library. Include the libraries=places
										// parameter when you first load the API. For example:
										// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

										function initMap1() {
											var map = new google.maps.Map(document.getElementById('map1'), {
											center: {lat: 27.332617, lng: -81.255690},
											zoom: 7
											});
											var input = /** @type {!HTMLInputElement} */(
												document.getElementById('pac-input'));

											var types = document.getElementById('type-selector');
											map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
											map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

											var autocomplete = new google.maps.places.Autocomplete(input);
											autocomplete.bindTo('bounds', map);

											var infowindow = new google.maps.InfoWindow();
											var marker = new google.maps.Marker({
											map: map,
											anchorPoint: new google.maps.Point(0, -29)
											});

											autocomplete.addListener('place_changed', function() {
											infowindow.close();
											marker.setVisible(false);
											var place = autocomplete.getPlace();
											if (!place.geometry) {
												// User entered the name of a Place that was not suggested and
												// pressed the Enter key, or the Place Details request failed.
												window.alert("No details available for input: '" + place.name + "'");
												return;
											}

											// If the place has a geometry, then present it on a map.
											if (place.geometry.viewport) {
												map.fitBounds(place.geometry.viewport);
											} else {
												map.setCenter(place.geometry.location);
												map.setZoom(17);  // Why 17? Because it looks good.
											}
											marker.setIcon(/** @type {google.maps.Icon} */({
												url: place.icon,
												size: new google.maps.Size(71, 71),
												origin: new google.maps.Point(0, 0),
												anchor: new google.maps.Point(17, 34),
												scaledSize: new google.maps.Size(35, 35)
											}));
											marker.setPosition(place.geometry.location);
											marker.setVisible(true);
											$("#step5Logintud").val(place.geometry.location.lng());
											$("#step5Latitude").val(place.geometry.location.lat());
											
											//console.log(place.geometry.location.lat());
											//console.log(place.geometry.location.lng());
											var address = '';
											if (place.address_components) {
												address = [
												(place.address_components[0] && place.address_components[0].short_name || ''),
												(place.address_components[1] && place.address_components[1].short_name || ''),
												(place.address_components[2] && place.address_components[2].short_name || '')
												].join(' ');
												$('#step5Address').val(address);
												$('#step5ZipCode').val(place.address_components[7].short_name);
											}
											

											infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
											infowindow.open(map, marker);
											});

											// Sets a listener on a radio button to change the filter type on Places
											// Autocomplete.
											/*function setupClickListener(id, types) {
											var radioButton = document.getElementById(id);
											
											radioButton.addEventListener('click', function() {
												autocomplete.setTypes(types);
											});
											}

											setupClickListener('changetype-all', []);
											setupClickListener('changetype-address', ['address']);
											setupClickListener('changetype-establishment', ['establishment']);
											setupClickListener('changetype-geocode', ['geocode']);*/
										}
										</script>
										
									<script async defer
										src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&libraries=visualization&libraries=places&callback=initialization">
									</script>

									<button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
									<button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
								</div>
						</div>
					</div>

					<div class="panel panel-primary setup-contentOrder" id="step-4">
						<div class="panel-heading">
							<h3 class="panel-title">Select a time for service ....</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">			
							<span ><b>Plese select the date to service: </b></span><input type="date" id="step6date" name="step6date">
							</div>
								
							<div class="form-group">
								<div class="container:'body'">
									<div class="btn-group" role="group" arial-label="Basic example">
										<button type="button" class="btn btn-success" name="step6time" >9:00 AM</button>
										<button type="button" class="btn btn-success" name="step6time">10:00 AM</button>
										<button type="button" class="btn btn-success" name="step6time">11:00 AM</button>
										<button type="button" class="btn btn-success" name="step6time">12:00 PM</button>
										<button type="button" class="btn btn-success" name="step6time">1:00 PM</button>
										<button type="button" class="btn btn-success" name="step6time">2:00 PM</button>
										<button type="button" class="btn btn-success" name="step6time">3:00 PM</button>
										<button type="button" class="btn btn-success" name="step6time">4:00 PM</button>
										<button type="button" class="btn btn-success" name="step6time">5:00 PM</button>
									</div>
								</div>
							</div>
							
							

							<button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
							<button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
						</div>
					</div>

					<div class="panel panel-primary setup-contentOrder" id="step-5">
						<div class="panel-heading">
							<h3 class="panel-title">Select the professional</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
							
											<label class="control-label" for="exampleRadios5">
											These Service Professionals are best suited for your scheduled repair and are all rated 4+ by previous customers. 
											</label>
											<label class="control-label" for="exampleRadios5">
											You can select one or the first available will respond to your request?
											</label>
										
										
							</div>



							<div class="list-group" id="step7ListCompany">
								
							</div>



							

							
							<button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
							<button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
						</div>
					</div>

					<div class="panel panel-primary setup-contentOrder" id="step-6">
						<div class="panel-heading">
							<h3 class="panel-title">Review Scheduled Repair Order Details</h3>
						</div>
						<div class="panel-body">
							
							<div class="list-group">
									<a href="#" class="list-group-item ">
										<span class="glyphicon glyphicon-envelope"></span> Details <span class="badge">1</span>
										<div class="d-flex w-100 justify-content-between">
											<span ><b>Repair Description: </b></span><span id="step8RepairDescription"></span><br>
											<span ><b>Schedule Date: </b></span><span id="step8Schedule"></span><br>	
											<span ><b>Time: </b></span><span id="step8Time"></span>
										</div>
									</a>
							</div>

							<div class="list-group">
									<a href="#" class="list-group-item ">
										<span class="glyphicon glyphicon-wrench"></span> Contractor <span class="badge">1</span>
										<div class="d-flex w-100 justify-content-between">
											<span ><b>Name: </b></span><span id="step8CompanyName"></span><br>
											
										</div>
									</a>
							</div>

							<div class="list-group">
									<a href="#" class="list-group-item ">
										<span class="glyphicon glyphicon-map-marker"></span> Address of service <span class="badge">1</span>
										<div class="d-flex w-100 justify-content-between">
											<span ><b>Address: </b></span><span id="step8Address"></span><br>
											<span ><b>ZipCode: </b></span><span id="step8ZipCode"></span><br>
											<span ><b>Latitude: </b></span><span id="step8Latitude"></span><br>
											<span ><b>Longitude: </b></span><span id="step8Longitude"></span><br>
											
										</div>
									</a>
							</div>

							<div class="list-group">
									<a href="#" class="list-group-item ">
										<span class="glyphicon glyphicon-info-sign"></span> Rate 
										<div class="d-flex w-100 justify-content-between">
											<span ><b>Prices start from $300-$400 per square and will increase depending on the size, mateiral and time needed to complete the repair.</b></span><span id="step8CompanyName"></span><br>
											
										</div>
									</a>
							</div>
							
							
							
							<button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
							<button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
						</div>
					</div>

					<div class="panel panel-primary setup-contentOrder" id="step-7">
						<div class="panel-heading">
							<h3 class="panel-title">Customer information</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6" >
									<div class="list-group">
										<div class="list-group-item ">
											<span class="glyphicon glyphicon-info-sign"></span> Info 
											<div class="d-flex w-100 justify-content-between">
												<span ><b>Please take just one more step, we need to verify your identity,please login or register</b></span><br><br>
												
											</div>
										</div>

										<div  class="list-group-item ">
											<span class="glyphicon glyphicon-info-sign"></span> Login
											<div class="d-flex w-100 justify-content-between">
												<div class="form-group">
													<label>User Name<span class="required">*</span></label>
													<input type="text" placeholder="" required="true" id="userClientOrder" name="userClientOrder" />
												</div>
												<div class="form-group">
													<label>Password<span class="required">*</span></label>
													<input type="password" placeholder="" required="true" id="passwordClientOrder" name="passwordClientOrder"/>
												</div>
												<button class=" btn-primary nextBtnOrder pull-left" type="button" id="buttonLoginCustomer">Login</button><br><br>
												<label id="answerValidateUserOrder" name="answerValidateUserOrder">Answer</label>
												<a href="#">Forgot password?</a>
												
											</div>
										</div>
									</div>
									<button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
								</div>
								<div class="col-sm-6">
									<div class="list-group">
										<div class="list-group-item ">
											<span class="glyphicon glyphicon-info-sign"></span> Info 
											<div class="d-flex w-100 justify-content-between">
												<span ><b>Are you new in RoofAdvisorZ?, fill the fields below</b></span><br><br>
												
											</div>
										</div>
										
											<div class="list-group-item " id="step6RegisterCustomerOrder">
												<div class="form-group">
													<label class="control-label">First Name</label>
													<input  type="text" required="required" placeholder="Enter First Name" id="firstCustomerName" name="firstCustomerName"  />
													</div> 
												<div class="form-group">
													<label class="control-label">Last Name</label>
													<input maxlength="100" type="text" required="required"  placeholder="Enter Last Name" id="lastCustomerName" name="lastCustomerName"  />
												</div>  
												<div class="form-group">
													<label class="control-label ">Email</label>
													<input maxlength="100"  type="text" required="required"  placeholder="Enter Email" id="emailValidation" name="emailValidation" onfocusout="validateEmail('customer')"/>
													<label class="control-label" id="answerEmailValidate" name="answerEmailValidate">Answer</label>
												</div>
												<div class="form-group">
													<label class="control-label ">Password</label>
													<input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Password" id="inputPassword" name="inputPassword" onblur="validInputPassword()"  />
													<div class="help-block">Minimum of 6 characters</div>
													<label class="control-label" id="answerPasswordValidateStep6" name="answerPasswordValidateStep6"></label>
												</div>
												<div class="form-group">
													<label class="control-label ">Confirm Password</label>
													<input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Confirm Password" id="inputPasswordConfirm" name="inputPasswordConfirm" onblur="validInputRePassword()" />
													<label class="control-label" id="answerRePasswordValidateStep6" name="answerRePasswordValidateStep6"></label>
												</div>

												
												<div class="form-group">
													<label class="control-label">Address</label>
													<input maxlength="100" type="text" required="required"  placeholder="Enter address" id="customerAddress" name="customerAddress" />
												</div>
												<div class="form-group">
													<label class="control-label">City</label>
													<input maxlength="100" type="text" required="required" placeholder="Enter city" id="customerCity" name="customerCity" />
												</div> 
												<div class="form-group">
													<label class="control-label">State</label>
													<input maxlength="100" type="text" required="required"  placeholder="Enter state" id="customerState" name="customerState" />
												</div>
												<div class="form-group">
													<label class="control-label">Zip code</label>
													<input maxlength="100" type="text" required="required"  placeholder="Enter zip code" id="customerZipCode" name="customerZipCode" />
												</div> 
												<div class="form-group">
													<label class="control-label">Phone number</label>
													<input maxlength="100" type="text" required="required"  placeholder="Enter phone number" id="customerPhoneNumber" name="customerPhoneNumber"  />
												</div>  
												<button class=" btn-primary nextBtnOrder pull-left" type="button" id="buttonLoginCustomer" onclick="saveCustomerData('Order')">Register</button><br><br>
											</div>
										
									</div>
									<button class="btn btn-primary nextBtnCustomer pull-right" type="button" id="lastFinishButtonOrder" name="lastFinishButtonOrder">Finish Order</button>
								</div>
								
									
								</div>
							</div>
						</div>

					</div>

				</form>
			</div>

		</div>
		
	</div>
	
<!-- /#page-content-wrapper -->

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


