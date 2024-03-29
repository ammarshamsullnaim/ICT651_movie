<?php
if (isset($_GET['lat']) && isset($_GET['lng'])) {
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Show Map</title>
    <!-- Include the Google Maps API script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIza****&libraries=places&callback=initMap" async defer></script>
    <script>
        // Initialize the map with the provided latitude and longitude
        function initMap() {
            var location = {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: location
            });
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }
    </script>
</head>
<body>
    <h1>Map</h1>
    <div id="map" style="height: 400px;"></div>
</body>
</html>
<?php
} else {
    echo "Latitude and/or Longitude not provided.";
}
?>
