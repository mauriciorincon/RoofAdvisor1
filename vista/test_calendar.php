<?php   
    $_year=date("Y");
    $_month=date("m");
    echo "<h2>$_month $_year </h2>";
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
    
    print_r($_eventsArray);
    //echo $oCalendar->draw_calendar($_month,$_year,$_eventsArray);
?>
 
    <!-- Page Content -->
    <div class="container">
 
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>FullCalendar PHP MySQL</h1>
                <p class="lead">Completa con rutas de archivo predefinidas que no tendrás que cambiar!</p>
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
						<div class="col-sm-offset-2 col-sm-10">
						  <div class="checkbox">
							<label class="text-danger"><input type="checkbox"  name="delete"> Eliminar Evento</label>
						  </div>
						</div>
					</div>
				  
				  <input type="hidden" name="id" class="form-control" id="id">
				
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Guardar</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>
 
    </div>
    <!-- /.container -->


<script src="vista/js/jquery-3.3.1.js"></script>
<script src="js/bootstrap.min.js"></script>
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
             $('#ModalEdit').modal('show');
         });
     },
     eventDrop: function(event, delta, revertFunc) { // si changement de position

         edit(event);

     },
     eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

         edit(event);

     },
     events: [
        <?php foreach($_eventsArray as $event): 
     
            $start = explode("/", $event['SchDate']);
            $end = explode("/", $event['SchDate']);

            $start1=$start[2]."-".$start[0]."-".$start[1];
            $end1=$end[2]."-".$end[0]."-".$end[1];
            
            $_color="#0071c5";
            switch($event['RequestType']){
                
            }
            if($event['RequestType']=="S"){

            }
        ?>
            {
                id: '<?php echo $event['OrderNumber']; ?>',
                title: '<?php echo $event['CustomerID']; ?>',
                start: '<?php echo $start1; ?>',
                end: '<?php echo $end1; ?>',
                color: '<?php echo '#0071c5'; ?>',
            },
        <?php endforeach; ?>

        /*{
         id: '1',
         title: 'Hello<br>como estas',
         start: '2018-11-01',
         end: '2018-11-03',
         color: '#0071c5',
        },
        {
         id: '2',
         title: 'Hello<br>como estas',
         start: '2018-11-15',
         end: '2018-11-16',
         color: '#0071c5',
        },*/
     ]
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

</script>
