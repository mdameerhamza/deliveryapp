<?php
$con = mysqli_connect("localhost","root","","delivery");

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>

<?php
$drop_location = $_POST['drop'];
$curr = $_POST['current'];


?>
<!DOCTYPE html>
<html>
<head>
	<title>sdas</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<style>
#map {
  height: 70%;
}
#directions-panel{
  height: 30%;
  background: #20205d;
  color: white;
}

html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}
</style>
<body>
 <input type="hidden" id="start" value="<?php echo $curr; ?>">
 <input type="hidden" id="end" value="<?php echo $drop_location ?>">

 <div  class="col-md-8" id="map"></div>
 
 <div class="col-md-4" id="directions-panel">
 </div>
</body>



<script src="jquery-1.12.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript">

  $(document).ready(function() {
   
    navigator.geolocation.getCurrentPosition(onPositionUpdate);
});

  function onPositionUpdate(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
    $.ajax({
      url : "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCLZzq31lWF8Oo31xbFTqHchlmXIfzqeAI&latlng="+position.coords.latitude+","+position.coords.longitude+"&sensor=true",
      dataType : "json",
      success : function(data) {
       var area = data.results[2].formatted_address;
       $("#start").val(area);

     }
   });
  }

</script>

<script>


  let map = "";
  let infoWindow = "";

  let directionsService = "";
  let directionsDisplay = "";
  let lat = 31.510375800000002;
  let lng = 74.3395583;
  let zoom = 15;
  let image1 = "";
  let image2 = "";
  let marker = "";
  let icons = "";



  function initMap() {

    var rendOpts= {preserveViewport: true,suppressMarkers: true};
    directionsService = new google.maps.DirectionsService;
    directionsDisplay = new google.maps.DirectionsRenderer(rendOpts);
     image1='marker1.png';
     image2='marker2.png';

   
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: zoom,
      center: {lat: lat , lng: lng }
    });
    //debugger;
    directionsDisplay.setMap(map);
    

  } //initMap end

    function moveToLocation( lastlat, lastlng ){
    var center = new google.maps.LatLng(lastlat, lastlng);
    map.panTo(center);
                //debugger;

  }
    function get_data() {
      navigator.geolocation.getCurrentPosition(onPositionUpdate);
       calculateAndDisplayRoute(directionsService, directionsDisplay);
       
      }


    $(document).ready(function() {
      get_data()
      setInterval( get_data,4000);
    });

  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
      'Error: The Geolocation service failed.' :
      'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  }

  function calculateAndDisplayRoute(directionsService, directionsDisplay) {


    directionsService.route({
      origin: document.getElementById('start').value,
      destination: document.getElementById('end').value,
      optimizeWaypoints: true,
      provideRouteAlternatives: true,
      travelMode: 'DRIVING',


      // unitSystem: google.maps.UnitSystem.IMPERIAL
    }, function(response, status) {
          if (status === 'OK') {
            // lat = map.getCenter().lat();
            // lng = map.getCenter().lng();
            directionsDisplay.setDirections(response);
            // var center = new google.maps.LatLng(lastlat, lastlng);
            // map.panTo(center);
             //moveToLocation( lastlat, lastlng );
            //zoom =  map.getZoom();
            // map.setZoom(zoom);

            var route = response.routes[0];
            console.log(route);
     
          
            makeMarker( route.legs[0].start_location, image1, route.legs[0].start_address );
            makeMarker( route.legs[0].end_location, image2, route.legs[0].end_address );
            var summaryPanel = document.getElementById('directions-panel');
            summaryPanel.innerHTML = '';
            // For each route, display summary information.
            for (var i = 0; i < route.legs.length; i++) {
              var routeSegment = i + 1;
              summaryPanel.innerHTML += `<h2>Route Information:</h2><br><h3>FROM: `+route.legs[i].start_address + '<br> TO: '+route.legs[i].end_address + '<br> DISTANCE : '+route.legs[i].distance.text + '<br> DURATION : '+route.legs[i].duration.text + '</h3><br><br>';
            }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });



  }

  function makeMarker( position, icon, title ) {
    marker = new google.maps.Marker({
      position: position,
      map: map,
      icon: icon,
      title: title,
      draggable: true
  });
  // map.setZoom(18);
  // map.setCenter(marker.getPosition());

}





</script>
<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCLZzq31lWF8Oo31xbFTqHchlmXIfzqeAI&libraries=places&callback=initMap"
async defer>
</script>
</html>

