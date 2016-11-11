<?php


$dbhost = 'localhost';
$dbuser = 'shubhagr_retina';
$dbpass = 'anveshan_doda';
$dbname = 'shubhagr_agvdata';
$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$conn){

die(mysqli_error());

}



if(isset($_GET['lati'])&&isset($_GET['longi'])&&isset($_GET['speed'])&&isset($_GET['heading'])&&isset($_GET['gearposition'])&&isset($_GET['brakeposition'])&&isset($_GET['mode'])){


$lati    = $_GET['lati'];
$longi   = $_GET['longi'];
$speed = $_GET['speed'];
$heading    = $_GET['heading'];
$gearposition   = $_GET['gearposition'];
$brakeposition   = $_GET['brakeposition'];
$mode   = $_GET['mode'];

$sql = "INSERT INTO variables_data (lati, longi, speed, heading, gearposition, brakeposition, mode) VALUES ($lati, $longi, $speed, $heading, $gearposition, $brakeposition, $mode)";


if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
    echo "Current Latitude : " . $lati . "Current Longitude :" . $longi ."Current Speed :" . $speed . "Current Heading :" . $heading . "Gear Position :" . $gearposition ."Brake Status :" . $brakeposition . "Mode :" . $mode . " | ";
} else {
    echo "no record created : " . $sql . "<br>" . mysqli_error($conn);
}


}
else
{
 $sql = "  SELECT id, lati ,longi FROM variables_data ORDER BY id DESC LIMIT 1";

$result = $conn->query($sql);
if ($result->num_rows>0)
{
    while ($row = $result->fetch_assoc())
{

echo " latitude: " . $row["lati"] . " | longitude: " . $row["longi"];
}

}
}

?>

<html>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDSBgT0i8uM-pk8J62gon4jwkHpn14dT0&callback=initMap" type="text/javascript"></script>

<script type="text/javascript">

var customIcons = {
      restaurant: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
      },
      bar: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
      }
    };



function myMap() {
  var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(22.316273, 87.306028),
        zoom: 13,
        mapTypeId: 'roadmap'
      });
  var point = new google.maps.LatLng(
              parseFloat($CLat),
              parseFloat($CLong));

  var icon = customIcons[restaurant] || {};

  var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });

  var icon = customIcons[bar] || {};

  var point = new google.maps.LatLng(
              parseFloat($TLat),
              parseFloat($TLong));

  var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });


}
</script>
<head>
<meta http-equiv="refresh" contents="5" >
</head>
<body onload="myMap()">

<h1>            AGV data  : Google Maps</h1>

<div id="map" style="width:100%;height:500px"></div>


</body>
</html>
