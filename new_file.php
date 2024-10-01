<?php
$con = mysqli_connect("localhost","root","","delivery");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
<form action="newmap.php" method="POST" target="_blank">
  <input type="hidden" name="current" id="current" value="">
Enter your starting address:
  <select name="drop">
    <option>Drop Off Location</option>
    <?php
      $sql = "SELECT * FROM deliveries";
      $run = mysqli_query($con,$sql);
      while($row = mysqli_fetch_array($run)){
        $name = $row['dvl_drop'];
        ?>
        <option value="<?php echo $name ?>"><?php echo $name ?></option>
        <?php 
      }
     ?>
  </select>
<input type="submit" value="get directions" />
</form>

<script src="jquery-1.12.4.min.js"></script>


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
             $("#current").val(area);
        }
    });
}

</script>