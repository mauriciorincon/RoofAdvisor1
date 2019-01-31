<!--<div id="mobilewizardmaster">-->
<div id="smartwizard">

    <!--<ul style="">-->
    <ul style="display:none">
        <li><a href="#step-1">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-2">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-3">Step Title<br /><small>Step description</small></a></li>
        <li><a href="#step-4">Step Title<br /><small>Step description</small></a></li>
    </ul>

    <div>
        <div id="step-1" class="">
        Please type the zip code
        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter your zip code" id="zipCodeBegin" name="zipCodeBegin" />
        <label class="control-label text-center h1" id="answerZipCode"><big></big></label>
        </div>
        <div id="step-2" class="">
            <label>Select Service</label>
            <select id="typeServiceCompany1" name="typeServiceCompany1"  onchange="setServiceType()" class="form-control">
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
            <style>
                /* Set the size of the div element that contains the map */
                #mapMobile {
                    height: 400px;  /* The height is 400 pixels */
                    width: 100%;  /* The width is the width of the web page */
                }
                #pac-input {
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
						
            <input  id="pac-input" type="text" placeholder="Enter a location" >
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
    </div>
</div>  