<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
						<script type="text/javascript">
							window.onload = function () {
								var gmarkers = [];
								var mapOptions = {
									center: new google.maps.LatLng(27.332617, 72.8200),
									zoom: 14
									
								};
								var infoWindow = new google.maps.InfoWindow();
								var latlngbounds = new google.maps.LatLngBounds();
								var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
								google.maps.event.addListener(map, 'click', function (e) {
									removeMarkers();
									alert("Latitude: " + e.latLng.lat() + "\r\nLongitude: " + e.latLng.lng());
									$("#step5Logintud").val(e.latLng.lng());
									$("#step5Latitude").val(e.latLng.lat());
									var myLatLng = {lat: e.latLng.lat(), lng: e.latLng.lng()};
									var marker = new google.maps.Marker({
										position: myLatLng,
										map: map,
										title: 'Hello World!'
									});
									gmarkers.push(marker);
								});

								function removeMarkers(){
									for(i=0; i<gmarkers.length; i++){
										gmarkers[i].setMap(null);
									}
								}
							}
						</script>
						<script async defer
							src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&libraries=visualization&callback=initMap">
						</script>
						<div id="dvMap" style="width: 1000px; height: 500px">
						</div>