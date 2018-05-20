$(document).ready(function() {
    $("#addRowDriver").click(function(){
        var rowCount = $('table#table_drivers tr:last').index() + 2;
        $("#table_drivers").append('<tr><td>'+rowCount+'</td><td><input maxlength="30" type="text" required="required" class="form-control" placeholder="First Name" id="driverFirstName[]" name="driverFirstName[]" /></td><td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Last Name"  id="driverLastName[]" name="driverLastName[]" /></td><td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Repair Crew Phone" id="driverPhone[]" name="driverPhone[]" /></td><td><input maxlength="30" type="text" required="required" class="form-control" placeholder="Driver License"  id="driverLicense[]" name="driverLicense[]" /></td><td><select class="form-control"  id="driverStatus[]" name="driverStatus[]"><option value="Active">Active</option><option value="Inactive">Inactive</option><option value="Terminated">Terminated</option></select></td><td><a href="#" class="btn-danger form-control" role="button" data-title="johnny" id="deleteRowDriver" data-id="1">Delete</a></td></tr>');
        
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
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( "La solicitud a fallado: " +  textStatus);
                    result=false;
                }
            });
        return result;    
     }
};

function saveContractorData(){
    var companyNameField = $("input#companyName").val();
    var firstNameField = $("input#firstNameCompany").val();
    var lastNameField = $("input#lastNameCompany").val();
    var phoneContactField = $("input#phoneContactCompany").val();
    var emailField = $("input#emailValidation").val();
    var typeCompanyField = $("select#typeCompany").val();

    var driver=[];

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
    $('select[name^="driverStatus"]').each(function() {
        driver.push($(this).val());
    });

    
    
    $.post( "controlador/ajax/insertContract.php", { "companyName" : companyNameField,"firstNameCompany": firstNameField,"lastNameCompany":lastNameField,
                                                    "phoneContactCompany":phoneContactField,"emailValidation":emailField,"typeCompany":typeCompanyField,
                                                "arrayDrivers":driver}, null, "text" )
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
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( "La solicitud a fallado: " +  textStatus);
                    result=false;
                }
            });
}


function validateCodeEmail(table){
    var emailField = $("input#emailValidation").val();
    var codeField = $("input#codeValidateField").val();
    var result1=false;

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
            return result1;
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
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
    $('#ContStatused').val(tableData[5]);

    
    //console.log(tableData[0]);
    //console.log(tableData);
} );


function updateContractor(){
    var contractorID = $("input#ContractorIDed").val();
    var contratorFirstName = $("input#ContNameFirsted").val();
    var contratorLastName = $("input#ContNameLasted").val();
    var contratorPhoneNumber = $("input#ContPhoneNumed").val();
    var contratorLinceseNumber = $("input#ContLicenseNumed").val();


    $.post( "controlador/ajax/updateContract.php", { "contractorID" : contractorID,"contratorFirstName": contratorFirstName,
                                                    "contratorLastName":contratorLastName,"contratorPhoneNumber":contratorPhoneNumber,
                                                "contratorLinceseNumber":contratorLinceseNumber}, null, "text" )
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
					
				}
 				
 			    })
            }else{
                
            }
            
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
            return result1;
        }
    });
}


$(".inactivate-contractor-button").click(function(){
    var contractorID = $(this).parents('tr:first').find('td:eq(0)').text();

    if(confirm("Are you sure you want to inactive contractor "+contractorID)){

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
            
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
                result1=false;
                return result1;
            }
        });



        //$("inactivate-contractor-button").attr("href", "query.php?ACTION=delete&ID='1'");
    }
    else{
        return false;
    }
});


function insertDriver(){
    var companyID = $("input#companyID").val();
    var contractorFirstName = $("input#ContNameFirstIn").val();
    var contractorLastName = $("input#ContNameLastIn").val();
    var contractorPhoneNumber = $("input#ContPhoneNumIn").val();
    var contractorLinceseNumber = $("input#ContLicenseNumIn").val();
    var contractorState = $("select#ContStatusIn").val();

    $.post( "controlador/ajax/insertDriver.php", { "companyID" : companyID,"contractorFirstName" : contractorFirstName,"contractorLastName": contractorLastName,
    "contractorPhoneNumber":contractorPhoneNumber,"contractorLinceseNumber":contractorLinceseNumber,
    "contractorState":contractorState}, null, "text" )
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
                
                $("#table_drivers_dashboard_company").append('<tr><td>'+consecutivo+'</td><td>'+contractorFirstName+'</td><td>'+contractorLastName+'</td><td>'+contractorPhoneNumber+'</td><td>'+contractorLinceseNumber+'</td><td>'+contractorState+'</td><td><a class="btn-info btn-sm" data-toggle="modal" href="#myModal2" onClick=""> <span class="glyphicon glyphicon-pencil"></span></a></td><td><a href="#" class="inactivate-contractor-button btn-danger btn-sm" id="inactivate-contractor-button" name="inactivate-contractor-button"><span class="glyphicon glyphicon-trash"></span></a></td></tr>');
            }else{
                
            }
            
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
            
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
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

    if( typeof companyAddress2 === 'undefined' || companyAddress2 === null ){
        companyAddress2="";
    }
    if( typeof companyAddress3 === 'undefined' || companyAddress3 === null ){
        companyAddress3="";
    }

    $.post( "controlador/ajax/updateCompany.php", { "companyID" : companyID,"compamnyName" : compamnyName,"firstCompanyName": firstCompanyName,
    "lastCompanyName":lastCompanyName,"companyAddress1":companyAddress1,"companyAddress2":companyAddress2,
    "companyAddress3":companyAddress3,"companyPhoneNumber":companyPhoneNumber,"companyType":companyType}, null, "text" )
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
            
        }
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
            result1=false;
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

        if (curStepBtn=="step-1" && isValid==true ){
            saveCustomerData();
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

    function saveCustomerData(){
        var firstCustomerName = $("input#firstCustomerName").val();
        var lastCustomerName = $("input#lastCustomerName").val();
        var emailValidation = $("input#emailValidation").val();
        var customerAddress = $("input#customerAddress").val();
        var customerCity = $("input#customerCity").val();
        var customerState = $("input#customerState").val();
        var customerZipCode = $("input#customerZipCode").val();
        var customerPhoneNumber = $("input#customerPhoneNumber").val();
    
        
        
        $.post( "controlador/ajax/insertCustomer.php", { "firstCustomerName" : firstCustomerName,"lastCustomerName": lastCustomerName,"emailValidation":emailValidation,
                                                        "customerAddress":customerAddress,"customerCity":customerCity,"customerState":customerState,
                                                    "customerZipCode":customerZipCode,"customerPhoneNumber":customerPhoneNumber}, null, "text" )
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
                    }
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( "La solicitud a fallado: " +  textStatus);
                        result=false;
                    }
                });
    }

    $(document).ready(function(){
        $('#firstNextBegin').hide();
        $('#zipCodeBegin').focusout(function(e) {
          
            var zipcode=$("input#zipCodeBegin").val();
            if (zipcode!==''){
                $.post( "controlador/ajax/getZipCode.php", { "zipcode" : zipcode}, null, "text" )
                .done(function( data, textStatus, jqXHR ) {
                    if ( console && console.log ) {
                        $("#answerEmailValidate").html(data);
                        var n = data.indexOf("Error");
                        if(n==-1){
                            $('#answerZipCode').html(data);
                            $('#firstNextBegin').show();
                            //result=true;
                        }else{
                            $('#answerZipCode').html(data);
                            $('#firstNextBegin').hide();
                            //result=false;
                        }
                        
                        console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                    }
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( "La solicitud a fallado: " +  textStatus);
                        result=false;
                    }
                });
            }                    
        });       
      });

   

      $(".btn-group > .btn").click(function(){
        $(".btn-group > .btn").removeClass("active");
        $(this).addClass("active");
    });


///////////////////////////////////////////////////////////////////////////////
//funtions for order

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
            isValid = true;
    
        $(".form-group").removeClass("has-error");
        
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (curStepBtn=="step-7" && isValid==true ){
            var valStep3=$('input[name=estep3Option]:checked').val();
            var valStep5=$('input[name=estep5Option]:checked').val();
            var valStep4=$('input[name=estep4Option]:checked').val();
            var valStep6=$('input[name=step6date]').val();
            var valStep6t=$('button[name=step6time].active').text();
            $('#step8RepairDescription').html(valStep3+', '+valStep5+' story'+', '+valStep4);
            $('#step8Schedule').html(valStep6);
            $('#step8Time').html(valStep6t);
               
        }
    
        
    
        
            if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
        
    });
    
    allPrevBtn.click(function () {
        
        var curStep = $(this).closest(".setup-contentOrder"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panelOrder div a[href="#' + curStepBtn + '"]').parent().prev().children("a"),
            curStepWizard = $('div.setup-panelOrder div a[href="#' + curStepBtn + '"]').parent().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;
    
        $(".form-group").removeClass("has-error");
        
        if (isValid) {
        
            nextStepWizard.removeAttr('disabled').trigger('click');
            curStepWizard.attr('disabled', 'disabled');
        
        }
    });
    
    $('div.setup-panelOrder div a.btn-success').trigger('click');
    });
 
/////////////////////////////////////////////////////////////////////////////