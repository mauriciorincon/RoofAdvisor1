<!--<div id="mobilewizardmaster">-->
<div id="smartwizard">

    <!--<ul style="">-->
    <ul style="display:none">
        <li><a href="#step-1">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-2">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-3">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-4">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-5">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-6">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-7">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-8">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-9">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-10">Step Title<br /><small>Step description</small></a></li>
    </ul>

    <div>
        <div id="step-1" class="">
            Please type the zip code
            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter your zip code" id="zipCodeBegin" name="zipCodeBegin" />
            <label class="control-label text-center h1" id="answerZipCode"><big></big></label>
        </div>
        <div id="step-2" class="">
            <label>Select Service</label>
            <select id="typeServiceCompany1" name="typeServiceCompany" class="form-control">
                <option value="NA">---------------</option>
                <option value="emergency">Emergency</option>
                <option value="schedule">Schedule</option>
                <option value="roofreport">RoofReport</option>
                <option value="reroofnew">Re-roof or New</option>
            </select>
        </div>
        <div id="step-3" class="">
            <label>Select the type of roofing material on your property?</label>
            <select id="estep3Option" name="estep3Option" class="form-control">
                <option value="Flat">Flat</option>
                <option value="Asphalt">Asphalt</option>
                <option value="Wood Shake/Slate">Wood Shake/Slate</option>
                <option value="Metal">Metal</option>
                <option value="Tile">Tile</option>
                <option value="Do not know">Do not know</option>
            </select>
			<label>Are you aware of any leaks or damage to the roof?</label>
			<select id="estep4Option" name="estep4Option" class="form-control">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <label>How many stories is your home?</label>
			<select id="estep5Option" name="estep4Option" class="form-control">
                <option value="1 Story">One</option>
                <option value="2 Story">Two</option>
                <option value="3 or more">Three</option>
                <option value="3 or more">More</option>
            </select>
            <label>Are you the owner or authorized to make property changes?</label>
			<select id="estep6Option" name="estep4Option" class="form-control">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div id="step-4" class="">
                    <input type="hidden" id="step5Logintud" name="step5Logintud" />
                    <input type="hidden" id="step5Latitude" name="step5Latitude" />
                    <input type="hidden" id="step5Address" name="step5Address" />
                    <input type="hidden" id="step5ZipCode" name="step5ZipCode" />
                    <input type="hidden" id="step5State" name="step5State" />
                    <input type="hidden" id="step5City" name="step5City" />
            <style>
                /* Set the size of the div element that contains the map */
                #mapMobile {
                    height: 400px;  /* The height is 400 pixels */
                    width: 100%;  /* The width is the width of the web page */
                }
                #pac-inputMob {
                    background-color: #fff;
                    font-family: Roboto;
                    font-size: 15px;
                    margin-top: 10px;
                    padding: 0 11px 0 13px;
                    text-overflow: ellipsis;
                    width: 100%;
                    border-radius: 7px;
                    background-color : #7ba8f2;
                }

            </style>
						
            <input  id="pac-inputMob" type="text" placeholder="Enter Service Location" >
            <div id="mapMobile"></div>

            <script>
            // This example requires the Places library. Include the libraries=places
            // parameter when you first load the API. For example:
            // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

            var map = null;

            function initMapMobile() {
                

                map = new google.maps.Map(document.getElementById('mapMobile'), {
                center: {lat: 27.332617, lng: -81.255690},
                zoom: 12,
                streetViewControl: false,
                mapTypeControl: false
                });

                ////Get lat and long from zipcode
            
                setLocation(map,"")
                /////////////////////////////////////

                var input = /** @type {!HTMLInputElement} */(
                    document.getElementById('pac-inputMob'));

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
                        $('#step5ZipCode').val(place.address_components[6].short_name);
                        $('#step5State').val(place.address_components[5].long_name+' ('+place.address_components[5].short_name+')');
                        $('#step5City').val(place.address_components[4].long_name);
                    }
                    

                    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                    infowindow.open(map, marker);
                });

               
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

           

            </script>
            
        
        </div>
        <div id="step-5" class="">
            <label>Select a Date & Time for service</label>
            <label>Select the date of service.</label>
            <input type="text" id="step6date" name="step6date" class="datepicker form-control"
                                style="font-size:24px;text-align:center;">
            <label>Select the time of service.</label>
            <input type="text" name="step6time" id="step6time" class="timepicker1 form-control"
                                style="z-index: 999999;font-size:24px;text-align:center;" />
            <!--<div class="order-option">
                <table>
                    <tr>
                        <td>Hour</td><td>Min</td><td></td>
                    </tr>
                    <tr>
                        <td>
                            <button id="up" onclick="setQuantity('up',this);">+</button>
                            <input type="text" id="quantityHour" value="8" size="1">
                            <button id="down" onclick="setQuantity('down',this);">-</button>
                        </td>
                        <td>
                            <button id="up" onclick="setQuantity('up',this);">+</button>
                            <input type="text" id="quantityMin" value="00" size="1">
                            <button id="down" onclick="setQuantity('down',this);">-</button>
                        </td>
                        <td>
                            <button id="up" onclick="setQuantity('up',this);">+</button>
                            <input type="text" id="quantityampm" value="AM" size="1">
                            <button id="down" onclick="setQuantity('down',this);">-</button>
                        </td>
                    </tr>
                </table>
            </div>-->
        </div>
        <div id="step-6" class="">
            <label>These Service Professionals are best suited for your scheduled repair and are all rated 4+ by previous customers.
                You can select one or the first available will respond to your work order.</label>
            <select id="selectCompanyMobWizard">

            </select>
        </div>
        <div id="step-7" class="">
            <label>Review Your Order Details</label>
            <a href="#" class="list-group-item ">
                <span class="glyphicon glyphicon-envelope"></span> Details
                <div class="d-flex w-100 justify-content-between">
                    <span><b>Repair Description:</b> Roof Material: </span><span
                        id="step8RepairDescription"></span><br>
                    <span><b>Schedule Date: </b></span><span id="step8Schedule"></span><br>
                    <span><b>Time: </b></span><span id="step8Time"></span>
                </div>
            </a>
            <div class="list-group">
                <a href="#" class="list-group-item ">
                    <span class="glyphicon glyphicon-wrench"></span> Contractor
                    <div class="d-flex w-100 justify-content-between">
                        <span><b>Name: </b></span><span id="step8CompanyName"></span><br>

                    </div>
                </a>
            </div>
            <div class="list-group">
                <a href="#" class="list-group-item ">
                    <span class="glyphicon glyphicon-map-marker"></span> Address of service
                    <div class="d-flex w-100 justify-content-between">
                        <span><b>Address: </b></span><span id="step8Address"></span><br>
                        <span><b>ZipCode: </b></span><span id="step8ZipCode"></span><br>
                        <!--<span ><b>Latitude: </b></span><span id="step8Latitude"></span><br>
                        <span ><b>Longitude: </b></span><span id="step8Longitude"></span><br>-->

                    </div>
                </a>
            </div>
        </div>
        <div id="step-8" class="">
            <h2>Almost Done!</h2>
            <label>User:</label>
            <input type="text" name="userClientOrder" id="userClientOrderMob" class=" form-control"/>
            <label>Password:</label>
            <input type="password" name="passwordClientOrder" id="passwordClientOrderMob" class=" form-control"/>
            <a style="" class="btn-primary btn-sm" href="#" onclick="login_customer_order_request()"> login</a>
            <a class="btn-primary btn-sm" href="#" onclick="fire_next_step();fire_next_step();"> register</a>
        </div>
        <div id="step-9" class="">
            <div class="list-group">
                <a href="#" class="list-group-item ">
                    <span class="glyphicon glyphicon-info-sign"></span>Emergency Service
                    <div class="d-flex w-100 justify-content-between">
                        <b>Emergency Repair Service Charge of $79 is the initial cost to secure the same
                            day service response from a qualified, pre-screened service professional. If
                            the service professional is unable to provide service within 24 hours from
                            the time you submit payment, we will refund the emergency repair charge.</b>
                    </div>
                </a>
            </div>
            <div class="list-group">
                <a href="#" class="list-group-item ">
                    <span class="glyphicon glyphicon-info-sign"></span>Roof Report
                    <div class="d-flex w-100 justify-content-between">
                        <b>Ordering a Roof Report cost $29. We create detailed aerial roof measurements
                            and diagrams that are sent to you via email and can be viewed in our web
                            site. If we cannot create a roof report for you due to obstructions or roof
                            complexity, we will refund your money.</b>
                    </div>
                </a>
            </div>
            <div>
                <button class="btn" onclick="show_payment_window()">"Agree to Initiate Service"</button>
            </div>
        </div>
        <div id="step-10" class="">
            <table>
                <tr>
                    <td>First Name</td>
                    <td><input maxlength="100" type="text" required="required" class="form-control"
                        placeholder="Enter First Name" id="firstCustomerNameMob" name="firstCustomerNameMob"/></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input maxlength="100" type="text" required="required" class="form-control"
                        placeholder="Enter Last Name" id="lastCustomerNameMob" name="lastCustomerNameMob"/></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input maxlength="100" type="email" required="required" class="form-control"
                        placeholder="Enter Email" id="emailValidationMob" name="emailValidationMob" onfocusout="validateEmail('customer',this)"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><label id="answerEmailValidate"
                        name="answerEmailValidate">Answer</label></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                    <div class="form-group">
                        <input maxlength="50" type="password" required="required" data-minlength="6" placeholder="Password"
                        id="inputPasswordMob" name="inputPasswordMob" onblur="validInputPassword(this)" class="form-control"/>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><div class="help-block col-sm-6">Minimum of 6 characters</div></td>
                </tr>
                <tr>
                    <td></td>
                    <td><label class="control-label" id="answerPasswordValidateStep6"
                        name="answerPasswordValidateStep6"></label></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input maxlength="50" type="password" required="required" data-minlength="6" placeholder="Confirm Password" 
                    id="inputPasswordConfirmMob" name="inputPasswordConfirmMob" onblur="validInputRePassword(this)" class="form-control"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><label id="answerRePasswordValidateStep6" name="answerRePasswordValidateStep6"></label></td>
                </tr>
                <tr>
                    <td>Phone number</td>
                    <td><input maxlength="100" type="number" min="1111111111" max="9999999999"
                        onkeypress="return isNumber(event)" required="required" class="form-control"
                        placeholder="Enter phone number" id="customerPhoneNumberMob" name="customerPhoneNumberMob"/></td>
                </tr>
               
                <tr>
                    <td></td>
                    <td>
                    
                    <label class="control-label ">PLEASE READ THE TERMS THOROUGHLY AND CAREFULLY. BY USING THE
                        PLATFORM, YOU AGREE TO BE BOUND BY THESE TERMS. IF YOU DO NOT AGREE TO THESE TERMS, THEN YOU MAY
                        NOT ACCESS OR USE THE PLATFORM</label>
                    <input type="checkbox" name="termsServiceAgreeMob" id="termsServiceAgreeMob" value="1"><span>I agree with the RoofServiceNow</span> <a
                        href="?controller=termsconditions&accion=showinfo" data-toggle="modal" target="_blank"> Terms
                        and Conditions</a>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><a class="btn-primary btn-sm" href="#" onclick="saveCustomerData('Order')"> register</a></td>
                </tr>
            </table>
            
                  
            </div>    
        </div>
    </div>
</div>  
<script>
/*$(document).ready(function() {
$('.timepicker').mdtimepicker();
});*/
</script>
