<?php
// Check if movieID is set in the URL
if (isset($_GET['movieID'])) {
    $movieID = $_GET['movieID'];

    $url = "http://localhost/project/indexdetailAPI.php?movieID=" . $movieID;

    $client = curl_init($url);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($client);
    $result = json_decode($response);

    echo '<a href="indexclient.php" class="btn btn-primary mt-3">Back to Movie Dashboard</a>';

    // Check if $result is not null and is an array or object
    if ($result !== null && (is_array($result) || is_object($result))) {
        // Display existing table
        echo '<h2>Movie Details</h2>';
        echo '<table class="table table-bordered table-striped">';
        echo "<tr>
                    <th>Location Name</th>
                <th>Movie ID</th>
                <th>Actions</th>
                <th>Weather</th>
            </tr>";

        // Display retrieved records by array
        foreach ($result as $x => $val) {
            // Use the Google Maps Geocoding API to get latitude and longitude based on locationName
            $locationCoordinates = getLocationCoordinates($val->locationName);

            echo "<tr>";
            echo "<td>" . ($val->locationName ?? '') . "</td>";
            echo "<td>" . ($val->movieID ?? '') . "</td>";
            echo "<td>
                    <a href='http://localhost/project/indexdetailclient.php?movieID=" . ($val->movieID ?? '') . "&lat=" . $locationCoordinates['lat'] . "&lng=" . $locationCoordinates['lng'] . "&locationName=" . urlencode($val->locationName) . "' class='btn btn-info btn-sm'>Details and Map</a>
                </td>";
            echo "<td>";
            echo "<button onclick=\"showWeather('{$val->locationName}', {$locationCoordinates['lat']}, {$locationCoordinates['lng']})\" class='btn btn-secondary'>Show Weather</button>";
            echo "<div id='weather-{$val->locationName}' class='weather-container'></div>";
            echo "</td>";
            echo "</tr>";

            // Call the function to calculate and display directions with recommendation
            echo "<script>";
            echo "calculateAndDisplayDirections(new google.maps.LatLng({$locationCoordinates['lat']}, {$locationCoordinates['lng']}));";
            echo "</script>";
        }
        echo "</table>";

        // Display the JSON response
        echo '<h2>JSON Response</h2>';
        echo '<pre>';
        echo json_encode($result, JSON_PRETTY_PRINT);
        echo '</pre>';
    } else {
        echo "No movie records found.";
    }
} else {
    echo "Movie ID is not set.";
}

// Function to get latitude and longitude based on locationName using Google Maps Geocoding API
function getLocationCoordinates($locationName) {
    $apiKey = "AIzaSyAeUOWcoif1SDM3L9EuNkn5qHs070bKQPQ";
    $locationNameEncoded = urlencode($locationName);

    $geocodeUrl = "https://maps.googleapis.com/maps/api/geocode/json?address={$locationNameEncoded}&key={$apiKey}";
    $geocodeResponse = file_get_contents($geocodeUrl);
    $geocodeData = json_decode($geocodeResponse, true);

    if ($geocodeData && isset($geocodeData['results'][0]['geometry']['location'])) {
        return $geocodeData['results'][0]['geometry']['location'];
    }

    return array('lat' => 0, 'lng' => 0); // Default coordinates if geocoding fails
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Show Map</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include the Google Maps API script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeUOWcoif1SDM3L9EuNkn5qHs070bKQPQ&libraries=places&callback=initMap" async defer></script>
    <style>
        /* Add your custom styles here */
        body {
            padding-top: 60px; /* Adjust based on the height of your navbar */
        }

        #map {
            height: 400px;
            border: 1px solid #ddd; /* Add a border for separation */
            margin-bottom: 20px;
        }

        .weather-container {
            display: none;
            margin-top: 10px;
        }

        #recommendation,
        #distance {
            margin-top: 20px;
        }
    </style>
    <script>
        // Initialize the map with the provided latitude and longitude
        function initMap() {
            var location = {lat: <?php echo $_GET['lat'] ?? 6.431968; ?>, lng: <?php echo $_GET['lng'] ?? 100.434582; ?>};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: location
            });
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }

        // Function to show weather for a specific location
        function showWeather(locationName, latitude, longitude) {
            var weatherDiv = document.getElementById('weather-' + locationName);
            var weatherContainer = document.querySelector('.weather-container');

            // Fetch weather information
            fetch('weather.php?lat=' + latitude + '&lng=' + longitude)
                .then(response => response.json())
                .then(weatherData => {
                    if (weatherData) {
                        var temperature = weatherData.main.temp;

                        // Display weather information
                        weatherDiv.innerHTML = "<h4>Weather in " + locationName + "</h4>" +
                            "<p>Temperature: " + temperature + " °C</p>" +
                            "<p>Humidity: " + weatherData.main.humidity + "%</p>" +
                            "<p>Weather: " + weatherData.weather[0].description + "</p>" +
                            "<p>Wind Speed: " + weatherData.wind.speed + " m/s</p>";

                        // Show the weather information div
                        weatherContainer.style.display = 'block';

                        // Make a recommendation based on temperature
                        var recommendation = provideWeatherRecommendation(temperature);
                        weatherDiv.innerHTML += "<p>Recommendation: " + recommendation + "</p>";
                    } else {
                        weatherDiv.innerHTML = "<p>Weather information not available.</p>";
                    }
                })
                .catch(error => {
                    console.error('Error fetching weather data:', error);
                    weatherDiv.innerHTML = "<p>Unable to fetch weather information.</p>";
                });
        }

        // Function to provide weather-based recommendation
        function provideWeatherRecommendation(temperature) {
            var recommendation = "";

            if (temperature > 30) {
                recommendation = "It's a hot day. Consider dressing lightly and stay hydrated.";
            } else if (temperature < 10) {
                recommendation = "It's quite cold. Dress warmly and consider bringing extra layers.";
            } else {
                recommendation = "The weather seems suitable for a visit. Enjoy your time!";
            }

            return recommendation;
        }

        // Function to hide weather information
        function hideWeather() {
            var weatherContainer = document.querySelector('.weather-container');
            weatherContainer.style.display = 'none';
        }

        // Function to calculate and display directions with recommendation
        function calculateAndDisplayDirections(destination) {
            var uitmArau = new google.maps.LatLng(6.4521, 100.2778);

            var request = {
                origin: uitmArau,
                destination: destination,
                travelMode: google.maps.TravelMode.DRIVING
            };

            directionsService.route(request, function (result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(result);

                    // Get distance in meters
                    var distance = result.routes[0].legs[0].distance.value;

                    // Convert distance to kilometers
                    var distanceInKm = distance / 1000;

                    // Recommendation based on distance
                    var recommendationDiv = document.getElementById('recommendation');
                    if (distanceInKm < 10) {
                        recommendationDiv.innerHTML = "<p>Short distance. You can consider walking or cycling.</p>";
                    } else if (distanceInKm >= 10 && distanceInKm < 50) {
                        recommendationDiv.innerHTML = "<p>Moderate distance. Consider taking a car or public transportation.</p>";
                    } else {
                        recommendationDiv.innerHTML = "<p>Long distance. It's recommended to use a car or other transportation.</p>";
                    }

                    // Display distance information
                    var distanceDiv = document.getElementById('distance');
                    distanceDiv.innerHTML = `<h3 class="mt-4">Distance from UiTM Arau</h3>
                                             <p class="lead">${distanceInKm.toFixed(2)} km</p>`;
                } else if (status == google.maps.DirectionsStatus.ZERO_RESULTS) {
                    var distanceDiv = document.getElementById('distance');
                    distanceDiv.innerHTML = `<p>No route available for this location.</p>`;
                } else {
                    alert('Error calculating directions: ' + status);
                }
            });
        }

        // Function to show distance when the button is clicked
        function showDistance() {
            var location = {lat: <?php echo $_GET['lat'] ?? 6.431968; ?>, lng: <?php echo $_GET['lng'] ?? 100.434582; ?>};
            var destination = new google.maps.LatLng(location.lat, location.lng);

            calculateAndDisplayDirections(destination);
        }
    </script>
</head>
<body>
    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="indexclient.php">Movie Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Add your navbar items here if needed -->
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h1>Map</h1>
                <div id="map"></div>
            </div>
            <div class="col-md-4">
                <div class="weather-container mt-3">
                    <button onclick="hideWeather()" class="btn btn-secondary">Hide Weather</button>
                    <button onclick="showDistance()" class="btn btn-primary mt-2">Show Distance</button>
                    <div id='distance'></div>
                    <div id='recommendation'></div>
                    <div id="weather-<?php echo $_GET['locationName'] ?? ''; ?>"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and Popper.js scripts at the end of the body -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
