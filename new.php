<?php
$con = mysqli_connect("localhost","root","","delivery");

// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
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
  height: 100%;
}
#directions-panel{
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
<script type="text/javascript">
  function initMap() {
  var myLatlng = {lat: -25.363, lng: 131.044};

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 4,
    center: myLatlng
  });

  var marker = new google.maps.Marker({
    position: myLatlng,
    map: map,
    title: 'Click to zoom'
  });

  map.addListener('center_changed', function() {
    // 3 seconds after the center of the map has changed, pan back to the
    // marker.
    window.setTimeout(function() {
      map.panTo(marker.getPosition());
    }, 3000);
  });

  marker.addListener('click', function() {
    map.setZoom(8);
    map.setCenter(marker.getPosition());
  });
}
</script>
<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCLZzq31lWF8Oo31xbFTqHchlmXIfzqeAI&libraries=places&callback=initMap"
async defer>
</script>