<div class="row">
    <div class="col-md-2">
        <div class="vertical-menu">
            <a href="#" class="active">Actions</a>
            <a href="#">Profile</a>
            
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
                /*var ref = firebase.app().database().ref("Orders");
                ref.once('value').then(function (snap) {
                            datos=snap.val();
                            for(k in datos){
                                fila=datos[k];
                                pos={lat:parseFloat(fila.Latitude),lng:parseFloat(fila.Longitude)};
                                marker = new google.maps.Marker({position: pos, map: map});
                            }

                
                        
                        
                        console.log('snap.val()', snap.val());
                        });*/

                var ref = firebase.database().ref("Orders");
                ref.orderByChild("CustomerID").equalTo("<?php echo $_actual_customer['CustomerID'] ?>").once("value", function(snapshot) {

                    datos=snapshot.val();
                            for(k in datos){
                                fila=datos[k];
                                pos={lat:parseFloat(fila.Latitude),lng:parseFloat(fila.Longitude)};
                                marker = new google.maps.Marker({position: pos, map: map});
                            }

                console.log(snapshot.val());
                
                });
            }
        </script>

        <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyB5HnjwLpr-WqknpRRU5WhrHCg6feVaYss",
            authDomain: "pruebabasedatos-eacf6.firebaseapp.com",
            databaseURL: "https://pruebabasedatos-eacf6.firebaseio.com",
            projectId: "pruebabasedatos-eacf6",
            storageBucket: "pruebabasedatos-eacf6.appspot.com",
            messagingSenderId: "120748340913"
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


        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&libraries=visualization&callback=initMap">
        </script>

       

        <div class="table-responsive">          
            <table class="table" id="table_drivers">
                <thead>
                <tr>
                    <th>Repair Type</th>
                    <th>Repair ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($_array_customer_to_show as $key => $order) { ?>
                        <tr>
                            <td><?php echo $order['RequestType']?></td>
                            <td><?php echo $order['OrderNumber']?></td>
                            <td><?php echo "" ?></td>
                            <td><?php if(isset($order['RepAddress'])){echo $order['RepAddress'];} ?></td>
                            <td><?php echo "" ?></td>
                            <td><?php echo $order['Hlevels'].", ".$order['Rtype'].", ".$order['Water']?></td>
                            <td><?php echo $order['Status']?></td>                            
                            <td><?php echo $order['EstAmtTime']?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
              
</div>



    				


