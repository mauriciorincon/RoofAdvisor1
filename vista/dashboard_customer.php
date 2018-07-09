

<div class="row">
    <div class="col-md-2">
        <div class="vertical-menu">
            <a href="#" style="background-color: #2765CF" ><span class="glyphicon glyphicon-cog"></span> Actions</a>
            <a href="#" class="active" data-toggle="collapse" data-target="#mapDashBoard1" onclick="hideShowDivs('customerDashProfile1');hideShowDivs('scheduleCompany');setActiveItemMenu(this);" >Orders</a>
            <a href="#" data-toggle="collapse" data-target="#customerDashProfile1" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('scheduleCompany');setActiveItemMenu(this);">Profile</a>
            <a href="#" data-toggle="collapse" data-target="#scheduleCompany" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('customerDashProfile1');setActiveItemMenu(this);">Scheduler</a>
            <a href="#">Estimating Wizard</a>
            <a href="#">Metrics in your Service Area</a>
            <a href="#">34 Emergency Repairs </a>
            <a href="#">1 Emergency Repairs Pending</a>
            <a href="#">3 Assigned</a>
            <a href="#">1 RepairCrew Available</a>
            <a href="#">Complete Your Registration</a>
            
        </div>
    </div>
    <div class="col-md-10" id="mapDashBoard">

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
                                <td><a class="btn-info btn-sm" data-toggle="modal"  
                                                href="#myModal2" 
                                                onClick=""> 
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
    
    <div class="col-md-10" id="customerDashProfile">
    
        <form role="form">
                            
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
                    <input type="text" class="form-control" required="required"  placeholder="Enter state" id="customerState" name="customerState" value="<?php echo $_actual_customer['State'] ?>"/>
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
        </form>
                
    </div>

    <div class="col-md-10" id="customerCalendar">
        <div class="collapse" id="scheduleCompany">
            <?php   echo '<h2>June 2018</h2>';
                    $oCalendar=new calendar();
                    echo $oCalendar->draw_controls(6,2018);
                    $_eventsArray=$oCalendar->getEvents(6,2018);
                    echo $oCalendar->draw_calendar(6,2018,$_eventsArray);
            ?>
        </div>
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


