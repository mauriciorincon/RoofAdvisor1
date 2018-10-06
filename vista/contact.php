
		
		<!-- breadcrum-area start-->
		<div class="breadcrum-area pt-120 pb-100 bg-img-2 bg-opacity">
			<div class="container">
				<div class="breadcrum-content">
					<ol class="breadcrumb">
					  <li><a href="#">home</a></li>
					  <li class="active">Contact</li>
					</ol>
				</div>
			</div>
		</div>
		<!-- breadcrum-area end-->
		<!-- contact-area start-->
		<div class="contact-area pt-80 pb-60">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-6 mb-20">
						<div class="contact-wrapper text-center">
							<div class="contact-icon">
								<i class="fa fa-map-marker"></i>
							</div>
							<div class="contact-text">
								<p>30 NEWBURY ST<br>BOSTON, MA</p>
                            </div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 mb-20">
						<div class="contact-wrapper text-center">
							<div class="contact-icon">
								<i class="fa fa-phone"></i>
							</div>
							<div class="contact-text">
								<p>(877) 529 5995</p>
                            </div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 mb-20">
						<div class="contact-wrapper text-center">
							<div class="contact-icon">
								<i class="fa fa-envelope"></i>
							</div>
							<div class="contact-text">
								<p>info@roofservicenow.com<br>www.roofservicenow.com</p>
                            </div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 mb-20">
						<div class="contact-wrapper text-center">
							<div class="contact-icon">
								<i class="fa fa-clock-o"></i>
							</div>
							<div class="contact-text">
								<p>Always open</p>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- contact-area end-->
		<!-- map-area start-->
		<div class="contact-widget pb-80">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6">
						<div class="contact-form">
							<form action="#">
								<label>your name<span class="required">*</span></label>
									<input type="text" placeholder="" />
								<label>your email<span class="required">*</span></label>
									<input type="text" placeholder="" />
								<label>subject<span class="required">*</span></label>
									<input type="text" placeholder="" />
								<label>Your Message<span class="required">*</span></label>	
									<textarea name="message" placeholder=""></textarea>	
								<button>Send Message</button>
							</form>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6">
						<div class="map-area">
							<div id="map"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- map-area end-->
		
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_5nh83Fd_eMJ-Xii87WOpSDhSzHa7le4"></script>
		<script>
		
            // When the window has finished loading create our google map below
            google.maps.event.addDomListener(window, 'load', init);
        
            function init() {
                // Basic options for a simple Google Map
                // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
                var mapOptions = {
                    // How zoomed in you want the map to start at (always required)
                    zoom: 11,

                    scrollwheel: false,

                    // The latitude and longitude to center the map (always required)
                    center: new google.maps.LatLng( 25.7617, 80.1918), // Miami

                    // How you would like to style the map. 
                    // This is where you would paste any style found on Snazzy Maps.
				styles: [
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#46bcec"
            },
            {
                "visibility": "on"
            }
        ]
    }
]
}

                // Get the HTML DOM element that will contain your map 
                // We are using a div with id="map" seen below in the <body>
                var mapElement = document.getElementById('map');

                // Create the Google Map using our element and options defined above
                var map = new google.maps.Map(mapElement, mapOptions);

                // Let's also add a marker while we're at it
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(25.7617, 80.1918),
                    map: map,
                    title: 'Miami'
                });
            }
		</script>
		
