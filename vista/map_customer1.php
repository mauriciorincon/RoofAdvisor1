<!DOCTYPE html>
<html>
  <head>
  

  <script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>
    
    <style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 500px;  /* The width is the width of the web page */
       }
    </style>

  </head>
  <body>
  <div id="map"></div>
    <script>
// Initialize and add the map
        function initMap() {
        // The location of Uluru
        var uluru = {lat: 27, lng: -81};
        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 6, center: uluru});
        // The marker, positioned at Uluru
        //var marker = new google.maps.Marker({position: uluru, map: map});
        var marker="";
            /*var ref = firebase.app().database().ref("Orders");
                ref.once('value')
                .then(function (snap) {
                    datos=snap.val();
                    for(k in datos){
                        fila=datos[k];
                        pos={lat:parseFloat(fila.Latitude),lng:parseFloat(fila.Longitude)};
                        marker = new google.maps.Marker({position: pos, map: map});
                    }
                
                
                console.log('snap.val()', snap.val());
                });*/

                var ref = firebase.database().ref("Orders");
                    ref.orderByChild("CustomerID").equalTo("10").once("value", function(snapshot) {

                        datos=snapshot.val();
                                for(k in datos){
                                    fila=datos[k];
                                    pos={lat:parseFloat(fila.Latitude),lng:parseFloat(fila.Longitude)};
                                    marker = new google.maps.Marker({position: pos, map: map});
                                }

                    console.log(snapshot.val());
                    
                    });
        }
    </script>

    <script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyB5HnjwLpr-WqknpRRU5WhrHCg6feVaYss",
        authDomain: "pruebabasedatos-eacf6.firebaseapp.com",
        databaseURL: "https://pruebabasedatos-eacf6.firebaseio.com",
        projectId: "pruebabasedatos-eacf6",
        storageBucket: "pruebabasedatos-eacf6.appspot.com",
        messagingSenderId: "120748340913"
    };
    firebase.initializeApp(config);
    //const dbRef = firebase.database().ref();
    //const usersRef = dbRef.child('Orders');

    
    /*var ref = firebase.database().ref("Orders");
        
            ref.on('value',function(snapshot){
                snapshot.forEach(function(childSnapshot){
                    var childData=childSnapshot.val();
                });
            });*/

    </script>


    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&libraries=visualization&callback=initMap">
    </script>



  </body>
</html>


