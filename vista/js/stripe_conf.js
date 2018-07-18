var handler = StripeCheckout.configure({
    key: public_key,
    //key: 'pk_test_iubKDaao3vNKYYrr45bJPUOl',
    image: 'img/logo.png',
    locale: 'auto',
    token: function(token) {
        var http = new XMLHttpRequest();
        var url = "?controller=paying&accion=setPaying";
        var params = JSON.stringify({ stripeToken : token.id,stripeEmail:token.email,totalAmount: amount_value});
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

        
      
    }
  });
  
  document.getElementById('customButton').addEventListener('click', function(e) {
    // Open Checkout with further options:
    handler.open({
      name: 'RoofAdvisorz',
      description: 'pay your service',
      amount: amount_value
    });
    e.preventDefault();
  });
  
  // Close Checkout on page navigation:
  window.addEventListener('popstate', function() {
    handler.close();
  });