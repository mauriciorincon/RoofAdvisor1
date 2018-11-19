var emergencyRepairCount=0;
var openService=0;
var scheduleRepairCount=0;
var reportRepairCount=0;
var closeService=0;

$(document).ready(function() {
    /*$('#table_orders_customer').DataTable({
        rowCallback: function(row, data, index){
            if(data[4]=='Estimate Sent'){
              $(row).find('td:eq(7)').css('color', 'red');
          }
        }
      }
    );*/
    $("#myMessagePostCardsPay").modal("show");
    
    $('[data-toggle1="tooltip"]').tooltip(); 

    //$('#table_orders_customer').DataTable();
    
    var table = $('#table_orders_customer').DataTable({
        "columnDefs": [
          { className: "text-right", "targets": [7,8] },
        ]
      });
    
    
    $('#table_orders_company').DataTable({
        "columnDefs": [
          { className: "text-right", "targets": [7,8] },
        ]
      }

    );
    step0=$('.stepwizard-step:eq(0)');
    if(step0!=undefined){
        step0.hide();
    }
    step1=$('.stepwizard-step:eq(1)');
    if(step1!=undefined){
        step1.hide();
    }
    step2=$('.stepwizard-step:eq(2)');
    if(step2!=undefined){
        step2.hide();
    }
    step3=$('.stepwizard-step:eq(3)');
    if(step3!=undefined){
        step3.hide();
    }
    step4=$('.stepwizard-step:eq(4)');
    if(step4!=undefined){
        step4.hide();
    }
    step5=$('.stepwizard-step:eq(5)');
    if(step5!=undefined){
        step5.hide();
    }
    step6=$('.stepwizard-step:eq(6)');
    if(step6!=undefined){
        step6.hide();
    }
    step7=$('.stepwizard-step:eq(7)');
    if(step7!=undefined){
        step7.hide();
    }
    step8=$('.stepwizard-step:eq(8)');
    if(step8!=undefined){
        step8.hide();
    }
    step10=$('.stepwizard-step:eq(2)');
    if(step10!=undefined){
        step10.hide();
    }
    $("body").keypress(function(e) {
        if (e.which == 13 && !$(e.target).is("textarea")) {
          return false;
        }
      });

      $('.timepicker').mdtimepicker();

      
      /*var options_fixed = { 
		now: "00:00", //hh:mm 24 hour format only, defaults to current time
		twentyFour: true, //Display 24 hour format, defaults to false
		upArrow: 'wickedpicker__controls__up', //The up arrow class selector to use, for custom CSS
		downArrow: 'wickedpicker__controls__down', //The down arrow class selector to use, for custom CSS
		close: 'wickedpicker__close', //The close class selector to use, for custom CSS
		hoverState: 'hover-state', //The hover state class to use, for custom CSS
		title: '', //The Wickedpicker's title,
		showSeconds: false, //Whether or not to show seconds,
		secondsInterval: 1, //Change interval for seconds, defaults to 1
		minutesInterval: 1, //Change interval for minutes, defaults to 1
		clearable: false, //Make the picker's input clearable (has clickable "x")
		beforeShow: null,
		show:
		function positionning() {
			$('#step6time').parent().append($('.timepicker1'));
			$('.timepicker1').css({'left':'20px','top':'71px'});
		}
	};*/

    //$('.timepicker1').wickedpicker(options_fixed);
    
    $('.timepicker1').wickedpicker();



      $('.timepicker').mdtimepicker().on('timechanged', function(e){
          console.log(e.value);
          console.log(e.time);
          time=e.time.substring(0,2);
          minutes=e.time.substring(3,2);
          if(parseInt(time)>17){
            alert('The time can not be longer than 5 in the afternoon');
            $('#newTimeSchedule').val('');
          }else if(parseInt(time)==17 && parseInt(minutes)==0){
            alert('The time can not be longer than 5 in the afternoon');
            $('#newTimeSchedule').val('');
          }else if(parseInt(time)<7){
            alert('The time can not be less than 7 o\'clock in the morning');
            $('#newTimeSchedule').val(''); 
          }
        });
        
        if(emergencyRepairCount !== (undefined || null)) {
            $('span[name=emergencyRepair]').text(emergencyRepairCount);
            $('span[name=scheduleRepair]').text(scheduleRepairCount);
            $('span[name=reportRepair]').text(reportRepairCount);
            $('span[name=repairDone]').text(closeService);
            $('span[name=repairOpen]').text(openService);
        }
    
} );



///////////////////////////////////////////////
//Register Company
//////////////////////////////////////////////

$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');
        allPrevBtn = $('.prevBtn');
    
    allWells.hide();
    
    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);
    
        //console.log("entro a clic");
        if (!$item.hasClass('disabled')) {
             //console.log("no tiene desabilitado");
            navListItems.removeClass('btn-success').addClass('btn-default');
            $item.addClass('btn-success');
            
            
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });
    
    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url'],input[type='email'],input[type='password']"),
            isValid = true;
        
        var cellCount=0;
        $(".form-group").removeClass("has-error");
        
        isValid=true;
        isValid=validInputPassword()
        isValid=validInputRePassword();
        if (curStepBtn=="step-2"){
            $("#table_drivers tbody tr").each(function (index) {
                cellCount=0;
                $(this).children("td").each(function (index2) {
                    //console.log($(this).find('input').val());
                    
                    if($(this).find('input').val()!="" && $(this).find('input').val()!=undefined){
                        cellCount+=1;
                    }
                    
                });
                if(cellCount==5 || cellCount==0){
                    //isValid = true;
                }else{
                    isValid = false;
                    for (var i = 0; i < curInputs.length; i++) {
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                    }
                }
            });
        }else{
            for (var i = 0; i < curInputs.length; i++) {
                if (!curInputs[i].validity.valid) {
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }
        }
        

        
    
        if (curStepBtn=="step-2" && isValid==true ){
            saveContractorData();
        }
    
        /*if (curStepBtn=="step-3" && isValid==true ){
            //isValid=false;
            isValid=validateCodeEmail('Company');
        }*/
    
        if(curStepBtn=="step-1"){
            if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
        }
    });
    
    allPrevBtn.click(function () {
        
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a"),
            curStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;
    
        
        //for (var x in curStepWizard){
        //	console.log(curStepWizard[x]);
        //}
        
        $(".form-group").removeClass("has-error");
        /*for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }*/
        
    
        if (isValid) {
        
            nextStepWizard.removeAttr('disabled').trigger('click');
            curStepWizard.attr('disabled', 'disabled');
        
        }
    });
    
    $('div.setup-panel div a.btn-success').trigger('click');
    });
// End Register Customer
//////////////////////////////////////////////////


$(document).ready(function() {
    $("#addRowDriver").click(function(){
        var rowCount = $('table#table_drivers tr:last').index() + 2;
        var $tr    = $('table#table_drivers tr:last');
        var $clone = $tr.clone();
        $clone.find(':text').val('');
        $clone.find('td:first').text(rowCount);
        $tr.after($clone);

        //$("#table_drivers").append('<tr><td>'+rowCount+'</td><td><input maxlength="30" type="text" required="required" class="form-control" placeholder="First Name" id="driverFirstName[]" name="driverFirstName[]" /></td><td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Last Name"  id="driverLastName[]" name="driverLastName[]" /></td><td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Repair Crew Phone" id="driverPhone[]" name="driverPhone[]" /></td><td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Driver License"  id="driverLicense[]" name="driverLicense[]" /></td><td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Email" id="driverEmail[]" name="driverEmail[]" /></td><td><select class="form-control"  id="driverStatus[]" name="driverStatus[]"><option value="Active">Active</option><option value="Inactive">Inactive</option><option value="Terminated">Terminated</option></select></td><td><select class="form-control" id="driverProfile[]" name="driverProfile[]"></select></td><td><a href="#" class="btn-danger form-control" role="button" data-title="johnny" id="deleteRowDriver" data-id="1">Delete</a></td></tr>');
        
    });
    $("#table_drivers").on('click','#deleteRowDriver',function(){
        $(this).parent().parent().remove();
    });
} );



function validateEmail(table) {
    var textoBusqueda = $("input#emailValidation").val();
    var result=true;
     if (textoBusqueda != "") {
         //Equivalente a lo anterior
            jsShowWindowLoad('');
            $.post( "controlador/ajax/validateEmail.php", { "emailValue" : textoBusqueda,"tableSearch": table}, null, "text" )
            .done(function( data, textStatus, jqXHR ) {
                if ( console && console.log ) {
                    $("#answerEmailValidate").html(data);
                    var n = data.indexOf("Error");
                    if(n==-1){
                        $("input#emailValidation").closest(".form-group").addClass("has-success").removeClass('has-error');
                        $("#firstNextValidation").show();
                        result=true;
                    }else{
                        $("input#emailValidation").closest(".form-group").addClass("has-error").removeClass('has-success');
                        $("#firstNextValidation").hide();
                        result=false;
                    }
                    
                    console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                    jsRemoveWindowLoad();
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( "La solicitud a fallado: " +  textStatus);
                    result=false;
                }
                jsRemoveWindowLoad();
            });
            
        return result;    
     }
}

function validateFormatMail(Email){
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(Email);
}

function saveContractorData(){
    var companyNameField = $("input#companyName").val();
    var firstNameField = $("input#firstNameCompany").val();
    var lastNameField = $("input#lastNameCompany").val();
    var phoneContactField = "+1"+$("input#phoneContactCompany").val();
    var emailField = $("input#emailValidation").val();
    var typeCompanyField = $("select#typeCompany").val();
    var password=$('input:password#inputPassword').val();
    var Repassword=$('input:password#inputPasswordConfirm').val();

    var driver=[];

    $("#validatingMessajeCode").html('');
    $("input#codeValidateField").closest(".form-group").removeClass("has-success").removeClass('has-error');

    $('input[name^="driverFirstName"]').each(function() {
        driver.push($(this).val());
    });

    $('input[name^="driverLastName"]').each(function() {
        driver.push($(this).val());
    });
    $('input[name^="driverPhone"]').each(function() {
        driver.push($(this).val());
    });
    $('input[name^="driverLicense"]').each(function() {
        driver.push($(this).val());
    });
    $('input[name^="driverEmail"]').each(function() {
        driver.push($(this).val());
    });
    $('select[name^="driverStatus"]').each(function() {
        driver.push($(this).val());
    });
    $('select[name^="driverProfile"]').each(function() {
        driver.push($(this).val());
    });

    
    jsShowWindowLoad('');
    $.post( "controlador/ajax/insertContract.php", { "companyName" : companyNameField,"firstNameCompany": firstNameField,"lastNameCompany":lastNameField,
                                                    "phoneContactCompany":phoneContactField,"emailValidation":emailField,"typeCompany":typeCompanyField,
                                                "password":password,"arrayDrivers":driver}, null, "text" )
            .done(function( data, textStatus, jqXHR ) {
                if ( console && console.log ) {
                    //$("#answerEmailValidate").html(data);
                    var n = data.indexOf("Error");
                    if(n==-1){
                        //other='<br><h3>Redirecting to RoofServiceNow login page after <span id="countdown">10</span> seconds</h3>';
                        
                        $('#myRegisterMessage div.modal-body').html(data);
                        $(document).ready(function(){$("#myRegisterMessage").modal("show"); });
                        //countdown();

                        
                    }else{
                        $('#myRegisterMessage div.modal-body').html(data);
                        $(document).ready(function(){$("#myRegisterMessage").modal("show"); });
                        result=false;
                    }
                    
                    console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                    jsRemoveWindowLoad();
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( "La solicitud a fallado: " +  textStatus);
                    result=false;
                }
                jsRemoveWindowLoad();
            });
}


function validateCodeEmail(table){
    var emailField = $("input#emailValidation").val();
    var codeField = $("input#codeValidateField").val();
    var result1=false;

    jsShowWindowLoad('');
    $.post( "controlador/ajax/validateCode.php", { "emailValidation" : emailField,"codeValidateField": codeField,"table":table}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            $("#validatingMessajeCode").html(data);
            var n = data.indexOf("Error");
            if(n==-1){
                $("input#codeValidateField").closest(".form-group").addClass("has-success").removeClass('has-error');
                
                if(table=='Company'){
                    curStepWizard = $('div.setup-panel div a[href="#step-4"]').parent().children("a")
                }else if(table=='Customers'){
                    curStepWizard = $('div.setup-panelCustomer div a[href="#step-3"]').parent().children("a")
                }
                
                curStepWizard.removeAttr('disabled').trigger('click');
                
            }else{
                $("input#codeValidateField").closest(".form-group").addClass("has-error").removeClass('has-success');
                
            }
            
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
            return result1;
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
        
    });
    
}


$('#table_drivers_dashboard_company tbody').on( 'click', 'tr', function () {
    var tableData = $(this).children("td").map(function() {
        return $(this).text();
    }).get();

    $('#ContractorIDed').val(tableData[0]);
    $('#ContNameFirsted').val(tableData[1]);
    $('#ContNameLasted').val(tableData[2]);
    $('#ContPhoneNumed').val(tableData[3]);
    $('#ContLicenseNumed').val(tableData[4]);
    //$('#ContStatused').val(tableData[5]);
    $('#ContStatused option[value='+tableData[6]+']').attr('selected','selected');

    
    //console.log(tableData[0]);
    //console.log(tableData);
} );


function updateContractor(){
    var contractorID = $("input#ContractorIDed").val();
    var contratorFirstName = $("input#ContNameFirsted").val();
    var contratorLastName = $("input#ContNameLasted").val();
    var contratorPhoneNumber = $("input#ContPhoneNumed").val();
    var contratorLinceseNumber = $("input#ContLicenseNumed").val();
    var contratorProfile = $('select#ContProfile').val();

    jsShowWindowLoad('');
    $.post( "controlador/ajax/updateContract.php", { "contractorID" : contractorID,"contratorFirstName": contratorFirstName,
                                                    "contratorLastName":contratorLastName,"contratorPhoneNumber":contratorPhoneNumber,
                                                "contratorLinceseNumber":contratorLinceseNumber,"contratorProfile":contratorProfile}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            if(n==-1){
                $('#myModal2').modal('hide');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
                
                $('#table_drivers_dashboard_company tr').each(function(){ //filas con clase 'small', especifica una clase, asi no tomas el nombre de las columnas
				if($(this).find('td').eq(0).text()==contractorID){
					$(this).find('td').eq(1).text(contratorFirstName);
                    $(this).find('td').eq(2).text(contratorLastName);
                    $(this).find('td').eq(3).text(contratorPhoneNumber);
                    $(this).find('td').eq(4).text(contratorLinceseNumber);
					$(this).find('td').eq(6).text(contratorProfile);
				}
 				
 			    })
            }else{
                
            }
            jsRemoveWindowLoad('');
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}


/*$(".inactivate-contractor-button").click(function(){
    var contractorID = $(this).parents('tr:first').find('td:eq(0)').text();

    if(confirm("Are you sure you want to inactive contractor "+contractorID)){
        jsShowWindowLoad('');
        $.post( "controlador/ajax/updateContractorState.php", { "contractorID" : contractorID,"contratorState": 'Inactive'}, null, "text" )
        .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            if(n==-1){
                //$(this).parents('tr:first').find('td:eq(5)').text('Inactive');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
                
                $('#table_drivers_dashboard_company tr').each(function(){ 
                    if($(this).find('td').eq(0).text()==contractorID){
                        $(this).find('td').eq(5).text('Inactive');
                        return false;
                    }
                 })
                 
            }else{
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
                result1=false;
                jsRemoveWindowLoad('');
                return result1;
            }
        });



        //$("inactivate-contractor-button").attr("href", "query.php?ACTION=delete&ID='1'");
    }
    else{
        return false;
    }
});*/


function insertDriver(){
    var companyID = $("input#companyID").val();
    var contractorFirstName = $("input#ContNameFirstIn").val();
    var contractorLastName = $("input#ContNameLastIn").val();
    var contractorPhoneNumber = $("input#ContPhoneNumIn").val();
    var contractorLinceseNumber = $("input#ContLicenseNumIn").val();
    var contractorState = $("select#ContStatusIn").val();
    var contractorEmail=$("input#emailValidation").val();
    var contractorProfile=$("select#ContProfileIn").val();

    var flag=true;
    var ListTextBox=$("#formInsertContractor").find("input");
    for (var i = 0; i < ListTextBox.length; i++) {
        if (!ListTextBox[i].validity.valid) {
            flag = false;
            $(ListTextBox[i]).closest(".form-group").addClass("has-error").removeClass("has-success");
        }
    }
    
    if(flag==true){
        flag=validateEmail('Contractors');
        
    }
    if (flag==false){
        $('#myMensaje div.modal-body').html('Please fill all fields to continue with driver creation');
        $("#myMensaje").modal("show");
        //alert('Please fill all fields to continue with driver creation');
        return;
    }

    jsShowWindowLoad('');
    $.post( "controlador/ajax/insertDriver.php", { "companyID" : companyID,"contractorFirstName" : contractorFirstName,"contractorLastName": contractorLastName,
    "contractorPhoneNumber":contractorPhoneNumber,"contractorLinceseNumber":contractorLinceseNumber,
    "contractorState":contractorState,"contractorEmail":contractorEmail,"contractorProfile":contractorProfile}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            if(n==-1){
                var pos=data.indexOf("|");
                var consecutivo=0;
                if(pos!=-1){
                    consecutivo=data.substr(0,pos);
                    data=data.substr(consecutivo);
                }
                $('#myModalInsertContractor').modal('hide');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
                
                $("#table_drivers_dashboard_company").append('<tr><td>'+consecutivo+'</td><td>'+contractorFirstName+
                                                            '</td><td>'+contractorLastName+'</td><td>'+contractorPhoneNumber+
                                                            '</td><td>'+contractorLinceseNumber+'</td><td>'+contractorEmail+
                                                            '</td><td>'+contractorProfile+'</td><td>'+contractorState+
                                                            '</td><td><a class="btn-info btn-sm" data-toggle="modal" href="#myModal2" onClick="">'+
                                                            '<span class="glyphicon glyphicon-pencil"></span></a></td><td><a href="#" '+
                                                            'class="inactivate-contractor-button btn-success btn-sm" id="inactivate-contractor-button" '+
                                                            'name="inactivate-contractor-button" title="Active Employee" onclick="disableEnableDriver(\''+
                                                            consecutivo+'\','+'\'Active\''+')"><span class="glyphicon glyphicon-ok"></span></a></td></tr>');
                //$('#selectDriverFilterDashboard').append('<option value="'+consecutivo+'">'+contractorFirstName+contractorLastName+'</option>');
                $("#selectDriverFilterDashboard option:last").after($('<option value="'+consecutivo+'">'+contractorFirstName+' '+contractorLastName+'</option>'));
                //$('#selectDriverFilterDashboard').append($('<option>', {value:consecutivo, text:contractorFirstName+contractorLastName}));
                
            }else{
                
            }
            
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });

}

function emptyTextNewDriver(){
    //$("input#companyID").val('');
    $("input#ContNameFirstIn").val('');
    $("input#ContNameLastIn").val('');
    $("input#ContPhoneNumIn").val('');
    $("input#ContLicenseNumIn").val('');
    
}

function updateDataCompany(){
    var companyID =$("input#companyID").val();
    var compamnyName=$("input#compamnyName").val();
    var firstCompanyName=$("input#firstCompanyName").val();
    var lastCompanyName=$("input#lastCompanyName").val();
    //var companyEmail=$("input#companyEmail").val();
    var companyAddress1=$("input#companyAddress1").val();
    var companyAddress2=$("input#companyAddress2").val();
    var companyAddress3=$("input#companyAddress3").val();
    var companyPhoneNumber=$("input#companyPhoneNumber").val();
    var companyType=$("input#companyType").val();

    var PayInfoBillingAddress1=$("input#compamnyPayAddress1").val();
    var PayInfoBillingAddress2=$("input#compamnyPayAddress2").val();
    var PayInfoBillingCity=$("input#compamnyPayCity").val();
    var PayInfoBillingST=$("input#compamnyPayState").val();
    var PayInfoBillingZip=$("input#compamnyPayZip").val();
    var PayInfoCCExpMon=$("input#compamnyPayMonth").val();
    var PayInfoCCExpYr=$("input#compamnyPayYear").val();
    var PayInfoCCNum=$("input#compamnyPayCCNum").val();
    var PayInfoCCSecCode=$("input#compamnyPaySecCode").val();
    var PayInfoName=$("input#compamnyPayName").val();
    var PrimaryFName=$("input#compamnyPayFName").val();
    var PrimaryLName=$("input#compamnyPayLName").val();

    var InsLiabilityAgencyName=$("input#compamnyAgencyName").val();
    var InsLiabilityAgtName=$("input#compamnyAgtName").val();
    var InsLiabilityAgtNum=$("input#compamnyAgtNum").val();
    var InsLiabilityPolNum=$("input#compamnyPolNum").val();
    var Status_Rating=$("input#compamnyStatusRating").val();


    if( typeof companyAddress2 === 'undefined' || companyAddress2 === null ){
        companyAddress2="";
    }
    if( typeof companyAddress3 === 'undefined' || companyAddress3 === null ){
        companyAddress3="";
    }
    jsShowWindowLoad('');
    $.post( "controlador/ajax/updateCompany.php", { "companyID" : companyID,"compamnyName" : compamnyName,"firstCompanyName": firstCompanyName,
    "lastCompanyName":lastCompanyName,"companyAddress1":companyAddress1,"companyAddress2":companyAddress2,
    "companyAddress3":companyAddress3,"companyPhoneNumber":companyPhoneNumber,"companyType":companyType,
    "PayInfoBillingAddress1":PayInfoBillingAddress1,"PayInfoBillingAddress2":PayInfoBillingAddress2,"PayInfoBillingCity":PayInfoBillingCity,
    "PayInfoBillingST":PayInfoBillingST,"PayInfoBillingZip":PayInfoBillingZip,"PayInfoCCExpMon":PayInfoCCExpMon,
    "PayInfoCCExpYr":PayInfoCCExpYr,"PayInfoCCNum":PayInfoCCNum,"PayInfoCCSecCode":PayInfoCCSecCode,"PayInfoName":PayInfoName,
    "PrimaryFName":PrimaryFName,"PrimaryLName":PrimaryLName,"InsLiabilityAgencyName":InsLiabilityAgencyName,
    "InsLiabilityAgtName":InsLiabilityAgtName,"InsLiabilityAgtNum":InsLiabilityAgtNum,"InsLiabilityPolNum":InsLiabilityPolNum,
    "Status_Rating":Status_Rating}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            if(n==-1){
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }else{
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function updateDataCustomer(customerID){
    var firstCustomerName = $("input#firstCustomerNameProfile").val();
    var lastCustomerName = $("input#lastCustomerNameProfile").val();
    var emailValidation = $("input#emailValidationProfile").val();
    var customerAddress = $("input#customerAddressProfile").val();
    var customerCity = $("input#customerCityProfile").val();
    var customerState = $("select#customerStateProfile").val();
    var customerZipCode = $("input#customerZipCodeProfile").val();
    var customerPhoneNumber = $("input#customerPhoneNumberProfile").val();
    
    jsShowWindowLoad('');
    $.post( "controlador/ajax/updateCustomer.php", { "customerID" : customerID,"firstCustomerName" : firstCustomerName,"lastCustomerName": lastCustomerName,
                                                    "emailValidation":emailValidation,"customerAddress":customerAddress,"customerCity":customerCity,
                                                    "customerState":customerState,"customerZipCode":customerZipCode,"customerPhoneNumber":customerPhoneNumber}
                                                    , null, "text" )
        .done(function( data, textStatus, jqXHR ) {
            if ( console && console.log ) {
                
                var n = data.indexOf("Error");
                if(n==-1){
                    $('#myMensaje div.modal-body').html(data);
                    $(document).ready(function(){$("#myMensaje").modal("show"); });
                }else{
                    $('#myMensaje div.modal-body').html(data);
                    $(document).ready(function(){$("#myMensaje").modal("show"); });
                }
                
                console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                jsRemoveWindowLoad('');
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
                result1=false;
                jsRemoveWindowLoad('');
                return result1;
            }
        });
}

///////////////////////////////////////////////////////////////////////////////
//funtions for customer suscribe

$(document).ready(function () {

    var navListItems = $('div.setup-panelCustomer div a'),
        allWells = $('.setup-contentCustomer'),
        allNextBtn = $('.nextBtnCustomer');
        allPrevBtn = $('.prevBtnCustomer');
    
    allWells.hide();
    
    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);
    
        //console.log("entro a clic");
        if (!$item.hasClass('disabled')) {
             //console.log("no tiene desabilitado");
            navListItems.removeClass('btn-success').addClass('btn-default');
            $item.addClass('btn-success');
            
            
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });
    
    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-contentCustomer"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panelCustomer div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;
    
        $(".form-group").removeClass("has-error");
        
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        var password=$('input:password#inputPassword').val();
        var Repassword=$('input:password#inputPasswordConfirm').val();
        if(password!=Repassword){
            $('input:password#inputPassword').addClass("has-error").removeClass("has-success");;
            $('input:password#inputPasswordConfirm').addClass("has-error").removeClass("has-success");;
            $('#answerRePasswordValidateStep6').html('The confirmation password are different');
            isValid = false;
        }

        if (curStepBtn=="step-1" && isValid==true ){
            saveCustomerData("register");
        }
    
        if (curStepBtn=="step-2" && isValid==true ){
            isValid=validateCodeEmail('Customers');
        }
    
        if(curStepBtn!="step-2"){
            if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
        }
    });
    
    allPrevBtn.click(function () {
        
        var curStep = $(this).closest(".setup-contentCustomer"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panelCustomer div a[href="#' + curStepBtn + '"]').parent().prev().children("a"),
            curStepWizard = $('div.setup-panelCustomer div a[href="#' + curStepBtn + '"]').parent().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;
    
        $(".form-group").removeClass("has-error");
        
        if (isValid) {
        
            nextStepWizard.removeAttr('disabled').trigger('click');
            curStepWizard.attr('disabled', 'disabled');
        
        }
    });
    
    $('div.setup-panelCustomer div a.btn-success').trigger('click');
    });
 
/////////////////////////////////////////////////////////////////////////////

    function saveCustomerData(p_pantalla){
        
        var firstCustomerName = $("input#firstCustomerName").val();
        var lastCustomerName = $("input#lastCustomerName").val();
        var emailValidation = $("input#emailValidation").val();
        var customerAddress = $("input#customerAddress").val();
        var customerCity = $("input#customerCity").val();
        var customerState = $("select#customerState").val();
        var customerZipCode = $("input#customerZipCode").val();
        var customerPhoneNumber = $("input#customerPhoneNumber").val();
        var password=$('input:password#inputPassword').val();
        var Repassword=$('input:password#inputPasswordConfirm').val();

        customerAddress = "";
        customerState = "";
        customerZipCode = "";
        customerAddress = "";
        customerCity = "";
        if(p_pantalla=="Order"){
            var flagMensaje="";
            var ListTextBox=$("#step6RegisterCustomerOrder").find("input");
            for (var i = 0; i < ListTextBox.length; i++) {
                if (!ListTextBox[i].validity.valid) {
                    flag = false;
                    $(ListTextBox[i]).closest(".form-group").addClass("has-error").removeClass("has-success");
                }
            }
            if(firstCustomerName.length==0){
                flagMensaje+="Please fill the customer firt name.\n";
            }
            if(lastCustomerName.length==0){
                flagMensaje+="Please fill the customer last name.\n";
            }
            if(emailValidation.length==0){
                flagMensaje+="Please fill the customer email.\n";
            }
            if(password.length<6){
                flagMensaje+="Please verify the password field, remember it must have at least 6 characters.\n";
            }
            if(Repassword.length<6){
                flagMensaje+="Please verify the verification password field, remembet it must have at least 6 characters.\n";
            }
            if(password!=Repassword){
                flagMensaje+="Please verify the password and verification are not the same.\n";
            }
            if(validateFormatMail(emailValidation)==false){
                flagMensaje+="Please verify the email field.\n";
            }
            /*if(customerAddress.length==0){
                flagMensaje+="Please fill the customer address.\n";
            }
            if(customerCity.length==0){
                flagMensaje+="Please fill the customer city.\n";
            }
            if(customerState.length==0){
                flagMensaje+="Please fill the customer state.\n";
            }
            if(customerZipCode.length==0){
                flagMensaje+="Please fill the customer zip code.\n";
            }*/
            if(customerPhoneNumber.length==0){
                flagMensaje+="Please fill the customer phone number.\n";
            }
            
            if (flagMensaje!=''){
                alert(flagMensaje);
                return false;
            }

        }
        jsShowWindowLoad('');
        $.post( "controlador/ajax/insertCustomer.php", { "firstCustomerName" : firstCustomerName,"lastCustomerName": lastCustomerName,"emailValidation":emailValidation,
                                                        "customerAddress":customerAddress,"customerCity":customerCity,"customerState":customerState,
                                                    "customerZipCode":customerZipCode,"customerPhoneNumber":customerPhoneNumber,"inputPassword":password,
                                                    "source_call":p_pantalla }, null, "text" )
                .done(function( data, textStatus, jqXHR ) {
                    if ( console && console.log ) {
                        $("#validatingMessajeCode").html(data);
                        var n = data.indexOf("Error");
                        if(n==-1){
                            if(p_pantalla=="Order"){
                                $('#register-modal').modal('hide');
                                
                                $('#headerTextAnswerOrder').html('Mail Verification');
                                $('#textAnswerOrder').html(data+', and clic the link to activate your acount, after that please click next step');
                                dataString="'"+emailValidation+"','"+password+"','step8'";
                                $('#buttonAnswerOrder').html('<br><br><button type="button" id="lastFinishButtonOrder" class="btn btn-default" data-dismiss="modal" onclick="loginUser('+dataString+')">Next Step</button><br><br>');
                                $('#myModalRespuesta').modal({backdrop: 'static',keyboard: false});
                            }
                            //$("#firstNextValidation").show();
                            if(p_pantalla=="register"){
                                $('#prevBtnRegisterCustomer').hide();
                                texto=$("#validatingMessajeCode").html();
                                $("#validatingMessajeCode").html(texto+"<br> You will redirect to login customer page in 10 seconds");
                                window.location.href = "?controller=user&accion=dashboardCustomer";
                                // Your application has indicated there's an error
                                /*window.setTimeout(function(){
                                    // Move to a new location or you can do something else
                                    window.location.href = "?controller=user&accion=dashboardCustomer";
                                }, 10000);*/
                            }
                            result=true;
                        }else{
                            
                            $('#textAnswerOrder').html(data);
                            $('#headerTextAnswerOrder').html('Error register customer');
                            $("#answerValidateUserOrder").html('<div class="alert alert-danger"><strong>'+data+'</strong></div>');
                            $('#lastFinishButtonOrder').hide();
                            $('#myModalRespuesta').modal({backdrop: 'static'});
                            result=false;
                        }
                        
                        console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                        jsRemoveWindowLoad('');
                    }
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( "La solicitud a fallado: " +  textStatus);
                        result=false;
                        jsRemoveWindowLoad('');
                    }
                });
    }

    $(document).ready(function(){
        $('#firstNextBegin').hide();
        $('#zipCodeBegin').keyup(function(e) {
            
            if(this.value.length!=5){
                return;
            }
            var zipcode=$("input#zipCodeBegin").val();
            if (zipcode!==''){
                //$('#loading').html('<img src="http://preloaders.net/preloaders/287/Filling%20broken%20ring.gif"> loading...');
                jsShowWindowLoad('Verifing ZipCode');
                $.post( "controlador/ajax/getZipCode.php", { "zipcode" : zipcode}, null, "text" )
                .done(function( data, textStatus, jqXHR ) {
                    if ( console && console.log ) {
                        var n = data.indexOf("Error");
                        
                        if(n==-1){
                            $('#answerZipCode').html(data);
                            if (data.indexOf("Sorry")==-1){
                                $('#firstNextBegin').show();
                                setLocation(map,zipcode);
                            }else{
                                $('#firstNextBegin').hide(); 
                                setLocation(map,zipcode);
                            }
                        }else{
                            $('#answerZipCode').html(data);
                            $('#firstNextBegin').hide();
                        }
                        
                        console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                    }
                    //$('#loading').html('');
                    jsRemoveWindowLoad();
                    $('html,body').scrollTop(0);
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( "La solicitud a fallado: " +  textStatus);
                        result=false;
                    }
                    //$('#loading').html();
                    jsRemoveWindowLoad();
                });
            }                    
        });       
      });

   
////////////////////////////////////////////////////////////////////////////////
//Activate or Deactivate the hours of step 6
$(".btn-group > .btn").click(function(){
        $(".btn-group > .btn").removeClass("active");
        $(this).addClass("active");
});

////////////////////////////////////////////////////////////////////////////////
//Activate or Deactivate the hours of step 7
/*$("#step7ListCompany > .list-group-item").click(function(){
    $("#step7ListCompany> .list-group-item").removeClass("active");
    $(this).addClass("active");
});*/

//Select one of the company from order
$('#step7ListCompany').on('click', 'a', function(){
    $("#step7ListCompany a").removeClass("active");
    $(this).addClass("active");
});

//Select type order
$('#step2OtypeService').on('click', 'a', function(){
    $("#step2OtypeService a").removeClass("active");
    $(this).addClass("active");
    var type=$(this).find('input:hidden').val();
    showHideSteps(type);
    $("#step2OtypeService a").removeClass("active").find('button').removeClass("btn-success").addClass("btn-primary");
    $(this).find('button').removeClass("btn-primary").addClass("btn-success");
    getValueService();
    showHideElementByService();
    nextStepWizard = $('div.setup-panelOrder div a[href="#step-2"]').parent().next().children("a");
    curStepWizard = $('div.setup-panelOrder div a[href="#step-2"]').parent().children("a");
    nextStepWizard.removeAttr('disabled').trigger('click');
    curStepWizard.attr('disabled', 'disabled');
    
   return false;
});


function getValueService(){
    var RequestType=$("a[name=linkServiceType] button.btn-success").parent().parent().parent().parent().parent().find("input:hidden[name='typeServiceOrder']").val()
    var fieldValue="";
    if(RequestType=='emergency' || RequestType=='roofreport'){
        switch(RequestType){
            case "emergency":
                fieldValue="AmountER";
                break;
            case "roofreport":
                fieldValue="AmountReport";
                break;
        }
        jsShowWindowLoad('');
            $.post( "controlador/ajax/getParameter.php", { "table" : "Parameters","field":fieldValue}, null, "text" )
            .done(function( data, textStatus, jqXHR ) {
                if ( console && console.log ) {
                    var n = data.indexOf("Error");
                    if(n==-1){
                        amount_value=data;
                    }else{
                        amount_value=0;
                    }
                    console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                    jsRemoveWindowLoad('');
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( "La solicitud a fallado: " +  textStatus);
                    result1=false;
                    jsRemoveWindowLoad('');
                    return result1;
                }
            });
    }

}

function showHideElementByService(){
    var RequestType=$("a[name=linkServiceType] button.btn-success").parent().parent().parent().parent().parent().find("input:hidden[name='typeServiceOrder']").val();
    switch(RequestType){
        case "roofreport":
            $('#step8CompanyName').parents('div').eq(1).hide()
            break;
        default:
            $('#step8CompanyName').parents('div').eq(1).show()
            break;
    }
    

}

///////////////////////////////////////////////////////////////////////////////
//funtions for register an order
//
//
////////////////////////////////////////////////////////////////////////////////

$(document).ready(function () {

    var navListItems = $('div.setup-panelOrder div a'),
        allWells = $('.setup-contentOrder'),
        allNextBtn = $('.nextBtnOrder');
        allPrevBtn = $('.prevBtnOrder');
    
    allWells.hide();
    
    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);
    
        //console.log("entro a clic");
        if (!$item.hasClass('disabled')) {
             //console.log("no tiene desabilitado");
            navListItems.removeClass('btn-success').addClass('btn-default');
            $item.addClass('btn-success');
            
            
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();

            
        }
    });
    
    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-contentOrder"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panelOrder div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true,
            curStepWizard = $('div.setup-panelOrder div a[href="#' + curStepBtn + '"]').parent().children("a");
    
        $(".form-group").removeClass("has-error");
        var logedUser=$('#userLoguedIn').val();
        
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if(curStepBtn=="step-1"  && isValid==true ){
            $(".btnvid1").hide();
        }

        if(curStepBtn=="step-2"  && isValid==true ){
            //nextStepWizard = $('div.setup-panelOrder div a[href="#step-10"]').parent().next().children("a");
        }

        if(curStepBtn=="step-2"  && isValid==true ){
            //nextStepWizard = $('div.setup-panelOrder div a[href="#step-10"]').parent().next().children("a");
        }
        if(curStepBtn=="step-3"  && isValid==true ){
            var address=$('#step5Address').val();
            if (address==''){
                isValid=false;
                $('#headerTextAnswerOrder').html('Step 3');
                $('#textAnswerOrder').html('Plese select the address for the service');
                $('#myModalRespuesta').modal({backdrop: 'static'});
            }else{
                //var RequestType=$("a[name=linkServiceType].active > input:hidden[name='typeServiceOrder']").val();
                var RequestType=$("a[name=linkServiceType] button.btn-success").parent().parent().parent().parent().parent().find("input:hidden[name='typeServiceOrder']").val()
                if(RequestType=='emergency' || RequestType=='roofreport'){
                    nextStepWizard = $('div.setup-panelOrder div a[href="#step-5"]').parent().next().children("a");
                    var valStep3=$('input[name=estep3Option]:checked').attr('data-value');
                    var valStep5=$('input[name=estep5Option]:checked').attr('data-value');
                    var valStep5Auto=$('input[name=estep6Option]:checked').attr('data-value');
                    var valStep4=$('input[name=estep4Option]:checked').attr('data-value');

                    /*var valStep3=$('input[name=estep3Option]:checked').val();
                    var valStep5=$('input[name=estep5Option]:checked').val();
                    var valStep4=$('input[name=estep4Option]:checked').val();
                    var valStep5Auto=$('input[name=estep6Option]:checked').val();*/
                    var valStep6=$('input[name=step6date]').val();
                    var valStep6t=$('input[name=step6time]').val();
                    var valStep7=$('a[name=linkCompany].active > span[name=companyName]').text();
                    var valStep5long=$('input:hidden[name=step5Logintud]').val();
                    var valStep5lat=$('input:hidden[name=step5Latitude]').val();
                    var valStep5Address=$('input:hidden[name=step5Address]').val();
                    var valStep5ZipCode=$('input:hidden[name=step5ZipCode]').val();
                    $('#step8RepairDescription').html(valStep3+', '+valStep5+' story'+', '+valStep4+', Autorization:'+valStep5Auto);
                    $('#step8Schedule').html('Pending');
                    $('#step8Time').html('Pending');
                    $('#step8CompanyName').html('Pending');
                    $('#step8Longitude').html(valStep5long);
                    $('#step8Latitude').html(valStep5lat);
                    $('#step8Address').html(valStep5Address);
                    $('#step8ZipCode').html(valStep5ZipCode);

                }
            }
            

        }    
        if(curStepBtn=="step-4"  && isValid==true ){
            var fecha=$('input[name=step6date]').val();
            var hora=$('input[name=step6time]').val();
            if(fecha=="" || hora==""){
                $('#headerTextAnswerOrder').html('Step 4');
                $('#textAnswerOrder').html('Plese select the date and time for the service');
                $('#myModalRespuesta').modal({backdrop: 'static'});
                isValid=false;
            }else{
                getListContractor(); 
            }
            
        }

        if (curStepBtn=="step-5" && isValid==true ){
            //var valStep3=$('input[name=estep3Option]:checked').val();
            //var valStep5=$('input[name=estep5Option]:checked').val();
            //var valStep5Auto=$('input[name=estep6Option]:checked').val();
            //var valStep4=$('input[name=estep4Option]:checked').val();

            var valStep3=$('input[name=estep3Option]:checked').attr('data-value');
            var valStep5=$('input[name=estep5Option]:checked').attr('data-value');
            var valStep5Auto=$('input[name=estep6Option]:checked').attr('data-value');
            var valStep4=$('input[name=estep4Option]:checked').attr('data-value');

            var valStep6=$('input[name=step6date]').val();
            var valStep6t=$('input[name=step6time]').val();
            var valStep7=$('a[name=linkCompany].active > span[name=companyName]').text();
            var valStep5long=$('input:hidden[name=step5Logintud]').val();
            var valStep5lat=$('input:hidden[name=step5Latitude]').val();
            var valStep5Address=$('input:hidden[name=step5Address]').val();
            var valStep5ZipCode=$('input:hidden[name=step5ZipCode]').val();
            
            if(valStep7==""){
                valStep7="Pending";
            }
            $('#step8RepairDescription').html(valStep3+', '+valStep5+', Leaks:'+valStep4+', Autorization:'+valStep5Auto);
            $('#step8Schedule').html(valStep6);
            $('#step8Time').html(valStep6t);
            $('#step8CompanyName').html(valStep7);
            $('#step8Longitude').html(valStep5long);
            $('#step8Latitude').html(valStep5lat);
            $('#step8Address').html(valStep5Address);
            $('#step8ZipCode').html(valStep5ZipCode);

            
            /*if(valStep7==""){
                isValid=false;
                $('#headerTextAnswerOrder').html('Step 4');
                $('#textAnswerOrder').html('Plese select the contractor for your service');
                $('#myModalRespuesta').modal({backdrop: 'static'});
            }else{
                $('#step8RepairDescription').html(valStep3+', '+valStep5+' story'+', '+valStep4);
                $('#step8Schedule').html(valStep6);
                $('#step8Time').html(valStep6t);
                $('#step8CompanyName').html(valStep7);
                $('#step8Longitude').html(valStep5long);
                $('#step8Latitude').html(valStep5lat);
                $('#step8Address').html(valStep5Address);
                $('#step8ZipCode').html(valStep5ZipCode);
            }*/
        }

        if (curStepBtn=="step-6" && isValid==true ){
            validateIsLoggedIn();
            
        }
        
        if(curStepBtn=="step-7" && logedUser==true){
            isValid=true;
        }
        
        if (isValid) {
            nextStepWizard.removeAttr('disabled').trigger('click');
            curStepWizard.attr('disabled', 'disabled');
        }
        
    });
    
    allPrevBtn.click(function () {
        
        var curStep = $(this).closest(".setup-contentOrder"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panelOrder div a[href="#' + curStepBtn + '"]').parent().prev().children("a"),
            curStepWizard = $('div.setup-panelOrder div a[href="#' + curStepBtn + '"]').parent().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;
    
            //if(curStepBtn=="step-10"  && isValid==true ){
            //    nextStepWizard = $('div.setup-panelOrder div a[href="#step-2"]').parent().next().children("a");
            //}

        $(".form-group").removeClass("has-error");

        if(curStepBtn=="step-2"){
            $(".btnvid1").show();
        }

        if (curStepBtn=="step-6"){
            var RequestType=$("a[name=linkServiceType] button.btn-success").parent().parent().parent().parent().parent().find("input:hidden[name='typeServiceOrder']").val()
            if(RequestType=='emergency' || RequestType=='roofreport'){
                nextStepWizard = $('div.setup-panelOrder div a[href="#step-4"]').parent().prev().children("a");
            }
        }
        if (curStepBtn=="step-8"){
            nextStepWizard = $('div.setup-panelOrder div a[href="#step-7"]').parent().prev().children("a")
        }

        if (isValid) {
        
            nextStepWizard.removeAttr('disabled').trigger('click');
            curStepWizard.attr('disabled', 'disabled');
        
        }
    });
    
    $('div.setup-panelOrder div a.btn-success').trigger('click');
    });
 
/////////////////////////////////////////////////////////////////////////////

function getListContractor(){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getListContractor.php", { }, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            $('#step7ListCompany').html(data);
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
        }
        jsRemoveWindowLoad();
        $('html,body').scrollTop(0);
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result=false;
        }
        jsRemoveWindowLoad();    
    });
    
}



$(document).ready(function() {
    $('#lastFinishButtonOrder').hide();
    $("#buttonLoginCustomer").click(function(){

        $('#lastFinishButtonOrder').hide();

        var userClientOrder=$('#userClientOrder').val();
        var passwordClientOrder=$('#passwordClientOrder').val();

        jsShowWindowLoad('');
        $.post( "controlador/ajax/validateUser.php", { "userClientOrder" : userClientOrder,"passwordClientOrder":passwordClientOrder}, null, "text" )
        .done(function( data, textStatus, jqXHR ) {
            if ( console && console.log ) {
                
                var n = data.indexOf("Error");
                

                if(n==-1 && n !== null){

                    /*$('#textAnswerOrder').html(data+'');
                    $('#buttonAnswerOrder').html('<br><br><button type="button" class="btn btn-default" data-dismiss="modal" onclick="insertOrderCustomer()">Finish</button><br><br>');

                    $('#headerTextAnswerOrder').html('Success');
                  
                    $("#answerValidateUserOrder").html('<div class="alert alert-success"><strong>'+data+'</strong></div>');
                    $('#lastFinishButtonOrder').show();
                    $('#myModalRespuesta').modal({backdrop: 'static'});
                    var p1 = data.indexOf("[");
                    var p2 = data.indexOf("]");
                    var userName=data.substring(p1+1,p2)
                    $('span#labelUserLoggedIn').html(userName);*/
                    validateIsLoggedIn();
                }else{
                    $('#textAnswerOrder').html(data);
                    $('#headerTextAnswerOrder').html('Error');
                    $("#answerValidateUserOrder").html('<div class="alert alert-danger"><strong>'+data+'</strong></div>');
                    $('#lastFinishButtonOrder').hide();
                    $('#myModalRespuesta').modal({backdrop: 'static'});
                }
                console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                jsRemoveWindowLoad('');
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
                result=false;
            }
            jsRemoveWindowLoad('');
        });

        
    });
    
} );

function login_customer_order_request(){
    $('#lastFinishButtonOrder').hide();
    var userClientOrder=$('#userClientOrder').val();
    var passwordClientOrder=$('#passwordClientOrder').val();
    if(userClientOrder=="" || userClientOrder==undefined){
        alert("Please fill user field");
        return false;
    }
    if(passwordClientOrder=="" || passwordClientOrder==undefined){
        alert("Please fill password field");
        return false;
    }
    jsShowWindowLoad('');
    $.post( "controlador/ajax/validateUser.php", { "userClientOrder" : userClientOrder,"passwordClientOrder":passwordClientOrder}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            if(n==-1 && n !== null){
                email_user_logued=userClientOrder;
                var i = data.indexOf("[");
                var i1 = data.indexOf("]");
                var user = data.substring(i+1, i1);
                $('span#labelUserLoggedIn').html(user);
                $("#logindrop").append('<li><a href="?controller=user&accion=logout">Log Out</a></li>');
                jsRemoveWindowLoad('');
                validateIsLoggedIn();
            }else{
                $('#textAnswerOrder').html(data);
                $('#headerTextAnswerOrder').html('Error');
                $("#answerValidateUserOrder").html('<div class="alert alert-danger"><strong>'+data+'</strong></div>');
                $('#lastFinishButtonOrder').hide();
                $('#myModalRespuesta').modal({backdrop: 'static'});
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result=false;
        }
        jsRemoveWindowLoad('');
    });

    
}

function insertOrderCustomer(idStripeCharge,amountValue){
    if(idStripeCharge== undefined){
        idStripeCharge="";
    }
    if(amountValue== undefined){
        amountValue="";
    }
    var RepZIP=$('#zipCodeBegin').val();
    var RequestType=$("a[name=linkServiceType] button.btn-success").parent().parent().parent().parent().parent().find("input:hidden[name='typeServiceOrder']").val()
    //var RequestType=$("a[name=linkServiceType].active > input:hidden[name='typeServiceOrder']").val();
    var Rtype=$('input[name=estep3Option]:checked').attr('data-value');
    var Hlevels=$('input[name=estep5Option]:checked').attr('data-value');
    var Authorized=$('input[name=estep6Option]:checked').attr('data-value');
    var Water=$('input[name=estep4Option]:checked').attr('data-value');

    //var Rtype=$("input:radio[name='estep3Option']:checked").val();
    //var Water=$("input:radio[name='estep4Option']:checked").val();
    //var Hlevels=$("input:radio[name='estep5Option']:checked").val();
    //var Authorized=$("input:radio[name='estep6Option']:checked").val();
    var SchDate=$("input[name='step6date']").val();
    var SchTime=$('input[name=step6time]').val();
    var CompanyID=$('a[name=linkCompany].active > input:hidden[name=idContractor]').val();
    var email=$('input#emailValidation').val();
    var password=$('input#inputPassword').val();
    var latitude=$('input:hidden[name=step5Latitude]').val();
    var longitude=$('input:hidden[name=step5Logintud]').val();
    var address=$('input:hidden[name=step5Address]').val();
    

    if(RequestType=='emergency'){
        RequestType='E'
    }else if(RequestType=='schedule'){
        RequestType='S'
    }else if(RequestType=='roofreport'){
        RequestType='R'
    }
    //                var valStep5ZipCode=$('input:hidden[name=step5ZipCode]').val();
    if(CompanyID==undefined){
        CompanyID="";
    }
    SchTime=changerHourFormat(SchTime);
    if(amountValue==undefined){
        amountValue=0;
    }
    jsShowWindowLoad('One second as we send you an invoice for the payment and create your order.');
    $.post( "controlador/ajax/insertOrder.php", {"RepZIP":RepZIP,"RequestType":RequestType,"Rtype":Rtype,"Water":Water,"Hlevels":Hlevels,
                                                "SchDate":SchDate,"SchTime":SchTime,"CompanyID":CompanyID,"email":email,
                                                "password":password,"Latitude":latitude,"Longitude":longitude,"Address":address,"stripeCharge":idStripeCharge,
                                                "Authorized":Authorized,"amount_value":amountValue}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            

            if(n==-1){
                jsShowWindowLoad('One second as we send you an invoice for the payment and create your order.');
                    window.location.href = "index.php?controller=user&accion=dashboardCustomer";
                    /*$('#textAnswerOrder').html(data+'');
                    $('#buttonAnswerOrder').html('<br><br><button type="button" class="btn btn-default" data-dismiss="modal" onclick="loginUser('+email+','+password+',datos)">Continue to Customer Area</button><br><br>');

                    $('#headerTextAnswerOrder').html('Success');
                  
                    $("#answerValidateUserOrder").html('<div class="alert alert-success"><strong>'+data+'</strong></div>');
                    $('#lastFinishButtonOrder').show();
                    $('#myModalRespuesta').modal({backdrop: 'static'});*/
            }else{
                    $('#headerTextAnswerOrder').html('Error validating User Account');
                    $('#textAnswerOrder').html(data+'<br><br>Please try again');
                    $("#answerValidateUserOrder").html('<div class="alert alert-danger"><strong>'+data+'</strong></div>');
                    $('#lastFinishButtonOrder').hide();
                    $('#buttonAnswerOrder').html('<br><br><button type="button" class="btn btn-default" data-dismiss="modal" onclick="insertOrderCustomer()">Finish</button><br><br>');
                    $('#myModalRespuesta').modal({backdrop: 'static'});
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result=false;
            jsRemoveWindowLoad('');
        }
    });
}

function validateIsLoggedIn(){
    jsShowWindowLoad('Validating Login');
    $.post( "controlador/ajax/validateLoggedIn.php", {}, null, "text" )
        .done(function( data, textStatus, jqXHR ) {
            if ( console && console.log ) {
                
                var n = data.indexOf("Error");
                

                if(n==-1){

                    var RequestType=$("a[name=linkServiceType] button.btn-success").parent().parent().parent().parent().parent().find("input:hidden[name='typeServiceOrder']").val()
                    //var RequestType=$("a[name=linkServiceType].active > input:hidden[name='typeServiceOrder']").val();
                    if(RequestType=='emergency' || RequestType=='roofreport'){
                        $('#userLoguedIn').val(true);
                        nextStepWizard = $('div.setup-panelOrder div a[href="#step-7"]').parent().next().children("a");
                        curStepWizard = $('div.setup-panelOrder div a[href="#step-6"]').parent().next().children("a");

                        nextStepWizard.removeAttr('disabled').trigger('click');
                        curStepWizard.attr('disabled', 'disabled');
                        if(typeof handler !== undefined){
                                  // $('#login-modal').style.display = "none";
                                let timerInterval; 
                                      swal({ 
                                            title: 'You have successfully logged in!',
                                            type: 'success', 
                                            html: 'You will be automatically redirected in <strong></strong> seconds.', 
                                            timer: 1, 
                                            onOpen: () => { 
                                                swal.showLoading() 
                                               }, 
                                             onClose: () => { 
                                                clearInterval(timerInterval) 
                                                } 
                                               }).then((result) => { 
                                                if ( // Read more about handling dismissals 
                                               result.dismiss === swal.DismissReason.timer 
                                                ) { 
                                                console.log('login has been completed successfully') }
                                                  $("#login-modal").removeClass('fade').modal('hide');
                                                  });
                        }
                    }else{
                        jsRemoveWindowLoad('');
                        insertOrderCustomer();
                        
                        /*$('#textAnswerOrder').html(data+'');
                        $('#buttonAnswerOrder').html('<br><br><button type="button" class="btn btn-default" data-dismiss="modal" onclick="insertOrderCustomer()">Finish</button><br><br>');

                        $('#headerTextAnswerOrder').html('Success');
                  
                        $("#answerValidateUserOrder").html('<div class="alert alert-success"><strong>'+data+'</strong></div>');
                        $('#lastFinishButtonOrder').show();
                        $('#myModalRespuesta').modal({backdrop: 'static'});*/
                    }
                    
                }else{
                    //$('#textAnswerOrder').html('You are not logged in. Please log in or, if new to RoofServiceNow, register as a new user.');
                    //$('#headerTextAnswerOrder').html('User validation');
                    //$("#answerValidateUserOrder").html('<div class="alert alert-danger"><strong>'+'You are not logged in. Please log in or, if new to RoofServiceNow, register as a new user.'+'</strong></div>');
                    //$('#lastFinishButtonOrder').hide();
                    //$('#login-modal').modal({backdrop: 'static'});
                    
                }
                console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                jsRemoveWindowLoad('');
                $('html,body').scrollTop(0);
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
                result=false;
                jsRemoveWindowLoad('');
            }
        });
}

function validInputPassword(){
    var password=$('input:password#inputPassword').val();
    var flag=true;
    if(password.length<6){
        $('input:password#inputPassword').closest(".form-group").addClass("has-error").removeClass("has-success");
        $('#answerPasswordValidateStep6').html('The password must have at least 6 chararters');
        flag=false;
    }else{
        $('input:password#inputPassword').closest(".form-group").addClass("has-success").removeClass("has-error");
        $('#answerPasswordValidateStep6').html('');
        flag=true;
    }
    
}

function validInputRePassword(){
    var password=$('input:password#inputPassword').val();
    var Repassword=$('input:password#inputPasswordConfirm').val();
    var flag=true;
    if(Repassword.length<6){
        $('input:password#inputPasswordConfirm').closest(".form-group").addClass("has-error").removeClass("has-success");
        $('#answerRePasswordValidateStep6').html('The password must have at least 6 chararters');
        flag=false;
    }else{
        $('input:password#inputPasswordConfirm').closest(".form-group").addClass("has-success").removeClass("has-error");
        $('#answerRePasswordValidateStep6').html('');
        flag=true;
        if(Repassword!=password){
            $('input:password#inputPasswordConfirm').closest(".form-group").addClass("has-error").removeClass("has-success");
            $('#answerRePasswordValidateStep6').html('The confirmation password are different');
            flag=false;
        }else{
            $('input:password#inputPassword').closest(".form-group").addClass("has-success").removeClass("has-error");
            $('input:password#inputPasswordConfirm').closest(".form-group").addClass("has-success").removeClass("has-error");
            $('#answerRePasswordValidateStep6').html('');
            $('#answerPasswordValidateStep6').html('');
            flag=true;
        }
    }
    return flag;
    
}

function loginUser(user,password,url){
    //alert('paso aca');
    
    var flag=true;
    if(user==undefined || user==""){
        flag=false;
    }
    if(password==undefined || password==""){
        flag=false;
    }
    if (flag==false){
        $('#textAnswerOrder').html("Please give the User and Password");
        $('#headerTextAnswerOrder').html('Error login user');
        $("#answerValidateUserOrder").html('<div class="alert alert-danger"><strong>Please give the User and Password</strong></div>');
        $('#lastFinishButtonOrder').hide();
        $('#myModalRespuesta').modal({backdrop: 'static'});
        return false;
    }
    jsShowWindowLoad('');
    $.post( "controlador/ajax/validateUser.php", { "userClientOrder" : user,"passwordClientOrder":password}, null, "text" )
        .done(function( data, textStatus, jqXHR ) {
            
            if ( console && console.log ) {
                var n = data.indexOf("Error");
                
                if(n==-1){
                    
                    if(url=="step8"){
                        var ind = data.indexOf("'");
                        var ind1 = data.indexOf("'", data.indexOf("'") + 1);
                        email_user_logued= data.substring(ind+1, ind1);
                        var i = data.indexOf("[");
                        var i1 = data.indexOf("]");
                        var user = data.substring(i+1, i1);
                        $('span#labelUserLoggedIn').html(user);
                        $("#logindrop").append('<li><a href="?controller=user&accion=logout">Log Out</a></li>');
                        validateIsLoggedIn();
                    }else{
                        window.location.href = "";
                    }
                    
                    console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                    jsRemoveWindowLoad('');
                    return true;
                }else{
                    $('#textAnswerOrder').html(data);
                    $('#headerTextAnswerOrder').html('Error login user');
                    $("#answerValidateUserOrder").html('<div class="alert alert-danger"><strong>'+data+'</strong></div>');
                    $('#lastFinishButtonOrder').hide();
                    $('#myModalRespuesta').modal({backdrop: 'static',keyboard: false});
                    console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                    jsRemoveWindowLoad('');
                    return  false;
                }
                
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
                
                jsRemoveWindowLoad('');
                return false;
            }
        });
}

function showRatings(identifier,type){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getListRating.php", {"id_search":identifier,"type": type}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            $('#headerTextAnswerRating').html('Customer Rating');
            $('#textAnswerRating').html(data);
            $('#myModalRating').modal({backdrop: 'static'});
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
        }
        jsRemoveWindowLoad('');
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result=false;
        }
        jsRemoveWindowLoad('');
    });
    //alert(contractorID);
}


function jsRemoveWindowLoad() {
    // eliminamos el div que bloquea pantalla
    $("#WindowLoad").remove();
 
}
 
function jsShowWindowLoad(mensaje) {
    //eliminamos si existe un div ya bloqueando
    jsRemoveWindowLoad();
 
    //si no enviamos mensaje se pondra este por defecto
    if (mensaje === undefined) mensaje = "Processing information<br>please wait";
 
    //centrar imagen gif
    height = 20;//El div del titulo, para que se vea mas arriba (H)
    var ancho = 0;
    var alto = 0;
 
    //obtenemos el ancho y alto de la ventana de nuestro navegador, compatible con todos los navegadores
    if (window.innerWidth == undefined) ancho = window.screen.width;
    else ancho = window.innerWidth;
    if (window.innerHeight == undefined) alto = window.screen.height;
    else alto = window.innerHeight;
 
    //operación necesaria para centrar el div que muestra el mensaje
    var heightdivsito = alto/2 - parseInt(height)/2;//Se utiliza en el margen superior, para centrar
 
   //imagen que aparece mientras nuestro div es mostrado y da apariencia de cargando
    imgCentro = "<div style='text-align:center;height:" + alto + "px;'><div  style='color:#000;margin-top:" + heightdivsito + "px; font-size:20px;font-weight:bold'>" + mensaje + "</div><img  src='img/load1.gif'></div>";
 
        //creamos el div que bloquea grande------------------------------------------
        div = document.createElement("div");
        div.id = "WindowLoad"
        div.style.width = ancho + "px";
        div.style.height = alto + "px";
        $("body").append(div);
 
        //creamos un input text para que el foco se plasme en este y el usuario no pueda escribir en nada de atras
        input = document.createElement("input");
        input.id = "focusInput";
        input.type = "text"
 
        //asignamos el div que bloquea
        $("#WindowLoad").append(input);
 
        //asignamos el foco y ocultamos el input text
        $("#focusInput").focus();
        $("#focusInput").hide();
 
        //centramos el div del texto
        $("#WindowLoad").html(imgCentro);
 
}

$(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar1').toggleClass('active');
    });

});


function refreshCalendar(pmonth,pyear,customerID){
    if (pmonth==undefined || pmonth==""){
        var month=$('#monthCalendar').val();
    }else{
        var month=pmonth;
    }
    if(pyear==undefined || pyear==""){
        var year=$('#yearCalendar').val();
    }else{
        var year=pyear;
    }

    

    jsShowWindowLoad('');
    $.post( "controlador/ajax/getCalendar.php", {"month":month,"year":year,"customerID":customerID }, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            $('#scheduleCompany').html(data);
            console.log( "La solicitud se ha completado correctamente."+jqXHR+textStatus);
        }
        jsRemoveWindowLoad('');
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  jqXHR+errorThrown+textStatus);
            result=false;
        }
        jsRemoveWindowLoad('');
    });
}

//Date picker order
$( function() {
        $.datepicker.setDefaults($.datepicker.regional['en']);
        $( ".datepicker" ).datepicker({ dateFormat: 'mm/dd/yy', minDate: 7  } );
  } );

//Date picker order
$( function() {
    $.datepicker.setDefaults($.datepicker.regional['en']);
    $( ".datepickers" ).datepicker({ dateFormat: 'mm/dd/yy', minDate: 1 });
} );

  

  function filterDashboard(table){
    $("#"+table+" tr").each(function(index) {
        if (index !== 0) {

            var date=$("#datepickerFilterDashboard").val();
            var state=$("#optionStateFilterDashboard").val();
            var driver=$("#selectDriverFilterDashboard").val();
            $row = $(this);
            if(date!==''){
                var id = $row.find("td:eq(1)").text();

                if (id.indexOf(date) !== 0) {
                    $row.hide();
                }else {
                    $row.show();
                }
            }else if(state!=='' && state!=='0'){
                //$row = $(this);
            
                var id = $row.find("td:eq(6)").text();

                if (id.indexOf(state) !== 0) {
                    $row.hide();
                }else {
                    $row.show();
                }
            }else if(driver!=='' && driver!=='0'){
                //$row = $(this);
                var id = $row.find("td:eq(10)").text();

                if (id.indexOf(driver) !== 0) {
                    $row.hide();
                }else {
                    $row.show();
                }
            }else{
                $row.show();
            }

            
        }
    });
  }
  /*$("#datepickerFilterCompanyDashboard").on("keyup", function() {
    var value = $(this).val();

    
});*/

function hideShowDivs(divName){
    $('#'+divName).collapse('hide');
    $('#'+divName).collapse('hide');
    $('#calendar').fullCalendar('option', 'height', 1500);
}

function setActiveItemMenu(item){
    $(".vertical-menu a").each(function (index) {
        $(this).removeClass('active');
    });
    $(item).addClass('active');
}

function getListCompany(tableName){
    data=$('#'+tableName+' tbody').html();
    data=data.trim();
    if (data==""){
        jsShowWindowLoad('');
        $.post( "controlador/ajax/getListCompany.php", {}, null, "text" )
        .done(function( data, textStatus, jqXHR ) {
            if ( console && console.log ) {
                $('#'+tableName+' tbody').html(data);
                $('[data-toggle1="tooltip"]').tooltip(); 
                console.log( "La solicitud se ha completado correctamente."+jqXHR+textStatus);
            }
            jsRemoveWindowLoad('');
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  jqXHR+errorThrown+textStatus);
                result=false;
            }
            jsRemoveWindowLoad('');
        });
    }
    
}

function getDataCompany(companyID){

    
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getDataCompany.php", { "companyID" : companyID}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            if(n==-1){
                data=jQuery.parseJSON(data);
                $("input#companyID").val(data.CompanyID);
                $("input#compamnyName").val(data.CompanyName);
                $("input#firstCompanyName").val(data.PrimaryFName);
                $("input#lastCompanyName").val(data.PrimaryLName);
                $("input#companyEmail").val(data.CompanyEmail);
                $("input#companyAddress1").val(data.CompanyAdd1);
                $("input#companyAddress2").val(data.CompanyAdd2);
                $("input#companyAddress3").val(data.CompanyAdd3);
                $("input#companyPhoneNumber").val(data.CompanyPhone);
                $("input#companyType").val(data.CompanyType);

                $("input#compamnyPayAddress1").val(data.PayInfoBillingAddress1);
                $("input#compamnyPayAddress2").val(data.PayInfoBillingAddress2);
                $("input#compamnyPayCity").val(data.PayInfoBillingCity);
                $("input#compamnyPayState").val(data.PayInfoBillingST);
                $("input#compamnyPayZip").val(data.PayInfoBillingZip);
                $("input#compamnyPayMonth").val(data.PayInfoCCExpMon);
                $("input#compamnyPayYear").val(data.PayInfoCCExpYr);
                $("input#compamnyPayCCNum").val(data.PayInfoCCNum);
                $("input#compamnyPaySecCode").val(data.PayInfoCCSecCode);
                $("input#compamnyPayName").val(data.PayInfoName);
                $("input#compamnyPayFName").val(data.PrimaryFName);
                $("input#compamnyPayLName").val(data.PrimaryLName);

                $("input#compamnyAgencyName").val(data.InsLiabilityAgencyName);
                $("input#compamnyAgtName").val(data.InsLiabilityAgtName);
                $("input#compamnyAgtNum").val(data.InsLiabilityAgtNum);
                $("input#compamnyPolNum").val(data.InsLiabilityPolNum);
                $("input#compamnyStatusRating").val(data.Status_Rating);
                
                
            }else{
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function getListDrivers(companyID){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getListDriver.php", { "companyID" : companyID}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            if(n==-1){
                $('#table_drivers_dashboard_admin tbody').html(data);
            }else{
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
                result1=false;
                jsRemoveWindowLoad('');
                return result1;
            }
        });
}

function disableEnableDriver(id_driver,action){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/enable_disable_driver.php", { "contractorID" : id_driver,"action":action}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            if(n==-1){
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });

                $('#table_drivers_dashboard_company tr').each(function(){ 
                    if($(this).find('td').eq(0).text()==id_driver){
                        
                        $(this).find('td').eq(6).text(action);
                        //var tdv =$(this).find('td').eq(8);
                        if(action=="Active"){ 
                            $(this).find('td').eq(9).find('span').addClass('glyphicon-trash').removeClass('glyphicon-ok');
                            $(this).find('td').eq(9).find('a').addClass('btn-danger').removeClass('btn-success');
                            $(this).find('td').eq(9).find('a').attr("onclick","disableEnableDriver('"+id_driver+"','Inactive')");
                        }else{
                            $(this).find('td').eq(9).find('span').removeClass('glyphicon-trash').addClass('glyphicon-ok');
                            $(this).find('td').eq(9).find('a').removeClass('btn-danger').addClass('btn-success');
                            $(this).find('td').eq(9).find('a').attr("onclick","disableEnableDriver('"+id_driver+"','Active')");
                        }
                        
                        //$(tdv).find('span').addClass('glyphicon glyphicon-trash').removeClass('glyphicon glyphicon-ok');
                        //$(tdv).find('a').addClass('glyphicon btn-danger').removeClass('btn-success');
                        return false;
                    }
                 })

            }else{
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus+ ' '+errorThrown);
                jsRemoveWindowLoad('');
            }
        });

}

function showEventCalendar(orderId){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getDataOrder.php", { "orderId" : orderId}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                $('#headerTextAnswerOrder').html('Order Detail');
                order=jQuery.parseJSON(data);
                string='<div>'+
                    '<table class="table table-bordered">'+
                    '<tr><td>Order ID</td><td>'+order.OrderNumber+'</td></tr>'+
                    '<tr><td>Company</td><td>'+order.CompanyName+'</td></tr>'+
                    '<tr><td>Contractor</td><td>'+order.ContNameFirst+' '+order.ContNameLast+'</td></tr>'+
                    '<tr><td>Customer</td><td>'+order.Fname+' '+order.Lname+'</td></tr>'+
                    '<tr><td>Schedule Date</td><td>'+order.SchDate+'</td></tr>'+
                    '<tr><td>Schedule Time</td><td>'+order.SchTime+'</td></tr>'+
                    '<tr><td>Status</td><td>'+order.Status+'</td></tr>'+
                    '<tr><td>Description</td><td>'+order.Hlevels+', '+order.Rtype+', '+order.Water+'</td></tr>'+
                '</table>'+
            '</div>';

                $('#myMensaje div.modal-body').html(string);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }else{
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

function showHideSteps(typeService){
    if(typeService=='schedule'){
        step4=$('.stepwizard-step:eq(4)');
        step5=$('.stepwizard-step:eq(5)');
        step8=$('.stepwizard-step:eq(8)');

        //step4.show();
        //step5.show();
        step8.hide();
        $('#step-6 h1').html('<font size="41"><strong>Review Scheduled Repair Order Details</strong></font>');
    }else if(typeService=='emergency' || typeService=='roofreport'){
        step4=$('.stepwizard-step:eq(4)');
        step5=$('.stepwizard-step:eq(5)');
        step8=$('.stepwizard-step:eq(8)');
        step4.hide();
        step5.hide();
        //step8.show();
        if(typeService=='emergency'){
            $('#step-6 h1').html('<font size="41"><strong>Review Emergency Repair Order Details</strong></font>');
            $('#divEmergencyService').show();
            $('#divRoofService').hide();
        }else{
            $('#step-6 h1').html('<font size="41"><strong>Review Roof Report Order Details</strong></font>');
            $('#divEmergencyService').hide();
            $('#divRoofService').show();
        }
        
    }
}

function setFirstStep(){
    $firstStep=$('div.setup-panel div a[href="#step-1"]').parent().children("a");
    $nextStepWizard = $('div.setup-panelCustomer div a[href="#step-1"]').parent().prev().children("a"),
    $nextStepWizard.removeAttr('disabled').trigger('click');

    //$firstStep.trigger('click');
}

function updateOrder(orderID,arrayChanges){
        jsShowWindowLoad('One second as we send you an invoice for the payment and create your order.');
        $.post( "controlador/ajax/updateOrder.php", { "orderId" : orderID,"arrayChanges":arrayChanges}, null, "text" )
        .done(function( data, textStatus, jqXHR ) {
            if ( console && console.log ) {
                var n = data.indexOf("Error");
                if(n==-1){
                    $('#headerTextAnswerOrder').html('Order Detail');
                    $('#myMensaje div.modal-body').html(data);
                    $(document).ready(function(){$("#myMensaje").modal("show"); });
                }else{
                    $('#myMensaje div.modal-body').html(data);
                    $(document).ready(function(){$("#myMensaje").modal("show"); });
                }
                console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                jsRemoveWindowLoad('');
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
                result1=false;
                jsRemoveWindowLoad('');
                return result1;
            }
        });
    

}

function showChargePayment(chargeID){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getChargeData.php", { "chargeID" : chargeID}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                //$('#headerTextPayment').html('Payment Detail');
                //$('#myPayment div.modal-body').html(data);
                //$(document).ready(function(){$("#myPayment").modal("show"); });
                $('#detailStripe').html(data);
                
            }else{
                $('#headerTextPayment').html('Error Detail Payment');
                $('#myPayment div.modal-body').html(data);
                $(document).ready(function(){$("#myPayment").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function changeSchedule(){
    var orderID=$('input#orderIDChangeSchedule').val();
    var dateSchedule=$('input#newDateSchedule').val();
    var requestType=$('input#orderTypeService').val();
    var timeSchedule=$('input#newTimeSchedule').val();
    
    
    if(dateSchedule=="" || timeSchedule==""){
        alert("Please fill the date and time");
        return false;
    }else{
        if(confirm("are you sure you want to change the date of the service?")){
            $('#myScheduleChange').modal('hide');
            if(requestType=="E"){
                updateOrder(orderID,"ETA,"+dateSchedule+' '+timeSchedule);
            }else{
                updateOrder(orderID,"SchDate,"+dateSchedule+",SchTime,"+timeSchedule);
            }
            
            
        }else{
            return false;
        }
    }

    

}

function cancelService(orderID,state){

    if(confirm("are you sure you want to cancel the service?")){
        updateOrder(orderID,state);
    }else{
        return false;
    }

}

function getOrderScheduleDateTime(orderId){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getDataOrder.php", { "orderId" : orderId}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                order=jQuery.parseJSON(data);
                $('input#orderIDChangeSchedule').val(order.FBID);
                $('input#orderTypeService').val(order.RequestType);
                $('input#newDateSchedule').val(order.SchDate);
                $("select#newTimeSchedule > option").each(function() {
                  
                    if(this.value==order.SchTime){
                        $(this).attr('selected','selected');
                    }
                });

                //$('select#newTimeSchedule option[value='+order.SchTime+']').attr('selected','selected');
                //$('#newTimeSchedule option[value='+order.SchTime+']').attr('selected','selected');
                
            }else{
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
    
}

function setOrderId(orderID,RequestType){
    $('#orderIDWork').val(orderID);
    $('#orderIDWorkText').html(orderID);
    $('#orderTypeTakeWork').val(RequestType);

    if(RequestType=='P'){
        $('#amountPostCard').show();
        $('#amountPostCardLabel').show();
        $('#numberPostCardLabel').show();
        $('#numberPostCard').show();

        jsShowWindowLoad('Searching Info');
        $.post( "controlador/ajax/getDataOrder.php", { "orderId" : orderID,"fieldSearch":"FBID"}, null, "text" )
        .done(function( data, textStatus, jqXHR ) {
            if ( console && console.log ) {
                var n = data.indexOf("Error");
                if(n==-1){
                    order=jQuery.parseJSON(data);
                    $('input#numberPostCard').val(order.postCardValue);
                }else{
                    $('input#numberPostCard').val(0);
                }
                jsRemoveWindowLoad('');
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
                jsRemoveWindowLoad('');
            }
        });

    }else{
        $('#amountPostCard').hide();
        $('#amountPostCardLabel').hide();
        $('#numberPostCardLabel').hide();
        $('#numberPostCard').hide();
    }

}
function takeWork(){
    var orderID=$('input:hidden#orderIDWork').val();
    var companyID=$('input:hidden#companyIDWork').val();
    var dateWork=$('input#dateWork').val();
    var timeWork=$('select#timeWork').val();
    var driverID=$('select#driverWork').val();
    var amountPostCard=$('input#amountPostCard').val();
    var orderType=$('#orderTypeTakeWork').val();

    var message="";

    if(orderID=="" || orderID==undefined){
        message+="Plese select the order<br>";
    }
    if(companyID=="" || companyID==undefined){
        message+="Plese select the company<br>";
    }
    if(dateWork=="" || dateWork==undefined){
        message+="Plese select the date for the work<br>";
    }
    if(timeWork=="" || timeWork==undefined){
        message+="Plese select the time for the work<br>";
    }
    if(driverID=="" || driverID==undefined){
        message+="Plese select the driver<br>";
    }
    if(orderType!=""){
        if(orderType=="P"){
            if(amountPostCard=="" || amountPostCard==undefined){
                message+="Plese fill the amount of the postcards<br>";
            }
        }
    
    }else{
        amountPostCard=0;
    }
    if (message!=""){
        $('#myMensaje > #headerMessage').html('Error validating');
        $('#myMensaje div.modal-body').html('You have to fill some fields:<br>'+message);
        $("#myMensaje").modal("show");
        return;
    }
    if(orderType=="P"){
        arrayChanges="SchDate,"+dateWork+",SchTime,"+timeWork+",CompanyID,"+companyID+",ContractorID,"+driverID+",Status,J,EstAmtMat,"+amountPostCard+",ActAmtMat,"+amountPostCard;
    }else{
        arrayChanges="SchDate,"+dateWork+",SchTime,"+timeWork+",CompanyID,"+companyID+",ContractorID,"+driverID+",Status,D";
    }
    
    updateOrder(orderID,arrayChanges)
    $("#myModalGetWork").modal("hide");
}

function vefifyInvoice(orderID){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/validateInvoice.php", { "orderID" : orderID}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                
                $('span#messageInvoice').html(data);
                
                
            }else{
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function generateInvoice(orderID,amountValue){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/generateInvoice.php", { "orderID" : orderID,"amount":amountValue}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                vefifyInvoice(orderID);
            }else{
                $('#myModalInvoice').modal('hide');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function sendInvoiceEmail(orderID){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/sendInvoiceMail.php", { "orderID" : orderID}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                $('#myModalInvoice').modal('hide');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }else{
                $('#myModalInvoice').modal('hide');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function changerHourFormat(hour){
    var n = hour.indexOf("PM");
    if(n!=-1){
        firstPart = hour.substring(0, 1);
        firstPart = Number(firstPart)+12;
        hour=firstPart+":00";
    }else{
        hour.replace("AM","");
    }
    return hour;
}

function getEstimateAmount(orderId){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getDataOrder.php", { "orderId" : orderId}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                
                order=jQuery.parseJSON(data);
                $('#myEstimateAmount  #orderID').val(order.FBID);
                /*$('#myEstimateAmount  #estimatedAmountOrderID').val(order.OrderNumber);
                $('#myEstimateAmount  #estimatedAmountMaterials').val(order.EstAmtMat);
                $('#myEstimateAmount  #estimatedAmountTime').val(order.EstAmtTime);
                $('#myEstimateAmount  #estimatedTime').val(order.EstTime);
                $('#myEstimateAmount  #totalEstimatedAmount').val(parseInt(order.EstAmtMat)+parseInt(order.EstAmtTime));*/
                 
                //$row=$("#estimatedAmountTable>tbody>tr:first");
                $row=$('#estimatedAmountTable tr').eq(1);
                $row.find("td:eq(1)").html('$'+order.EstAmtMat+'.00');
                $row.find("td:eq(3)").html('$'+order.EstAmtMat+'.00');

                $row=$('#estimatedAmountTable tr').eq(2);
                valorHour=order.EstAmtTime/order.EstTime;
                $row.find("td:eq(1)").html('$'+valorHour+'.00');
                $row.find("td:eq(2)").html(order.EstTime);
                $row.find("td:eq(3)").html('$'+order.EstAmtTime+'.00');

                $row=$('#estimatedAmountTable tr').eq(3);
                $total=parseInt(order.EstAmtMat)+parseInt(order.EstAmtTime);
                $row.find("td:eq(3)").html('$'+$total+'.00');

                $row=$('#estimatedAmountTable tr').eq(4);
                $total=parseInt(order.EstAmtMat)+parseInt(order.EstAmtTime);
                $row.find("td:eq(3)").html('$'+$total+'.00');

                //$(document).ready(function(){$("#myEstimateAmount").modal("show"); });
            }else{
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function acceptEstimateAmount(){
    var orderID=$('#myEstimateAmount  #orderID').val();
    var status='G';
    
    //if(confirm("are you sure you want to accept the Estimate Amount?")){
        $('#myEstimateAmount').modal('hide');
        updateOrder(orderID,"Status,"+status);
        
    //}else{
    //    return false;
    //}
}

function refuseEstimateAmount(){
    var orderID=$('#myEstimateAmount  #orderID').val();
    var status='E';
    
    if(confirm("are you sure you want to decline the Estimate Amount?")){
        $('#myEstimateAmount').modal('hide');
        updateOrder(orderID,"Status,"+status);
        
    }else{
        return false;
    }
}

function getFinalAmount(orderId){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getDataOrder.php", { "orderId" : orderId}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                order=jQuery.parseJSON(data);
                if(order.RequestType=='P'){
                    $('#myFinalAmount  #orderIDFinal').val(order.FBID);
                    total=isNaN(parseInt(order.ActAmtMat)) ? 0 : parseInt(order.ActAmtMat);
                    total1=isNaN(parseInt(order.ActAmtTime)) ? 0 : parseInt(order.ActAmtTime);
                    total=total+total1;
                    amount_value=total*100;
                    action_type="pay_invoice_service";
                    if(typeof handler !== undefined){
                        handler.open({
                            name: 'RoofServiceNow',
                            description: 'pay your service',
                            amount: parseInt(amount_value),
                            email:userMailCompany
                        });
                    }
                }else{
                    $('#myFinalAmount  #orderIDFinal').val(order.FBID);
               
                    $row=$('#totalAmountTable tr').eq(1);
                    $row.find("td:eq(1)").html('$'+order.ActAmtMat+'.00');
                    $row.find("td:eq(3)").html('$'+order.ActAmtMat+'.00');

                    $row=$('#totalAmountTable tr').eq(2);
                    if(order.ActTime!="" && order.ActAmtTime!=""){
                        valorHour=(order.ActAmtTime/order.ActTime).toFixed(2);
                    }else{
                        valorHour=0;
                    }
                    
                    $row.find("td:eq(1)").html('$'+valorHour);
                    $row.find("td:eq(2)").html(order.ActTime);
                    $row.find("td:eq(3)").html('$'+order.ActAmtTime+'.00');

                    $row=$('#totalAmountTable tr').eq(3);
                    $total=isNaN(parseInt(order.ActAmtMat)) ? 0 : parseInt(order.ActAmtMat);
                    $total1=isNaN(parseInt(order.ActAmtTime)) ? 0 : parseInt(order.ActAmtTime);
                    $total=$total+$total1;
                    $row.find("td:eq(3)").html('$'+$total+'.00');

                    $row=$('#totalAmountTable tr').eq(4);
                    $total=isNaN(parseInt(order.ActAmtMat)) ? 0 : parseInt(order.ActAmtMat);
                    $total1=isNaN(parseInt(order.ActAmtTime)) ? 0 : parseInt(order.ActAmtTime);
                    $total=$total+$total1;
                    $row.find("td:eq(3)").html('$'+$total+'.00');
                }
                
                
                
                //$(document).ready(function(){$("#myEstimateAmount").modal("show"); });
            }else{
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function acceptFinalAmount(){
    var orderID=$('#myFinalAmount  #orderIDFinal').val();
    var status='K';
    
    
        $('#myPaymentType').modal('show');
        //updateOrder(orderID,"Status,"+status);
        
    
}

function refuseFinalAmount(){
    var orderID=$('#myFinalAmount  #orderIDFinal').val();
    var status='I';
    
    if(confirm("are you sure you want to decline the Final Amount?")){
        $('#myFinalAmount').modal('hide');
        updateOrder(orderID,"Status,"+status);
        
    }else{
        return false;
    }
}

function selectPaymentType(){
    var orderID=$('#myFinalAmount  #orderIDFinal').val();
    var status='K';
    //var paymentType=$('#myPaymentType  #selectPaymnetType').val();
    var paymentType=$("input:radio[name='selectPaymnetType']:checked").val();    

    if(paymentType=="cash" ||paymentType=="check"){
        $('#myPaymentType').modal('hide');
        $('#myFinalAmount').modal('hide');
        updateOrder(orderID,"Status,"+status+",PaymentType,"+paymentType);
    }else if(paymentType=="online"){
        row=$('#totalAmountTable tr').eq(4);
        totalValue=row.find("td:eq(3)").html();
        totalValue=totalValue.replace("$", "");
        totalValue=totalValue.replace(".00", "");
        amount_value=totalValue*100;
        action_type="pay_invoice_service";
        if(typeof handler !== undefined){
            handler.open({
                name: 'RoofServiceNow',
                description: 'pay your service',
                amount: parseInt(amount_value),
                email:userMailCompany
              });
        }
    }
}

function payOnlineInvoce(stripeID,amount){
    var orderID=$('#myFinalAmount  #orderIDFinal').val();
    var status='K';
    
    $('#myPaymentType').modal('hide');
    $('#myFinalAmount').modal('hide');
    
    updateOrder(orderID,"Status,"+status+",PaymentType,Online,StripeID,"+stripeID+",amount,"+amount);

}

function payOnlineInvocePostCard(stripeID,amount){
    var companyID=$('#companyIDhidden').val();
    
    $('#myMessagePostCardsPay').modal('hide');
    
    data="PaymentType,Online,StripeID,"+stripeID+",amount,"+amount+",postCardValue,0";

    jsShowWindowLoad('');
    $.post( "controlador/ajax/updateDataCompany1.php", { "companyID" : companyID,"arrayChanges":data}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                alert("The paymanet was made correctly, now you can create orders of Postcards");
                $(document).ready(function(){$("#myModalPostAdmin").modal("hide"); });
                $(document).ready(function(){$("#myPostCard").modal("hide"); });
            }else{
                alert("Error, "+data);
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });

}

//For start rating
$('.voted').hover(
    function() {
        $('.voted').addClass('hide');
        $('.votable').removeClass('hide');
    }
);

$('.votable').on('mouseleave',function(){
    $('.voted').removeClass('hide');
    $('.votable').addClass('hide');
});

$('.votable > i').hover(
    function() {
        $(this).prevAll().addBack().removeClass('fa-star-o').addClass('fa-star icon-c');
        $(this).nextAll().removeClass('fa-star icon-c').addClass('fa-star-o');
    },
    function() {
        $(this).prevAll().addBack().removeClass('fa-star icon-c').addClass('fa-star-o');
    }
);

$('.votable > i').click(function(e) {
    var vote_type = $(this).attr('data-vote-type');
    var el = $('.voted > i[data-vote-type="' + vote_type + '"]');
    //alert(vote_type);
    $('#ratingCompany').html("Rating: "+vote_type);
    
    $(el).prevAll().addBack().removeClass('fa-star-o').addClass('fa-star icon-c');
    $(el).nextAll().removeClass('fa-star icon-c').addClass('fa-star-o');
});

//For start rating
$('.voted1').hover(
    function() {
        
        $('.voted1').addClass('hide');
        $('.votable1').removeClass('hide');
    }
);

$('.votable1').on('mouseleave',function(){
    $('.voted1').removeClass('hide');
    $('.votable1').addClass('hide');
});

$('.votable1 > i').hover(
    function() {
        $(this).prevAll().addBack().removeClass('fa-star-o').addClass('fa-star icon-d');
        $(this).nextAll().removeClass('fa-star icon-d').addClass('fa-star-o');
    },
    function() {
        $(this).prevAll().addBack().removeClass('fa-star icon-d').addClass('fa-star-o');
    }
);

$('.votable1 > i').click(function(e) {
    var vote_type = $(this).attr('data-vote-type');
    var el = $('.voted1 > i[data-vote-type="' + vote_type + '"]');
    //alert(vote_type);
    $('#ratingProfessional').html("Rating: "+vote_type);

    $(el).prevAll().addBack().removeClass('fa-star-o').addClass('fa-star icon-d');
    $(el).nextAll().removeClass('fa-star icon-d').addClass('fa-star-o');
});

function setOrderSelected(oderId,FBID){
    $("input#orderIDRating").val(oderId);
    $("input#orderFBID").val(FBID);
    $("span#orderRatingId").html(oderId);

    jsShowWindowLoad('');
    $.post( "controlador/ajax/getRatingData.php", { "orderID" : FBID}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                data=jQuery.parseJSON(data);
                var keys=Object.keys(data);
                if(keys!=null && keys.length>0){
                    $("input:radio[name='ratingYesNo'][value="+data[keys[0]].Recommended+"]").attr('checked','checked');
                    $('input#ratingObservation').val(data[keys[0]].Comments);
                    $("label#ratingCompany").html("Rating: "+data[keys[0]].RatingCompany);
                    $("label#ratingProfessional").html("Rating: "+data[keys[0]].RatingContractor);

                    var el = $('.voted > i[data-vote-type="' + parseInt(data[keys[0]].RatingCompany) + '"]');
                    $(el).prevAll().addBack().removeClass('fa-star-o').addClass('fa-star icon-c');
                    $(el).nextAll().removeClass('fa-star icon-c').addClass('fa-star-o');

                    var el = $('.voted1 > i[data-vote-type="' + parseInt(data[keys[0]].RatingContractor) + '"]');
                    $(el).prevAll().addBack().removeClass('fa-star-o').addClass('fa-star icon-d');
                    $(el).nextAll().removeClass('fa-star icon-d').addClass('fa-star-o');

                    $(".votable1").unbind('mouseenter mouseleave');
                    $(".votable1 > i").unbind('mouseenter mouseleave');
                    $(".voted1").unbind('mouseenter mouseleave');

                    $(".votable").unbind('mouseenter mouseleave');
                    $(".votable > i").unbind('mouseenter mouseleave');
                    $(".voted").unbind('mouseenter mouseleave');
                    $("#buttonRating").hide();

                }else{
                    $("input:radio[name='ratingYesNo'][value='No']").attr('checked','checked');
                    $('input#ratingObservation').val("");
                    $("label#ratingCompany").html("Rating: 0");
                    $("label#ratingProfessional").html("Rating: 0");

                    $('.voted > i').removeClass('fa-star icon-c').addClass('fa-star-o');
                    $('.voted1 > i').removeClass('fa-star icon-d').addClass('fa-star-o');
                    $("#buttonRating").show();
                }
                
                console.log(data);
            }else{
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function insertOrderRating(){
    var orderID=$("input#orderFBID").val();
    var Recommended=$("input:radio[name='ratingYesNo']:checked").val();
    var ratingCompany=$("label#ratingCompany").html();
    var ratingProfessional=$("label#ratingProfessional").html();
    var observation=$('input#ratingObservation').val();

    ratingCompany = ratingCompany.replace("Rating: ","")+".0";
    ratingProfessional = ratingProfessional.replace("Rating: ","")+".0";

    jsShowWindowLoad('');
    $.post( "controlador/ajax/insertRating.php", { "orderID" : orderID,"Recommended":Recommended,"RatingCompany":ratingCompany,
                                                    "RatingContractor":ratingProfessional,"Observation":observation}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                $('#myRatingScore').modal('hide');
                
                $('#headerTextAnswerOrder').html('Rating response');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
                console.log(data);
            }else{
                $('#headerTextAnswerOrder').html('Rating response');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function getInvoices(orderID){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getListInvoice.php", { "orderID" : orderID}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                $('#invoiceInfo tbody').html(data);
                //$( "#myInvoiceInfo" ).dialog('open');
                $(document).ready(function(){$("#myInvoiceInfo").modal("show"); });
                $('#detailStripe').html("");
                //console.log(data);
            }else{
                $('#headerTextAnswerOrder').html('Invoice response');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function getCommentary(orderID){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getListCommentary.php", { "orderID" : orderID}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                $('input:hidden#commentaryIDOrder').val(orderID);
                $('#commentaryInfo tbody').html(data);
                //$( "#myInvoiceInfo" ).dialog('open');
                $(document).ready(function(){$("#myCommentaryInfo").modal("show"); });
                //console.log(data);
            }else{
                $('#headerTextAnswerOrder').html('Commentary response');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function insertCommentary(){
    var orderID=$('input:hidden#commentaryIDOrder').val();
    var commentary=$('#commentOrder').val();
    var message="";
    if(orderID=="" || orderID==null || orderID==undefined){
        message="Please select the order<br>";
    }
    if(commentary=="" || commentary==null || commentary==undefined){
        message="Please write the commentary<br>";
    }
    if(message!=""){
        alert(message);
        return;
    }
    jsShowWindowLoad('');
    $.post( "controlador/ajax/insertOrderCommentary.php", { "orderID" : orderID,"commentary":commentary}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                $("#myCommentaryInfo").modal("hide");
                $("#myCommentaryInfoN").modal("hide");
                $('#headerTextAnswerOrder').html('Commentary response');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }else{
                $("#myCommentaryInfo").modal("hide");
                $("#myCommentaryInfoN").modal("hide");
                $('#headerTextAnswerOrder').html('Commentary response');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

/*$( "#myInvoiceInfo" ).dialog({
    autoOpen: false,
    modal: true,
    buttons: {
        Cancel: function() {
            $(this).dialog('close');
        }
    }
});*/

function resetPassword(){
    userType=$('input:hidden#typeUser').val();
    userMail=$('input:text#emailReset').val();

    message = "";
    if(userType==undefined || userType==""){
        message='Please select user type \n';
        
    }
    if(userMail==undefined || userMail==""){
        message+='Please type user mail \n';
    }
    if(message!=""){
        alert(message);
        return;
    }
    jsShowWindowLoad('');
    $.post( "controlador/ajax/resetPassword.php", { "userType" : userType,"userMail" : userMail}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                $('#myMensaje1 div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje1").modal("show"); });
            }else{
                
                $('#myMensaje1 div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje1").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function changePaswword(table,id_user,temporal_password){
    password=$('input#newpassword').val();
    password1=$('input#retypepassword').val();

    //alert(table+id_user+temporal_password);
    message="";
    if(table=="" || table==undefined){
        message+="Plese selete type user \n";
    }
    if(id_user=="" || id_user==undefined){
        message+="Plese select user \n";
    }
    if(temporal_password=="" || temporal_password==undefined){
        message+="Plese select temporal password \n";
    }

    if(password=="" || password==undefined){
        message+="Plese type the password \n";
    }
    if(password1=="" || password1==undefined){
        message+="Plese confirm the password \n";
    }
    if(password.length<6){
        message+="the password must be at least 6 characters \n";
    }
    if(password1.length<6){
        message+="the password must be at least 6 characters \n";
    }
    if(password!=password1){
        message+="The password and the confirmation are different, please review \n";
    }
    if(message!=""){
        alert(message);
        return;
    }
    jsShowWindowLoad('');
    $.post( "controlador/ajax/changePassword.php", { "userType" : table,"userId" : id_user,"tempPass":temporal_password,"newPass":password}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                other='<br><h3>Redirecting to RoofServiceNow login page after <span id="countdown">10</span> seconds</h3>';
                direction=data;
                $('#myMensaje1 div.modal-body').html(other);
                $(document).ready(function(){$("#myMensaje1").modal("show"); });
                countdown();
            }else{
                
                $('#myMensaje1 div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje1").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

var seconds = 10;
var direction = "http://localhost/RoofAdvisor1/";

function countdown() {
    seconds = seconds - 1;
    if (seconds < 0) {
        // Chnage your redirection link here
        window.location = direction;
    } else {
        // Update remaining seconds
        document.getElementById("countdown").innerHTML = seconds;
        // Count down using javascript
        window.setTimeout("countdown()", 1000);
    }
}


function disableEnableCompany(companyID,action){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/enable_disable_company.php", { "companyID" : companyID,"action" : action}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            if(n==-1){
                $('#myMensaje div.modal-body').html(data);
                

                $('#table_list_company tr').each(function(){ 
                    if($(this).find('td').eq(0).text()==companyID){
                        if(action=="Active"){ 
                            text='<div class="alert alert-success">Active</div>';
                            $(this).find('td').eq(6).html(text);
                            $(this).find('td').eq(7).find('a:eq(1)').addClass('btn-danger').removeClass('btn-success');
                            $(this).find('td').eq(7).find('span:eq(1)').addClass('glyphicon-remove').removeClass('glyphicon-ok');
                            $(this).find('td').eq(7).find('a:eq(1)').attr("onclick","disableEnableCompany("+companyID+"','Inactive')");
                        }else{
                            text='<div class="alert alert-danger">Inactive</div>';
                            $(this).find('td').eq(6).html(text);
                            $(this).find('td').eq(7).find('a:eq(1)').addClass('btn-success').removeClass('btn-danger');
                            $(this).find('td').eq(7).find('span:eq(1)').addClass('glyphicon-ok').removeClass('glyphicon-remove');
                            $(this).find('td').eq(7).find('a:eq(1)').attr("onclick","disableEnableCompany("+companyID+"','Active')");
                        }
                    }
                 })
                 jsRemoveWindowLoad('');
                $(document).ready(function(){$("#myMensaje").modal("show"); });

            }else{
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
                result1=false;
                jsRemoveWindowLoad('');
                return result1;
            }
        });

}

function filterCompany(nameType,nameStatus,tableName){
    var serviceTypeSelected=$('input[name="'+nameType+'"]:checked');
    var serviceStatusSelected=$('input[name="'+nameStatus+'"]:checked');

    var listTypeService="";
    var listTypeStatus="";
    var listTypeServiceName="";
    var listTypeStatusName="";

    $.each( serviceTypeSelected, function( key, value ) {
        listTypeServiceName+=getRequestType($(this).val())+",";
        listTypeService=listTypeService+$(this).val()+",";
        console.log($(this).val());
    });

    $.each( serviceStatusSelected, function( key, value ) {
        listTypeStatusName+=getStatus($(this).val())+",";
        listTypeStatus=listTypeStatus+$(this).val()+",";
        console.log($(this).val());
    });

    hideShowMarketByTypeServiceAndSatus(listTypeService,listTypeStatus);
    //hideShowMarketByTypeService(listTypeService);
    //hideShowMarketByStatus(listTypeStatus);
    $('#myFilterWindow').modal('hide');
    
    var table = $('#'+tableName).DataTable();
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            return listTypeServiceName.indexOf(data[5])>-1 || listTypeStatusName.indexOf(data[6])>-1 ? true : false;
        }     
    );
    table.draw();
    $.fn.dataTable.ext.search.pop();
}

function filterCustomer(nameType,nameStatus,tableName){
    var serviceTypeSelected=$('input[name="'+nameType+'"]:checked');
    var serviceStatusSelected=$('input[name="'+nameStatus+'"]:checked');

    var listTypeService="";
    var listTypeStatus="";
    var listTypeServiceName="";
    var listTypeStatusName="";

    $.each( serviceTypeSelected, function( key, value ) {
        listTypeServiceName+=getRequestType($(this).val())+",";
        listTypeService=listTypeService+$(this).val()+",";
        console.log($(this).val());
    });

    $.each( serviceStatusSelected, function( key, value ) {
        listTypeStatusName+=getStatus($(this).val())+",";
        listTypeStatus=listTypeStatus+$(this).val()+",";
        console.log($(this).val());
    });

    hideShowMarketByTypeServiceAndSatus(listTypeService,listTypeStatus);
    //hideShowMarketByTypeService(listTypeService);
    //hideShowMarketByStatus(listTypeStatus);
    $('#myFilterWindow').modal('hide');
    
    var table = $('#'+tableName).DataTable();
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            return listTypeServiceName.indexOf(data[1])>-1 || listTypeStatusName.indexOf(data[4])>-1 ? true : false;
        }     
    );
    table.draw();
    $.fn.dataTable.ext.search.pop();
}

function selectUnselectCheck(nameCheck,chek){
    var checkSelected=$('input[name="'+nameCheck+'"]');
    $.each( checkSelected, function( key, value ) {
        $(this).attr('checked', $(chek).is(':checked'));
    });
}

function setInfoUploadFile(orderId){
$('#UploadReportIDOrder').val(orderId);
}

function uploadAjax(fileName){
    var file_name=$('#file_name').val();
    var inputFileImage = document.getElementById(fileName);
    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('file',file);
    var url = 'controlador/ajax/uploadReports.php';
    file_name = file_name.replace(/[^\w\s]/gi, '');
    file_name = file_name.replace(/ /g, '_');
    file_name = file_name.replace('.pdf', '');
    data.append('file_name',file_name);
    data.append('orderID',$('#UploadReportIDOrder').val());
    
    $.ajax({
        url:url,
        type:'POST',
        contentType:false,
        data:data,
        processData:false,    
        cache:false,
        success : function(json) {
            console.log(json);
            data=jQuery.parseJSON(json);
            alert(data.msg);
            $("#myUploadReportN").modal("hide");  
            $("#myUploadReport").modal("hide");  
        },
        error : function(xhr, status) {
            alert('An error occurred when uploading the file. It could not be saved.');
        },
        complete : function(xhr, status) {
            //alert('The operation end correctly');
        }
    });
    
    }

function getListReportFile(orderID){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getListReportFiles.php", { "orderID" : orderID}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                $('input:hidden#UploadReportIDOrder').val(orderID);
                $('#myUploadReport #UploadReportInfo tbody').html(data);
                //$( "#myInvoiceInfo" ).dialog('open');
                $(document).ready(function(){$("#myUploadReport").modal("show"); });
                //console.log(data);
            }else{
                $('#headerTextAnswerOrder').html('Roof Report response');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function changeSelection(selectionType){
    selectionType=$("#customerTypeRequest").find(":selected").val()

    $('#customButton').hide();
    $('#question1').val('');
    $('#question2').val('');
    $('#question3').val('');
    $('#question4').val('');
    $('#question5').val('');
    $('#orderNumberRRR').val('');
    $('#customerInfoRRR').val('');
    
    $('input:hidden[name=step5Latitude]').val('');
    $('input:hidden[name=step5Logintud]').val('');
    $('input:hidden[name=step5Address]').val('');
    $('input:hidden[name=step5ZipCode]').val('');

    switch (selectionType){
        case "order":
            $('#orderNumberRRR').show();
            $('#labelorderNumberRRR').show();
            $('#customerInfoRRR').show();
            $('#customerIDRRR').hide();
            $('#labelcustomerIDRRR').hide();
            $('#buttoncustomerIDRRR').hide();
            $('#linkNewCustomer').hide();
            break;
        case "customer":
            $('#orderNumberRRR').hide();
            $('#labelorderNumberRRR').hide();
            
            $('#customerIDRRR').show();
            $('#labelcustomerIDRRR').show();
            $('#buttoncustomerIDRRR').show();
            break;
        case "newCustomer":
            $('#orderNumberRRR').hide();
            $('#labelorderNumberRRR').hide();
            $('#customerInfoRRR').hide();
            $('#labelcustomerIDRRR').hide();
            $('#buttoncustomerIDRRR').hide();
            $('#linkNewCustomer').show();
            
            
            break;
    }
}

function getCustomerInfo(customerID){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getDataCustomer.php", { "customerID" : customerID}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                customer=jQuery.parseJSON(data);
                $('#customerInfoRRR').val("Address: "+customer.Address+'\n'+"City: "+customer.City+'\n'+"Email: "+customer.Email+'\n'+"Name: "+customer.Fname+' '+customer.Lname+'\n'+"Phone: "+customer.Phone);
                $('#customButton').show();
            }else{
                $('#headerTextAnswerOrder').html('Roof Report response');
                $('#myMensaje div.modal-body').html(data);
                $(document).ready(function(){$("#myMensaje").modal("show"); });
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function getInforCustomerForRoofReport(){
    var orderId=$('#orderNumberRRR').val();
    if(orderId==undefined || orderId==''){
        alert("Please fill the order field.");
        return;
    }
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getDataOrder.php", { "orderId" : orderId,"fieldSearch":"OrderNumber"}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            if(data.indexOf("null")>-1){
                $('#headerTextAnswerOrder').html('Roof Report response');
                $('#myModalRespuesta div.modal-body').html('the entered order does not exist') ;
                $(document).ready(function(){$("#myModalRespuesta").modal("show"); });
            }else{
                var n = data.indexOf("Error");
                if(n==-1){
                    order=jQuery.parseJSON(data);
                    $('#question1').val(order.Rtype);
                    $('#question2').val(order.Water);
                    $('#question3').val(order.Hlevels);
                    $('#question4').val(order.Authorized);
                    $('#question5').val(order.RepAddress);
                    $('input:hidden[name=step5Latitude]').val(order.Latitude);
                    $('input:hidden[name=step5Logintud]').val(order.Longitude);
                    $('input:hidden[name=step5Address]').val(order.RepAddress);
                    $('input:hidden[name=step5ZipCode]').val(order.RepZIP);
                    getCustomerInfo(order.CustomerID);
                    $('#customButton').show();
                }else{
                    $('#headerTextAnswerOrder h4').html('Roof Report response');
                    $('#myMensaje div.modal-body').html(data);
                    $(document).ready(function(){$("#myMensaje").modal("show"); });
                }
            }
            
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });

    
}

function getCustomerListRR(){

}

function showMapSelect(typeService){
    if(typeService=='roofReport'){
        $('#buttonRoofReport').show();
        $('#buttonPostCard').hide();
        
    }else if(typeService=='postCard'){
        $('#buttonPostCard').show();
        $('#buttonRoofReport').hide();
    }
    $(document).ready(function(){$("#myMapSelectAddress").modal("show"); });
}
function closeMapSelect(textBoxInfo){
    $('#'+textBoxInfo).val($('#step5Address').val());
    $(document).ready(function(){$("#myMapSelectAddress").modal("hide"); });
}


function insertOrderRoofReport(idStripeCharge,amountValue){
    var RepZIP=$('#step5ZipCode').val();
    var RequestType="roofreport";
    
    var Rtype=$("#question1").find(":selected").val();
    var Water=$("#question2").find(":selected").val();
    var Hlevels=$("#question3").find(":selected").val();
    var Authorized=$("#question4").find(":selected").val();
    var CompanyID=$('#companyIDhidden').val();
    CompanyID=CompanyID.trim();
    var email="";
    var password="";
    var latitude=$('input:hidden[name=step5Latitude]').val();
    var longitude=$('input:hidden[name=step5Logintud]').val();
    var address=$('input:hidden[name=step5Address]').val();
    var SchDate=formatActualDate();
    var SchTime=formatActualTime(2);

    var selectionType=$("#customerTypeRequest").find(":selected").val()

    if(RequestType=='emergency'){
        RequestType='E'
    }else if(RequestType=='schedule'){
        RequestType='S'
    }else if(RequestType=='roofreport'){
        RequestType='R'
    }
    
    if(CompanyID==undefined){
        CompanyID="";
    }
    if(amountValue==undefined){
        amountValue=0;
    }
    jsShowWindowLoad('One second as we send you an invoice for the payment and create your order.');
    $.post( "controlador/ajax/insertOrder.php", {"RepZIP":RepZIP,"RequestType":RequestType,"Rtype":Rtype,"Water":Water,"Hlevels":Hlevels,
                                                "SchDate":SchDate,"SchTime":SchTime,"CompanyID":CompanyID,"email":email,
                                                "password":password,"Latitude":latitude,"Longitude":longitude,"Address":address,"stripeCharge":idStripeCharge,
                                                "Authorized":Authorized,"amount_value":amountValue}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            

            if(n==-1){
                    var dataSplit=data.split(",");
                    var orderIDSplit=dataSplit[2].split("/");
                    var orderIDSplit1=orderIDSplit[orderIDSplit.length-1].split(' - ');
                    if (selectionType=="newCustomer"){
                        var firstCustomerName = $("input#firstCustomerName").val();
                        var lastCustomerName = $("input#lastCustomerName").val();
                        var emailValidation = $("input#emailValidationCustomer").val();
                        var customerAddress = $("input#customerAddress").val();
                        var customerCity = $("input#customerCity").val();
                        var customerState = $("select#customerState").val();
                        var customerZipCode = $("input#customerZipCode").val();
                        var customerPhoneNumber = "+1"+$("input#customerPhoneNumber").val();

                        $.post( "controlador/ajax/insertCustomer.php", { "firstCustomerName" : firstCustomerName,"lastCustomerName": lastCustomerName,"emailValidation":emailValidation,
                                                        "customerAddress":customerAddress,"customerCity":customerCity,"customerState":customerState,
                                                    "customerZipCode":customerZipCode,"customerPhoneNumber":customerPhoneNumber,"password":password,
                                                    "selectionType":selectionType,"source_call":"company_dash"}, null, "text" )
                        .done(function( dataC, textStatusC, jqXHRC ) {
                            if ( console && console.log ) {
                                var n = dataC.indexOf("Error");
                                if(n==-1){
                                    arrayChanges="CustomerID,"+dataC;
                                    updateOrder(orderIDSplit1[0],arrayChanges)
                                }
                                console.log(dataC);
                            }
                        })
                        .fail(function( jqXHR, textStatus, errorThrown ) {
                            if ( console && console.log ) {
                                console.log( "La solicitud a fallado: " +  textStatusC);
                                result=false;
                                
                            }
                        });
                    }
                     $(document).ready(function(){$("#myRoofReportRequest").modal("hide"); });

                    $('#textAnswerOrder').html(data+'');
                    

                    $('#headerTextAnswerOrder').html('Success');
                  
                    $("#answerValidateUserOrder").html('<div class="alert alert-success"><strong>'+data+'</strong></div>');
                    $('#lastFinishButtonOrder').show();
                    $('#myModalRespuesta').modal({backdrop: 'static'});
            }else{
                    $('#headerTextAnswerOrder').html('Error validating User Account');
                    $('#textAnswerOrder').html(data+'<br><br>Please try again');
                    $("#answerValidateUserOrder").html('<div class="alert alert-danger"><strong>'+data+'</strong></div>');
                    $('#lastFinishButtonOrder').hide();
                    $('#buttonAnswerOrder').html('<br><br><button type="button" class="btn btn-default" data-dismiss="modal" onclick="insertOrderCustomer()">Finish</button><br><br>');
                    $('#myModalRespuesta').modal({backdrop: 'static'});
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result=false;
            jsRemoveWindowLoad('');
        }
    });
}

function insertOrderPostCard(){
    
    
    var RequestType="postcard";
    
    var Rtype="";
    var Water="";
    var Hlevels="";
    var Authorized="";
    var CompanyID=$('#companyIDhidden').val();
    CompanyID=CompanyID.trim();
    var email="";
    var password="";
    var latitude=$('input:hidden[name=step5Latitude]').val();
    var longitude=$('input:hidden[name=step5Logintud]').val();
    var address=$('input:hidden[name=step5Address]').val();
    var RepZIP=$('#step5ZipCode').val();
    var SchDate=formatActualDate();
    var SchTime=formatActualTime(2);
    var idStripeCharge="";
    var amountValue=$('#textPostCardQuantity').val();
    var balance=$('#postCardBalance').val();

    if(parseInt(amountValue)>parseInt(balance)){
        alert('The quantity of post cards request can not be higher than the balance post card of the company');
        return;
    }
    if(parseInt(amountValue)<250){
        alert('The quantity of post cards request can not be smaller than 250');
        return;
    }
    var selectionType="PostCard"

    if(RequestType=='emergency'){
        RequestType='E'
    }else if(RequestType=='schedule'){
        RequestType='S'
    }else if(RequestType=='roofreport'){
        RequestType='R'
    }else if(RequestType=='postcard'){
        RequestType='P'
    }
    
    if(CompanyID==undefined){
        CompanyID="";
    }
    if(amountValue==undefined){
        amountValue=0;
    }
    jsShowWindowLoad('One second we are saving the order.');
    $.post( "controlador/ajax/insertOrder.php", {"RepZIP":RepZIP,"RequestType":RequestType,"Rtype":Rtype,"Water":Water,"Hlevels":Hlevels,
                                                "SchDate":SchDate,"SchTime":SchTime,"CompanyID":CompanyID,"email":email,
                                                "password":password,"Latitude":latitude,"Longitude":longitude,"Address":address,"stripeCharge":idStripeCharge,
                                                "Authorized":Authorized,"postCardValue":amountValue}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            

            if(n==-1){
                    var dataSplit=data.split(",");
                    var orderIDSplit=dataSplit[2].split("/");
                    var orderIDSplit1=orderIDSplit[orderIDSplit.length-1].split(' - ');
                    
                    $(document).ready(function(){$("#myPostCard").modal("hide"); });
                    $('#textAnswerOrder').html(data+'');
                    $('#headerTextAnswerOrder').html('Success');
                    $('#myModalRespuesta').modal({backdrop: 'static'});

                    balance=parseInt(balance)-parseInt(amountValue);
                    var data="postCardValue,"+balance;

                    
                    $.post( "controlador/ajax/updateDataCompany1.php", { "companyID" : CompanyID,"arrayChanges":data}, null, "text" )
                    .done(function( data, textStatus, jqXHR ) {
                        if ( console && console.log ) {
                            var n = data.indexOf("Error");
                            if(n==-1){
                                alert("The postcard was charged to the company");
                                $(document).ready(function(){$("#myModalPostAdmin").modal("hide"); });
                            }else{
                                
                            }
                            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                            jsRemoveWindowLoad('');
                        }
                    })
                    .fail(function( jqXHR, textStatus, errorThrown ) {
                        if ( console && console.log ) {
                            console.log( "La solicitud a fallado: " +  textStatus);
                            result1=false;
                            
                            return result1;
                        }
                    });

            }else{
                    $('#headerTextAnswerOrder').html('Error validating User Account');
                    $('#textAnswerOrder').html(data+'<br><br>Please try again');
                    $("#answerValidateUserOrder").html('<div class="alert alert-danger"><strong>'+data+'</strong></div>');
                    $('#lastFinishButtonOrder').hide();
                    $('#buttonAnswerOrder').html('<br><br><button type="button" class="btn btn-default" data-dismiss="modal" onclick="insertOrderCustomer()">Finish</button><br><br>');
                    $('#myModalRespuesta').modal({backdrop: 'static'});
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result=false;
            jsRemoveWindowLoad('');
        }
    });
}

function formatActualDate() {
    var d = new Date();
    var n = d.getFullYear();
    var m = d.getMonth();
    var da = d.getDate();
    da=("00" + da).slice(-2);
    m=("00" + m).slice(-2);
    return m.toString()+'/'+da.toString()+'/'+n.toString();
}

function formatActualTime(aditionHours) {
    var d = new Date();
    var hour = d.getHours();
    var min = d.getMinutes();
    if(aditionHours>0){
        hour=hour+2;
        if(hour>23){
            hour=hour-23;
        }
    }
    hour=("00" + hour).slice(-2);
    min=("00" + min).slice(-2);
    return hour.toString()+':'+min.toString();
}

function validateInfoCustomer(){
    var firstCustomerName = $("input#firstCustomerName").val();
    var lastCustomerName = $("input#lastCustomerName").val();
    var emailValidation = $("input#emailValidationCustomer").val();
    var customerAddress = $("input#customerAddress").val();
    var customerCity = $("input#customerCity").val();
    var customerState = $("select#customerState").val();
    var customerZipCode = $("input#customerZipCode").val();
    var customerPhoneNumber = "+1"+$("input#customerPhoneNumber").val();
    var message = "";

    if(firstCustomerName==undefined || firstCustomerName==''){
        message+="Please, fill the Customer name field \n";
    }
    if(lastCustomerName==undefined || lastCustomerName==''){
        message+="Please, fill the Customer last name field \n";
    }
    if(emailValidation==undefined || emailValidation==''){
        message+="Please, fill the email field \n";
    }
    if(customerAddress==undefined || customerAddress==''){
        message+="Please, fill the address field \n";
    }
    if(customerCity==undefined || customerCity==''){
        message+="Please, fill the city field \n";
    }
    if(customerState==undefined || customerState==''){
        message+="Please, fill the state field \n";
    }
    if(customerZipCode==undefined || customerZipCode==''){
        message+="Please, fill the zip code field \n";
    }
    if(customerPhoneNumber==undefined || customerPhoneNumber==''){
        message+="Please, fill the phone number field \n";
    }
    if(message!=""){
        alert(message);
        $('#linkNewCustomer').addClass('btn-danger').removeClass('btn-success');
        return false;
    }else{
        $(document).ready(function(){$("#myRegisterNewCustomer").modal("hide"); });
        $('#linkNewCustomer').addClass('btn-success').removeClass('btn-danger');
        return true;
    }
}

function validateOrderInfo(){
    var RepZIP=$('#step5ZipCode').val();
    var RequestType="roofreport";
    var Rtype=$("#question1").find(":selected").val();
    var Water=$("#question2").find(":selected").val();
    var Hlevels=$("#question3").find(":selected").val();
    var Authorized=$("#question4").find(":selected").val();
    var CompanyID=$('#companyIDhidden').val();
    var latitude=$('input:hidden[name=step5Latitude]').val();
    var longitude=$('input:hidden[name=step5Logintud]').val();
    var address=$('input:hidden[name=step5Address]').val();
    var message = "";

    if(RepZIP==undefined || RepZIP==''){
        message+="Please, fill the address field \n";
    }
    if(RequestType==undefined || RequestType==''){
        message+="Please, fill the request type field \n";
    }
    if(Rtype==undefined || Rtype==''){
        message+="Please, select roof type field \n";
    }
    if(Water==undefined || Water==''){
        message+="Please, define leaks question \n";
    }
    if(Hlevels==undefined || Hlevels==''){
        message+="Please, define stories quetion \n";
    }
    if(Authorized==undefined || Authorized==''){
        message+="Please, define Authorized quetion \n";
    }
    if(CompanyID==undefined || CompanyID==''){
        message+="Please, define company ID \n";
    }
    if(latitude==undefined || latitude==''){
        message+="Please, fill the address field \n";
    }
    if(longitude==undefined || longitude==''){
        message+="Please, fill the address field \n";
    }
    if(address==undefined || address==''){
        message+="Please, fill the address field \n";
    }
    if(message!=""){
        alert(message);
        return false; 
    }else{
        return true;
    }
}


function showPayWindow(){
    var selectionType=$("#customerTypeRequest").find(":selected").val();
    if(validateOrderInfo()==false){
        return;
    }else{
        if(selectionType=='newCustomer'){
            if(validateInfoCustomer()==false){
                return false;
            }else{
                //action_type="pay_invoice_service";
                if(typeof handler !== undefined){
                    handler.open({
                        name: 'RoofServiceNow',
                        description: 'pay your service',
                        amount: parseInt(amount_value),
                        email:userMailCompany
                      });
                } 
            }
        }else{
            if(typeof handler !== undefined){
                handler.open({
                    name: 'RoofServiceNow',
                    description: 'pay your service',
                    amount: parseInt(amount_value),
                    email:userMailCompany
                  });
            }
        }
    }
}

function showPostCardInfo(companyID){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getBalancePostCard.php", { "companyID" : companyID}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                data=jQuery.parseJSON(data);

                $('#postCardBalance').val(data.postCardQuantity);
                $('#companyPostCard').val(companyID);

                if(parseInt(data.postCardQuantity)==0){
                    $(document).ready(function(){$("#myPostCard").modal("hide"); });
                    $(document).ready(function(){$("#myPostCardServiceP").modal("show"); });
                }
                if(parseInt(data.postCardValue)!=0){
                    $("#myMessagePostCardsPay").modal("show");
                }
            }else{
                
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });

}

function chargePostCardCompany(){
    var quantity=$('#postCardQuantity').val();
    var companyID=$('#companyPostCard').val();
    var balance=$('#postCardBalance').val();
    var amount=$('#postCardValue').val();
    
    if(quantity<250){
        alert('The minimum value allowed for postcards is 250');
        return false;
    }
    if(amount=='' || amount==0){
        alert('Please review the amount of postcards, it cannot be 0 or empty');
        return false;
    }
    /*amount_value=70000;
    action_type="pay_invoice_postcard";
    if(typeof handler !== undefined){
        handler.open({
            name: 'RoofServiceNow',
            description: 'pay your service',
            amount: amount_value
            });
    }*/
    balance=isNaN(parseInt(balance)) ? 0 : parseInt(balance);
    
    var total=parseInt(balance)+parseInt(quantity);
    var data="postCardQuantity,"+total+",postCardValue,"+amount;
    jsShowWindowLoad('');
    $.post( "controlador/ajax/updateDataCompany1.php", { "companyID" : companyID,"arrayChanges":data}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            var n = data.indexOf("Error");
            if(n==-1){
                alert("The post card was charged to the company");
                $(document).ready(function(){$("#myModalPostAdmin").modal("hide"); });
            }else{
                
            }
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            jsRemoveWindowLoad('');
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            jsRemoveWindowLoad('');
            return result1;
        }
    });
}

function showPayPostCards(totalValue){
    amount_value=totalValue;
    action_type="pay_postcard_service";
    if(typeof handler !== undefined){
        handler.open({
            name: 'RoofServiceNow',
            description: 'pay your service',
            amount: parseInt(amount_value),
            email:userMailCompany
            });
    }
}

function closeExtraWindows(){
    $(document).ready(function(){$("#myPostCard").modal("hide"); });
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ( (charCode > 31 && charCode < 48) || charCode > 57) {
        return false;
    }
    return true;
}

$("#userClient").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#submitLoginCustomer").click();
    }
});

$("#passwordClient").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#submitLoginCustomer").click();
    }
});

$("#userContractor").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#submitLoginContractor").click();
    }
});

$("#passwordContractor").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#submitLoginContractor").click();
    }
});
