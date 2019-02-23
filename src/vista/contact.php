
	
		<!-- breadcrum-area start-->
		<div class="breadcrum-area pt-120 pb-100 bg-img-2 bg-opacity" style="display:none;">
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
		<div class="contact-area mobhead-area pt-80 pb-60">
			<div class="container">
                               <div class="section-heading text-center">
                                        <h2>Contact us </h2>
                                        <p>Got a question? need some help signing up? Do not hesitate to reach out.</p>
                                </div>
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-6 mb-20">
						<div class="contact-wrapper text-center">
							<div class="contact-icon">
								<i class="fa fa-map-marker"></i>
							</div>
							<div class="contact-text">
								<p>Location Near You</p>
                            </div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 mb-20">
						<div class="contact-wrapper text-center">
							<div class="contact-icon">
								<i class="fa fa-phone"></i>
							</div>
							<div class="contact-text">
								<p>(888) 400-5996 </p>
                            </div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 mb-20">
						<div class="contact-wrapper text-center">
							<div class="contact-icon">
								<i class="fa fa-envelope"></i>
							</div>
							<div class="contact-text">
								<p>support@roofservicenow.com<br>www.roofservicenow.com</p>
                            </div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 mb-20">
						<div class="contact-wrapper text-center">
							<div class="contact-icon">
								<i class="fa fa-clock-o"></i>
							</div>
							<div class="contact-text">
								<p>Schedule a demo today!</p>
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
							<form id="rsncform1" action=""  method="post">
								<label>your name<span class="required">*</span></label>
									<input type="text" id="name" name="name"  placeholder="Name" />
								<label>your email<span class="required">*</span></label>
									<input type="text" id="email" name="email" placeholder="Email" />
								<label>subject<span class="required">*</span></label>
									<input type="text" id="subject" name="subject" placeholder="Subject" />
								<label>Your Message<span class="required">*</span></label>	
									<textarea name="message" id="message" placeholder="Message"></textarea>	
								<button id='contactsub' type="button">Send Message</button>
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
       
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByZeiCm6nbhUpByOG-M1gGm7BIVIolopM"></script>
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
                    center: new google.maps.LatLng(25.7617, -80.1918), // Miami

                    // How you would like to style the map. 
                    // This is where you would paste any style found on Snazzy Maps.
				styles: 
[
    {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#fa511a"
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#005678"
            }
        ]
    },
    {
        "featureType": "transit.station.airport",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#eb5c00"
            },
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#005678"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "labels",
        "stylers": [
            {
                "color": "#ffffff"
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
                    position: new google.maps.LatLng(25.7617, -80.1918),
                    map: map,
                    title: 'Snazzy!'
                });
            }


function sendcontactemail(id){
            var data = $('#'+id).serialize();
           //alert(data);
             $.ajax({
                type: 'POST',
                url: "../controlador/ajax/sendcontactemail.php",
                data: data,
                 success: function(data) {
                     $('#cform1').html(data);
let timerInterval
swal({
  type:'success',
  title: 'Thanks for reaching out!',
  html: 'A RoofServiceNow Specialist should be reaching out to you within the next 24hrs </br></br></br> Autoclose in <strong></strong>',
  timer: 5000,
  width:700,
  imageUrl:'../img/logo.png',  
imageWidth: 250,
  imageHeight: 250,
onOpen: () => {
    swal.showLoading()
    timerInterval = setInterval(() => {
      swal.getContent().querySelector('strong')
        .textContent = swal.getTimerLeft()
    }, 100)
  },
  onClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  if (
    // Read more about handling dismissals
    result.dismiss === swal.DismissReason.timer
  ) {
    console.log('contact email successful');
  }
})
var myBtn = document.getElementById('contactsub');
 myBtn.addEventListener('click', function(event)
{
   sendcontactemail('rsncform1');

$('#rsncform1').submit(function(event) {
    event.preventDefault();

});

});
                      },
                  error: function(data) { // if error occured
                   sweetAlert("Oops...", "Something went wrong!", "error");

                    },
                            }); }

 var myBtn = document.getElementById('contactsub');
 myBtn.addEventListener('click', function(event)
{
   sendcontactemail('rsncform1');

$('#rsncform1').submit(function(event) {
    event.preventDefault();
alert('noob');
});
 });

		
</script>
