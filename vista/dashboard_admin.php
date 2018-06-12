<div class="row">
    <div class="col-md-2">
        <div class="vertical-menu">
            <a href="#" class="active">Actions</a>
            <a href="#">Estimating Wizard</a>
            <a href="#">Scheduler</a>
            <a href="#">Metrics in your Service Area</a>
            <a href="#">34 Emergency Repairs </a>
            <a href="#">1 Emergency Repairs Pending</a>
            <a href="#">3 Assigned</a>
            <a href="#">1 RepairCrew Available</a>
            <a href="#">Complete Your Registration</a>
            
        </div>
    </div>
    <div class="col-md-10">
        <style>
            /* Set the size of the div element that contains the map */
            #map {
                height: 350px;  /* The height is 400 pixels */
                width: 100%;  /* The width is the width of the web page */
                padding: 10px;
            }
        </style>
        <div id="map"></div>
        <script>
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 25.745693, lng: -80.375028},
            zoom: 10
            });
        }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&callback=initMap"
        async defer></script>

         <div class="table-responsive">          
                            <table class="table" id="table_drivers">
                                <thead>
                                <tr>
                                    <th>Repair ID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
        </div>
    </div>
</div>

