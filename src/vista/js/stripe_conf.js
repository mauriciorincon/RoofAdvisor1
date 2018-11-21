var handler = StripeCheckout.configure({
    key: public_key,
    //key: 'pk_test_iubKDaao3vNKYYrr45bJPUOl',
    image: 'img/stripe-logo.png',
    locale: 'auto',
    token: function(token) {
        var http = new XMLHttpRequest();
        //////////////////////////////////////////////////////
        //Production
        var url = "?controller=paying&accion=setPaying";
        /////////////////////////////////////////////////////
        //test 
        //var url = "http://localhost/RoofAdvisor1/index.php?controller=paying&accion=setPaying";


        var params = JSON.stringify({ stripeToken : token.id,stripeEmail:token.email,totalAmount: amount_value});
        //var params = "stripeToken="+token.id+"&"+"stripeEmail="+token.email;
        
        http.open("POST", url, true);

        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        jsShowWindowLoad('');

        //http.setRequestHeader("Content-type", "application/json; charset=utf-8");
        //http.setRequestHeader("Content-length", params.length);
        //http.setRequestHeader("Connection", "close");

        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                try {
                    var objStripe=jQuery.parseJSON(http.responseText);
                    if(objStripe.message=='Payment complete.'){
                        if(action_type=="pay_emergency_service"){
                            jsRemoveWindowLoad('');
                            insertOrderCustomer(objStripe.id,(amount_value));
                        }else if(action_type=="pay_company_roofreport"){
                            jsRemoveWindowLoad('');
                            insertOrderRoofReport(objStripe.id,(amount_value));
                        }else if(action_type=="pay_invoice_service"){
                            jsRemoveWindowLoad('');
                            payOnlineInvoce(objStripe.id,(amount_value));
                        }else if(action_type=="pay_postcard_service"){
                            jsRemoveWindowLoad('');
                            payOnlineInvocePostCard(objStripe.id,(amount_value));
                        }
                        
                    }else{
                        console.log(http.responseText);
                    }
                } catch (error) {
                    console.log(http.responseText);
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
      name: 'RoofServicenow',
      description: 'Agree to Initiate Service',
      amount: amount_value,
      email: email_user_logued
    });
    e.preventDefault();
  });
  
  // Close Checkout on page navigation:
  window.addEventListener('popstate', function() {
    handler.close();
  });
