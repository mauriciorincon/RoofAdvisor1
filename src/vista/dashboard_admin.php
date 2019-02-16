Welcome to RoofServicenow Admin 
<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
		<div class="btn-group mr-2" role="group" aria-label="First group">
            <button type="button" class="btn btn-primary active"  data-toggle="collapse" data-target="#mapDashBoard1" onclick="hideShowDivs('companyDashProfile1');hideShowDivs('companyDashBoard');hideShowDivs('companyDashEmployee1');hideShowDivs('scheduleCompany');setActiveItemMenu(this);">Orders</button>
            <button type="button" class="btn btn-primary"  data-toggle="collapse" data-target="#companyDashBoard" onclick="hideShowDivs('companyDashProfile1');hideShowDivs('mapDashBoard1');hideShowDivs('companyDashEmployee1');hideShowDivs('scheduleCompany');setActiveItemMenu(this);getListCompany('table_list_company')">Company</button>
			<button type="button" class="btn btn-primary"  data-toggle="collapse" data-target="#companyDashProfile1" onclick="hideShowDivs('companyDashBoard');hideShowDivs('mapDashBoard1');hideShowDivs('companyDashEmployee1');hideShowDivs('scheduleCompany');setActiveItemMenu(this);">Profile</button>
			<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#companyDashEmployee1" onclick="hideShowDivs('companyDashProfile1');hideShowDivs('companyDashBoard');hideShowDivs('mapDashBoard1');hideShowDivs('scheduleCompany');setActiveItemMenu(this);" >Employee</button>
            <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#scheduleCompany" onclick="hideShowDivs('companyDashProfile1');hideShowDivs('companyDashBoard');hideShowDivs('companyDashEmployee1');hideShowDivs('mapDashBoard1');setActiveItemMenu(this);">Scheduler</button>
            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myFilterWindow" onclick="">Filter Options</button>
            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Metrics
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a href="" class="list-group-item " onclick="" ><span class="glyphicon glyphicon-file"></span><span ></span><span name="emergencyRepair" class="badge badge-primary" style="background:black;">4</span>Emergency Repair</a>
                    <a href="" class="list-group-item " onclick="" ><span class="glyphicon glyphicon-file"></span><span></span><span  name="scheduleRepair" class="badge badge-primary" style="background:black;">4</span>Schedule Repair</a>
                    <a href="" class="list-group-item " onclick="" ><span class="glyphicon glyphicon-file"></span><span ></span><span name="reportRepair" class="badge badge-primary" style="background:black;">4</span>Report Repair</a>
                    <a href="" class="list-group-item " onclick="" ><span class="glyphicon glyphicon-file"></span><span ></span><span name="repairDone" class="badge badge-primary" style="background:black;">4</span>Repair Done</a>
                    <a href="" class="list-group-item " onclick="" ><span class="glyphicon glyphicon-file"></span><span ></span><span name="repairOpen" class="badge badge-primary" style="background:black;">4</span>Repair Open</a>
                </div>
        </div>
        
                
        
</div>


    
<div id="mapDashBoard1" class="collapse in">

    <script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>

    <style>
    /* Set the size of the div element that contains the map */
    #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
    }
    </style>

    <a href="#" data-toggle="collapse" data-target="#onlyMapAdminDashboard">Hide/Show Map</a>
    <div id="onlyMapAdminDashboard" class="collapse in">
        <div id="map"></div>
    </div>
    <script>

        var marketrs=[];
        var contractorMarker=[];
        var mapObject;
        var infowindow;
        var orderOpenContractor=[];

        var scheduleRepairCount=0;
        var emergencyRepairCount=0;
        var reportRepairCount=0;
        var postCardCount=0;

        var closeService=0;
        var openService=0;

        var openService=0;
        <?php echo 'var iconBase = "'. $_SESSION['image_path'].'"';?>

        // Initialize and add the map
        function initMap() {
            // The location of Uluru
            var uluru = {lat: 25.745693, lng: -80.375028};
            // The map, centered at Uluru
            mapObject = new google.maps.Map(
                document.getElementById('map'), {zoom: 11, center: uluru});

            // The marker, positioned at Uluru
            //var marker = new google.maps.Marker({position: uluru, map: map});
            var marker="";
            var iconBase = iconBase+'img_maps/';
            

            var geocoder = new google.maps.Geocoder();
            infowindow = new google.maps.InfoWindow();

            //if(address != "" && address != null && address != " "){
            //    geocodeAddress(geocoder,map,address,iconBase);
            //}
            
            

            var ref = firebase.database().ref("Orders");
            ref.once("value", function(snapshot) {

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
                    
                }
            });

            
            
            // Retrieve new orders as they are added to our database
            ref.limitToLast(1).on("child_added", function(snapshot, prevChildKey) {
                var newOrder = snapshot.val();
                    row=validateExist(newOrder.OrderNumber)
                    if(row==-1){
                            addOrderToTable(newOrder,companyID,map,infowindow,iconBase);
                    }                        
                
                console.log("Data: " + newOrder);
                
            });

            // Retrieve new orders as they are added to our database
            ref.on("child_changed", function(snapshot, prevChildKey) {
                var updateOrder = snapshot.val();
                
                row=validateExist(updateOrder.OrderNumber);
                if(row==-1){
                        addOrderToTable(updateOrder,map,infowindow,iconBase);
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

                
                

                
                console.log("Data: " + updateOrder.OrderNumber);
                
            });

            // Remove orders that are deleted from database
                ref.on("child_removed", function(snapshot) {
                var deletedOrder = snapshot.val();
                    row=validateExist(deletedOrder.OrderNumber);
                    if(row>-1){
                        removeOrderOnTable(deletedOrder);
                    }
                console.log("Data: " + deletedOrder.OrderNumber);
                
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
                        infowindow.setContent('<p><b>Order #:</b>'+fila.OrderNumber+'  <br><b>Address:</b>'+fila.RepAddress+' '+fila.RepCity+' '+fila.RepState+
                                                    '</b><br><b>Status:</b>'+getStatus(fila.Status)+
                                                    '<br><b>Date:</b>'+fila.SchDate+' '+fila.SchTime+
                                                    '<br><b>Customer:</b>'+customerName+
                                                    '<br><b>Contractor:</b>'+contractorName+'</p>');
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
                position: results[0].geometry.location
                
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

        function addOrderToTable(dataOrder,map,infowindow,iconBase){
            var t = $('#table_orders_company').DataTable();
            var requestType=getRequestType(dataOrder.RequestType);
            var status=getStatus(dataOrder.Status);
            
            var dataCustomer="";
            var companyActions="";
            var dataContractor="";
                                

            if(dataOrder.ContractorID=="" || dataOrder.ContractorID==null){
                if(dataOrder.RequestType!='R' && dataOrder.RequestType!='P'){
                    dataContractor='';
                }else{
                    dataContractor='<a class="btn-primary btn-sm" data-toggle="modal"'+
                                'href="#myModalGetWork" '+
                                'onClick="setOrderId(\''+dataOrder.FBID+'\',\''+ dataOrder.RequestType+'\')"> '+
                                '<span class="glyphicon glyphicon-check"></span>TalTake work</a>';
                }
            }else{
                getContractorName(dataOrder.ContractorID).then(function(contractorName){
                            dataContractor=contractorName; 
                    });
            }

            companyActions='<a class="btn-info btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Invoice Info" '+
                            'href="#" '+ 
                            'onClick="getInvoices(\''+dataOrder.FBID+'\')">'+ 
                            '<span class="glyphicon glyphicon-list-alt"></span>'+
                        '</a>';
            getCustomerData(dataOrder.CustomerFBID,dataOrder.RepAddress).then(function(customerDataX) {                  
                dataCustomer=customerDataX;
            });
            
                
            companyActions+='<a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+
                            'href="" '+
                            'onClick="getCommentary(\''+dataOrder.FBID+'\')">'+ 
                            '<span class="glyphicon glyphicon-comment"></span>'+
                        '</a>';    
            
            companyActions+='<a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Upload Files" '+ 
                            'href="#" ' +
                            'onClick="getListReportFile(\''+dataOrder.FBID+'\')">'+ 
                            '<span class="glyphicon glyphicon-upload"></span>'+
                        '</a>';
                
            valueMat=isNaN(parseInt(dataOrder.EstAmtMat)) ? 0 : parseInt(dataOrder.EstAmtMat);
            valueTime=isNaN(parseInt(dataOrder.EstAmtTime)) ? 0 : parseInt(dataOrder.EstAmtTime);

            valueMatA=isNaN(parseInt(dataOrder.ActAmtMat)) ? 0 : parseInt(dataOrder.ActAmtMat);
            valueTimeA=isNaN(parseInt(dataOrder.ActAmtTime)) ? 0 : parseInt(dataOrder.ActAmtTime);

            estimateAmount=(parseInt(valueMat)+parseInt(valueTime));
			estimateAmount = estimateAmount ? estimateAmount : '0';		
                        
            finalAmount=parseInt(valueMatA)+parseInt(valueTimeA);
            finalAmount = finalAmount ? finalAmount : '0';

            if(dataOrder.RequestType=='P'){
                description='Number of Postcard: '+dataOrder.postCardValue;
            }else{
                description=dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water;
            }

            t.row.add( [
                    dataOrder.OrderNumber,
                    dataOrder.SchDate,
                    dataOrder.SchTime,
                    dataCustomer,
                    description,
                    requestType,
                    status,
                    '$'+estimateAmount,
                    '$'+finalAmount,
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

        }

        function updateOrderOnTable(dataOrder){
            var value = dataOrder.OrderNumber;
            $("#table_orders_company tr").each(function(index) {
                if (index !== 0) {

                    $row = $(this);

                    var id = $row.find("td:eq(0)").text();
                    if (id.indexOf(value) === 0) {
                        var requestType=getRequestType(dataOrder.RequestType);
                        var status=getStatus(dataOrder.Status);
                        var dataCustomer="";

                        if(dataOrder.ContractorID=="" || dataOrder.ContractorID==null){
                            if(dataOrder.RequestType!='R' && dataOrder.RequestType!='P'){
                                dataContractor='';
                            }else{
                                dataCustomer='<a class="btn-primary btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take work" '+
                                            'href="#myModalGetWork" '+
                                            'onClick="setOrderId(\''+dataOrder.FBID+'\',\''+ dataOrder.RequestType+'\')"> '+
                                            '<span class="glyphicon glyphicon-check"></span>Take work</a>';
                                $row.find("td:eq(10)").html(dataCustomer);
                            }
                        }else{
                            getContractorName(dataOrder.ContractorID).then(function(contractorName){
                                $row.find("td:eq(10)").html(contractorName);
                            });
                        }

                       
                        getCustomerData(dataOrder.CustomerFBID,dataOrder.RepAddress).then(function(customerData) {  
                            $row.find("td:eq(3)").html(customerData);
                        });

                        
                        getCompanyStatus(dataOrder.CompanyID).then(function(companyStatus){
                            companyActions='<a class="btn-info btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Invoice Info" '+
                                'href="#" '+ 
                                'onClick="getInvoices(\''+dataOrder.FBID+'\')">'+ 
                                '<span class="glyphicon glyphicon-list-alt"></span>'+
                            '</a>';
                            companyActions+='<a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments" '+
                                                    'href="" '+
                                                    'onClick="getCommentary(\''+dataOrder.FBID+'\')">'+ 
                                                    '<span class="glyphicon glyphicon-comment"></span>'+
                                                '</a>';    
                            companyActions+='<a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Upload Files" '+ 
                                    'href="#" ' +
                                    'onClick="getListReportFile(\''+dataOrder.FBID+'\')">'+ 
                                    '<span class="glyphicon glyphicon-upload"></span>'+
                                '</a>';
                             
                            $row.find("td:eq(11)").html(companyActions);
                        });

                        $row.find("td:eq(1)").html(dataOrder.SchDate);
                        $row.find("td:eq(2)").html(dataOrder.SchTime);

                        if(dataOrder.RequestType=='P'){
                            description='Number of Postcard: '+dataOrder.postCardValue;
                        }else{
                            description=dataOrder.Hlevels+', '+dataOrder.Rtype+', '+dataOrder.Water;
                        }
                        $row.find("td:eq(4)").html(description);

                        $row.find("td:eq(5)").html(requestType);
                        $row.find("td:eq(6)").html(status);

                        valueMat=isNaN(parseInt(dataOrder.EstAmtMat)) ? 0 : parseInt(dataOrder.EstAmtMat);
                        valueTime=isNaN(parseInt(dataOrder.EstAmtTime)) ? 0 : parseInt(dataOrder.EstAmtTime);

                        valueMatA=isNaN(parseInt(dataOrder.ActAmtMat)) ? 0 : parseInt(dataOrder.ActAmtMat);
                        valueTimeA=isNaN(parseInt(dataOrder.ActAmtTime)) ? 0 : parseInt(dataOrder.ActAmtTime);

                        estimateAmount=(parseInt(valueMat)+parseInt(valueTime));
                        estimateAmount = estimateAmount ? estimateAmount : '0';		
                                    
                        finalAmount=parseInt(valueMatA)+parseInt(valueTimeA);
                        finalAmount = finalAmount ? finalAmount : '0';

                        $row.find("td:eq(7)").html('$'+estimateAmount);
                        $row.find("td:eq(8)").html('$'+finalAmount);
                        $row.find("td:eq(9)").html(dataOrder.PaymentType);   
                    }
                }
            });
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
            
                var ref = firebase.database().ref("Customers/"+customerFBID);
                ref.once('value').then(function(snapshot) {
                        data=snapshot.val();
                        return resolve(data.Fname+' '+data.Lname+' / '+RepAddress+' / '+data.Phone);
                    });
                    //return reject("Undefined");
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

    <script>
    <?php echo $_SESSION['firebase_path_javascript']; ?>
    
    firebase.initializeApp(config);


    </script>


    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&libraries=visualization&callback=initMap">
    </script>
    <br>



    <div class="table-responsive">          
        <table class="table table-striped table-bordered" id="table_orders_company">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Customer Info</th>
                    <th>Roof Desc</th>
                    <th>Job Type</th>
                    <th>Status</th>
                    <th>Est Amt</th>
                    <th>Final Amt</th>
                    <th>Payment</th>
                    <th>Pro</th>
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
                                $_customerName=$this->_userModel->getNode('Customers/'.$order['CustomerFBID'].'/Fname');
                                $_customerName.=" ".$this->_userModel->getNode('Customers/'.$order['CustomerFBID'].'/Lname');

                                $_phone_number=$this->_userModel->getNode('Customers/'.$order['CustomerFBID'].'/Phone');
                                $_phone_number=str_replace("+1","",$_phone_number);
                                echo $_customerName.' / '.$order['RepAddress'].' / '.$_phone_number;
                                
                                
                            ?></td>
                        
                        <td><?php 
                                if(strcmp($order['RequestType'],"P")==0){
                                    echo 'Number of Postcard: '.$order['postCardValue'];
                                }else{
                                    echo $order['Hlevels'].", ".$order['Rtype'].", ".$order['Water'];
                                }
                            ?>
                        </td>
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

                        <td><?php echo "$".(intval($order['EstAmtMat'])+intval($order['EstAmtTime']))?></td>
                        <td><?php echo "$".(intval($order['ActAmtMat'])+intval($order['ActAmtTime']))?></td>
                        <td><?php echo $order['PaymentType']?></td>
                        <td><?php 
                                if(!isset($order['ContractorID']) or empty($order['ContractorID'])){ 
                                    if(strcmp($order['RequestType'],'R')!==0 and  strcmp($order['RequestType'],'P')!==0){
                                       
                                    ?>
                                        
                            <?php }else{ ?>
                                    <a class="btn-primary btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Take the job"  
                                            href="#myModalGetWork" 
                                            onClick="setOrderId('<?php echo $order['FBID']?>','<?php echo $order['RequestType']?>')"> 
                                            <span class="glyphicon glyphicon-check"></span>Take work
                                        </a>
                            <?php }
                                }else{
                                    $_contractorName=$this->_userModel->getNode('Contractors/'.$order['ContractorID'].'/ContNameFirst');
                                    $_contractorName.=" ".$this->_userModel->getNode('Contractors/'.$order['ContractorID'].'/ContNameLast');

                                    echo $_contractorName;
                                } 
                                
                            ?>
                        </td>
                        <td>
                            <a class="btn-info btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Invoice Info"  
                                href="#" 
                                onClick="<?php echo "getInvoices('".$order['FBID']."')" ?>"> 
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </a>
                            <a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Comments"  
                                href="#" 
                                onClick="<?php echo "getCommentary('".$order['FBID']."')" ?>"> 
                                <span class="glyphicon glyphicon-comment"></span>
                            </a>
                            <a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Upload Files"  
                                href="#" 
                                onClick="<?php echo "getListReportFile('".$order['FBID']."')" ?>"> 
                                <span class="glyphicon glyphicon-upload"></span>
                            </a>
                        </td>
                    
                    
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div> 
</div>
    
<div class="collapse container" id="companyDashBoard">
    

        <div class="table-responsive">          
            <table class="table" id="table_list_company">
                <thead>
                <tr>
                    <th>CompanyID</th>
                    <th>CompanyLicNum</th>
                    <th>Address</th>
                    <th>CompanyEmail</th>
                    <th>CompanyName</th>
                    <th>CompanyPhone</th>
                    <th>CompanyStatus</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
</div>         


<div class="collapse container" id="companyDashProfile1">
    
    <div class="modal-header"> 
        <!--<button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h4 class="modal-title" id="headerTextProfileCompany">Company Profile</h4> 
    </div> 
    <div class="modal-body" id="textProfileCompany"> 
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#profile">Basic</a></li>
            <li><a data-toggle="tab" href="#paying">Paying</a></li>
            <li><a data-toggle="tab" href="#others">Others</a></li>
        </ul>

                <div class="tab-content">
                    <!--Div profile-->
                    <div id="profile" class="tab-pane fade in active">
                        
                        <form role="form">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="control-label ">Company ID</label>
                                    <input maxlength="100" disabled type="text" class="form-control"  id="companyID" name="companyID" value="<?php echo $_actual_company['CompanyID'] ?>" />
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Company Name</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Name" id="compamnyName" name="compamnyName" value="<?php echo $_actual_company['CompanyName'] ?>" />
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

                                <div class="form-group">
                                    <label class="control-label">Phone number</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter phone number" id="companyPhoneNumber" name="companyPhoneNumber"  value="<?php echo $_actual_company['CompanyPhone'] ?>"/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Company Type</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Company Type" id="companyType" name="companyType" value="<?php echo $_actual_company['CompanyType'] ?>"/>
                                </div> 
                                    
                            </div>
                            
                        </form>
                    </div>

                    <!--Div paying-->
                    <div id="paying" class="tab-pane fade">
                        
                        <form role="form">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="control-label">Billing Address</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address" id="compamnyPayAddress1" name="compamnyPayAddress1" value="<?php echo $_actual_company['PayInfoBillingAddress1'] ?>" />
                                </div>
                                <div class="form-group">

                                    <label class="control-label">Billing Address 2</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address 2" id="compamnyPayAddress2" name="compamnyPayAddress2" value="<?php echo $_actual_company['PayInfoBillingAddress2'] ?>" />

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
                        </form>
                    </div>

                    <!--Div orders-->
                    <div id="others" class="tab-pane fade">
                        <form role="form">
                            <div class="panel-body">
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
                        </form>
                    </div>

                </div> 
    
        <button type="button" class="btn-primary btn-sm" onClick="updateDataCompany()" >Update Info</button>        
        <div class="modal-footer" id="buttonrating"> 
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
        </div> 
    </div>
</div>

<div class="collapse container" id="companyDashEmployee1">

			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerTextDriversCompany">Employee List</h4> 
			</div> 
			<div class="modal-body" id="textAnswerDriversCompany"> 
                <div class="table-responsive">
                        <table class="table" id="table_drivers_dashboard_company" name="table_drivers_dashboard_company">
                            <thead>
                            <tr>
                                <th>ContractorID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Employee Phone</th>
                                <th>Employee License</th>
                                <th>Employee Email</th>
                                <th>Profile</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Inactive</th>
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
                        
                        <a class="btn btn-outline-primary" data-toggle="modal"  
                                            href="#myModalInsertContractor" 
                                            onClick="emptyTextNewDriver()"> 
                                            <span class="glyphicon glyphicon-file">New Employee</span>
                        </a>
                        
                </div>
            </div> 
			
	

</div>

<!-- formulario Insertar contractor datos-->
<div class="collapse container" id="scheduleCompany">
            <?php   $_year=date("Y");
                    $_month=date("m");
                    echo "<h2>$_month $_year </h2>";
                    $_eventsArray=array();
                    $oCalendar=new calendar();
                    echo $oCalendar->draw_controls($_month,$_year);
                    if(strlen($_month)==1){
						$_eventsArrayAux=$oCalendar->getEvents("0".$_month,$_year);
					}else{
						$_eventsArrayAux=$oCalendar->getEvents($_month,$_year);
					}
					
						foreach($_eventsArrayAux as $key => $orderData){
							if(strcmp( $orderData['CustomerID'], $_actual_customer['CustomerID']) == 0){
								array_push($_eventsArray,$order);
							}
						}
					
                    //print_r($_eventsArray);
                    echo $oCalendar->draw_calendar($_month,$_year,$_eventsArray);
            ?>
     
</div><!-- /cierro modal -->


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
<div class="modal" id="myModalCompanyProfile" role="dialog" style="height: 1000px;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Company Info</h4>
        </div>
        <div class="modal-body"  id="myModalCompanyProfileBody">
            
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="accordion" id="accordionExample">

                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0" style="background-color: gainsboro;">
                                    <button class="btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Company Info
                                    </button>
                                    <!--<button class="btn-primary btn-sm" style="float: right;" onClick="updateDataCompany()"><span class="glyphicon glyphicon-save"></span>Save Basic Info</button>-->
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
                                        <label class="control-label ">Contractor License Number</label>
                                        <input maxlength="100"  type="text" required="required" class="form-control" placeholder="Enter License Number" id="companyLicenseNumber" name="companyLicenseNumber" value="<?php if(isset($_actual_company['ComapnyLicNum'])){ echo $_actual_company['ComapnyLicNum'];}  ?>"/>
                                    </div>
                                   
                                   
                                    <div class="form-group">
                                        <label class="control-label ">License Expiration Date</label>
                                        <input maxlength="100"  type="text" required="required" class="form-control datepickerdob" placeholder="Enter Expiration date" id="companyExpirationDate" name="companyExpirationDate" value="<?php if(isset($_actual_company['LicExpiration'])){ echo $_actual_company['LicExpiration'];}?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label ">License Verified</label>
                                        <input maxlength="100"  type="checkbox" disabled class="form-control" placeholder="Enter Verified" id="companyVerified" name="companyVerified" value="<?php if(isset($_actual_company['Verified'])){ echo $_actual_company['Verified'];} ?>"/>
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
                                    <div class="form-group">
                                        <label class="control-label ">In Business Since</label>
                                        <input maxlength="100"  type="text" required="required" class="form-control datepickerdob" placeholder="Enter In Business Since" id="companyBusinessSince" name="companyBusinessSince" value="<?php if(isset($_actual_company['InBusinessSince'])){ echo $_actual_company['InBusinessSince'];} ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0" style="background-color: gainsboro;">
                                    <button class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Company Billing
                                    </button>
                                    <!--<button class="btn-primary btn-sm" style="float: right;" onClick="updateDataCompany()"><span class="glyphicon glyphicon-save"></span>Save Billing Info</button>-->
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-group">

                                    <label class="control-label">Billing Address</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Billing Address 2" id="compamnyPayAddress1" name="compamnyPayAddress1" value="<?php echo $_actual_company['PayInfoBillingAddress1'] ?>" />

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
                                        <label class="control-label">PayInfoCredit Card Number</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Month (MM)" id="compamnyPayMonth" name="compamnyPayMonth" value="<?php echo $_actual_company['PayInfoCCExpMon'] ?>" />
                                    </div>
                                    <!--
                                    <div class="form-group">
                                        <label class="control-label">Credit Card Expiration Year (YYYY)</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Expiration Year (YYYY)" id="compamnyPayYear" name="compamnyPayYear" value="<?php echo $_actual_company['PayInfoCCExpYr'] ?>" />
                                    </div>
                                    -->
                                    <div class="form-group">
                                        <label class="control-label">Credit Card Number</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card Number" id="compamnyPayCCNum" name="compamnyPayCCNum" value="<?php echo $_actual_company['PayInfoCCNum'] ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Credit Card CSV</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Credit Card CSV" id="compamnyPaySecCode" name="compamnyPaySecCode" value="<?php echo $_actual_company['PayInfoCCSecCode'] ?>" />
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
                                    <label class="control-label">Name on Cred Card</label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Name on Cred Card" id="compamnyPayName" name="compamnyPayName" value="<?php echo $_actual_company['PayInfoName'] ?>" />
                                    </div>
                                    <!--
                                    <div class="form-group">
                                        <label class="control-label">First Name on Credit Card</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name on Credit Card" id="compamnyPayFName" name="compamnyPayFName" value="<?php echo $_actual_company['PrimaryFName'] ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Last Name on Credit Card</label>
                                        <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name on Credit Card" id="compamnyPayLName" name="compamnyPayLName" value="<?php echo $_actual_company['PrimaryLName'] ?>" />
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0" style="background-color: gainsboro;">
                                    <button class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Company Insurance
                                    </button>
                                    <!--<button class="btn-primary btn-sm" style="float: right;" onClick="updateDataCompany()"><span class="glyphicon glyphicon-save"></span>Save Info</button>-->
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
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0" style="background-color: gainsboro;">
                                    <button class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Stripe Info
                                    </button>
                                    <!--<button type="button" class="btn-primary btn-sm" style="float: right;" onClick="query_valid_account_stripe('<?php echo $_actual_company['stripeAccount'] ?>')" >Validate Info to Receive Payments</button>-->
                                    <!--<button class="btn-primary btn-sm" style="float: right;" onClick="updateDataCompany()"><span class="glyphicon glyphicon-save"></span>Save Stripe Info</button>-->
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
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0" style="background-color: gainsboro;">
                                    <button class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Deposit Accounts
                                    </button>
                                    
                                </h2>
                            </div>

                            <div id="collapseFive" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="alert alert-primary" role="alert">
                                        <h2><b>Accounts</b></h2>
                                    </div>
                                    <table class="table table-bordered" id="listBankCompany">
                                        <tr>
                                            <td>id</td>
                                            <td>Holder  Name</td>
                                            <td>Holder  Type</td>
                                            <td>Bank Name</td>
                                            <!--
                                            <td>Country</td>
                                            <td>Currency</td>
                                            -->
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
                        <div>
                            <a class="btn-primary btn-sm" data-toggle="modal"  
                                href="#myExportInfoWindow" 
                                onClick=""> 
                                <span class="glyphicon glyphicon-save"></span>
                                Export Info
                            </a> 
                            
                        </div>

                        <div class="accordion" id="accordionPayments">
                            <div class="card">
                                <div class="card-header" id="headingOnep">
                                    <h2 class="mb-0" style="background-color: gainsboro;">
                                        <button class="btn-link" type="button" data-toggle="collapse" data-target="#collapseOnep" aria-expanded="true" aria-controls="collapseOnep">
                                        <span class="glyphicon glyphicon-plus-sign"></span> Balance
                                        </button>
                                        <button class="btn-primary btn-sm" style="float: right;" onClick="getStripeInfo('balance','tableCompanyBalance','<?php echo $_actual_company['CompanyID'] ?>')"><span class="glyphicon glyphicon-refresh"></span></button>
                                        
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
                                                    <!--
                                                    <th>Currency</th>
                                                    -->
                                                    <th>bank_account</th>
                                                    <!--
                                                    <th>bitcoin_receiver</th>
                                                    <th>card</th>
                                                    -->
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
                                                                "<td>".$trancs->source_types->bank_account."</td>".
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
                                                                
                                                                "<td>".$trancs->source_types->bank_account."</td>".
                                                                
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
                                        
                                    </h2>
                                </div>
                                <div id="collapseTwop" class="collapse" aria-labelledby="headingTwop" data-parent="#accordionPayments">
                                    <table class="table table-bordered" id="tableCompanyTransfer" >
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Amount</th>
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
    </div><!-- /cierro contenedor -->
  </div><!-- /cierro dialogo-->
</div><!-- /cierro modal -->





<!-- formulario Insertar contractor datos-->
<div class="modal" id="myModalSchedyleCompany" role="dialog" style="height: 1000px;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Service Schedule</h4>
      </div>
        <div class="modal-body"  id="scheduleCompany">
            <?php   echo '<h2>June 2018</h2>';
                    $oCalendar=new calendar();
                    echo $oCalendar->draw_controls(6,2018);
                    $_eventsArray=$oCalendar->getEvents(6,2018);
                    echo $oCalendar->draw_calendar(6,2018,$_eventsArray);
            ?>
        </div>
    </div><!-- /cierro contenedor -->
  </div><!-- /cierro dialogo-->
</div><!-- /cierro modal -->


<div class="modal fade" id="myFilterWindow" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 

		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="headerMessage">Filter Options</h4> 
			</div> 
			<div class="modal-body" id="textMessage"> 
                <p>
                <table class="table">
                    <thead>
                        <tr><th scope="col">Service Type</th><th><input class="form-check-input" type="checkbox" value="S" name="selectAllTYpe" checked onchange="selectUnselectCheck('defaultCheckType',this)"></th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Schedule Repair</td><td><input class="form-check-input" type="checkbox" value="S" name="defaultCheckType"  checked></td></tr>
                        <tr><td>Emergency Repair</td><td><input class="form-check-input" type="checkbox" value="E" name="defaultCheckType" checked></td></tr>
                        <tr><td>Report Repair</td><td><input class="form-check-input" type="checkbox" value="R" name="defaultCheckType" checked></td></tr>
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

<!-- formulario Insertar contractor datos-->
<div class="modal" id="myModalGetWork" role="dialog" >
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Take work</h4>
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
                <label for="numberPostCard" id="numberPostCardLabel">Number of postcards</label>
                <input type="text" class="form-control" name="numberPostCard" id="numberPostCard" readonly >
            </div>
            <div class="form-group">
                <label for="amountPostCard" id="amountPostCardLabel">Amount</label>
                <input type="text" class="form-control" name="amountPostCard" id="amountPostCard" >
            </div>
            
            <div class="form-group">
                <label for="driverWork">Driver for the work</label>
                <select name="driverWork" id="driverWork" class="form-control" required>
                    <?php foreach ($_array_contractors_to_show as $key => $contractor) {?>
                        <option value="<?php echo $contractor['ContractorID']?>"><?php echo $contractor['ContNameFirst']." ".$contractor['ContNameLast']?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="button" class="btn-primary btn-sm" onClick="takeWork()" >Save</button>
            <button  type="button" class="btn-danger btn-sm" data-dismiss="modal">Cancel</button>
        </div>
    </div><!-- /cierro contenedor -->
  </div><!-- /cierro dialogo-->
</div><!-- /cierro modal -->

<!-- formulario Insertar contractor datos-->
<div class="modal" id="myModalPostAdmin" role="dialog" >
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Charge PostCard</h4>
      </div>
        <div class="modal-body"  id="myModalPostAdminBody">
            <input type="hidden" value="<?php echo $_actual_company['CompanyID'] ?>" id="companyPostCard" />
            <div class="form-group">
                <label for="postCardBalance">PostCard Balance</label>
                <input type="text" class="form-control" name="postCardBalance" id="postCardBalance" readonly >
            </div>
            <div class="form-group">
                <label for="postCardQuantity">Quantity PostCard Company</label>
                <input type="text" class="form-control" name="postCardQuantity" id="postCardQuantity" required >
            </div>
            <div class="form-group">
                <label for="dateWork">PostCard Value</label>
                <input type="text" class="form-control" name="postCardValue" id="postCardValue" required >
            </div>
            
            <button type="button" class="btn-primary btn-sm" onClick="chargePostCardCompany()" >Charge Post Cards</button>
            <button  type="button" class="btn-danger btn-sm" data-dismiss="modal">Cancel</button>
        </div>
    </div><!-- /cierro contenedor -->
  </div><!-- /cierro dialogo-->
</div><!-- /cierro modal -->

<!-- formulario Insertar contractor datos-->
<div class="modal" id="myModalEmployeeList" role="dialog" style="height: 1000px;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Service Schedule</h4>
      </div>
      <div class="modal-body" id=""> 
            
            <div class="table-responsive">
                <table class="table table-condensed" id="table_drivers_dashboard_admin">
                    <thead>
                        <tr>
                            <td class="text-center"><strong>Id</strong></td>
                            <td class="text-center"><strong>First Name</strong></td>
                            <td class="text-center"><strong>Last Name</strong></td>
                            <td class="text-center"><strong>Phone Number</strong></td>
                            <td class="text-center"><strong>Licence Number</strong></td>
                            <td class="text-center"><strong>Email</strong></td>
                            <td class="text-center"><strong>Status</strong></td>
                            <td class="text-center"><strong>Actions</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>       
        

    </div><!-- /cierro contenedor -->
  </div><!-- /cierro dialogo-->
</div><!-- /cierro modal -->
