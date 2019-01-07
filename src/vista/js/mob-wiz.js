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

                                nextStepWizard = $('div.setup-panelOrder div a[href="#step-1"]').parent().next().children("a")
                                nextStepWizard.removeAttr('disabled').trigger('click');
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

