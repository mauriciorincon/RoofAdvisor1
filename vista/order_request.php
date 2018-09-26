<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                                        <div style="" class="col-sm-6" >
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
                                                                        <button class=" btn-primary btn-lg nextBtnOrder pull-left" type="button" id="buttonLoginCustomer">Login</button><br><br><br><br>
                                                                        <label id="answerValidateUserOrder" name="answerValidateUserOrder">Answer</label>
                                                                        <a href="#">Forgot password?</a>

                                                                </div>
                                                        </div>
                                                </div>
                                                <!--<button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
                                                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>-->
                                        </div>
                                        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div id="appwiz" class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panelOrder">
            <div class="stepwizard-step col-xs-1" > 
                <a href="#step-1"  type="button" class="btn btn-success btn-circle">1</a>
                <p><small>Z Code</small></p>
            </div>
            <div class="stepwizard-step col-xs-1"> 
                <a href="#step-2"  type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small> Order </small></p>
			</div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-10"  type="button" class="btn btn-default btn-circle" disabled="disabled">2.1</a>
                <p><small>Question?</small></p>
			</div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-3"  type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Address</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-4"  type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                <p><small>Time</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-5"  type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
                <p><small>Professional</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-6"  type="button" class="btn btn-default btn-circle" disabled="disabled">6</a>
                <p><small>Review</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-7"  type="button" class="btn btn-default btn-circle" disabled="disabled">7</a>
                <p><small>Validation</small></p>
			</div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-8"  type="button" class="btn btn-default btn-circle" disabled="disabled">8</a>
                <p><small>Complete</small></p>
            </div>
        </div>
    </div>
    <div id="appfrm1">
    <div id="welcome-txt">
    <span>
    Need a <strong>Roofer?</strong> Fast<strong style="color:#fa511a;"> same day</strong>service!
    </span>
    </div>
    <form role="form">
     <div id="step1contain">
        <div class="panel panel-primary setup-contentOrder" id="step-1">
            <div id="zip-panel-heading" class="panel-heading">
                 <h3 class="panel-title">ZIP CODE</h3>
            </div>
            <div class="panel-body pbody-white">
                <div class="form-group">
                    <label class="control-label text-center h1"><big>ZIP CODE</big></label>
                    <input maxlength="100" type="text" required="required" class="form-control input-lg" placeholder="Enter your zip code" id="zipCodeBegin" name="zipCodeBegin" />
					<label class="control-label text-center h1" id="answerZipCode"><big></big></label>
                </div>
                
				
               
                <button class="btn btn-primary nextBtnOrder pull-right" type="button" id="firstNextBegin" name="firstNextBegin">Next</button>
                
            </div>
        </div>
        </div>
        <div class="panel panel-primary setup-contentOrder" id="step-2">
            <div class="panel-heading">
                 <h3 class="panel-title"><font size="10"><strong>Create a work order</strong></font> </h3>
            </div>
            <div class="panel-body">
				<div class="list-group-item ">
				<font size="5">&#9312;</font><font size="5"><strong>What type of service?</strong></font>
				</div>
				<div class="list-group" id="step2OtypeService">
				<a href="#" class="list-group-item " name="linkServiceType">
					<input type="hidden" value="emergency" name="typeServiceOrder">
						<table>
							<tr>
								<td style="padding: 12px 12px 12px 12px;">
									<button class=" btn-primary   btn-lg" type="button" style="width:160px">Emergency Repair</button>
								</td>
								<td style="padding: 12px 12px 12px 12px;">
								<h4>An emergency repair is a same day service. The first available rated service pro will choose your repair order and provide you with an ETA of when they will arrive at the repair location.  You will be able to review their ratings, communicate, send them pictures, and track their location. An estimate for your approval will be provided prior to start of work. </h4>
								</td>
							</tr>
						</table>
						<div class="d-flex w-100 justify-content-between">
						
						<span></span>
							
						</div>
					</a>

					<a href="#" class="list-group-item" name="linkServiceType">
						<input type="hidden" value="schedule" name="typeServiceOrder">
						<table>
							<tr>
								<td style="padding: 12px 12px 12px 12px;">
									<button class=" btn-success   btn-lg" type="button" style="width:160px">Schedule Repair</button>
								</td>
								<td style="padding: 12px 12px 12px 12px;">
								<h4>A scheduled repair is scheduled a week in advance. You will be able to choose the service pro or allow the first available rated service pro will choose your repair order.</h4>
								</td>
							</tr>
						</table>
						<div class="d-flex w-100 justify-content-between">
						
						<span></span>
							
						</div>
					</a>

					<a href="#" class="list-group-item" name="linkServiceType">
						<input type="hidden" value="roofreport" name="typeServiceOrder">
						<table>
							<tr>
								<td style="padding: 12px 12px 12px 12px;">
									<button class=" btn-primary   btn-lg" type="button" style="width:160px">Order Roof Report</button>
								</td>
								<td style="padding: 12px 12px 12px 12px;">
								<h4>Get a detailed roof report for $29 within 24 hours. We create accurate aerial roof measurements and diagrams you can use to estimates material cost to replace your roof. See sample. If we cannot create the roof report for you due to aerial obstructions or roof complexity, we will refund your money guaranteed.</h4>
								</td>
							</tr>
						</table>
						<div class="d-flex w-100 justify-content-between">
						
						<span></span>
							
						</div>
					</a>
					
				</div>
					

					
								
				
					
				
				<!--<div class="list-group-item ">
				<font size="5">&#9313;</font> <font size="5"><strong>Best select the type of roofing material on your property?</strong></font>		
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
						<div class="form-group">
							<div class ="col-md-5">
							</div>
							<div class ="col-md-1">
									<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option5" value="Do not know">
							</div>
							<div class="col-md-6">
									<label class="form-check-label" for="estep3Option5">
									Do not Know
									</label>
							</div>
						</div>	
						<label>&nbsp;</label>

				</div>
                
				<div class="list-group-item ">
					<font size="5">&#9314;</font> <font size="5"><strong>Are you aware of any leaks or damage to the roof?</strong></font>		
				</div>

				<div class="list-group-item ">
					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep4Option" id="estep4Option1" value="Yes" checked></div>
						<div class="col-md-6"><label class="form-check-label" for="estep4Option1">Yes</label></div>
					</div>

					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep4Option" id="estep4Option2" value="No"></div>
						<div class="col-md-6"><label class="form-check-label" for="estep4Option2">No</label></div>
					</div>
					<label>&nbsp;</label>
				</div>

				<div class="list-group-item ">
				<font size="5">&#9315;</font> <font size="5"><strong>How many stories is your home?</strong></font>
				</div>

				<div class="list-group-item ">
					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep5Option" id="estep5Option1" value="1 story" checked></div>
						<div class="col-md-6"><label class="form-check-label" for="estep5Option1">One</label></div>
					</div>

					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep5Option" id="estep5Option2" value="2 story"></div>
						<div class="col-md-6"><label class="form-check-label" for="estep5Option2">Two</label></div>
					</div>

					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep5Option" id="estep5Option3" value="3 or more"></div>
						<div class="col-md-6"><label class="form-check-label" for="estep5Option3">Three or More</label></div>
					</div>
					<label>&nbsp;</label>
				</div>

				<div class="list-group-item ">
					<font size="5">&#9316;</font> <font size="5"><strong>Are you the owner or authorized to make property changes?</strong></font>		
				</div>

				<div class="list-group-item ">
					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep6Option" id="estep6Option1" value="Yes" checked></div>
						<div class="col-md-6"><label class="form-check-label" for="estep6Option1">Yes</label></div>
					</div>

					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep6Option" id="estep6Option2" value="No"></div>
						<div class="col-md-6"><label class="form-check-label" for="estep6Option2">No</label></div>
					</div>
					<label>&nbsp;</label>
				</div>-->

                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
            </div>

		</div>

		<div class="panel panel-primary setup-contentOrder" id="step-10">
			<div class="panel-heading">
                 <h3 class="panel-title"><font size="10"><strong>Create a work order</strong></font> </h3>
			</div>
			<div class="panel-body">
			<div class="list-group-item ">
				<font size="5">&#9313;</font> <font size="5"><strong>Best select the type of roofing material on your property?</strong></font>		
				</div>
				<div class="list-group-item ">
						<div class="form-group">
						
							<style>
								.segmented-control > label::after {
									background-color: #319DD4;
								}
							</style>
							<div class="segmented-control" style="width: 100%; color: #319DD4">
								<input type="radio" name="estep3Option" data-value="Flat, Single Ply" id="sc-1-1-1" checked>
								<input type="radio" name="estep3Option" data-value="Asphalt" id="sc-1-1-2">
								<input type="radio" name="estep3Option" data-value="Wood Shake/Composite" id="sc-1-1-3" >
								<input type="radio" name="estep3Option" data-value="Metal" id="sc-1-1-4">
								<input type="radio" name="estep3Option" data-value="Tile" id="sc-1-1-5">
								<input type="radio" name="estep3Option" data-value="Do not know" id="sc-1-1-6">
								<label for="sc-1-1-1" data-value="Flat, Single Ply">Flat, Single Ply</label>
								<label for="sc-1-1-2" data-value="Asphalt">Asphalt</label>
								<label for="sc-1-1-3" data-value="Wood Shake/Composite">Wood Shake/Composite</label>
								<label for="sc-1-1-4" data-value="Metal">Metal</label>
								<label for="sc-1-1-5" data-value="Tile">Tile</label>
								<label for="sc-1-1-6" data-value="Do not know">Do not know</label>
							</div>					
						</div>
				</div>
                
				<div class="list-group-item ">
					<font size="5">&#9314;</font> <font size="5"><strong>Are you aware of any leaks or damage to the roof?</strong></font>		
				</div>

				<div class="list-group-item ">
					<div class="form-group">
							<div class="segmented-control" style="width: 100%; color: #319DD4">
								<input type="radio" name="estep4Option" data-value="Yes" id="estep4Option1" checked>
								<input type="radio" name="estep4Option" data-value="No" id="estep4Option2">
								
								<label for="estep4Option1" data-value="Yes">Yes</label>
								<label for="estep4Option2" data-value="No">No</label>
								
							</div>

					</div>

				</div>

				<div class="list-group-item ">
					<font size="5">&#9315;</font> <font size="5"><strong>How many stories is your home?</strong></font>
				</div>

				<div class="list-group-item ">
					<div class="form-group">
							<div class="segmented-control" style="width: 100%; color: #319DD4">
								<input type="radio" name="estep5Option" data-value="1 story" id="estep5Option1" checked>
								<input type="radio" name="estep5Option" data-value="2 story" id="estep5Option2">
								<input type="radio" name="estep5Option" data-value="3 or more" id="estep5Option3" >
								<input type="radio" name="estep5Option" data-value="3 or more" id="estep5Option4">
								
								<label for="estep5Option1" data-value="1 story">One</label>
								<label for="estep5Option2" data-value="2 story">Two</label>
								<label for="estep5Option3" data-value="3 or more">Three</label>
								<label for="estep5Option4" data-value="3 or more">More</label>
								
							</div>
						
					</div>
					
				</div>

				<div class="list-group-item ">
					<font size="5">&#9316;</font> <font size="5"><strong>Are you the owner or authorized to make property changes?</strong></font>		
				</div>

				<div class="list-group-item ">
					<div class="form-group">
							<div class="segmented-control" style="width: 100%; color: #319DD4">
								<input type="radio" name="estep6Option" data-value="Yes" id="estep6Option1" checked>
								<input type="radio" name="estep6Option" data-value="No" id="estep6Option2">
								
								<label for="estep6Option1" data-value="Yes">Yes</label>
								<label for="estep6Option2" data-value="No">No</label>
								
							</div>
						
					</div>
				</div>

                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
			</div>
		</div>
		
		<div class="panel panel-primary setup-contentOrder" id="step-3">
            <div class="panel-heading">
                 <h1 class="panel-title"><font size="10"><strong>Create a work order</strong></font> </h1>
            </div>
            <div class="panel-body">
				<span class="glyphicon glyphicon-info-sign h1white"></span> <font size="5"><strong class="h1white">Select the place for the service</strong></font>	
					<input type="hidden" id="step5Logintud" name="step5Logintud"/>
					<input type="hidden" id="step5Latitude" name="step5Latitude"/>
					<input type="hidden" id="step5Address" name="step5Address"/>
					<input type="hidden" id="step5ZipCode" name="step5ZipCode"/>
					<div class="list-group">
					
							<input id="pac-input" class="controls" type="text"
								placeholder="Enter a location" style="margin-left: 20px;margin-top:10px;">
                            
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

							var map = null;

							function initMap1() {
								

								map = new google.maps.Map(document.getElementById('map1'), {
								center: {lat: 27.332617, lng: -81.255690},
								zoom: 12
								});

								////Get lat and long from zipcode
							
								setLocation(map,"")
								/////////////////////////////////////

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

							function setLocation(map,zipcode){
								//var address = $('#zipCodeBegin').val();
								var address=zipcode;
								if(address==undefined || address==""){
									address = '02201';
								} 
								console.log("zipcode: "+address);
								geocoder = new google.maps.Geocoder();
								
								geocoder.geocode( { 'address': address}, function(results, status) {
								if (status == 'OK') {
									map.setCenter(results[0].geometry.location);
									var marker = new google.maps.Marker({
										map: map,
										position: results[0].geometry.location
									});
								} else {
									alert('Geocode was not successful for the following reason: ' + status);
								}
								});
							}

							function clearMarkers(map) {
        						map.clearOverlays();
      						}

							</script>
							
						<script async defer
							src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&libraries=visualization&libraries=places&callback=initialization">
						</script>

						<button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                		<button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
					</div>
			</div>
		</div>

		<div class="panel panel-primary setup-contentOrder" id="step-4">
            <div class="panel-heading">
                 <h3 class="panel-title"><font size="10"><strong>Select a time for service ....</strong></font></h3>
            </div>
            <div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						<span class="h1white"><h4><b>Please select the date of service. </b></h4></span><input type="text" id="step6date" name="step6date" class="datepicker" style="font-size:24px;text-align:center;">
					</div>
					<div class="col-sm-6">
						<span class="h1white"><h4><b>Please select the time of service. </b></h4></span>
						<input type="text" id="step6time" name="step6time" class="timepicker"  style="font-size:24px;text-align:center;" />
					</div>
					<div class="col-sm-12">
						<br>
						<center><h4 class="h1white"><b>Schedule repair service are schedule a week in advance</b></h4></center>
					</div>
	
				</div> 
              <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder" id="step-5">
            <div class="panel-heading">
                 <h3 class="panel-title"><font size="10"><strong>Select the professional</strong></font></h3>
            </div>
            <div class="panel-body">
				<div class="form-group">
				
								<!--<label class="control-label" for="exampleRadios5">-->
								<span class="h1white" ><h4><b>These Service Professionals are best suited for your scheduled repair and are all rated 4+ by previous customers.</b> </h4></span>
								<!--</label>-->
								<!--<label class="control-label" for="exampleRadios5">-->
								<h4 class="h1white"><b>You can select one or the first available will respond to your work order?</b></h4>
								<!--</label>-->
							
							
				</div>

				<div class="list-group1" id="step7ListCompany">
					
				</div>
         
                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder" id="step-6">
            <div class="panel-heading">
                 <h3 class="panel-title"><font size="10"><strong>Review Scheduled Repair Order Details</strong></font></h3>
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

				<!--<div class="list-group">
						<a href="#" class="list-group-item ">
							<span class="glyphicon glyphicon-info-sign"></span> Rate 
							<div class="d-flex w-100 justify-content-between">
								<span ><b>Prices start from $300-$400 per square and will increase depending on the size, mateiral and time needed to complete the repair.</b></span><span id="step8CompanyName"></span><br>
								
							</div>
						</a>
				</div>-->
                
                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder" id="step-8">
            <div class="panel-heading">
                 <h3 class="panel-title">Payment Processing</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">		
						<div class ="col-md-6">
							<div class="list-group">
								<a href="#" class="list-group-item ">
									<span class="glyphicon glyphicon-info-sign"></span>Emergency Service 
									<div class="d-flex w-100 justify-content-between">
									<b>Emergency Repair Service Charge of $75 is the initial cost to secure the same day service response from a qualified, pre-screened service professional. If the service professional is unable to provide service within 24 hours from the time you submit payment, we will refund the emergency repair charge.</b>
									</div>
								</a>
							</div>
						</div>
						<div class ="col-md-6">
							<div class="list-group">
								<a href="#" class="list-group-item ">
									<span class="glyphicon glyphicon-info-sign"></span>Roof Report 
									<div class="d-flex w-100 justify-content-between">
									<b>Ordering a Roof Report cost $29. We create detailed aerial roof measurements and diagrams that are sent to you via email and can be viewed in our web site. If we cannot create a roof report for you due to obstructions or roof complexity, we will refund your money.</b>
									</div>
								</a>
							</div>
							
						</div>
					<div class ="col-md-12">
						<label class="control-label text-center h1 h1white"><big>To finish your order, please click on <b>Pay Your Service</b> button to make the charge to your card.</big></label>
						<?php
							if(!isset($_SESSION)) { 
								session_start(); 
							} 
							require_once($_SESSION['application_path']."/controlador/payingController.php");
							
						
							$_objPay=new payingController();
							echo "<center>";
							$_objPay->showPayingWindow1();
							echo "</center>";
						?>
					</div>	
                    
					
					<label class="control-label text-center h1" id="answerZipCode"><big></big></label>
                </div>
				
				<button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
				
               
                
                
            </div>
		</div>
		
		<div class="panel panel-primary setup-contentOrder" id="step-7">
			<input type="hidden" id="userLoguedIn" value="false" />
            <div class="panel-heading">
                 <h3 class="panel-title"><font size="10"><strong>Customer information</strong></font></h3>
            </div>
            <div class="panel-body">
				<div class="row">
					<div style="margin-bottom: 20px;" class="col-sm-12">
						<div class="list-group">
							<div class="list-group-item ">
								<span class="glyphicon glyphicon-info-sign"></span> Info 
								<div class="d-flex w-100 justify-content-between">
									<span ><b>Are you new to RoofServiceNow?, fill the fields below</b></span><br><br>
									
								</div>
							</div>
							
							<div class="list-group-item " id="step6RegisterCustomerOrder">
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
                                                                <div id="reg-frm2">
              							<div class="form-group">
                                                                        <label class="control-label Rlft-frm">First Name</label>
                                                                        <input  type="text" required="required" placeholder="Enter First Name" id="firstCustomerName" name="firstCustomerName"  />
                                                                        <label style="margin-left: 52px;" class="control-label Rlft-frm1">Last Name</label>
                                                                        <input  maxlength="100" type="text" required="required"  placeholder="Enter Last Name" id="lastCustomerName" name="lastCustomerName"  />
                                                                </div>
	
								<div class="form-group">
									<label style="margin-left: 17px;" class="control-label Rlft-frm">Address</label>
									<input maxlength="100" type="text" required="required"  placeholder="Enter address" id="customerAddress" name="customerAddress" />
								        <label class="control-label Rlft-frm1">City</label>
                                                                        <input maxlength="100" type="text" required="required" placeholder="Enter city" id="customerCity" name="customerCity" />
                                                                </div>
								<div class="form-group">
              							        <label style="margin-left:37px;" class="control-label Rlft-frm">State</label>
                                                                        <select style="display:inline-block;width:183px;" id="customerState" name="customerState" required="required" class="form-control" placeholder="Select state">

                                                                                <?php foreach ($_array_state as $key => $value1) { ?>
                                                                                        <option value="<?php echo $value1 ?>"><?php echo $value1 ?></option>
                                                                                <?php } ?>
                                                                        </select>
                                                                        <label style="margin-left: 66px;" class="control-label Rlft-frm1">Zip code</label>
                                                                        <input maxlength="100" type="text" required="required"  placeholder="Enter zip code" id="customerZipCode" name="customerZipCode" />
                                                                </div>
								
								<div class="form-group">
									<label style="margin-left:-31px;" class="control-label Rlft-frm">Phone number</label>
									<input style="width: 498px;" maxlength="100" type="text" required="required"  placeholder="Enter phone number" id="customerPhoneNumber" name="customerPhoneNumber"  />
								</div>
                                                                </div>  
								<button class=" btn-primary  btn-lg nextBtnOrder pull-left" type="button" id="buttonLoginCustomer1" onclick="saveCustomerData('Order')">Register</button><br><br>
                                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login-modal">I already have an account.</button>			
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
<div class="modal fade" id="myModalRespuesta" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<!--<button type="button" class="close" data-dismiss="modal">&times;</button> -->
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
