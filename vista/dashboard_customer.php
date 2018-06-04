<br>
<br>
<br>

    <h3>WELCOME TO ROOFADVISOR </h3>
    <p>Here you can view your orders and their state, also you can manage your profile</p>

   
    
    <ul class="nav nav-tabs">
        <li><a data-toggle="tab" href="#profile">Profile</a></li>
        <li class="active"><a data-toggle="tab" href="#orders">Orders</a></li>
       
    </ul>

    <div class="tab-content">
        <!--Div profile-->
        <div id="profile" class="tab-pane fade ">
            <h3>Profile</h3>
            <form role="form">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label ">Customer ID</label>
                        <input maxlength="100" disabled type="text" class="form-control"  id="customerID" name="customerID" value="<?php echo $_actual_customer['CustomerID'] ?>" />
                    </div>

                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" id="firstCustomerName" name="firstCustomerName" value="<?php echo $_actual_customer['Fname'] ?>" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" id="lastCustomerName" name="lastCustomerName" value="<?php echo $_actual_customer['Lname'] ?>" />
                    </div>  
                    <div class="form-group">
                        <label class="control-label ">Email</label>
                        <input maxlength="100" disabled type="text" required="required" class="form-control" placeholder="Enter Email" id="customerEmail" name="customerEmail" value="<?php echo $_actual_customer['Email'] ?>"/>
                    </div> 
                    <div class="form-group">
                        <label class="control-label">Address</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="customerAddress" name="customerAddress" value="<?php echo $_actual_customer['Address'] ?>"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">City</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter city" id="customerCity" name="customerCity" value="<?php echo $_actual_customer['City'] ?>"/>
                    </div> 
                    <div class="form-group">
                        <label class="control-label">State</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter state" id="customerState" name="customerState" value="<?php echo $_actual_customer['State'] ?>"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Zip code</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter zip code" id="customerZipCode" name="customerZipCode" value="<?php echo $_actual_customer['ZIP'] ?>"/>
                    </div> 
                    <div class="form-group">
                        <label class="control-label">Phone number</label>
                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter phone number" id="customerPhoneNumber" name="customerPhoneNumber"  value="<?php echo $_actual_customer['Phone'] ?>"/>
                    </div>    
                </div>    
            </form>
        </div>

        <!--Div orders-->
        <div id="orders" class="tab-pane fade in active">
            <h3>Orders</h3>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">          
                            <table class="table" id="table_drivers">
                                <thead>
                                <tr>
                                    <th>OrderNumber</th>
                                    <th>RepAddress</th>
                                    <th>RepCity</th>
                                    <th>RepState</th>
                                    <th>RepZIP</th>
                                    <th>RequestType</th>
                                    <th>Status</th>
                                    <th>ETA</th>
                                    <th>Status</th>
                                    <th>EstAmtMat</th>
                                    <th>EstAmtTime</th>
                                    <th>EstTime</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($_array_customer_to_show as $key => $order) { ?>
                                        <tr>
                                            <td><?php echo $order['OrderNumber']?></td>
                                            <td><?php echo $order['RepAddress']?></td>
                                            <td><?php echo $order['RepCity']?></td>
                                            <td><?php echo $order['RepState']?></td>
                                            <td><?php echo $order['RepZIP']?></td>
                                            <td><?php echo $order['RequestType']?></td>
                                            <td><?php echo $order['Status']?></td>
                                            <td><?php echo $order['ETA']?></td>
                                            <td><?php echo $order['Status']?></td>
                                            <td><?php echo $order['EstAmtMat']?></td>
                                            <td><?php echo $order['EstAmtTime']?></td>
                                            <td><?php echo $order['EstTime']?></td>
                                            <td><a href="#" class="btn-danger form-control" role="button" data-title="johnny" id="deleteRowDriver" data-id="1">Detail</a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>
    
                        <style>
                        /* Set the size of the div element that contains the map */
                        #map {
                            height: 700px;  /* The height is 400 pixels */
                            width: 100%;  /* The width is the width of the web page */
                        }
                        </style>

                        <div id="map"></div>

                        <script>
                            // Initialize and add the map
                            function initMap() {
                                // The location of Uluru
                                var uluru = {lat: 27, lng: -81};
                                // The map, centered at Uluru
                                var map = new google.maps.Map(
                                    document.getElementById('map'), {zoom: 6, center: uluru});
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

                                    </div>
                                </div>
                            </div>
                            
                            <div id="maps" class="tab-pane fade">
                                <h3>Map</h3>
                                <script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>
                        
                                <style>
                                /* Set the size of the div element that contains the map */
                                #map {
                                    height: 700px;  /* The height is 400 pixels */
                                    width: 100%;  /* The width is the width of the web page */
                                }
                                </style>

                                <div id="map"></div>

                                <script>
                                    // Initialize and add the map
                                    function initMap() {
                                        // The location of Uluru
                                        var uluru = {lat: 27, lng: -81};
                                        // The map, centered at Uluru
                                        var map = new google.maps.Map(
                                            document.getElementById('map'), {zoom: 6, center: uluru});
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
                    </div>
                </div>
            </div>
        <div>
    </div>
    
    				


