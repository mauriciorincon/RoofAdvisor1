$(document).ready(function(){
        $('#mobzipCodeBegin').keyup(function(e) {
            if(this.value.length!=5){
                return;
            }
            var mobzipcode=$("input#mobzipCodeBegin").val();
            if (mobzipcode!==''){
               // jsShowWindowLoad('Verifing ZipCode');
                $.post( "controlador/ajax/getZipCode.php", { "zipcode" : mobzipcode}, null, "text" )
                .done(function( data, textStatus, jqXHR ) {
                    if ( console && console.log ) {
                        var n = data.indexOf("Error");
                      if(n==-1){
                            $('#mobanswerZipCode').html(data);
                            if (data.indexOf("Sorry")==-1){
                                setLocation(map,zipcode);

                                nextStepWizard = ;
                                nextStepWizard.removeAttr('disabled').trigger('click');
                            }else{
                                setLocation(map,zipcode);
                            }
                        }else{
                            $('#mobanswerZipCode').html(data);
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

