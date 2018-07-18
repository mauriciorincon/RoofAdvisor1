var handler = StripeCheckout.configure({
    
    key: 'pk_test_iubKDaao3vNKYYrr45bJPUOl',
    image: 'img/logo.png',
    locale: 'auto',
    token: function(token) {
        var http = new XMLHttpRequest();
        var url = "?controller=paying&accion=setPaying";
        var params = JSON.stringify({ stripeToken : token.id,stripeEmail:token.email });
        //var params = "stripeToken="+token.id+"&"+"stripeEmail="+token.email;
        
        http.open("POST", url, true);

        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        //http.setRequestHeader("Content-type", "application/json; charset=utf-8");
        //http.setRequestHeader("Content-length", params.length);
        //http.setRequestHeader("Connection", "close");

        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                var objStripe=jQuery.parseJSON(http.responseText);
                if(objStripe.message=='Payment complete.'){
                    insertOrderCustomer(objStripe.id);
                }else{

                }
                
                //alert(http.responseText);
            }
        }
        http.send("param="+params);

        /*$.post( "controlador/ajax/getDataOrder.php", { "stripeToken" : token.id,"stripeEmail":token.email}, null, "text" )
        .done(function( data, textStatus, jqXHR ) {
        if ( console && console.log ) {
            console.log(data);
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
                result1=false;
                jsRemoveWindowLoad('');
                return result1;
            }
        });*/
      
    }
  });
  
  document.getElementById('customButton').addEventListener('click', function(e) {
    // Open Checkout with further options:
    handler.open({
      name: 'RoofAdvisorz',
      description: 'pay your service',
      amount: 2000
    });
    e.preventDefault();
  });
  
  // Close Checkout on page navigation:
  window.addEventListener('popstate', function() {
    handler.close();
  });