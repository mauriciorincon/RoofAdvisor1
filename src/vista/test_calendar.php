<?php   
    $_year=date("Y");
    $_month=date("m");
    
    $_eventsArray=array();
    $oCalendar=new calendar();
    
    //echo $oCalendar->draw_controls($_month,$_year);
    if(strlen($_month)==1){
        $_eventsArrayAux=$oCalendar->getEvents("0".$_month,$_year);
    }else{
        $_eventsArrayAux=$oCalendar->getEvents($_month,$_year);
    }
    
        foreach($_eventsArrayAux as $key => $orderData){
            //if(strcmp( $orderData['CustomerID'], $_actual_customer['CustomerID']) == 0){
                array_push($_eventsArray,$orderData);
            //}
        }
    
    //print_r($_eventsArray);
    //echo $oCalendar->draw_calendar($_month,$_year,$_eventsArray);
    
?>
 
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
						  <option style="color:#000;" value="#000">&#9724; Negro</option>
						  
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
				<button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
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
				<h4 class="modal-title" id="myModalLabel">Modificar Evento</h4>
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
					<label for="title" class="col-sm-2 control-label">Comapny</label>
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
				  <!--<div class="form-group">
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
						  <option style="color:#000;" value="#000">&#9724; Negro</option>
						  
						</select>
					</div>
				  </div>
				    <div class="form-group"> 
						<div class="col-sm-offset-2 col-sm-10">
						  <div class="checkbox">
							<label class="text-danger"><input type="checkbox"  name="delete"> Eliminar Evento</label>
						  </div>
						</div>
					</div>-->
				  
          
				  <input type="hidden" name="id" class="form-control" id="id">
				
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				<!--<button type="submit" class="btn btn-primary">Guardar</button>-->
			  </div>
			</form>
			</div>
		  </div>
		</div>
 
    </div>
    <!-- /.container -->


<script src="vista/js/jquery-3.3.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>
<script>
    $(document).ready(function() {
 
 var date = new Date();
var yyyy = date.getFullYear().toString();
var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();
 

   

 $('#calendar').fullCalendar({
     header: {
          language: 'en',
         left: 'prev,next today',
         center: 'title',
         right: 'month,basicWeek,basicDay',

     },
     defaultDate: yyyy+"-"+mm+"-"+dd,
     editable: true,
     eventLimit: true, // allow "more" link when too many events
     selectable: true,
     selectHelper: true,
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
              var color=getRequestColor(data.RequestType);
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

function getRequestType(requestType){
                var RequestType="";
                switch (requestType) {
                    case "E":
                        RequestType = "Emergency";
                        break;
                    case "S":
                        RequestType = "Schedule";
                        break;
                    case "R":
                        RequestType = "RoofReport";
                        break;
                    case "P":
                        RequestType = "PostCard";
                        break;
                    default:
                        RequestType = "No value found";
                }
                return RequestType;
            }

  function getRequestColor(requestType){
      var colorType="";
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
      return colorType;
  }

function getStatus(status){
                var orderStatus="";
                switch (status) {
                    case "A":
							orderStatus = "Order Open";
							break;
						case "C":
							orderStatus = "Acepted Order";
							break;
						case "D":
							orderStatus = "Order Assigned";
							break;
						case "E":
							orderStatus = "Contractor Just Arrived";
							break;
						case "F":
							orderStatus = "Estimate Sent";
							break;
						case "G":
							orderStatus = "Estimate Approved";
							break;
						case "H":
							orderStatus = "Work In Progress";
							break;
						case "I":
							orderStatus = "Work Completed";
							break;
						case "J":
							orderStatus = "Final Bill";
							break;
						case "K":
							orderStatus = "Order Completed Paid";
							break;
						case "Z":
							orderStatus = "Cancel work";
							break;
						case "P":
							orderStatus = "Report In Progress";
							break;
						case "R":
							orderStatus = "Report In Progress";
							break;
						case "S":
							orderStatus = "Report Complete";
                            break;
                        case "T":
                            orderStatus = "Orden In Progress";
                            break;
                        case "U":
                            orderStatus = "Orden Asigned";
                            break;
                        case "M":
                            orderStatus = "Mailed";
                            break;
						default:
							orderStatus = "Undefined";
                }
                return orderStatus;
            }

  var config = {
      apiKey: "AIzaSyCJIT-8FqBp-hO01ZINByBqyq7cb74f2Gg",
      authDomain: "roofadvisorzapp.firebaseapp.com",
      databaseURL: "https://roofadvisorzapp.firebaseio.com",
      projectId: "roofadvisorzapp",
      storageBucket: "roofadvisorzapp.appspot.com",
      messagingSenderId: "480788526390"
  };
  firebase.initializeApp(config);



 

</script>
