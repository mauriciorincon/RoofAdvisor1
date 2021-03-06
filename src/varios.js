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
             console.log("no tiene desabilitado");
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
    
        $(".form-group").removeClass("has-error");
        
        isValid=validInputPassword()
        isValid=validInputRePassword();
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }
        
    
        if (curStepBtn=="step-2" && isValid==true ){
            saveContractorData();
        }
    
        if (curStepBtn=="step-3" && isValid==true ){
            //isValid=false;
            isValid=validateCodeEmail('Company');
        }
    
        if(curStepBtn!="step-3"){
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
};

function saveContractorData(){
    var companyNameField = $("input#companyName").val();
    var firstNameField = $("input#firstNameCompany").val();
    var lastNameField = $("input#lastNameCompany").val();
    var phoneContactField = $("input#phoneContactCompany").val();
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
    $('select[name^="driverStatus"]').each(function() {
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
                        $("#step3ContractorResponse").addClass("has-success").removeClass('has-error');
                        //$("#firstNextValidation").show();
                        $("#step3ContractorResponse").html(data);
                        result=true;
                    }else{
                        $("#step3ContractorResponse").addClass("has-error").removeClass('has-success');
                        //$("#firstNextValidation").hide();
                        $("#step3ContractorResponse").html(data);
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

    jsShowWindowLoad('');
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


$(".inactivate-contractor-button").click(function(){
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
});


/*function insertDriver(){
    var companyID = $("input#companyID").val();
    var contractorFirstName = $("input#ContNameFirstIn").val();
    var contractorLastName = $("input#ContNameLastIn").val();
    var contractorPhoneNumber = $("input#ContPhoneNumIn").val();
    var contractorLinceseNumber = $("input#ContLicenseNumIn").val();
    var contractorState = $("select#ContStatusIn").val();

    jsShowWindowLoad('');
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

}*/

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
    jsShowWindowLoad('');
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
        var customerState = $("input#customerState").val();
        var customerZipCode = $("input#customerZipCode").val();
        var customerPhoneNumber = $("input#customerPhoneNumber").val();
        var password=$('input:password#inputPassword').val();
        var Repassword=$('input:password#inputPasswordConfirm').val();

        
        if(p_pantalla=="Order"){
            var flag=true;
            var ListTextBox=$("#step6RegisterCustomerOrder").find("input");
            for (var i = 0; i < ListTextBox.length; i++) {
                if (!ListTextBox[i].validity.valid) {
                    flag = false;
                    $(ListTextBox[i]).closest(".form-group").addClass("has-error").removeClass("has-success");
                }
            }
            if(password.length<6){
                flag = false;
            }
            if(Repassword.length<6){
                flag = false;
            }
            if(password!=Repassword){
                flag = false;
            }
            if (flag==false){
                alert('Please fill all fields to continue with register');
                return;
            }

        }
        jsShowWindowLoad('');
        $.post( "controlador/ajax/insertCustomer.php", { "firstCustomerName" : firstCustomerName,"lastCustomerName": lastCustomerName,"emailValidation":emailValidation,
                                                        "customerAddress":customerAddress,"customerCity":customerCity,"customerState":customerState,
                                                    "customerZipCode":customerZipCode,"customerPhoneNumber":customerPhoneNumber,"password":password}, null, "text" )
                .done(function( data, textStatus, jqXHR ) {
                    if ( console && console.log ) {
                        $("#validatingMessajeCode").html(data);
                        var n = data.indexOf("Error");
                        if(n==-1){
                            if(p_pantalla=="Order"){
                                $('#headerTextAnswerOrder').html('Mail Verification');
                                $('#textAnswerOrder').html(data+', and clic the link to activate your acount, after that please click finish button');
                                $('#buttonAnswerOrder').html('<br><br><button type="button" class="btn btn-default" data-dismiss="modal" onclick="insertOrderCustomer()">Finish</button><br><br>');
                                $('#myModalRespuesta').modal({backdrop: 'static'});
                            }
                            //$("#firstNextValidation").show();
                            result=true;
                        }else{
                            
                            $('#textAnswerOrder').html(data);
                            $('#headerTextAnswerOrder').html('Error');
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
                            }else{
                                $('#firstNextBegin').hide(); 
                            }
                        }else{
                            $('#answerZipCode').html(data);
                            $('#firstNextBegin').hide();
                        }
                        
                        console.log( "La solicitud se ha completado correctamente."+data+textStatus);
                    }
                    //$('#loading').html('');
                    jsRemoveWindowLoad();
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

$('#step7ListCompany').on('click', 'a', function(){
    $("#step7ListCompany a").removeClass("active");
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

        if(curStepBtn=="step-2"  && isValid==true ){
            
        }
        if(curStepBtn=="step-3"  && isValid==true ){
            var address=$('#step5Address').val();
            if (address==''){
                isValid=false;
                $('#headerTextAnswerOrder').html('Step 3');
                $('#textAnswerOrder').html('Plese select the address for the service');
                $('#myModalRespuesta').modal({backdrop: 'static'});
            }else{
                var RequestType=$("input:radio[name='typeServiceOrder']:checked").val();
                if(RequestType=='E'){
                    nextStepWizard = $('div.setup-panelOrder div a[href="#step-5"]').parent().next().children("a");
                    var valStep3=$('input[name=estep3Option]:checked').val();
                    var valStep5=$('input[name=estep5Option]:checked').val();
                    var valStep4=$('input[name=estep4Option]:checked').val();
                    var valStep6=$('input[name=step6date]').val();
                    var valStep6t=$('button[name=step6time].active').text();
                    var valStep7=$('a[name=linkCompany].active > span[name=companyName]').text();
                    var valStep5long=$('input:hidden[name=step5Logintud]').val();
                    var valStep5lat=$('input:hidden[name=step5Latitude]').val();
                    var valStep5Address=$('input:hidden[name=step5Address]').val();
                    var valStep5ZipCode=$('input:hidden[name=step5ZipCode]').val();
                    $('#step8RepairDescription').html(valStep3+', Stories:'+valStep5+' '+', '+valStep4);
                    $('#step8Schedule').html('Defined by the administrator');
                    $('#step8Time').html('Defined by the administrator');
                    $('#step8CompanyName').html('Defined by the administrator');
                    $('#step8Longitude').html(valStep5long);
                    $('#step8Latitude').html(valStep5lat);
                    $('#step8Address').html(valStep5Address);
                    $('#step8ZipCode').html(valStep5ZipCode);

                }
            }
            

        }    
        if(curStepBtn=="step-4"  && isValid==true ){
            var fecha=$('input[name=step6date]').val();
            var hora=$('button[name=step6time].active').text();
            if(fecha=="" || hora==""){
                $('#headerTextAnswerOrder').html('Step 4');
                $('#textAnswerOrder').html('Plese select the date and time for the service');
                $('#myModalRespuesta').modal({backdrop: 'static'});
                isValid=false;
            }else{
                getListCompany(); 
            }
            
        }

        if (curStepBtn=="step-5" && isValid==true ){
            var valStep3=$('input[name=estep3Option]:checked').val();
            var valStep5=$('input[name=estep5Option]:checked').val();
            var valStep4=$('input[name=estep4Option]:checked').val();
            var valStep6=$('input[name=step6date]').val();
            var valStep6t=$('button[name=step6time].active').text();
            var valStep7=$('a[name=linkCompany].active > span[name=companyName]').text();
            var valStep5long=$('input:hidden[name=step5Logintud]').val();
            var valStep5lat=$('input:hidden[name=step5Latitude]').val();
            var valStep5Address=$('input:hidden[name=step5Address]').val();
            var valStep5ZipCode=$('input:hidden[name=step5ZipCode]').val();
            if(valStep7==""){
                isValid=false;
                $('#headerTextAnswerOrder').html('Step 4');
                $('#textAnswerOrder').html('Plese select the contractor for your service');
                $('#myModalRespuesta').modal({backdrop: 'static'});
            }else{
                $('#step8RepairDescription').html(valStep3+', Stories: '+valStep5+''+', '+valStep4);
                $('#step8Schedule').html(valStep6);
                $('#step8Time').html(valStep6t);
                $('#step8CompanyName').html(valStep7);
                $('#step8Longitude').html(valStep5long);
                $('#step8Latitude').html(valStep5lat);
                $('#step8Address').html(valStep5Address);
                $('#step8ZipCode').html(valStep5ZipCode);
            }
        }

        if (curStepBtn=="step-6" && isValid==true ){
            validateIsLoggedIn();
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

function getListCompany(){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getListContractor.php", { }, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            $('#step7ListCompany').html(data);
            console.log( "La solicitud se ha completado correctamente."+data+textStatus);
        }
        jsRemoveWindowLoad();
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
                

                if(n==-1){
                    $('#textAnswerOrder').html(data+'');
                    $('#buttonAnswerOrder').html('<br><br><button type="button" class="btn btn-default" data-dismiss="modal" onclick="insertOrderCustomer()">Finish</button><br><br>');

                    $('#headerTextAnswerOrder').html('Success');
                  
                    $("#answerValidateUserOrder").html('<div class="alert alert-success"><strong>'+data+'</strong></div>');
                    $('#lastFinishButtonOrder').show();
                    $('#myModalRespuesta').modal({backdrop: 'static'});
                    var p1 = data.indexOf("[");
                    var p2 = data.indexOf("]");
                    var userName=data.substring(p1+1,p2)
                    $('span#labelUserLoggedIn').html(userName);
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

function insertOrderCustomer(){
    var RepZIP=$('#zipCodeBegin').val();
    var RequestType=$("input:radio[name='typeServiceOrder']:checked").val();
    var Rtype=$("input:radio[name='estep3Option']:checked").val();
    var Water=$("input:radio[name='estep4Option']:checked").val();
    var Hlevels=$("input:radio[name='estep5Option']:checked").val();
    var ActAmtTime=$("input[name='step6date']").val();
    var ActTime=$("button[name='step6time'].active").text();
    var ContractorID=$('a[name=linkCompany].active > input:hidden[name=idContractor]').val();
    var email=$('input#emailValidation').val();
    var password=$('input#inputPassword').val();
    var latitude=$('input:hidden[name=step5Latitude]').val();
    var longitude=$('input:hidden[name=step5Logintud]').val();
    var address=$('input:hidden[name=step5Address]').val();

    
    //                var valStep5ZipCode=$('input:hidden[name=step5ZipCode]').val();
    jsShowWindowLoad('');
    $.post( "controlador/ajax/insertOrder.php", {"RepZIP":RepZIP,"RequestType":RequestType,"Rtype":Rtype,"Water":Water,"Hlevels":Hlevels,
                                                "ActAmtTime":ActAmtTime,"ActTime":ActTime,"ContractorID":ContractorID,"email":email,
                                                "password":password,"Latitude":latitude,"Longitude":longitude,"Address":address}, null, "text" )
    .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            
            var n = data.indexOf("Error");
            

            if(n==-1){
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
    jsShowWindowLoad('');
    $.post( "controlador/ajax/validateLoggedIn.php", {}, null, "text" )
        .done(function( data, textStatus, jqXHR ) {
            if ( console && console.log ) {
                
                var n = data.indexOf("Error");
                

                if(n==-1){
                    $('#textAnswerOrder').html(data+'');
                    $('#buttonAnswerOrder').html('<br><br><button type="button" class="btn btn-default" data-dismiss="modal" onclick="insertOrderCustomer()">Finish</button><br><br>');

                    $('#headerTextAnswerOrder').html('Success');
                  
                    $("#answerValidateUserOrder").html('<div class="alert alert-success"><strong>'+data+'</strong></div>');
                    $('#lastFinishButtonOrder').show();
                    $('#myModalRespuesta').modal({backdrop: 'static'});
                }else{
                    $('#textAnswerOrder').html('You are not logged in, please log in or register');
                    $('#headerTextAnswerOrder').html('Error');
                    $("#answerValidateUserOrder").html('<div class="alert alert-danger"><strong>'+'You are not logged in, please log in or register'+'</strong></div>');
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
                jsRemoveWindowLoad('');
            }
        });
}

function validInputPassword(objeto){
    var password = "";
    if(objeto!=undefined){
        password = $(objeto).val();
    }else{
        var password=$('input:password#inputPassword').val();
        objeto = $('input:password#inputPassword');
    }
    
    var flag=true;
    if(password.length<6){
        $(objeto).closest(".form-group").addClass("has-error").removeClass("has-success");
        $('#answerPasswordValidateStep6').html('The password must have at least 6 chararters');
        flag=false;
    }else{
        $(objeto).closest(".form-group").addClass("has-success").removeClass("has-error");
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
            $('#answerRePasswordValidateStep6').html('The comfirmation password are different');
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
    jsShowWindowLoad('');
    $.post( "controlador/ajax/validateUser.php", { "userClientOrder" : user,"passwordClientOrder":password}, null, "text" )
        .done(function( data, textStatus, jqXHR ) {
            if ( console && console.log ) {
                var n = data.indexOf("Error");
                
                if(n==-1){
                    window.location.href = "";
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
                jsRemoveWindowLoad('');
            }
        });
}

function showRatings(contractorID){
    jsShowWindowLoad('');
    $.post( "controlador/ajax/getListRating.php", {"id_contractor":contractorID }, null, "text" )
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
    if (mensaje === undefined) mensaje = "Procesando la información<br>Espere por favor";
 
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


function refreshCalendar(pmonth,pyear){
    if (pmonth==undefined){
        var month=$('#monthCalendar').val();
    }else{
        var month=pmonth;
    }
    if(pyear==undefined){
        var year=$('#yearCalendar').val();
    }else{
        var year=pyear;
    }

    

    jsShowWindowLoad('');
    $.post( "controlador/ajax/getCalendar.php", {"month":month,"year":year }, null, "text" )
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

$( function() {
    
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
