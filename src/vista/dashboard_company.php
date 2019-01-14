<input type="hidden" value="<?php echo $_actual_company['CompanyID']?>" id="companyIDhidden" >
<input type="hidden" value="" id="activeCustomerIDhidden">
<input type="hidden" value="" id="activeCustomerAddress">
<?php
echo '<script>var userMailCompany=\''.$_SESSION['email'].'\'; </script>';
echo '<script>var actualCompanyStatus=\''.$_actual_company['CompanyStatus'].'\'; </script>';
?>

<div id="db-cus-main" style="margin-bottom:-5px !important;">
    <div class="btn-toolbar" style="margin-bottom:20px;" role="toolbar" aria-label="Toolbar with button groups">
		<div class="btn-group mr-2" role="group" aria-label="First group">
            <button type="button" class="btn btn-primary active" id="orderButtonCompany"  data-toggle="collapse" data-target="#mapDashBoard1" onclick="hideShowDivs('companyDashProfile1');hideShowDivs('companyDashEmployee1');hideShowDivs('scheduleCompany');hideShowDivs('listCustomerByCompany');setActiveItemMenu(this);">Orders</button>
			<button type="button" class="btn btn-primary "  data-toggle="collapse" data-target="#companyDashProfile1" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('companyDashEmployee1');hideShowDivs('scheduleCompany');hideShowDivs('listCustomerByCompany');setActiveItemMenu(this);">Profile</button>
			<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#companyDashEmployee1" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('companyDashProfile1');hideShowDivs('scheduleCompany');hideShowDivs('listCustomerByCompany');setActiveItemMenu(this);" >Employee</button>
            <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#scheduleCompany" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('companyDashProfile1');hideShowDivs('companyDashEmployee1');hideShowDivs('listCustomerByCompany');setActiveItemMenu(this);">Scheduler</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myFilterWindow" onclick="">Filter Options</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myPostCard" onclick="showPostCardInfo('<?php echo trim($_actual_company['CompanyID'])?>')">Post Card</button>
            <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#listCustomerByCompany" onclick="hideShowDivs('mapDashBoard1');hideShowDivs('companyDashProfile1');hideShowDivs('companyDashEmployee1');hideShowDivs('scheduleCompany');getListCustomer('table_list_customer_by_company','<?php echo $_actual_company['CompanyID'] ?>');setActiveItemMenu(this);">Customers</button>
            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myUrls" onclick="">Resources</button>
        </div>
    </div>

    <?php echo '<script> 
        var iconBase =\''. $_SESSION['image_path'].'\';
        var address =\''.  $_actual_company['CompanyAdd1']." ".$_actual_company['CompanyAdd2'].'\';
        var companyID =\''. $_actual_company['CompanyID'].'\';
    </script>'?>

<div id="mapDashBoard1" class="collapse in">
        <script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>

        <style>
            /* Set the size of the div element that contains the map */
            #map {
                height: 400px;  /* The height is 400 pixels */
                width: 100%;  /* The width is the width of the web page */
            }
        </style>
        <a href="#" data-toggle="collapse" data-target="#onlyMapCompanyDashboard">Hide/Show Map</a>
        <div id="onlyMapCompanyDashboard" class="collapse in">
            <div id="map"></div>
        </div>
        
        <script>
        
            function initialization(){	
					initMap();
                    initMapOrder();
                    initMap1();
            }
            
            var marketrs=[];
            var contractorMarker=[];
            var pendingOrders=[];
            var mapObject;
            var infowindow;
            var orderOpenContractor=[];
        
            
            var scheduleRepairCount=0;
            var emergencyRepairCount=0;
            var reportRepairCount=0;
            var postCardCount=0;

            var openService=0;
            var closeService=0;
            // Initialize and add the map
            function initMap() {
                // The location of Uluru
                var uluru = {lat: 25.745693, lng: -80.375028};
                // The map, centered at Uluru
                mapObject = new google.maps.Map(
				document.getElementById('map'), {zoom: 11, center: uluru,streetViewControl: false,
                                mapTypeControl: false});

                // The marker, positioned at Uluru
                //var marker = new google.maps.Marker({position: uluru, map: map});
                var marker="";
                infowindow = new google.maps.InfoWindow();
                
                var iconBase = iconBase+'img_maps/';

               

                

                var geocoder = new google.maps.Geocoder();
                

                if(address != "" && address != null && address != " "){
                    geocodeAddress(geocoder,map,address,iconBase);
                }
                
                

                var ref = firebase.database().ref("Orders");
                ref.orderByChild("CompanyID").equalTo("<?php echo $_actual_company['CompanyID'] ?>").once("value", function(snapshot) {

                    datos=snapshot.val();
                    for(k in datos){
                        fila=datos[k];

                        switch (fila.RequestType) {
                            case "E":
                                emergencyRepairCount++;
                                break;
                            case "S":
                                scheduleRepairCount++;
                                break;
                            case "R":
                                reportRepairCount++;
                                break;
                            case "P":
                                postCardCount++;
                                break;
                            default:
                        }

                        switch (fila.Status) {
                            case "K":
                                closeService++;
                                break;
                            default:
                                openService++;
                                break;
                        }
                        var marker={
                            lat: parseFloat(fila.Latitude),
                            lng: parseFloat(fila.Longitude),
                            icon: iconBase+'library_maps.png',
                            text: fila.SchDate
                        };
                        var oMarket=addMarket(marker,fila,infowindow);
                        
                        marketrs.push(oMarket);

                        if(fila.Status=='D'){
                            if(fila.ContractorID!="" || fila.ContractorID!=undefined){
                                
                                orderOpenContractor.push(fila.ContractorID);
                                var refContractor = firebase.database().ref("/Contractors/"+fila.ContractorID);
                                refContractor.once("value", function(snapshot) {
                                    var updateContractor = snapshot.val();
                                    var marker={
                                        lat: parseFloat(updateContractor.CurrentLocation.latitude),
                                        lng: parseFloat(updateContractor.CurrentLocation.longitude),
                                        icon: iconBase+'library_maps.png'
                                    };
                                    var oMarket=addMarketContractor(marker,updateContractor);
                                    contractorMarker.push(oMarket);
                                });
                            }
                        }
                    }
                
                });
                
                // Retrieve new orders as they are added to our database
                ref.on("child_changed", function(snapshot, prevChildKey) {
                    
                    var updateOrder = snapshot.val();
                    console.log(updateOrder);
                    if(updateOrder.CompanyID==companyID || updateOrder.CompanyID=='' ){
                        row=validateExist(updateOrder.OrderNumber);
						if(row==-1 || row==undefined){
                                if (pendingOrders.includes(updateOrder.OrderNumber)){
                                    
                                }else{
                                    pendingOrders.push(updateOrder.OrderNumber);    
                                    addOrderToTable(updateOrder,customerID,map,infowindow,iconBase);
                                }
                                
                                
								
						}else{
								updateOrderOnTable(updateOrder,row);
						}
                        removeMarket(updateOrder.OrderNumber);
                        var marker={
                            lat: parseFloat(updateOrder.Latitude),
                            lng: parseFloat(updateOrder.Longitude),
                            icon: iconBase+'library_maps.png',
                            text: updateOrder.SchDate
                        };
                        var oMarket=addMarket(marker,updateOrder,infowindow);
                        marketrs.push(oMarket);

                        //Function to paint driver position
                        if(updateOrder.Status=='D'){
                            if(updateOrder.ContractorID!="" || updateOrder.ContractorID!=undefined){
                                if (orderOpenContractor.indexOf(updateOrder.ContractorID)==-1){
                                    orderOpenContractor.push(fila.ContractorID);
                                }
                                var refContractor = firebase.database().ref("/Contractors/"+updateOrder.ContractorID);
                                refContractor.once("value", function(snapshot) {
                                    var updateContractor = snapshot.val();
                                    removeMarketContractor(updateContractor.ContractorID);
                                    var marker={
                                        lat: parseFloat(updateContractor.CurrentLocation.latitude),
                                        lng: parseFloat(updateContractor.CurrentLocation.longitude),
                                        icon: iconBase+'library_maps.png'
                                    };
                                    var oMarket=addMarketContractor(marker,updateContractor);
                                    contractorMarker.push(oMarket);
                                });
                            }
                        }else{
                            removeMarketContractor(updateOrder.ContractorID);
                        }

                    }else{
                        if(updateOrder.Status!='A'){
                            row=validateExist(updateOrder.OrderNumber);
                            if(row==-1 || row==undefined){
                                removeOrderOnTable(updateOrder);
                            }
                        }
					}
                    console.log("Data: " + updateOrder.OrderNumber);
                    return false;
                });

                // Remove orders that are deleted from database
                ref.on("child_removed", function(snapshot) {
                    var deletedOrder = snapshot.val();
                        row=validateExist(deletedOrder.OrderNumber);
                        if(row==-1 || row==undefined){
                            removeOrderOnTable(deletedOrder);
                        }
                    console.log("Data: " + deletedOrder.OrderNumber);
                    
                });

                var refOpen = firebase.database().ref("Orders");
                refOpen.orderByChild("CompanyID").equalTo("").once("value", function(snapshot) {
                    datos=snapshot.val();
                    for(k in datos){
                        fila=datos[k];

                        switch (fila.Status) {
                            case "K":
                                closeService++;
                                break;
                            default:
                                openService++;
                                break;
                        }
                        var marker={
                            lat: parseFloat(fila.Latitude),
                            lng: parseFloat(fila.Longitude),
                            icon: iconBase+'library_maps.png',
                            text: fila.SchDate
                        };
                        var oMarket=addMarket(marker,fila,infowindow);
                        marketrs.push(oMarket);
                    }
                });
                
            }

            function addMarket(data,fila,infowindow){
                    var image="";
					image=getIconImage(fila.Status)
					var oMarket= new google.maps.Marker({
						position: new google.maps.LatLng(data.lat,data.lng),
						map:mapObject,
						icon:'img/img_maps/'+image,
                        id:fila.OrderNumber,
                        typeService:fila.RequestType,
                        status:fila.Status
					});

					oMarket.addListener('click', function() {
                        var customerName="";
                        var contractorName="";
                        getContractorName(fila.ContractorID).then(function(contractorName){
                            getCustomerName(fila.CustomerFBID).then(function(customerName) {
                            if(fila.ContractorID==""){
                                infowindow.setContent('<p><b>Order #:</b>'+fila.OrderNumber+'  <br><b>Address:</b>XXXXXX XXXXXX XXXXXX'+
                                                        '</b><br><b>Status:</b>'+getStatus(fila.Status)+
                                                        '<br><b>Date:</b>'+fila.SchDate+' '+fila.SchTime+
                                                        '<br><b>Customer:</b>XXXXXXX XXXXXXXX'+
                                                        '<br><b>Contractor:</b>XXXXXXX XXXXXXX</p>');
                            }else{
                                infowindow.setContent('<p><b>Order #:</b>'+fila.OrderNumber+'  <br><b>Address:</b>'+fila.RepAddress+' '+fila.RepCity+' '+fila.RepState+
                                                        '</b><br><b>Status:</b>'+getStatus(fila.Status)+
                                                        '<br><b>Date:</b>'+fila.SchDate+' '+fila.SchTime+
                                                        '<br><b>Customer:</b>'+customerName+
                                                        '<br><b>Contractor:</b>'+contractorName+'</p>');
                            }
                            
                                infowindow.open(map, oMarket); 
                            });    
                        }); 
                    });
					return oMarket;
                }

                
            
            function geocodeAddress(geocoder, resultsMap,varAddress,path) {
                var address = varAddress;
                geocoder.geocode({'address': address}, function(results, status) {
                if (status === 'OK') {
                    resultsMap.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location,
                    label:"C"
                    
                    });
                    //console.log(results);
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
                });
            }

            function bindInfoWindow(marker, html) {
                google.maps.event.addListener(marker, 'click', function (event) {
                    infowindow.setContent(html);
                    infowindow.position = event.latLng;
                    infowindow.open(map, marker);
                });
            }

            function addOrderToTable(dataOrder,companyID,map,infowindow,iconBase){
                var t = $('#table_orders_company').DataTable();
                var requestType=getRequestType(dataOrder.RequestType);
                var status=getStatus(dataOrder.Status);
                
                var dataCustomer="";
                var companyActions="";
                var dataContractor="";
                                       
                valueMat=isNaN(parseInt(dataOrder.EstAmtMat)) ? 0 : parseInt(dataOrder.EstAmtMat);
                valueTime=isNaN(parseInt(dataOrder.EstAmtTime)) ? 0 : parseInt(dataOrder.EstAmtTime);

                valueMatA=isNaN(parseInt(dataOrder.ActAmtMat)) ? 0 : parseInt(dataOrder.ActAmtMat);
                valueTimeA=isNaN(parseInt(dataOrder.ActAmtTime)) ? 0 : parseInt(dataOrder.ActAmtTime);
                        
                if(dataOrder.Status=="F" && dataOrder.RequestType=="P"){
                        
						valorTotal=(parseInt(valueMat)+parseInt(valueTime));
						
						estimateAmount='<a class="btn-warning btn-sm" data-toggle="modal"'+
											'href="#myEstimateAmount" '+
											'onClick="getEstimateAmount(\''+dataOrder.FBID+'\')"> '+
											'<span class="glyphicon glyphicon-check"></span>Approve Amt:'+valorTotal+
										'</a>';
					}else{

						estimateAmount=(parseInt(valueMat)+parseInt(valueTime));
						estimateAmount = estimateAmount ? '$'+estimateAmount : '$0';		
                }
                if(dataOrder.Status=="J" && dataOrder.RequestType=="P"){
						valorTotal=(parseInt(valueMatA)+parseInt(valueTimeA));
						finalAmount='<a class="btn-success btn-sm" data-toggle="modal"'+
											'href="#myFinalAmount" '+
											'onClick="getFinalAmount(\''+dataOrder.FBID+'\')"> '+
											'<span class="glyphicon glyphicon-check"></span>Approve Amt:'+valorTotal+
										'</a>';
                }else{
                    finalAmount=parseInt(valueMatA)+parseInt(valueTimeA);
                    finalAmount = finalAmount ? '$'+finalAmount : '$0';
                }
                if(dataOrder.RequestType=='P'){
                    description='Number of Postcard: '+dataOrder.postCardValue;
                }else{
                    description=dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water;
                }

                actualCompanyId=$('#companyIDhidden').val();

                
                
                    getContractorName(dataOrder.ContractorID).then(function(contractorName){
                        dataContractor=takeJobCompany(dataOrder,actualCompanyStatus,contractorName);

                        if(dataOrder.CompanyID==""){
                            dataCustomer="XXXXX XXXXX XXXXX XXXXX";
                            companyActions=actionsCompany(dataOrder,actualCompanyStatus);
                                t.row.add( [
                                        dataOrder.OrderNumber,
                                        dataOrder.SchDate,
                                        dataOrder.SchTime,
                                        dataCustomer,
                                        dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water,
                                        requestType,
                                        status,
                                        estimateAmount,
                                        finalAmount,
                                        dataOrder.PaymentType,
                                        dataContractor,
                                        companyActions,
                                    ] ).draw( false );
                                
                                var marker={
                                    lat: parseFloat(dataOrder.Latitude),
                                    lng: parseFloat(dataOrder.Longitude),
                                    icon: iconBase+'library_maps.png',
                                    text: dataOrder.SchDate
                                };
                                var oMarket=addMarket(marker,dataOrder,infowindow);
                                marketrs.push(oMarket);

                                for( var i = 0; i < pendingOrders.length-1; i++){ 
                                    if ( pendingOrders[i] === dataOrder.OrderNumber) {
                                        pendingOrders.splice(i, 1); 
                                    }
                                }
                        }else{
                            getCustomerData(dataOrder.CustomerFBID,dataOrder.RepAddress).then(function(customerDataX) {  
                                dataCustomer=customerDataX;

                                companyActions=actionsCompany(dataOrder,actualCompanyStatus);
                                t.row.add( [
                                        dataOrder.OrderNumber,
                                        dataOrder.SchDate,
                                        dataOrder.SchTime,
                                        dataCustomer,
                                        dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water,
                                        requestType,
                                        status,
                                        estimateAmount,
                                        finalAmount,
                                        dataOrder.PaymentType,
                                        dataContractor,
                                        companyActions,
                                    ] ).draw( false );
                                
                                var marker={
                                    lat: parseFloat(dataOrder.Latitude),
                                    lng: parseFloat(dataOrder.Longitude),
                                    icon: iconBase+'library_maps.png',
                                    text: dataOrder.SchDate
                                };
                                var oMarket=addMarket(marker,dataOrder,infowindow);
                                marketrs.push(oMarket);

                                for( var i = 0; i < pendingOrders.length-1; i++){ 
                                    if ( pendingOrders[i] === dataOrder.OrderNumber) {
                                        pendingOrders.splice(i, 1); 
                                    }
                                }
                            });
                        } 
                    });
            }

            function updateOrderOnTable(dataOrder,row){
                var value = dataOrder.OrderNumber;
                
                
					var t = $('#table_orders_company').DataTable();
					var row=t.rows( function ( idx, data, node ) {
						return data[0] === value;
					} ).indexes();

                var $row = t.row(row);
                //$row=$("#table_orders_company").find('tr:eq('+(row+1)+')');

                var requestType=getRequestType(dataOrder.RequestType);
                            var status=getStatus(dataOrder.Status);
                            var dataCustomer="";

                            if(dataOrder.CompanyID!=""){
                                getCompanyStatus(dataOrder.CompanyID).then(function(companyStatus){
                                    getContractorName(dataOrder.ContractorID).then(function(contractorName){
                                        dataContractor=takeJobCompany(dataOrder,companyStatus,contractorName);
                                            $row.cell($row, 10).data(dataContractor).draw(false);
                                            //$row.find("td:eq(10)").html(dataContractor);
                                            return;    
                                        
                                    });
                                });
                            }
                            
                            
                            if(dataOrder.CompanyID==""){
                                customerData="XXXXX XXXXX XXXXX XXXXX";
                                $row.cell($row, 3).data(customerData).draw(false);
                                //$row.find("td:eq(3)").html(customerData);
                            }else{
                                getCustomerData(dataOrder.CustomerFBID,dataOrder.RepAddress).then(function(customerData) {  
                                    $row.cell($row, 3).data(customerData).draw(false);
                                    //$row.find("td:eq(3)").html(customerData);
                                });
                            }
                            

                            
                            getCompanyStatus(dataOrder.CompanyID).then(function(companyStatus){
                                actionC=actionsCompany(dataOrder,companyStatus);
                                    $row.cell($row, 11).data(actionC).draw(false);
                                    //$row.find("td:eq(11)").html(actionC);
                                
                            });

                            valueMat=isNaN(parseInt(dataOrder.EstAmtMat)) ? 0 : parseInt(dataOrder.EstAmtMat);
                            valueTime=isNaN(parseInt(dataOrder.EstAmtTime)) ? 0 : parseInt(dataOrder.EstAmtTime);

                            valueMatA=isNaN(parseInt(dataOrder.ActAmtMat)) ? 0 : parseInt(dataOrder.ActAmtMat);
                            valueTimeA=isNaN(parseInt(dataOrder.ActAmtTime)) ? 0 : parseInt(dataOrder.ActAmtTime);

                            if(dataOrder.Status=="F" && dataOrder.RequestType=="P"){
                                valorTotal=(parseInt(valueMat)+parseInt(valueTime));
                                estimateAmount='<a class="btn-warning btn-sm" data-toggle="modal" '+
                                                    'href="#myEstimateAmount" '+
                                                    'onClick="getEstimateAmount(\''+dataOrder.FBID+'\')"> '+
                                                    '<span class="glyphicon glyphicon-check"></span>Approve Amt:'+valorTotal+
                                                '</a>';
                            }else{

                                estimateAmount=(parseInt(valueMat)+parseInt(valueTime));
                                estimateAmount = estimateAmount ? estimateAmount : '$0';
                            }
                            if(dataOrder.Status=="J" && dataOrder.RequestType=="P"){
                                valorTotal=(parseInt(valueMatA)+parseInt(valueTimeA));
                                finalAmount='<a class="btn-success btn-sm" data-toggle="modal"'+
                                                    'href="#myFinalAmount" '+
                                                    'onClick="getFinalAmount(\''+dataOrder.FBID+'\')"> '+
                                                    '<span class="glyphicon glyphicon-check"></span>Approve Amt:'+valorTotal+
                                                '</a>';
                            }else{
                                finalAmount=(parseInt(valueMatA)+parseInt(valueTimeA));
                                finalAmount = finalAmount ? '$'+finalAmount : '$0';
                            }
                            $row.cell($row, 1).data(dataOrder.SchDate).draw(false);
                            //$row.find("td:eq(1)").html(dataOrder.SchDate);
                            $row.cell($row, 2).data(dataOrder.SchTime).draw(false);
                            //$row.find("td:eq(2)").html(dataOrder.SchTime);
                            if(dataOrder.RequestType=='P'){
                                description='Number of Postcard: '+dataOrder.postCardValue;
                            }else{
                                description=dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water;
                            }

                            //$row.find("td:eq(4)").html(description);
                            //$row.find("td:eq(5)").html(requestType);
                            //$row.find("td:eq(6)").html(status);
                            //$row.find("td:eq(7)").html(estimateAmount);
                            //$row.find("td:eq(8)").html(finalAmount);
                            //$row.find("td:eq(9)").html(dataOrder.PaymentType);

                            $row.cell($row, 4).data(description).draw(false);
                            $row.cell($row, 5).data(requestType).draw(false);
                            $row.cell($row, 6).data(status).draw(false);
                            $row.cell($row, 7).data(estimateAmount).draw(false);
                            $row.cell($row, 8).data(finalAmount).draw(false);
                            $row.cell($row, 9).data(dataOrder.PaymentType).draw(false);

            }

            function removeOrderOnTable(dataOrder){
                var value = dataOrder.OrderNumber;
					var t = $('#table_orders_company').DataTable();
					t.rows( function ( idx, data, node ) {
						return data[0] === value;
					} )
					.remove()
					.draw();
            }

            function validateExist(orderID){
                var t = $('#table_orders_company').DataTable();
                var data = t.rows().data();
                var indice=-1;
                var row = data.each(function (value, index) {
                    if (value[0] === orderID){
                        indice=index;
                        }
                });	
                return indice;
                
              

            }

           
            function addMarketContractor(data,fila){
                var image="contractor.png";
                var oMarket= new google.maps.Marker({
                    position: new google.maps.LatLng(data.lat,data.lng),
                    map:mapObject,
                    icon:'img/img_maps/'+image,
                    id:fila.ContractorID
                });

                oMarket.addListener('click', function() {
                                infowindow.setContent('<p><b>Name:</b>'+fila.ContNameFirst+' '+fila.ContNameLast+'<br><b>Tel:</b>'+fila.ContPhoneNum+
                                                        '<br><b>Status:</b>'+fila.ContWorkStatus+'</p>');
                                infowindow.open(map, this);
                            });
                return oMarket;
            }

            function removeMarket(idOrder){
                marketrs.map(function(marker) {
                    if(marker.id==idOrder){
                        marker.setVisible(false);
                        marketrs.splice( marketrs.indexOf(marker), 1 );
                    }
                })                
            }

            function hideShowMarketByTypeServiceAndSatus(listTypeService,listTypeStatus){
					marketrs.map(function(marker) {
						if(listTypeService.indexOf(marker.typeService)>-1 || listTypeStatus.indexOf(marker.status)>-1){
							marker.setVisible(true);
						}else{
							marker.setVisible(false);
						}
					})                
                }
            
            function removeMarketContractor(idContractor){
                for(var i = contractorMarker.length - 1; i >= 0; i--) {
                    if(contractorMarker[i].id === idContractor) {
                        contractorMarker[i].setVisible(false);
                        contractorMarker.splice(i, 1);
                    }
                }
                
            }
            
            function getCustomerName(customerFBID) {
                return new Promise(function (resolve, reject) {
                   
                    var ref = firebase.database().ref("Customers/"+customerFBID);
                    ref.once('value').then(function(snapshot) {
							data=snapshot.val();
							return resolve(data.Fname+' '+data.Lname);
						});
                        //return reject("Undefined");
                    });
                
            }

            function getCustomerData(customerFBID,RepAddress) {
                return new Promise(function (resolve, reject) {
                   if(customerFBID==""){
                    return resolve(RepAddress);
                   }else{
                    var ref = firebase.database().ref("Customers/"+customerFBID);
                    ref.once('value').then(function(snapshot) {
							data=snapshot.val();
							return resolve(data.Fname+' '+data.Lname+' / '+RepAddress+' / '+data.Phone);
						});
                        //return reject("Undefined");
                    
                   }
                });
                    
                
            }

            function getCompanyStatus(companyID) {
                return new Promise(function (resolve, reject) {
                   
                    var ref = firebase.database().ref("Company/"+companyID);
                    ref.once('value').then(function(snapshot) {
							data=snapshot.val();
							return resolve(data.CompanyStatus);
						});
                    });
                
            }

            function getContractorName(ContractorID) {
                return new Promise(function (resolve, reject) {
                   
                    var ref = firebase.database().ref("Contractors/"+ContractorID);
                    ref.once('value').then(function(snapshot) {
							data=snapshot.val();
							return resolve(data.ContNameFirst+' '+data.ContNameLast);
						});
                        //return resolve("Undefined");
                    });
                
            }


        </script>

        <?php echo '<script>'.$_SESSION['firebase_path_javascript'].'</script>'; ?>
        <script>    
            firebase.initializeApp(config);
        </script>


        <!--<script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&libraries=visualization&callback=initMap">
        </script>
        -->
        <br>
       

         
        <div class="table-responsive">          
            <table class="table table-striped table-bordered" id="table_orders_company">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Name/Addr/Phone</th>
                        <th>Description</th>
                        <th>Req Type</th>
                        <th>Status</th>
                        <th>Est. Amt</th>
                        <th>Final. Amt</th>
                        <th>Payment</th>
                        <th>Contractor</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($_array_orders_to_show as $key => $order) { ?>
                        <tr>
                            <td><?php echo $order['OrderNumber']?></td>
                            <td><?php echo $order['SchDate']?></td>
                            <td><?php echo $order['SchTime']?></td>
                            <td><?php
                                    if(empty($order['CompanyID'])){
                                        echo "XXXXX XXXXX XXXXX XXXXX";
                                    }else{
                                        $_customerName=$this->_userModel->getNode('Customers/'.$order['CustomerFBID'].'/Fname');
                                        $_customerName.=" ".$this->_userModel->getNode('Customers/'.$order['CustomerFBID'].'/Lname');

                                        $_phone_number=$this->_userModel->getNode('Customers/'.$order['CustomerFBID'].'/Phone');
                                        $_phone_number=str_replace("+1","",$_phone_number);
                                        echo $_customerName.' / '.$order['RepAddress'].' / '.$_phone_number;
                                    }
                                    
                                ?></td>
                            
                            <td><?php 
                                if(strcmp($order['RequestType'],"P")==0){
                                    echo 'Number of Postcard: '.$order['postCardValue'];
                                }else{
                                    echo $order['Hlevels'].", ".$order['Rtype'].", ".$order['Water'];
                                }
                                

                                ?></td>
                            <td><?php 
                                    echo '<script type="text/javascript">',
                                        'document.write(getRequestType(\''.$order['RequestType'].'\'));',
                                    '</script>';
                                ?>
                            </td>
                            <td><?php 
                                    echo '<script type="text/javascript">',
                                        'document.write(getStatus(\''.$order['Status'].'\'));',
                                    '</script>';	
                                ?>
                            </td>                            

                            <td align="right"><?php 
                                    if($order['Status']=='F' and $order['RequestType']=='P' ){
                                ?>
                                        <a class="btn-warning btn-sm" data-toggle="modal"  
                                            href="#myEstimateAmount" 
                                            onClick="getEstimateAmount('<?php echo $order['FBID']?>')"> 
                                            <span class="glyphicon glyphicon-check"></span>Approve Amt: <?php echo "$".(intval($order['EstAmtMat'])+intval($order['EstAmtTime'])); ?> 
                                        </a>
                                <?php
                                    }else{
                                        echo "$".(intval($order['EstAmtMat'])+intval($order['EstAmtTime']));
                                    }
                                    
                                ?>
                            </td>                            
                            <td align="right"><?php 
                                    if($order['Status']=='J'){											
                                ?>
                                    <a class="btn-success btn-sm" data-toggle="modal"  
                                            href="#myFinalAmount" 
                                            onClick="getFinalAmount('<?php echo $order['FBID']?>')"> 
                                            <span class="glyphicon glyphicon-check"></span>Approve Amt: <?php echo "$".(intval($order['ActAmtMat'])+intval($order['ActAmtTime'])); ?> 
                                        </a>
                                <?php 
                                    }else if ( $order['RequestType']=='P' ){
                                ?>
                                    <a class="btn-success btn-sm" data-toggle="modal"  
                                            href="#" 
                                            onClick="getFinalAmount('<?php echo $order['FBID']?>')"> 
                                            <span class="glyphicon glyphicon-check"></span>Approve Amt: <?php echo "$".(intval($order['ActAmtMat'])+intval($order['ActAmtTime'])); ?> 
                                        </a>
                                <?php
                                    }else{
                                        echo "$".(intval($order['ActAmtMat'])+intval($order['ActAmtTime']));
                                    }
                                ?>
                            </td>
                            <td><?php echo $order['PaymentType']?></td>
                            <td><?php 
                                    $_contractorName=$this->_userModel->getNode('Contractors/'.$order['ContractorID'].'/ContNameFirst');
                                    $_contractorName.=" ".$this->_userModel->getNode('Contractors/'.$order['ContractorID'].'/ContNameLast');
                                     echo '<script type="text/javascript">',
                                     'document.write(takeJobCompany('.json_encode($order,JSON_FORCE_OBJECT).',\''.$_actual_company['CompanyStatus'].'\',\''.$_contractorName.'\'));',
                                     '</script>';
                                    ?>
                                    
                                    
                            </td>
                            <td>
                                <?php 
										echo '<script type="text/javascript">',
											'document.write(actionsCompany('.json_encode($order,JSON_FORCE_OBJECT).',\''.$_actual_company['CompanyStatus'].'\'));',
											'</script>';	
								?>
                            </td>
                           
                           
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div> 
</div>


		<!-- Modal content--> 


<div class="collapse container" id="companyDashProfile1"> 
			<div class="modal-header"> 
				<!--<button type="button" class="close" data-dismiss="modal">&times;</button> -->
				<!--<h4 class="modal-title" id="headerTextProfileCompany">Company Profile</h4> -->
            </div> 
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="accordion" id="accordionExample">

                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0" style="background-color: gainsboro;">
                                    <button class="btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Basic Info
                                    </button>
                                    <button class="btn-primary btn-sm" style="float: right;" onClick="updateDataCompany()"><span class="glyphicon glyphicon-save"></span>Save Basic Info</button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="control-label ">Company ID</label>
                                        <input maxlength="100" disabled type="text" class="form-control"  id="companyID" name="companyID" value="<?php echo $_actual_company['CompanyID'] ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Company Name</label>
                                        <input maxlength="100" disabled type="text" required="required" class="form-control" placeholder="Enter Company Name" id="compamnyName" name="compamnyName" value="<?php echo $_actual_company['CompanyName'] ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">First Name</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" id="firstCompanyName" name="firstCompanyName" value="<?php echo $_actual_company['PrimaryFName'] ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Last Name</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" id="lastCompanyName" name="lastCompanyName" value="<?php echo $_actual_company['PrimaryLName'] ?>" />
                                    </div>  

                                    <div class="form-group">
                                        <label class="control-label ">Email</label>
                                        <input maxlength="100" disabled type="text" required="required" class="form-control" placeholder="Enter Email" id="companyEmail" name="companyEmail" value="<?php echo $_actual_company['CompanyEmail'] ?>"/>
                                    </div> 
                                    <div class="form-group">
                                        <label class="control-label ">License Number</label>
                                        <input maxlength="100"  type="text" required="required" class="form-control" placeholder="Enter License Number" id="companyLicenseNumber" name="companyLicenseNumber" value="<?php if(isset($_actual_company['ComapnyLicNum'])){ echo $_actual_company['ComapnyLicNum'];}  ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label ">In Business Since</label>
                                        <input maxlength="100"  type="text" required="required" class="form-control datepickerdob" placeholder="Enter In Business Since" id="companyBusinessSince" name="companyBusinessSince" value="<?php if(isset($_actual_company['InBusinessSince'])){ echo $_actual_company['InBusinessSince'];} ?>"/>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label class="control-label ">Expiration date</label>
                                        <input maxlength="100"  type="text" required="required" class="form-control datepickerdob" placeholder="Enter Expiration date" id="companyExpirationDate" name="companyExpirationDate" value="<?php if(isset($_actual_company['LicExpiration'])){ echo $_actual_company['LicExpiration'];}?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label ">Verified</label>
                                        <input maxlength="100"  type="text" required="required" class="form-control" placeholder="Enter Verified" id="companyVerified" name="companyVerified" value="<?php if(isset($_actual_company['Verified'])){ echo $_actual_company['Verified'];} ?>"/>
                                    </div>
                                    <!--
                                    <div class="form-group">
                                        <label class="control-label">Address</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="companyAddress1" name="companyAddress1" value="<?php echo $_actual_company['CompanyAdd1'] ?>"/>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="companyAddress2" name="companyAddress2" value="<?php echo $_actual_company['CompanyAdd2'] ?>"/>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label">Zip Code</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="companyAddress3" name="companyAddress3" value="<?php echo $_actual_company['CompanyAdd3'] ?>"/>
                                    </div>
                                    -->
                                    <div class="form-group">
                                        <label class="control-label">Phone number</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter phone number" id="companyPhoneNumber" name="companyPhoneNumber"  value="<?php echo $_actual_company['CompanyPhone'] ?>"/>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Company Type</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Type" id="companyType" name="companyType" value="<?php echo $_actual_company['CompanyType'] ?>"/>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0" style="background-color: gainsboro;">
                                    <button class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Stripe Info
                                    </button>
                                    <button type="button" class="btn-primary btn-sm" style="float: right;" onClick="query_valid_account_stripe('<?php echo $_actual_company['stripeAccount'] ?>')" >Validate Info for recibe payments</button>           
                                    <button class="btn-primary btn-sm" style="float: right;" onClick="updateDataCompany()"><span class="glyphicon glyphicon-save"></span>Save Stripe Info</button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                            <div class="form-group">
                                                <label class="control-label">Type</label>
                                                <select id="compamnylegal_entity_type" name="compamnylegal_entity_type" onchange="validate_fields_stripe_account()" value="<?php echo $_array_stripe_info->legal_entity->type ?>">
                                                    <option value="company">Company</option>
                                                    <option value="individual">Individual</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="compamnylegal_entity_business_name">Business Name</label>
                                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter legal_entity.business_name" id="compamnylegal_entity_business_name" name="compamnylegal_entity_business_name" value="<?php if(isset($_array_stripe_info->legal_entity->business_name)){ echo $_array_stripe_info->legal_entity->business_name;}  ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="compamnylegal_entity_business_tax_id">Business tax id</label>
                                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter legal_entity.business_tax_id" id="compamnylegal_entity_business_tax_id" name="compamnylegal_entity_business_tax_id" value="<?php if(isset($_array_stripe_info->legal_entity->business_tax_id_provided)){echo $_array_stripe_info->legal_entity->business_tax_id_provided;} ?>" />
                                            </div> 
                                            <div class="form-group">
                                                <label class="control-label" for="compamnylegal_entity_State">State</label>
                                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter State" id="compamnylegal_entity_State" name="compamnylegal_entity_State" value="<?php if(isset($_array_stripe_info->legal_entity->address->state)){echo $_array_stripe_info->legal_entity->address->state;} ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="compamnylegal_entity_City">City</label>
                                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter City" id="compamnylegal_entity_City" name="compamnylegal_entity_City" value="<?php if(isset($_array_stripe_info->legal_entity->address->city)){echo $_array_stripe_info->legal_entity->address->city;} ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="compamnylegal_entity_Zipcode">Zipcode</label>
                                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Zipcode" id="compamnylegal_entity_Zipcode" name="compamnylegal_entity_Zipcode" value="<?php if(isset($_array_stripe_info->legal_entity->address->postal_code)){echo $_array_stripe_info->legal_entity->address->postal_code;} ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="compamnylegal_entity_Address">Address</label>
                                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Address" id="compamnylegal_entity_Address" name="compamnylegal_entity_Address" value="<?php if(isset($_array_stripe_info->legal_entity->address->line1)){echo $_array_stripe_info->legal_entity->address->line1;} ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="compamnylegal_entity_first_name">First Name</label>
                                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter legal_entity.first_name" id="compamnylegal_entity_first_name" name="compamnylegal_entity_first_name" value="<?php if(isset($_array_stripe_info->legal_entity->first_name)){echo $_array_stripe_info->legal_entity->first_name;} ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="compamnylegal_entity_last_name">Last Name</label>
                                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter legal_entity.last_name" id="compamnylegal_entity_last_name" name="compamnylegal_entity_last_name" value="<?php if(isset($_array_stripe_info->legal_entity->last_name)){echo $_array_stripe_info->legal_entity->last_name;} ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="compamnylegal_entity_dob">Birthday</label>
                                                <input maxlength="100" type="text" class="form-control datepickerdob" id="compamnylegal_entity_dob" name="compamnylegal_entity_dob" value="<?php if(isset($_array_stripe_info->legal_entity->dob->month)){echo $_array_stripe_info->legal_entity->dob->month."/".$_array_stripe_info->legal_entity->dob->day,"/".$_array_stripe_info->legal_entity->dob->year;}?>" />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="compamnylegal_entity_last4">Social security number last 4</label>
                                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Social security number last" id="compamnylegal_entity_last4" name="compamnylegal_entity_last4" value="<?php if(isset($_array_stripe_info->legal_entity->ssn_last_4_provided)){echo $_array_stripe_info->legal_entity->ssn_last_4_provided;} ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="compamnylegal_entity_personal_id">Personal Id</label>
                                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Personal Id" id="compamnylegal_entity_personal_id" name="compamnylegal_entity_personal_id" value="<?php if(isset($_array_stripe_info->legal_entity->personal_id_number_provided)){echo $_array_stripe_info->legal_entity->personal_id_number_provided;} ?>" />
                                            </div>
                                            
                                            <div class="form-group">
                                            
                                                <a class="btn-primary btn-sm" data-toggle="modal"  
                                                    href="#myDocumentIDFront" 
                                                    onClick=""> 
                                                    <span class="glyphicon glyphicon-upload"></span>
                                                    Upload Documento ID Front
                                                </a>
                                                <a class="btn-primary btn-sm" data-toggle="modal"  
                                                    href="#myDocumentIDBack" 
                                                    onClick=""> 
                                                    <span class="glyphicon glyphicon-upload"></span>
                                                    Upload Documento ID Back
                                                </a>
                                            </div>
                                            
                                            
                                            <br>
                                            <div>
                                                <h3>Payment processing services Terms</h3>
                                                <label>
                                                Payment processing services for [account holder term, e.g. drivers or sellers] on [platform name] are provided by Stripe and are subject to the <a href="https://stripe.com/us/connect-account/legal" target="_blank">Stripe Connected Account Agreement</a>, which includes the <a href="https://stripe.com/us/legal"  target="_blank">Stripe Terms of Service</a> (collectively, the “Stripe Services Agreement”). By agreeing to [this agreement / these terms / etc.] or continuing to operate as a [account holder term] on [platform name], you agree to be bound by the Stripe Services Agreement, as the same may be modified by Stripe from time to time. As a condition of [platform name] enabling payment processing services through Stripe, you agree to provide [platform name] accurate and complete information about you and your business, and you authorize [platform name] to share it and transaction information related to your use of the payment processing services provided by Stripe.
                                                </label>
                                            </div>
                                            
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0" style="background-color: gainsboro;">
                                    <button class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Billing
                                    </button>
                                    <button class="btn-primary btn-sm" style="float: right;" onClick="updateDataCompany()"><span class="glyphicon glyphicon-save"></span>Save Billing Address</button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-group">

                                    <label class="control-label">Billing Address 2</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address 2" id="compamnyPayAddress1" name="compamnyPayAddress1" value="<?php echo $_actual_company['PayInfoBillingAddress1'] ?>" />

                                    <label class="control-label">Billing Address (Con't)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address (Con't)" id="compamnyPayAddress2" name="compamnyPayAddress2" value="<?php echo $_actual_company['PayInfoBillingAddress2'] ?>" />

                                    <label class="control-label">Billing Address (Con't)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address (Con't)" id="compamnyPayAddress2" name="compamnyPayAddress2" value="<?php echo $_actual_company['PayInfoBillingAddress2'] ?>" />

                                    </div>
                                    <div class="form-group">
                                    <label class="control-label">City</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter City" id="compamnyPayCity" name="compamnyPayCity" value="<?php echo $_actual_company['PayInfoBillingCity'] ?>" />
                                    </div>
                                    <div class="form-group">
                                    <label class="control-label">State</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter State" id="compamnyPayState" name="compamnyPayState" value="<?php echo $_actual_company['PayInfoBillingST'] ?>" />
                                    </div>
                                    <div class="form-group">
                                    <label class="control-label">Zip Code</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Zip Code" id="compamnyPayZip" name="compamnyPayZip" value="<?php echo $_actual_company['PayInfoBillingZip'] ?>" />
                                    </div>
                                    <div class="form-group">
                                    <label class="control-label">Credit Card Expiration Month (MM)</label>

                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Month" id="compamnyPayMonth" name="compamnyPayMonth" value="<?php echo $_actual_company['PayInfoCCExpMon'] ?>" />
                                    </div>
                                    <div class="form-group">
                                    <label class="control-label">PayInfCredit Card Expiration Year (YYYY)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Year" id="compamnyPayYear" name="compamnyPayYear" value="<?php echo $_actual_company['PayInfoCCExpYr'] ?>" />
                                    </div>
                                    <div class="form-group">
                                    <label class="control-label">PayInfoCredit Card Number</label>

                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Month (MM)" id="compamnyPayMonth" name="compamnyPayMonth" value="<?php echo $_actual_company['PayInfoCCExpMon'] ?>" />
                                    </div>
                                    <div class="form-group">
                                    <label class="control-label">Credit Card Expiration Year (YYYY)</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Year (YYYY)" id="compamnyPayYear" name="compamnyPayYear" value="<?php echo $_actual_company['PayInfoCCExpYr'] ?>" />
                                    </div>
                                    <div class="form-group">
                                    <label class="control-label">Credit Card Number</label>

                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Number" id="compamnyPayCCNum" name="compamnyPayCCNum" value="<?php echo $_actual_company['PayInfoCCNum'] ?>" />
                                    </div>
                                    <div class="form-group">
                                    <label class="control-label">Credit Card CSV</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card CSV" id="compamnyPaySecCode" name="compamnyPaySecCode" value="<?php echo $_actual_company['PayInfoCCSecCode'] ?>" />
                                    </div>
                                    <div class="form-group">
                                    <label class="control-label">Name on Cred Card</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Name on Cred Card" id="compamnyPayName" name="compamnyPayName" value="<?php echo $_actual_company['PayInfoName'] ?>" />
                                    </div>
                                    <div class="form-group">
                                    <label class="control-label">First Name on Credit Card</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name on Credit Card" id="compamnyPayFName" name="compamnyPayFName" value="<?php echo $_actual_company['PrimaryFName'] ?>" />
                                    </div>
                                    <div class="form-group">
                                    <label class="control-label">Last Name on Credit Card</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name on Credit Card" id="compamnyPayLName" name="compamnyPayLName" value="<?php echo $_actual_company['PrimaryLName'] ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0" style="background-color: gainsboro;">
                                    <button class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Others
                                    </button>
                                    <button class="btn-primary btn-sm" style="float: right;" onClick="updateDataCompany()"><span class="glyphicon glyphicon-save"></span>Save Others</button>
                                </h2>
                            </div>

                            <div id="collapseFour" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                        <div class="form-group">
                                            <label class="control-label">Company Insurance Name</label>
                                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Insurance Name" id="compamnyAgencyName" name="compamnyAgencyName" value="<?php echo $_actual_company['InsLiabilityAgencyName'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Insurance Agent's Name</label>
                                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Insurance Agent's Name" id="compamnyAgtName" name="compamnyAgtName" value="<?php echo $_actual_company['InsLiabilityAgtName'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Insurance Agent's Phone Number</label>
                                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Insurance Agent's Phone Number" id="compamnyAgtNum" name="compamnyAgtNum" value="<?php echo $_actual_company['InsLiabilityAgtNum'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Insurance Policy Number</label>
                                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Insurance Policy Number" id="compamnyPolNum" name="compamnyPolNum" value="<?php echo $_actual_company['InsLiabilityPolNum'] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Company Rating</label>
                                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Rating" id="compamnyStatusRating" name="compamnyStatusRating" value="<?php echo $_actual_company['Status_Rating'] ?>" readonly />
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0" style="background-color: gainsboro;">
                                    <button class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <span class="glyphicon glyphicon-plus-sign"></span> External Accounts
                                    </button>
                                    
                                </h2>
                            </div>

                            <div id="collapseFive" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="alert alert-primary" role="alert">
                                        External accounts
                                    </div>
                                    <table class="table table-bordered" id="listBankCompany">
                                        <tr>
                                            <td>id</td>
                                            <td>Holder  Name</td>
                                            <td>Holder  Type</td>
                                            <td>Bank Name</td>
                                            <td>Country</td>
                                            <td>Currency</td>
                                            <td>Last4</td>
                                            <td>Routing Number</td>
                                            <td>Action</td>
                                        </tr>
                                        <?php
                                            $n=1;
                                            if(isset($_array_stripe_bank)){
                                                foreach($_array_stripe_bank as $clave=>$bank){
                                                echo "<tr>".
                                                            "<td>".$n."</td>".
                                                            "<td>".$bank->account_holder_name."</td>".
                                                            "<td>".$bank->account_holder_type."</td>".
                                                            "<td>".$bank->bank_name."</td>".
                                                            "<td>".$bank->country."</td>".
                                                            "<td>".$bank->currency."</td>".
                                                            "<td>".$bank->last4."</td>".
                                                            "<td>".$bank->routing_number."</td>".
                                                            '<td>
                                                                <a class="btn-primary btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Set as default bank account"'.
                                                                'href="#" '.
                                                                'onClick="actionWithBank(\'setdefault\',\''.$_actual_company['stripeAccount'].'\',\''.$bank->id.'\')" > '.
                                                                '<span class="glyphicon glyphicon-star"></span></a>
                                                                <a class="btn-danger btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Delete Bank Account"'.
                                                                'href="#" '.
                                                                'onClick="actionWithBank(\'delete\',\''.$_actual_company['stripeAccount'].'\',\''.$bank->id.'\',this)" > '.
                                                                '<span class="glyphicon glyphicon-trash"></span></a>
                                                            </td>'.
                                                        "</tr>";
                                                    $n++;
                                                }
                                            }
                                        ?>
                                    </table>
                                    <a class="btn-primary btn-sm" data-toggle="modal"  
                                                        href="#myProfileBank" 
                                                        onClick="prepareCreateBank('<?php echo $_actual_company['stripeAccount'] ?>')"> 
                                                        <span class="glyphicon glyphicon-bitcoin"></span>
                                                        New Bank
                                    </a> 
                                </div>
                            </div>
                        </div>
                    </div>    
                    
                </div>
                
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <div>
                            Wallet Balance<br>
                            <a href="">+ Add funds to your RoofServiceNow Wallet</a>
                        </div>

                        <div class="accordion" id="accordionPayments">
                            <div class="card">
                                <div class="card-header" id="headingOnep">
                                    <h2 class="mb-0" style="background-color: gainsboro;">
                                        <button class="btn-link" type="button" data-toggle="collapse" data-target="#collapseOnep" aria-expanded="true" aria-controls="collapseOnep">
                                        <span class="glyphicon glyphicon-plus-sign"></span> Balance
                                        </button>
                                        <button class="btn-primary btn-sm" style="float: right;" onClick="getStripeInfo('balance','tableCompanyBalance','<?php echo $_actual_company['CompanyID'] ?>')"><span class="glyphicon glyphicon-refresh"></span></button>
                                        <button class="btn-primary btn-sm" style="float: right;" onClick=""><span class="glyphicon glyphicon-save"></span>Export Info</button>
                                    </h2>
                                </div>

                                <div id="collapseOnep" class="collapse" aria-labelledby="headingOnep" data-parent="#accordionPayments">
                                    <div class="card-body">
                                        <table class="table table-bordered" id="tableCompanyBalance" >
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>Currency</th>
                                                    <th>bank_account</th>
                                                    <th>bitcoin_receiver</th>
                                                    <th>card</th>
                                                </tr> 
                                            <thead>
                                            <tbody>
                                            <?php
                                                $n=1;
                                                if(isset($_array_stripe_balance->available)){
                                                    foreach($_array_stripe_balance->available as $clave=>$trancs){
                                                        $_amount=0;
                                                        if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                                                        $_amount1=0;
                                                        if($trancs->source_types->card==0){$_amount1=0;}else{$_amount1=$trancs->source_types->card/100;}
                                                    echo "<tr>".
                                                                "<td>".$n."</td>".
                                                                "<td>Available</td>".
                                                                "<td>".number_format($_amount, 2, '.', '')."</td>".
                                                                "<td>".$trancs->currency."</td>".
                                                                "<td>".$trancs->source_types->bank_account."</td>".
                                                                "<td>".$trancs->source_types->bitcoin_receiver."</td>".
                                                                "<td>".number_format($_amount1, 2, '.', '')."</td>".
                                                            "</tr>";
                                                        $n++;
                                                    }
                                                }
                                                if(isset($_array_stripe_balance->connect_reserved)){
                                                    foreach($_array_stripe_balance->connect_reserved as $clave=>$trancs){
                                                        $_amount=0;
                                                        if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                                                    echo "<tr>".
                                                                "<td>".$n."</td>".
                                                                "<td>connect_reserved</td>".
                                                                "<td>".number_format($_amount, 2, '.', '')."</td>".
                                                                "<td>".$trancs->currency."</td>".
                                                                "<td>".""."</td>".
                                                                "<td>".""."</td>".
                                                                "<td>".""."</td>".
                                                            "</tr>";
                                                        $n++;
                                                    }
                                                }
                                                if(isset($_array_stripe_balance->pending)){
                                                    foreach($_array_stripe_balance->pending as $clave=>$trancs){
                                                        $_amount=0;
                                                        if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                                                        $_amount1=0;
                                                        if($trancs->source_types->card==0){$_amount1=0;}else{$_amount1=$trancs->source_types->card/100;}
                                                        echo "<tr>".
                                                                "<td>".$n."</td>".
                                                                "<td>Pending</td>".
                                                                "<td>".number_format($_amount, 2, '.', '')."</td>".
                                                                "<td>".$trancs->currency."</td>".
                                                                "<td>".$trancs->source_types->bank_account."</td>".
                                                                "<td>".$trancs->source_types->bitcoin_receiver."</td>".
                                                                "<td>".number_format($_amount1, 2, '.', '')."</td>".
                                                            "</tr>";
                                                        $n++;
                                                    }
                                                }
                                            ?>  
                                            </tbody>   
                                        </table>
                                    </div>
                                </div>
                            </div>                     
                            

                        
                            <div class="card">
                                <div class="card-header" id="headingTwop">
                                    <h2 class="mb-0" style="background-color: gainsboro;">
                                        <button class="btn-link" type="button" data-toggle="collapse" data-target="#collapseTwop" aria-expanded="true" aria-controls="collapseTwop">
                                        <span class="glyphicon glyphicon-plus-sign"></span> Transfer
                                        </button>
                                        <button class="btn-primary btn-sm" style="float: right;" onClick="getStripeInfo('transfer','tableCompanyTransfer','<?php echo $_actual_company['CompanyID'] ?>')"><span class="glyphicon glyphicon-refresh"></span></button>
                                        <button class="btn-primary btn-sm" style="float: right;" onClick=""><span class="glyphicon glyphicon-save"></span>Export Info</button>
                                    </h2>
                                </div>
                                <div id="collapseTwop" class="collapse" aria-labelledby="headingTwop" data-parent="#accordionPayments">
                                    <table class="table table-bordered" id="tableCompanyTransfer" >
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Amount</th>
                                                <th>Balance_Transaction</th>
                                                <th>Created</th>
                                                <th>Description</th>
                                                <th>Destination_Payment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $n=1;
                                            if(isset($_array_stripe_transfer->data)){
                                                foreach($_array_stripe_transfer->data as $clave=>$trancs){
                                                    $_amount=0;
                                                    if($trancs->amount==0){$_amount=0;}else{$_amount=round($trancs->amount/100,2);}
                                                echo "<tr>".
                                                            "<td>".$trancs->id."</td>".
                                                            "<td>".number_format($_amount, 2, '.', '')."</td>".
                                                            "<td>".$trancs->balance_transaction."</td>".
                                                            "<td>".date("F j, Y, g:i a",$trancs->created)."</td>".
                                                            "<td>".$trancs->description."</td>".
                                                            "<td>".$trancs->destination_payment."</td>".
                                                        "</tr>";
                                                    $n++;
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                               
                            <div class="card">
                                <div class="card-header" id="headingThreep">
                                    <h2 class="mb-0" style="background-color: gainsboro;">
                                        <button class="btn-link" type="button" data-toggle="collapse" data-target="#collapseThreep" aria-expanded="true" aria-controls="collapseThreep">
                                        <span class="glyphicon glyphicon-plus-sign"></span> Transactions
                                        </button>
                                        <button class="btn-primary btn-sm" style="float: right;" onClick="getStripeInfo('transaction','tableCompanyTransactions','<?php echo $_actual_company['CompanyID'] ?>')"><span class="glyphicon glyphicon-refresh"></span></button>
                                        <button class="btn-primary btn-sm" style="float: right;" onClick=""><span class="glyphicon glyphicon-save"></span>Export Info</button>
                                    </h2>
                                </div>
                                <div id="collapseThreep" class="collapse" aria-labelledby="headingThreep" data-parent="#accordionPayments">
                                    <table class="table table-bordered" id="tableCompanyTransactions" >
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>amount</th>
                                                <th>available_on</th>
                                                <th>created</th>
                                                <th>currency</th>
                                                <th>description</th>
                                                <th>fee</th>
                                                <th>net</th>
                                                <th>status</th>
                                                <th>type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $n=1;
                                            if(isset($_array_stripe_transaction->data)){
                                                foreach($_array_stripe_transaction->data as $clave=>$trancs){
                                                    $_amount=0;
                                                    if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                                                    $_amount_1=0;
                                                    if($trancs->net==0){$_amount_1=0;}else{$_amount_1=$trancs->net/100;}
                                                echo "<tr>".
                                                            "<td>".$trancs->id."</td>".
                                                            "<td>".number_format($_amount, 2, '.', '')."</td>".
                                                            "<td>".$trancs->available_on."</td>".
                                                            "<td>".date("F j, Y, g:i a",$trancs->created)."</td>".
                                                            "<td>".$trancs->currency."</td>".
                                                            "<td>".$trancs->description."</td>".
                                                            "<td>".$trancs->fee."</td>".
                                                            "<td>".number_format($_amount_1, 2, '.', '')."</td>".
                                                            "<td>".$trancs->status."</td>".
                                                            "<td>".$trancs->type."</td>".
                                                        "</tr>";
                                                    $n++;
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>     
                                </div>
                            </div>
                                
                            <div class="card">
                                <div class="card-header" id="headingFourp">
                                    <h2 class="mb-0" style="background-color: gainsboro;">
                                        <button class="btn-link" type="button" data-toggle="collapse" data-target="#collapseFourp" aria-expanded="true" aria-controls="collapseFourp">
                                        <span class="glyphicon glyphicon-plus-sign"></span> Pay outs
                                        </button>
                                        <button class="btn-primary btn-sm" style="float: right;" onClick="getStripeInfo('payout','tableCompanyPayouts','<?php echo $_actual_company['CompanyID'] ?>')"><span class="glyphicon glyphicon-refresh"></span></button>
                                        <button class="btn-primary btn-sm" style="float: right;" onClick=""><span class="glyphicon glyphicon-save"></span>Export Info</button>
                                    </h2>
                                </div>
                                <div id="collapseFourp" class="collapse" aria-labelledby="headingFourp" data-parent="#accordionPayments">
                                    <table class="table table-bordered" id="tableCompanyPayouts">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>amount</th>
                                                <th>created</th>
                                                <th>arrival_date</th>
                                                <th>currency</th>
                                                <th>description</th>
                                                <th>destination</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $n=1;
                                            if(isset($_array_stripe_payout->data)){
                                                foreach($_array_stripe_payout->data as $clave=>$payout){
                                                    $_amount=0;
                                                    if($payout->amount==0){$_amount=0;}else{$_amount=$payout->amount/100;}
                                                echo "<tr>".
                                                            "<td>".$payout->id."</td>".
                                                            "<td>".number_format($_amount, 2, '.', '')."</td>".
                                                            "<td>".date("F j, Y, g:i a",$payout->created)."</td>".
                                                            "<td>".date("F j, Y, g:i a",$payout->arrival_date)."</td>".
                                                            "<td>".$payout->currency."</td>".
                                                            "<td>".$payout->description."</td>".
                                                            "<td>".$payout->destination."</td>".
                                                        "</tr>";
                                                    $n++;
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                                
                                
                            
                        </div>
                    </div>
                </div>
            </div>                         
</div> 


		<!-- Modal content--> 
<div class="collapse container" id="companyDashEmployee1"> 
			<div class="modal-header"> 
				
				<h4 class="modal-title" id="headerTextDriversCompany">Employee List</h4> 
			</div> 
			<div class="modal-body" id="textAnswerDriversCompany"> 
                <div class="table-responsive">
                <?php if(strcmp($_actual_company['CompanyStatus'],'Active')!==0){?>
                    <div class="alert alert-danger">
                        <strong>Attention!</strong> Your company in not Active, please finish filling out the profile
                    </div>
                <?php } ?>
                        <table class="table" id="table_drivers_dashboard_company" name="table_drivers_dashboard_company">
                            <thead>
                            <tr>
                                <th>ContractorID</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Employee Phone</th>
                                <th>Employee License</th>
                                <th>Employee Email</th>
                                <th>Profile</th>
                                <th>Status</th>
                                <th>-Edit-</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($_array_contractors_to_show as $key => $contractor) { ?>
                                <tr>
                                    <td><?php echo $contractor['ContractorID']?></td>
                                    <td><?php echo $contractor['ContNameFirst']?></td>
                                    <td><?php echo $contractor['ContNameLast']?></td>
                                    <td><?php echo $contractor['ContPhoneNum']?></td>
                                    <td><?php echo $contractor['ContLicenseNum']?></td>
                                    <td><?php if (isset($contractor['ContEmail'])){echo $contractor['ContEmail'];}else{echo '';}?></td>
                                    <td><?php if (isset($contractor['ContractorProfile'])){echo $contractor['ContractorProfile'];}else{echo '';}?></td>
                                    <td><?php echo $contractor['ContStatus']?></td>
                                    <td>
                                        <a class="btn-info btn-sm" data-toggle="modal"  
                                            href="#myModal2"  data-toggle1="tooltip"  title="Edit Employee"
                                            onClick=""> 
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                    </td>
                                    <td>
                                    <?php if(strcmp($_actual_company['CompanyStatus'],'Active')!==0){?>
                                        <a href="#" class="inactivate-contractor-button btn-default btn-sm"  data-toggle1="tooltip"  title="Active Employee"
                                            id="inactivate-contractor-button" name="inactivate-contractor-button" 
                                            data-toggle="tooltip" title="Inactive Employee" onclick="alert('You can not active the employee until the company is active')" >
                                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                            </a>
                                    <?php }else{ ?>
                                        <?php if(strcmp($contractor['ContStatus'],"Active")==0){?>
                                            <a href="#" class="inactivate-contractor-button btn-danger btn-sm"  data-toggle1="tooltip"  title="Inactive Employee"
                                             id="inactivate-contractor-button" name="inactivate-contractor-button" 
                                             data-toggle="tooltip" onclick="disableEnableDriver('<?php echo $contractor['ContractorID']?>','Inactive')">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                        <?php } else{ ?>
                                            <a href="#" class="inactivate-contractor-button btn-success btn-sm"  data-toggle="tooltip" title="Active Employee"
                                            id="inactivate-contractor-button" name="inactivate-contractor-button"  
                                            data-toggle1="tooltip" onclick="disableEnableDriver('<?php echo $contractor['ContractorID']?>','Active')">
                                                <span class="glyphicon glyphicon-ok"></span>
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                    </td>
                                    
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        
                        <a class="btn-primary btn-sm" data-toggle="modal"  
                                            href="#myModalInsertContractor" 
                                            onClick="emptyTextNewDriver()"> 
                                            <span class="glyphicon glyphicon-file"></span>
                                            New Employee
                        </a>
                        
                </div>
            </div> 
			
</div> 




<!-- formulario Modal Actualizar datos-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit Employee Data</h4>
      </div>
      <div class="modal-body">

        <form role="form" method="post" action="?controlador=precontrato&accion=editaCupo">
            <div class="form-group">
                <label for="ContractorIDed">ContractorID</label>
                <input type="text" class="form-control" name="ContractorIDed" id="ContractorIDed"  required readonly>
            </div>
            <div class="form-group">
                <label for="ContNameFirsted">First name</label>
                <input type="text" class="form-control" name="ContNameFirsted" id="ContNameFirsted"  required oninvalid="this.setCustomValidity('')"
                oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="ContNameLasted">Last Name</label>
                <input type="text" class="form-control" name="ContNameLasted" id="ContNameLasted" maxlength="60" required oninvalid="this.setCustomValidity('')"
                oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="ContPhoneNumed">Employee Phone</label>
                <input type="text" class="form-control" name="ContPhoneNumed" id="ContPhoneNumed" maxlength="60" required oninvalid="this.setCustomValidity('')"
                oninput="setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="ContLicenseNumed">Employee License</label>
                <input type="text" class="form-control" name="ContLicenseNumed" id="ContLicenseNumed" maxlength="60" required oninvalid="this.setCustomValidity('')"
                oninput="setCustomValidity('')">
            </div>
            
            <div class="form-group">
            <label for="ContStatused">Profile</label>
                    <select class="form-control" id="ContProfile" name="ContProfile">
                        <?php foreach ($_profileList as $key => $value1) { ?>
                            <option value="<?php echo $value1 ?>"><?php echo $value1 ?></option>
                        <?php } ?>
                    </select>
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


<!-- formulario Insertar contractor datos-->
<div class="modal fade" id="myModalInsertContractor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Contrator Data</h4>
      </div>
      <div class="modal-body">

        <form role="form" method="post" action="" id="formInsertContractor">
            <div class="form-group">
                <label for="ContractorIDed">ContractorID</label>
                <input type="text" class="form-control" name="ContractorIDIn" id="ContractorIDIn" readonly>
            </div>
            <div class="form-group">
                <label for="ContNameFirsted">First name</label>
                <input type="text" class="form-control" name="ContNameFirstIn" id="ContNameFirstIn"  required oninvalid="this.setCustomValidity('Write the First name of contractor')"
                oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="ContNameLasted">Last Name</label>
                <input type="text" class="form-control" name="ContNameLastIn" id="ContNameLastIn" maxlength="60" required oninvalid="this.setCustomValidity('Write the Last name of contractor')"
                oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="ContPhoneNumed">Repair Crew Phone</label>
                <input type="text" class="form-control" name="ContPhoneNumIn" id="ContPhoneNumIn" maxlength="60" required oninvalid="this.setCustomValidity('Write the phone number of contractor')"
                oninput="setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="ContLicenseNumed">Employee Driver License</label>
                <input type="text" class="form-control" name="ContLicenseNumIn" id="ContLicenseNumIn" maxlength="60" required oninvalid="this.setCustomValidity('Write the license number of contractor')"
                oninput="setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="ContLicenseNumed">Employee Email</label>
                <input type="text" class="form-control" name="emailValidation" id="emailValidation" maxlength="60" onfocusout="validateEmail('Contractors')" required oninvalid="this.setCustomValidity('Write the email for the contractor')"
                oninput="setCustomValidity('')">
                <label class="control-label" id="answerEmailValidate" name="answerEmailValidate">Answer</label>
            </div>
            
            <div class="form-group">
            <label for="ContStatused">Profile</label>
                    <select class="form-control" id="ContProfileIn" name="ContProfileIn">
                        <?php foreach ($_profileList as $key => $value1) { ?>
                            <option value="<?php echo $value1 ?>"><?php echo $value1 ?></option>
                        <?php } ?>
                    </select>
            </div>

            <div class="form-group">
            <label for="ContStatused">Status</label>
                    <select class="form-control" id="ContStatusIn" name="ContStatusIn" disabled>
                        <option value="Active">Active</option>
                        <option value="Inactive" selected>Inactive</option>
                        <option value="Terminated">Terminated</option>
                    </select>
            </div>
          

            <button type="button" class="btn-primary btn-sm" onClick="insertDriver()" >Save</button>
            <button  type="button" class="btn-danger btn-sm" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div><!-- /cierro contenedor -->
  </div><!-- /cierro dialogo-->
</div><!-- /cierro modal -->


<!-- formulario Insertar contractor datos-->
<div class="collapse container" id="scheduleCompany">

    <!--////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <!-- Page Content -->
    <div class="container">
 
        <div class="row">
            <div class="col-lg-12 text-center">
                <div id="calendar" class="col-centered">
                </div>
            </div>
			
        </div>
        <!-- /.row -->
		
		<!-- Modal -->
		<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="addEvent.php">
			
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar Evento</h4>
			  </div>
			  <div class="modal-body">
				
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Titulo</label>
					<div class="col-sm-10">
					  <input type="text" name="title" class="form-control" id="title" placeholder="Titulo">
					</div>
				  </div>
				  <div class="form-group">
					<label for="color" class="col-sm-2 control-label">Color</label>
					<div class="col-sm-10">
					  <select name="color" class="form-control" id="color">
									  <option value="">Seleccionar</option>
						  <option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro</option>
						  <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
						  <option style="color:#008000;" value="#008000">&#9724; Verde</option>						  
						  <option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
						  <option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
						  <option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
						  <option style="color:#000;"    value="#000">&#9724; Negro</option>
						  
						</select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">Fecha Inicial</label>
					<div class="col-sm-10">
					  <input type="text" name="start" class="form-control" id="start" readonly>
					</div>
				  </div>
				  <div class="form-group">
					<label for="end" class="col-sm-2 control-label">Fecha Final</label>
					<div class="col-sm-10">
					  <input type="text" name="end" class="form-control" id="end" readonly>
					</div>
				  </div>
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Guardar</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>
		
		
		
		<!-- Modal -->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="editEventTitle.php">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Order Detail</h4>
			  </div>
			  <div class="modal-body">
				
				<div class="form-group">
					<label for="title" class="col-sm-2 control-label">Order ID</label>
					<div class="col-sm-10">
					  <input type="text" name="title" class="form-control" id="title" placeholder="Titulo" readonly>
					</div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Date Registration</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="datetimeReg" placeholder="Titulo" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Company</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="companyID" placeholder="Titulo" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Customer</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="customerID" placeholder="Titulo" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Total Value</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="totalValue" placeholder="Titulo" readonly>
                    </div>
                </div>
                <input type="hidden" name="id" class="form-control" id="id">
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<!--<button type="submit" class="btn btn-primary">Guardar</button>-->
			  </div>
			</form>
			</div>
		  </div>
		</div>
 
    </div>
    <!-- /.container -->


   <!-- <script src="vista/js/jquery-3.3.1.js"></script>
    <script src="js/bootstrap.min.js"></script>-->
    
    
    <script>
        $(document).ready(function() {
        
        var date = new Date();
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
        var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();
        

    

            $('#calendar').fullCalendar({
                locale: 'en',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay',

                },
                defaultDate: yyyy+"-"+mm+"-"+dd,
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                selectHelper: true,
                height: 2000,
                select: function(start, end) {
                    
                    $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                    $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                    $('#ModalAdd').modal('show');
                },
                eventRender: function(event, element) {
                    element.bind('dblclick', function() {
                        $('#ModalEdit #id').val(event.id);
                        $('#ModalEdit #title').val(event.title);
                        $('#ModalEdit #color').val(event.color);
                        $('#ModalEdit #companyID').val(event.company);
                        $('#ModalEdit #customerID').val(event.customer);
                        $('#ModalEdit #datetimeReg').val(event.date_register);
                        $('#ModalEdit #totalValue').val(event.total_value);
                        
                        getCustomerName(event.customer).then(function(customerName) {  
                        $('#ModalEdit #customerID').val(customerName);
                                        //alert(customerName);
                                        });
                        getCompanyName(event.company).then(function(companyName) {  
                        $('#ModalEdit #companyID').val(companyName);
                                        //alert(customerName);
                                        });

                        $('#ModalEdit').modal('show');
                    });
                },
                eventDrop: function(event, delta, revertFunc) { // si changement de position

                    edit(event);

                },
                eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

                    edit(event);

                },
                events: function(start, end, timezone, callback) {
                var events = [];
                var month =moment($('#calendar').fullCalendar('getView').intervalStart).format('MM');
                var year =moment($('#calendar').fullCalendar('getView').intervalStart).format('YYYY');
                var ref = firebase.database().ref("Orders");
                var month1=jQuery("#calendar").fullCalendar('getDate').month();
                var month2=moment($('#calendar').fullCalendar('getView').intervalEnd).format('MM');
                var date = new Date($('#calendar').fullCalendar('getDate'));
                var month_int = date.getMonth();
                ref.orderByChild("SchDate").endAt(year).once("value", function(snapshot) {

                    datos=snapshot.val();
                    for(r in datos){
                        
                        data=datos[r];
                        if(data.SchDate.startsWith(month1) || data.SchDate.startsWith(month1+1) || data.SchDate.startsWith(month1+2)){
                        var start = data.SchDate.split("/");
                        var start1=start[2]+"-"+start[0]+"-"+start[1];
                        var end1=start[2]+"-"+start[0]+"-"+start[1];

                        var typeR=getRequestType(data.RequestType);
                        var color=getRequestColor(data.RequestType,data.Status);
                        var status=getStatus(data.Status);

                        valueMatA=isNaN(parseInt(data.ActAmtMat)) ? 0 : parseInt(data.ActAmtMat);
                        valueTimeA=isNaN(parseInt(data.ActAmtTime)) ? 0 : parseInt(data.ActAmtTime);

                        events.push({
                            id: data.OrderNumber,
                            title: data.OrderNumber+' - '+typeR+' - '+status,
                            start: start1,
                            end: end1,
                            color: color,
                            company: data.CompanyID,
                            customer: data.CustomerFBID,
                            status: status,
                            date_register: data.DateTime,
                            total_value: valueMatA+valueTimeA,
                        });
            
                        }
                    }
                    callback(events);
                });
                
                }
                
            });
            
            function edit(event){
                start = event.start.format('YYYY-MM-DD HH:mm:ss');
                if(event.end){
                    end = event.end.format('YYYY-MM-DD HH:mm:ss');
                }else{
                    end = start;
                }
                
                id =  event.id;
                
                Event = [];
                Event[0] = id;
                Event[1] = start;
                Event[2] = end;
                
                $.ajax({
                url: 'editEventDate.php',
                type: "POST",
                data: {Event:Event},
                success: function(rep) {
                        if(rep == 'OK'){
                            alert('Evento se ha guardado correctamente');
                        }else{
                            alert('No se pudo guardar. Inténtalo de nuevo.'); 
                        }
                    }
                });
            }
            
            });

            function getCustomerName(customerFBID) {
            return new Promise(function (resolve, reject) {
                    
                var ref = firebase.database().ref("Customers/"+customerFBID);
                ref.once('value').then(function(snapshot) {
                data=snapshot.val();
                return resolve(data.Fname+' '+data.Lname);
            });
                        //return reject("Undefined");
            });  
            }

            function getCompanyName(companyID) {
                return new Promise(function (resolve, reject) {
                    
                var ref = firebase.database().ref("Company/"+companyID);
                ref.once('value').then(function(snapshot) {
                data=snapshot.val();
                return resolve(data.CompanyName);
            });
            });
                
            }

            

            function getRequestColor(requestType,status){
                var colorType="";
                if(status=='K'){
                    colorType = "#008000";
                }else{
                    switch (requestType) {
                        case "E":
                            colorType = "#FF0000";
                            break;
                        case "S":
                            colorType = "#0071c5";
                            break;
                        case "R":
                            colorType = "#FFD700";
                            break;
                        case "P":
                            colorType = "#40E0D0";
                            break;
                        default:
                            colorType = "#000";
                    }
                }
                
                return colorType;
            }

        </script>



<!--////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
</div><!-- /close modal schedule -->

<!-- formulario Insertar contractor datos-->
<div class="modal" id="myModalGetWork" role="dialog" >
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Take Lead</h4>
      </div>
        <div class="modal-body"  id="myModalGetWorkBody">
            <input type="hidden" value="<?php echo $_actual_company['CompanyID'] ?>" id="companyIDWork" />
            <input type="hidden" value="" id="orderIDWork" />
            <input type="hidden" value="" id="orderTypeTakeWork" />
            <div class="form-group">
                <label for="dateWork">Date for the work</label>
                <input type="text" class="form-control datepickers" name="dateWork" id="dateWork" required >
            </div>
            <div class="form-group">
                <label for="timeWork">Time for the work</label>
                <input type="text" name="timeWork" id="timeWork" class="timepicker1" style="z-index: 105100;font-size:24px;text-align:center;position:absolute"/>
            </div>
            <br>
            <br>
            <br>
            <div class="form-group">
                <label for="driverWork">Assign Crew</label>
                <select name="driverWork" id="driverWork" class="form-control" required>
                    <?php foreach ($_array_contractors_to_show as $key => $contractor) {?>
                        <option value="<?php echo $contractor['ContractorID']?>"><?php echo $contractor['ContNameFirst']." ".$contractor['ContNameLast']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="pricingWork">Pricing for take the work</label>
                <input type="text" name="pricingWork" id="pricingWork" readonly/>
            </div>
            <button type="button" class="btn-primary btn-sm" onClick="takeWork()" >Confirm</button>
            <button  type="button" class="btn-danger btn-sm" data-dismiss="modal">Cancel</button>
        </div>
    </div><!-- /cierro contenedor -->
  </div><!-- /cierro dialogo-->
</div><!-- /cierro modal -->





<div class="modal fade" id="myInvoiceInfo" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerMyInvoice">Invoice Info</h4> 
			</div> 
			<div class="modal-body" id="textMyInvoice"> 
				<div class="table-responsive">
					<table class="table table-condensed" id="invoiceInfo">
						<thead>
							<tr>
								<td><strong>Invoice Number</strong></td>
								<td class="text-center"><strong>Price</strong></td>
								<td class="text-center"><strong>Date</strong></td>
								<td class="text-center"><strong>Payment Type</strong></td>
								<td class="text-center"><strong>Trans ID</strong></td>
								<td class="text-center"><strong>View</strong></td>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
				<div id="detailStripe">

				</div>
			</div>

			<div class="modal-footer" id="buttonPayment"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myFilterWindow" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 

		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerMessage">Filter Options</h4> 
			</div> 
			<div class="modal-body" id="typeOfService"> 
                <p>
                <table class="table">
                    <thead>
                        <tr><th scope="col">Service Type</th><th><input class="form-check-input" type="checkbox" value="S" name="selectAllTYpe" checked onchange="selectUnselectCheck('defaultCheckType',this)"></th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Schedule Repair</td><td><input class="form-check-input" type="checkbox" value="S" name="defaultCheckType"  checked></td></tr>
                        <tr><td>Emergency Repair</td><td><input class="form-check-input" type="checkbox" value="E" name="defaultCheckType" checked></td></tr>
                        <tr><td>Report Repair</td><td><input class="form-check-input" type="checkbox" value="R" name="defaultCheckType" checked></td></tr>
                        <tr><td>Postcard</td><td><input class="form-check-input" type="checkbox" value="P" name="defaultCheckType" checked></td></tr>
                        <tr><td>New or Reroof</td><td><input class="form-check-input" type="checkbox" value="M" name="defaultCheckType" checked></td></tr>
                        <tr><td scope="col"><b>Service Type<b></td><td><input class="form-check-input" type="checkbox" value="S" name="selectAllStatus" checked onchange="selectUnselectCheck('defaultCheckStatus',this)"></td></tr>
                        <tr><td>Order Open</td><td><input class="form-check-input" type="checkbox" value="A" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Acepted Order</td><td><input class="form-check-input" type="checkbox" value="C" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Order Assigned</td><td><input class="form-check-input" type="checkbox" value="D" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Contractor Just Arrived</td><td><input class="form-check-input" type="checkbox" value="E" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Estimate Sent</td><td><input class="form-check-input" type="checkbox" value="F" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Estimate Approved</td><td><input class="form-check-input" type="checkbox" value="G" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Work In Progress</td><td><input class="form-check-input" type="checkbox" value="H" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Work Completed</td><td><input class="form-check-input" type="checkbox" value="I" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Final Bill</td><td><input class="form-check-input" type="checkbox" value="J" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Order Completed Paid</td><td><input class="form-check-input" type="checkbox" value="K" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Cancel work</td><td><input class="form-check-input" type="checkbox" value="Z" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Report In Progress</td><td><input class="form-check-input" type="checkbox" value="P" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Report Incomplete Refund</td><td><input class="form-check-input" type="checkbox" value="R" name="defaultCheckStatus" checked></td></tr>
                        <tr><td>Report Complete</td><td><input class="form-check-input" type="checkbox" value="S" name="defaultCheckStatus" checked></td></tr>
                    </tbody>
                </table>
                
			</div> 
            <div class="modal-footer" id="buttonMessage"> 
                <button type="button" class="btn-primary btn-sm" onclick="filterCompany('defaultCheckType','defaultCheckStatus','table_orders_company')">Filter</button> 
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myCommentaryInfo" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerMyCommentary">Comment Info</h4> 
			</div> 
			<div class="modal-body" id="textMyCommentary"> 
                <input type="hidden" value="" id="commentaryIDOrder" />
				<div class="table-responsive">
					<table class="table table-condensed" id="commentaryInfo">
						<thead>
							<tr>
								<td class="text-center"><strong>User</strong></td>
								<td class="text-center"><strong>Date</strong></td>
								<td class="text-center"><strong>Comment</strong></td>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>

			<div class="modal-footer" id="buttonCommentary"> 
                <button type="button" class="btn-primary btn-sm" data-target="#myCommentaryInfoN" data-toggle="modal">New Comment</button> 
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myCommentaryInfoN" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerMyCommentaryN">New Comment </h4> 
			</div> 
			<div class="modal-body" id="textMyCommentaryN"> 
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea class="form-control" rows="5" id="commentOrder"></textarea>
                </div>
			</div>

			<div class="modal-footer" id="buttonCommentary"> 
                <button type="button" class="btn-primary btn-sm" onclick="insertCommentary()">Save</button> 
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myUploadReport" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerUploadReport">Files</h4> 
			</div> 
			<div class="modal-body" id="textUploadReport"> 
                <input type="hidden" value="" id="UploadReportIDOrder" />
				<div class="table-responsive">
					<table class="table table-condensed" id="UploadReportInfo">
						<thead>
							<tr>
								<td class="text-center"><strong>User</strong></td>
								<td class="text-center"><strong>Date</strong></td>
								<td class="text-center"><strong>Download</strong></td>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>

			<div class="modal-footer" id="buttonUploadReport"> 
                <button type="button" class="btn-primary btn-sm" data-target="#myUploadReportN" data-toggle="modal">New File</button> 
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myUploadReportN" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerMyUploadReportN">New Roof Report </h4> 
			</div> 
			<div class="modal-body" id="textMyUploadReportN"> 
                <div class="form-group">        
                        <label for="name">File Name</label>
                        <input type="text" class="form-control" id="file_name" name="name" placeholder="Enter name" required />
                </div>
                <input id="uploadImage" type="file" accept="application/pdf" name="image" />
			</div>

			<div class="modal-footer" id="buttonUploadReport"> 
                <button type="button" class="btn-primary btn-sm" onclick="uploadAjax('uploadImage')">Upload</button> 
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myRoofReportRequest" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headermyRoofReportRequest">Roof Report Request</h4> 
			</div> 
			<div class="modal-body" id="textmyRoofReportRequest"> 
                <div class="form-group">
                    <label class="control-label">Select Option</label>
                    <select id="customerTypeRequest" name="customerTypeRequest" onchange="changeSelection()" required="required" class="form-control" placeholder="Select state">
                        <option value="order">Based on existing order</option>
                        <option value="newCustomer">New customer</option>
                    </select>
                </div> 
                <div class="form-group">
                    <label class="control-label" id="labelorderNumberRRR">Type order number</label>
                    <input maxlength="100" type="text" class="form-control" onblur="getInforCustomerForRoofReport()" placeholder="Order Number" id="orderNumberRRR" name="orderNumberRRR" />
                </div> 
                <div class="form-group">
                    <label class="control-label" id="labelcustomerIDRRR" hidden>Select customer</label>
                    <input maxlength="100" type="text" class="form-control" placeholder="Customer Id" id="customerIDRRR" name="customerIDRRR" />
                    <button type="button" class="btn-primary btn-sm" id="buttoncustomerIDRRR" hidden>+</button>
                </div>
                <div class="form-group">
                    <label class="control-label">Customer Info</label>
                    <textarea class="form-control" rows="5" id="customerInfoRRR"></textarea>
                    <a href="#" class="btn input-block-level form-control" data-toggle="modal" data-target="#myRegisterNewCustomer" id="linkNewCustomer">Fill info new customer</a>
                </div>
                <div class="form-group">
                    <label class="control-label">Best select the type of roofing material on your property?</label>
                    <select name="question1" id="question1" class="form-control">
                        <option value="Flat">Flat</option>
                        <option value="Asphalt">Asphalt</option>
                        <option value="Wood Shake/Slate">Wood Shake/Slate</option>
                        <option value="Metal">Metal</option>
                        <option value="Tile">Tile</option>
                        <option value="Do not know">Do not know</option>
                    </select>
                    	
                </div>
                <div class="form-group">
                    <label class="control-label">Are you aware of any leaks or damage to the roof?</label>
                    <select name="question2" id="question2" class="form-control">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>	
                </div>
                <div class="form-group">
                    <label class="control-label">How many stories is your home?</label>
                    <select name="question3" id="question3" class="form-control">
                        <option value="1 Story">1 story</option>
                        <option value="2 Story">2 story</option>
                        <option value="3 or more">Three</option>
                        <option value="3 or more">More</option>
                    </select>	
                </div>
                <div class="form-group">
                    <label class="control-label">Are you the owner or authorized to make property changes?</label>
                    <select name="question4" id="question4" class="form-control">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>	
                </div>
                <div class="form-group">
                    <label class="control-label">Select the place for the service</label>
                    <input type="text" class="form-control" id="question5" placeholder="Address" onclick="showMapSelect('roofReport')">	
                </div>
                
                
			</div>
            <div class="modal-footer" id="buttonUploadReport"> 
            
                    <?php
							if(!isset($_SESSION)) { 
								session_start(); 
							} 
							require_once($_SESSION['application_path']."/controlador/payingController.php");
							
						
							$_objPay=new payingController();
							//echo "<center>";
							//$_objPay->showPayingWindow1('Request','pay_company_roofreport');
							//echo "</center>";
						?>
                        <button id="customButtonCancel" class="btn" onclick="showPayWindow()">Request</button>
                        <button id="customButtonCancel" class="btn" data-dismiss="modal">Close</button>
                    
                
				    <!--<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> -->
                  
			 </div>
                
			
		</div> 
	</div>
</div>

<div class="modal fade" id="myCustomerList" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headermyCustomerList">Customer List</h4> 
			</div> 
			<div class="list-group1" id="myCustomerListGroup">
					
			</div>

			<div class="modal-footer" id="buttonUploadReport"> 
                <button type="button" class="btn-primary btn-sm" onclick="uploadAjax('uploadImage')">Upload</button> 
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myPostCard" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headermyRoofReportRequest">Post Card Request</h4> 
			</div> 
			<div class="modal-body" id="textmyPostCard"> 
                <div class="form-group">
                    <label class="control-label">PostCard Balance</label>
                    <input type="text" class="form-control" id="postCardBalance" placeholder="Balance postCard" onclick="" readonly>	
                </div>
                <div class="form-group">
                    <label class="control-label">Select the place for the post cards deliver</label>
                    <input type="text" class="form-control" id="placePostCard" placeholder="Address" onclick="showMapSelect('postCard')">	
                </div>
                <div class="form-group">
                    <label class="control-label" id="labelPostCardQuantity">Type post card quantity</label>
                    <input maxlength="100" type="text" class="form-control"  placeholder="post card quantity" id="textPostCardQuantity" name="textPostCardQuantity" />
                </div> 
			</div>
            <div class="modal-footer" id="buttonPostCard"> 
                <button id="customButtonCancel" class="btn" onclick="insertOrderPostCard()">Request</button>
                <button id="customButtonCancel" class="btn" data-dismiss="modal">Close</button>
			 </div>
		</div> 
	</div>
</div>

<div class="modal fade" id="myMapSelectAddress" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headermyMapSelectAddress">Service Address</h4> 
			</div> 
			<div class="modal-body" id="textmyMapSelectAddress"> 

                <div class="panel-body">
				    <span class="glyphicon glyphicon-info-sign h1white"></span> <font size="5"><strong class="h1white">Select the place for the service</strong></font>	
					<input type="hidden" id="step5Logintud" name="step5Logintud"/>
					<input type="hidden" id="step5Latitude" name="step5Latitude"/>
					<input type="hidden" id="step5Address" name="step5Address"/>
					<input type="hidden" id="step5ZipCode" name="step5ZipCode"/>
					<div class="list-group">
					
							<input id="pac-inputC" class="controls" type="text"
								placeholder="Enter a location" >
                            
                                <style>
						/* Set the size of the div element that contains the map */
						#map2 {
							height: 400px;  /* The height is 400 pixels */
							width: 100%;  /* The width is the width of the web page */
						}
                        </style>
						
							
							<div id="map2"></div>

							<script>
							// This example requires the Places library. Include the libraries=places
							// parameter when you first load the API. For example:
							

							var map_ = null;

							function initMapOrder() {
								

								map_ = new google.maps.Map(document.getElementById('map2'), {
								center: {lat: 27.332617, lng: -81.255690},
                                zoom: 12,
                                streetViewControl: false,
                                mapTypeControl: false
								});

								////Get lat and long from zipcode
							
								setLocation(map_,"")
								/////////////////////////////////////

								var input = /** @type {!HTMLInputElement} */(
									document.getElementById('pac-inputC'));

								var types = document.getElementById('type-selector');
								map_.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
								map_.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

								var autocomplete = new google.maps.places.Autocomplete(input);
								autocomplete.bindTo('bounds', map_);

								var infowindow = new google.maps.InfoWindow();
								var marker = new google.maps.Marker({
								    map: map_,
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
										map_.fitBounds(place.geometry.viewport);
									} else {
										map_.setCenter(place.geometry.location);
										map_.setZoom(17);  // Why 17? Because it looks good.
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
									infowindow.open(map_, marker);
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
									address = '33101';
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
							<style>
                                .pac-container {
                                    z-index: 10000 !important;
                                }
                            </style>
						<!--
                        <script async defer
							src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&libraries=visualization&libraries=places&callback=initialization">
						</script>
                        -->
						
					</div>
			    </div>
            </div>

			<div class="modal-footer" id="buttonUploadReport"> 
                <button class="btn-primary btn-sm" type="button" onclick="closeMapSelect('question5')" id='buttonRoofReport'>Set Location</button>
                <button class="btn-primary btn-sm" type="button" onclick="closeMapSelect('placePostCard')" id='buttonPostCard'>Set Location</button>
                
                <button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button>
                		
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myRegisterNewCustomer" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerRegisterNewCustomer">Customer Info</h4> 
			</div> 
            <div class="modal-body" id="textRegisterNewCustomer">
                <div class="list-group1" id="myCustomerListGroup">
                        <div class="form-group">
                            <label class="control-label">First Name</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" id="firstCustomerName" name="firstCustomerName"  />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" id="lastCustomerName" name="lastCustomerName"  />
                        </div>  
                        <div class="form-group">
                            <label class="control-label ">Email</label>
                            <input maxlength="100"  type="text" required="required" class="form-control" placeholder="Enter Email" id="emailValidationCustomer" name="emailValidationCustomer" onfocusout="validateEmail('customer')"/>
                            <label class="control-label" id="answerEmailValidate" name="answerEmailValidate">Answer</label>
                        </div>
                        <!--<div class="form-group">
                            <label class="control-label ">Password</label>
                            <input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Password" id="inputPassword" name="inputPassword" onblur="validInputPassword()"  />
                            <div class="help-block">Minimum of 6 characters</div>
                            <label class="control-label" id="answerPasswordValidateStep6" name="answerPasswordValidateStep6"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Confirm Password</label>
                            <input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Confirm Password" id="inputPasswordConfirm" name="inputPasswordConfirm" onblur="validInputRePassword()" />
                            <label class="control-label" id="answerRePasswordValidateStep6" name="answerRePasswordValidateStep6"></label>
                        </div> -->
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="customerAddress" name="customerAddress" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter city" id="customerCity" name="customerCity" />
                        </div> 
                        <div class="form-group">
                            <label class="control-label">State</label>
                            <select id="customerState" name="customerState" required="required" class="form-control" placeholder="Select state">
                                <?php foreach ($_array_state as $key => $value1) { ?>
                                    <option value="<?php echo $value1 ?>"><?php echo $value1 ?></option>
                                <?php } ?>
                            </select>
                            
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label">Zip code</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter zip code" id="customerZipCode" name="customerZipCode" />
                        </div> 
                        <div class="form-group">
                            <label class="control-label">Phone number</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter phone number" id="customerPhoneNumber" name="customerPhoneNumber"  />
                        </div>
                </div>
            </div>
			<div class="modal-footer" id="buttonUploadReport"> 
                <button type="button" class="btn-primary btn-sm" onclick="validateInfoCustomer()">Save Info</button> 
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myRegisterNewCustomerCompany" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerRegisterNewCustomer">Customer Info</h4> 
			</div> 
            <div class="modal-body" id="textRegisterNewCustomer">
                <div class="list-group1" id="myCustomerListGroup">
                        <div class="form-group">
                            <label class="control-label">First Name</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" id="firstCustomerNameCompany" name="firstCustomerNameCompany"  />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" id="lastCustomerNameCompany" name="lastCustomerNameCompany"  />
                        </div>  
                        <div class="form-group">
                            <label class="control-label ">Email</label>
                            <input maxlength="100"  type="text" required="required" class="form-control" placeholder="Enter Email" id="emailValidationCustomerCompany" name="emailValidationCustomerCompany" onfocusout="validateEmail('customer')"/>
                            <label class="control-label" id="answerEmailValidate" name="answerEmailValidate">Answer</label>
                        </div>
                        <!--<div class="form-group">
                            <label class="control-label ">Password</label>
                            <input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Password" id="inputPassword" name="inputPassword" onblur="validInputPassword()"  />
                            <div class="help-block">Minimum of 6 characters</div>
                            <label class="control-label" id="answerPasswordValidateStep6" name="answerPasswordValidateStep6"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Confirm Password</label>
                            <input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Confirm Password" id="inputPasswordConfirm" name="inputPasswordConfirm" onblur="validInputRePassword()" />
                            <label class="control-label" id="answerRePasswordValidateStep6" name="answerRePasswordValidateStep6"></label>
                        </div> -->
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="customerAddressCompany" name="customerAddressCompany" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter city" id="customerCityCompany" name="customerCityCompany" />
                        </div> 
                        <div class="form-group">
                            <label class="control-label">State</label>
                            <select id="customerStateCompany" name="customerStateCompany" required="required" class="form-control" placeholder="Select state">
                                <?php foreach ($_array_state as $key => $value1) { ?>
                                    <option value="<?php echo $value1 ?>"><?php echo $value1 ?></option>
                                <?php } ?>
                            </select>
                            
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label">Zip code</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter zip code" id="customerZipCodeCompany" name="customerZipCodeCompany" />
                        </div> 
                        <div class="form-group">
                            <label class="control-label">Phone number</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter phone number" id="customerPhoneNumberCompany" name="customerPhoneNumberCompany"  />
                        </div>
                </div>
            </div>
			<div class="modal-footer" id="buttonUploadReport"> 
                <button type="button" class="btn-primary btn-sm" onclick="validateInfoCustomer('Company')">Save Info</button> 
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>
  

<div class="modal fade" id="myPostCardServiceP" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headermyPostCardServiceP">Postcard Info</h4> 
			</div> 
            <div class="modal-body" id="textmyPostCardServiceP">
            <embed src="<?php echo  $_SESSION['rsn_documents_path']."PostcardsService.pdf"; ?>" type="application/pdf" width="900" height="600"></embed>
            </div>
			<div class="modal-footer" id="buttonmyPostCardServiceP"> 
                
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<?php 
//echo $_actual_company['postCardValue'];
if(!empty($_actual_company['postCardValue'])){
    echo '
    <div class="modal fade" id="myMessagePostCardsPay" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            
            <!-- Modal content--> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    
                    <h4 class="modal-title" id="headermyMessagePostCardsPay">Postcard Info</h4> 
                </div> 
                <div class="modal-body" id="textmyMessagePostCardsPay">
                    <p>
                    We are very grateful for your choice, to be able to use the postcards please make the payment by clicking <a href="#" onclick="showPayPostCards('.($_actual_company['postCardValue']*100).')">here</a>
                    </p>              
                </div>
                <div class="modal-footer" id="buttonPaymentType"> 
                    <button type="button" class="btn-danger btn-sm"  data-dismiss="modal" onClick="closeExtraWindows()">Close</button>
                </div> 
            </div> 
        </div>
    </div>
    ';
}
?>


<div class="modal fade" id="myFinalAmount" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headermyFinalAmount">Confirm Final Amount</h4> 
			</div> 
			<div class="modal-body" id="textSchedule" style="position:relative;right:0px;top:55px;"> 
				<input type="hidden" value="" id="orderIDFinal" />
				<!--<table>
					<tr><td>Order ID</td><td><input type="text" value="" id="finalAmountOrderID" readonly></td></tr>
					<tr><td>Final Amount Materials</td><td><input type="text" value="" id="finalAmountMaterials" readonly></td></tr>
					<tr><td>Final Amount Time</td><td><input type="text" value="" id="finalAmountTime" readonly></td></tr>
					<tr><td>Final Time</td><td><input type="text" value="" id="finalime" readonly></td></tr>
				</table>-->

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><strong>Confirm Final Amount</strong></h3>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-condensed" id="totalAmountTable">
										<thead>
											<tr>
                                                <td class="text-center"><strong>Price</strong></td>
												<td class="text-center"><strong>Quantity</strong></td>
												<td class="text-right"><strong>Totals</strong></td>
											</tr>
										</thead>
										<tbody>
											<!-- foreach ($order->lineItems as $line) or some such thing here -->
											<tr>
												<td>Amount Materials</td>
												<td class="text-center"><input type="text" id="estMatCompanyF" name="estMatCompanyF" class="form-control input-sm"  onfocusout="calculateFinalAmount()"/></td>
												<td class="text-center"><input type="text" id="estMatCntCompanyF" name="estMatCntCompanyF" class="form-control input-sm" onfocusout="calculateFinalAmount()"/></td>
												<td class="text-right">$00.00</td>
											</tr>
											<tr>
												<td>Amount Time</td>
												<td class="text-center"><input type="text" id="estHourCompanyF" name="estHourCompanyF" class="form-control input-sm" onfocusout="calculateFinalAmount()"/></td>
												<td class="text-center"><input type="text" id="estHourCntCompanyF" name="estHourCntCompanyF" class="form-control input-sm" onfocusout="calculateFinalAmount()"/></td>
												<td class="text-right">$00.00</td>
											</tr>
											
											<tr>
												<td class="thick-line"></td>
												<td class="thick-line"></td>
												<td class="thick-line text-center"><strong>Subtotal</strong></td>
												<td class="thick-line text-right">$00.00</td>
											</tr>
                                            <tr>
												<td>Deposit</td>
												<td class="text-center">$00.00</td>
												<td class="text-center">1</td>
												<td class="text-right">$00.00</td>
											</tr>
											<tr>
												<td class="no-line"></td>
												<td class="no-line"></td>
												<td class="no-line text-center"><strong>Total</strong></td>
												<td class="no-line text-right">$00.00</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
            <br>
            <br> 
			<div class="modal-footer" id="buttonmyFinalAmount"> 
				<button type="button" class="btn-primary btn-sm" onClick="sendFinalAmount()" >Send</button>
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Cancel</button> 
				
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myPaymentType" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerPaymentType">How do you prefer to pay</h4> 
			</div> 
			<div class="modal-body" id="PaymentType"> 
				<input type="hidden" value="" id="orderIDPaymentType" />
				<div class="form-group">
				<label for="ContStatused">Payment Type</label>
					<div class="radio">
						<label><input type="radio" name="selectPaymnetType" id="selectPaymnetType" value="cash" checked>Cash</label>
					</div>
					<div class="radio">
						<label><input type="radio" name="selectPaymnetType" id="selectPaymnetType" value="check" >Check</label>
					</div>
					<div class="radio disabled">
						<label><input type="radio" name="selectPaymnetType" id="selectPaymnetType" value="Online">Online</label>
					</div>

					
					<!--<select id="selectPaymnetType" class="form-control" name="selectPaymnetType">
						<option value="cash">Cash</option>
						<option value="check">Check</option>
						<option value="Online">Online</option>
					</select>-->
				</div>
				
			</div> 
			<div class="modal-footer" id="buttonPaymentType"> 
				<button type="button" class="btn-primary btn-sm" onClick="selectPaymentType()" >Accept</button>
				<button type="button" class="btn-danger btn-sm"  data-dismiss="modal">Close</button>
			</div> 
		</div> 
	</div>
</div>

<div class="collapse container" id="listCustomerByCompany">
    <div class="table-responsive">          
        <table class="table" id="table_list_customer_by_company">
            <thead>
            <tr>
                <th>CustomerID</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip Code</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <button type="button" class="btn-primary btn-sm" data-toggle="modal" data-target="#myUploadListCustomer" onclick="">Upload Clients</button>
    <button type="button" class="btn-primary btn-sm" data-toggle="modal" data-target="#myRegisterNewCustomerCompany" onclick="">New Client</button>
</div>         

<div class="modal fade" id="myUploadListCustomer" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerUploadListCustomer">List Customers</h4> 
			</div> 
			<div class="modal-body" id="textUploadListCustomer"> 
                <div class="alert alert-danger">
                    You can upload the list of clients, for such purpose please use the template provided by clicking <a href="<?php echo  $_SESSION['rsn_documents_path']."curstomer_format.xlsx"; ?>" >here</a>, after completing it please use the upload button. 
                </div>
                <input id="uploadFile" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="uploadFile" />
			</div>

			<div class="modal-footer" id="buttonUploadReport"> 
                <button type="button" class="btn-primary btn-sm" onclick="uploadAjaxXls('uploadFile','<?php echo $_actual_company['CompanyID']?>')">Upload</button>
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myRegisterUpdateCustomerCompany" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerRegisterUpdateCustomer">Customer Info</h4> 
			</div> 
            <div class="modal-body" id="textRegisterUpdateCustomer">
                <div class="list-group1" id="myCustomerListGroup">
                        <input type="hidden" id="customerIdCompanyFBIDU" name="customerIdCompanyFBIDU" />
                        <input type="hidden" id="customerIdCompanyU" name="customerIdCompanyU" />
                        <div class="form-group">
                            <label class="control-label">First Name</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" id="firstCustomerNameCompanyU" name="firstCustomerNameCompanyU"  />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" id="lastCustomerNameCompanyU" name="lastCustomerNameCompanyU"  />
                        </div>  
                        <div class="form-group">
                            <label class="control-label ">Email</label>
                            <input maxlength="100"  type="text" required="required" class="form-control" placeholder="Enter Email" id="emailValidationCustomerCompanyU" name="emailValidationCustomerCompanyU" onfocusout="validateEmail('customer')"/>
                            <label class="control-label" id="answerEmailValidate" name="answerEmailValidate">Answer</label>
                        </div>
                        <!--<div class="form-group">
                            <label class="control-label ">Password</label>
                            <input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Password" id="inputPassword" name="inputPassword" onblur="validInputPassword()"  />
                            <div class="help-block">Minimum of 6 characters</div>
                            <label class="control-label" id="answerPasswordValidateStep6" name="answerPasswordValidateStep6"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label ">Confirm Password</label>
                            <input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Confirm Password" id="inputPasswordConfirm" name="inputPasswordConfirm" onblur="validInputRePassword()" />
                            <label class="control-label" id="answerRePasswordValidateStep6" name="answerRePasswordValidateStep6"></label>
                        </div> -->
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter address" id="customerAddressCompanyU" name="customerAddressCompanyU" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter city" id="customerCityCompanyU" name="customerCityCompanyU" />
                        </div> 
                        <div class="form-group">
                            <label class="control-label">State</label>
                            <select id="customerStateCompanyU" name="customerStateCompanyU" required="required" class="form-control" placeholder="Select state">
                                <?php foreach ($_array_state as $key => $value1) { ?>
                                    <option value="<?php echo $value1 ?>"><?php echo $value1 ?></option>
                                <?php } ?>
                            </select>
                            
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label">Zip code</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter zip code" id="customerZipCodeCompanyU" name="customerZipCodeCompanyU" />
                        </div> 
                        <div class="form-group">
                            <label class="control-label">Phone number</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter phone number" id="customerPhoneNumberCompanyU" name="customerPhoneNumberCompanyU"  />
                        </div>
                </div>
            </div>
			<div class="modal-footer" id="buttonUploadReport"> 
                <button type="button" class="btn-primary btn-sm" onclick="updateDataCustomerFromCompany()">Update Info</button> 
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myUrls" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headermyUrls">Resources</h4> 
			</div> 
			<div class="modal-body" id="textmyUrls"> 
					<div class="container">
						<div class="row">
						<div class="col-md-3">
							<div class="well no-padding">
								<div>
									<ul class="nav nav-list nav-menu-list-style">
                                        
                                        <?php 
                                            echo '<li><label class="tree-toggle nav-header glyphicon-icon-rpad">'
                                            .'<span class="glyphicon glyphicon-folder-close m5"></span>Articles
                                            <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span></label>'
                                            .'<ul class="nav nav-list tree bullets">';
                                            echo '<li><a href="'.$_SESSION['rsn_documents_path'].'Help_Your_Crews_Be_Respectful_of_Homeowners.pdf" target="_blank">Help Your Crews....</a></li>';
                                            echo '<li><a href="'.$_SESSION['rsn_documents_path'].'StrategiestoImproveRatingsandReferrals.pdf" target="_blank">Strategies to Improve....</a></li>';
                                            echo '</ul></li>';

                                            echo '<li><label class="tree-toggle nav-header glyphicon-icon-rpad">'
                                            .'<span class="glyphicon glyphicon-folder-close m5"></span>Building and Permits
                                            <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span></label>'
                                            .'<ul class="nav nav-list tree bullets">';

											$n=0;
											$state="";
											$city="";
											while(isset($_array_urls[$n]['state'])){
												if(strcmp($state,$_array_urls[$n]['state'])==0){
                                                    if(strcmp($city,$_array_urls[$n]['city'])==0){
                                                        echo '<li><a href="'.$_array_urls[$n]['url'].'" target="_blank">'.$_array_urls[$n]['place'].'</a></li>';
                                                    }else{
                                                        if(!empty($city)){
                                                            echo '</ul></li>';
                                                        }
                                                        $city=$_array_urls[$n]['city'];
                                                        echo '<li><label class="tree-toggle nav-header glyphicon-icon-rpad">'.
                                                            '<span class="glyphicon glyphicon-folder-close m5"></span>'.$city
													        .'<span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span></label>
											            <ul class="nav nav-list tree bullets">';
                                                        
                                                        echo '<li><a href="'.$_array_urls[$n]['url'].'" target="_blank">'.$_array_urls[$n]['place'].'</a></li>';
                                                    }
													
												}else{
													if(!empty($state)){
														echo '</ul></li></ul></li>';
													}
                                                    $state=$_array_urls[$n]['state'];
                                                    $city=$_array_urls[$n]['city'];
                                                    echo '<li><label class="tree-toggle nav-header">'.$state.'</label><ul class="nav nav-list tree">';

                                                    echo '<li><label class="tree-toggle nav-header glyphicon-icon-rpad">'
                                                        .'<span class="glyphicon glyphicon-folder-close m5"></span>'.$city
													    .'<span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span></label>'
                                                        .'<ul class="nav nav-list tree bullets">';

                                                    echo '<li><a href="'.$_array_urls[$n]['url'].'" target="_blank">'.$_array_urls[$n]['place'].'</a></li>';
													
												}
												$n++;
											}
										
											echo '</ul></li></ul></li></ul></li>';
										?>
										</ul></li>
									</ul>
								</div>
							</div>
						</div>
						</div>
					</div>
			</div>

			<div class="modal-footer" id="buttonmyUrls"> 
                
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>


<div class="modal fade" id="myEstimateAmount" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content" > 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerEstimateAmount">Send Estimate</h4> 
			</div> 
			<div class="modal-body" id="textEstimateAmount" style="position:relative;right:0px;top:45px;"> 
				<input type="hidden" value="" id="orderID" />
				
				
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><strong>Estimate Amount</strong></h3>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-condensed" id="estimatedAmountTable">
										<thead>
											<tr>
												<td><strong>Item</strong></td>
												<td class="text-center"><strong>Price</strong></td>
												<td class="text-center"><strong>Quantity</strong></td>
												<td class="text-right"><strong>Totals</strong></td>
											</tr>
										</thead>
										<tbody>
											<!-- foreach ($order->lineItems as $line) or some such thing here -->
											<tr>
												<td>Amount Materials</td>
												<td class="text-center"><input type="text" id="estMatCompany" name="estMatCompany" class="form-control input-sm"  onfocusout="calculateEstAmount()"/></td>
												<td class="text-center"><input type="text" id="estMatCntCompany" name="estMatCntCompany" class="form-control input-sm" onfocusout="calculateEstAmount()"/></td>
												<td class="text-right">$00.00</td>
											</tr>
											<tr>
												<td>Amount Time</td>
												<td class="text-center"><input type="text" id="estHourCompany" name="estHourCompany" class="form-control input-sm" onfocusout="calculateEstAmount()"/></td>
												<td class="text-center"><input type="text" id="estHourCntCompany" name="estHourCntCompany" class="form-control input-sm" onfocusout="calculateEstAmount()"/></td>
												<td class="text-right">$00.00</td>
											</tr>
											<tr>
												<td>Deposit</td>
												<td class="text-center"><input type="text" id="estMatAntCompany" name="estMatAntCompany" class="form-control input-sm"/></td>
												<td class="text-center">1</td>
												<td class="text-right">$00.00</td>
											</tr>
											<tr>
												<td class="thick-line"></td>
												<td class="thick-line"></td>
												<td class="thick-line text-center"><strong>Subtotal</strong></td>
												<td class="thick-line text-right">$00.00</td>
											</tr>
											<tr>
												<td class="no-line"></td>
												<td class="no-line"></td>
												<td class="no-line text-center"><strong>Total</strong></td>
												<td class="no-line text-right">$00.00</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div> 
            <br>
            <br>
			<div class="modal-footer" id="buttonEstimateAmount"> 
				<button type="button" class="btn-primary btn-sm" onClick="sendEstimateAmount()" >Confirm</button>
            
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Cancel</button> 
			</div> 
            
		</div> 
	</div>
</div>

<div class="modal fade" id="myOrderByCustomer" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headermyOrderByCustomer">Create Order</h4> 
			</div> 
			<div class="modal-body" id="textmyOrderByCustomer"> 
                <?php
                    $_otherModel=new othersController();
	                $_array_state=$_otherModel->getParameterValue('Parameters/state');
                    include_once('vista/order_request.php'); 
                ?>
			</div> 
			<div class="modal-footer" id="buttonmyOrderByCustomer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myProfileBank" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headermyProfileBank">New Bank</h4> 
			</div> 
            <div class="modal-body" id="textmyProfileBank"> 
                <input type="hidden" id="myProfileBankAccountId" value="">
                <div class="form-group">
                    <label class="control-label" for="myProfileBankCountry">Country</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter bank country" id="myProfileBankCountry" name="myProfileBankCountry" readonly />
                </div>
                <div class="form-group">
                    <label class="control-label" for="myProfileBankCurrency">Currency</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter bank Currency" id="myProfileBankCurrency" name="myProfileBankCurrency" readonly/>
                </div>
                <div class="form-group">
                    <label class="control-label" for="myProfileBankaccount_holder_name">Account Holder Name</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter bank Currency" id="myProfileBankaccount_holder_name" name="myProfileBankaccount_holder_name" />
                </div>
                <div class="form-group">
                    <label class="control-label" for="myProfileBankaccount_holder_name">Account Holder Type</label>
                    <select id="myProfileBankaccount_holder_type" name="myProfileBankaccount_holder_type">
                        <option value="individual">Individual</option>
                        <option value="company">Company</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="myProfileBankaccount_holder_name">Routing Number</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter bank Currency" id="myProfileBankrouting_number" name="myProfileBankrouting_number" />
                </div>
                <div class="form-group">
                    <label class="control-label" for="myProfileBankaccount_number">Account Number</label>
                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter bank Currency" id="myProfileBankaccount_number" name="myProfileBankaccount_number" />
                </div>
			</div> 
            <div class="modal-footer" id="buttonmyProfileBank"> 
                <button type="button" class="btn btn-default" onclick="actionWithBank('insert')">Save</button> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myDocumentIDFront" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headermyDocumentIDFront">Upload Document Front </h4> 
            </div> 
            
			<div class="modal-body" id="textmyDocumentIDFront"> 
            Requirements for ID verification
            <ul>
            <li>Acceptable documents vary by country, although a passport scan is always acceptable and preferred.</li>
            <li>Scans of both the front and back are usually required for government-issued IDs and driver’s licenses.</li>
            <li>Files need to be JPEGs or PNGs smaller than 5MB. We can’t verify PDFs.</li>
            <li>Files should be in color, be rotated with the image right-side up, and have all information clearly legible.</li>
            </ul>
                <input id="myDocumentIDFrontImage" type="file" accept="image/*" name="myDocumentIDFrontImage" />
			</div>

			<div class="modal-footer" id="buttonUploadReport"> 
                <button type="button" class="btn-primary btn-sm" onclick="uploadFileAjax('myDocumentIDFrontImage','documentIDFront','<?php echo $_actual_company['CompanyID']?>','myDocumentIDFront')">Upload</button> 
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myDocumentIDBack" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headermyDocumentIDBack">Upload Document Back </h4> 
            </div> 
            
			<div class="modal-body" id="textmyDocumentIDBack"> 
            Requirements for ID verification
            <ul>
                <li>The document back is usually required for government-issued IDs and driver's licenses.</li>
            
            </ul>
                <input id="myDocumentIDBackImage" type="file" accept="image/*" name="myDocumentIDFrontImage" />
			</div>

			<div class="modal-footer" id="buttonUploadReport"> 
                <button type="button" class="btn-primary btn-sm" onclick="uploadFileAjax('myDocumentIDBackImage','documentIDBack','<?php echo $_actual_company['CompanyID']?>','myDocumentIDBack')">Upload</button>
				<button type="button" class="btn-danger btn-sm" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myRatingScore" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerPaymentType">Rate your overall experience Order <b><span id="orderRatingId"></span></b></h4> 
				
			</div> 
			<div class="modal-body" id="PaymentType"> 
				<input type="hidden" value="" id="orderIDRating" />
				<input type="hidden" value="" id="orderFBID" />
				<div class="form-group">
					<label for="ratingQuestion">Would you like to recommend the service company?</label>
					<div class="radio">
						<label><input type="radio" name="ratingYesNo" id="ratingYesNo" value="Yes" >Yes</label>
					</div>
					<div class="radio disabled">
						<label><input type="radio" name="ratingYesNo" id="ratingYesNo" value="No">No</label>
					</div>
				</div>

				<div class="form-group">
					<label for="ratingQuestion">How would you rate the service company?</label>
						<div class="votable hide">
							<i class="fa fa-3x fa-star-o" data-vote-type="1"></i>
							<i class="fa fa-3x fa-star-o" data-vote-type="2"></i>
							<i class="fa fa-3x fa-star-o" data-vote-type="3"></i>
							<i class="fa fa-3x fa-star-o" data-vote-type="4"></i>
							<i class="fa fa-3x fa-star-o" data-vote-type="5"></i>
						</div>
					<div class="voted">
						<i class="fa fa-3x fa-star-o" data-vote-type="1"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="2"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="3"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="4"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="5"></i>
						
					</div>
					<i><label id="ratingCompany">Rating: 0</label></i>
				</div> 
				<div class="form-group">
					<label for="ratingQuestion">How would you rate the service professional?</label>
					<div class="votable1 hide">
						<i class="fa fa-3x fa-star-o" data-vote-type="1"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="2"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="3"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="4"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="5"></i>
					</div>
					
					<div class="voted1">
						<i class="fa fa-3x fa-star-o" data-vote-type="1"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="2"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="3"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="4"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="5"></i>
					</div>
					<i><label id="ratingProfessional">Rating: 0</label></i>
				</div> 
				<div class="form-group">
					<label for="ratingQuestion">What else would you like others to know?</label>
					<input type="text" class="form-control" id="ratingObservation" placeholder="What else would you like others to know?"/>
				</div>
				<div class="modal-footer" id="buttonPaymentType"> 
					<!--<button type="button" class="btn-primary btn-sm" id="buttonRating" onClick="insertOrderRating()" >Rating</button>-->
					<button type="button" class="btn-danger btn-sm"  data-dismiss="modal">Close</button>
				</div> 
			</div>
		</div> 
	</div>
</div>

<div class="modal fade" id="myListOrderByCustomer" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headermyListOrderByCustomer">Create Order</h4> 
			</div> 
			<div class="modal-body" id="textmyListOrderByCustomerr"> 
                <div class="table-responsive">          
                    <table class="table" id="table_list_orders_by_company">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Company ID</th>
                            <th>Contractor ID</th>
                            <th>Created By</th>
                            <th>Create Date</th>
                            <th>Request Type</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
			</div> 
			<div class="modal-footer" id="buttonmyOrderByCustomer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myMensaje" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerMessageMessage">Modal Header</h4> 
			</div> 
			<div class="modal-body" id="textMessage"> 
				<p >Some text in the modal. myMensaje</p> 
			</div> 
			<div class="modal-footer" id="buttonMessage"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>



<div class="modal fade" id="myModalRespuesta" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerTextAnswerOrder">Modal Header</h4> 
			</div> 
			<div class="modal-body" id="textAnswerOrder"> 
				<p >Some text in the modal. myModalRespuesta</p> 
			</div> 
			<div class="modal-footer" id="buttonAnswerOrder"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

<div class="modal fade" id="myModalRespuestaCompany" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerTextAnswerCompany">Modal Header</h4> 
			</div> 
			<div class="modal-body" id="textAnswerOrder"> 
				<p >Some text in the modal. myModalRespuesta</p> 
			</div> 
			<div class="modal-footer" id="buttonAnswerOrder"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>

