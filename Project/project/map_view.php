<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mapping the Magic</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        #map {
            height: 100vh;
            width: 100%;
            border-radius: 10px;
        }

        .container {
            margin-top: 20px;
        }

        .card {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Mapping the Magic</a>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div id="map"></div>
            </div>
            <div class="col-md-4">
                <!-- Search Card -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Search Location</h5>
                        <label for="movieSelect">Select Movie:</label>
                        <select class="form-control" id="movieSelect" onchange="updateLocations()">
                            <option value="harryPotter">Harry Potter</option>
                            <option value="spiderMan">The Amazing Spider-Man</option>
                            <option value="trainToBusan">Train to Busan</option>
                        </select><br>
                        
                        <label for="locationInput">Select Location:</label>
                        <select class="form-control" id="locationInput"></select><br>

                        <!-- Add Date Input -->
                        <label for="dateInput">Select Date:</label>
                        <input type="date" class="form-control" id="dateInput"><br>

                        <button class="btn btn-primary" onclick="searchLocation()">Search</button>
                    </div>
                </div>

                <!-- Weather Card -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Weather Information</h5>
                        <div id="weatherInfo"></div>
                    </div>
                </div>

                <!-- Historical Weather Card -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Historical Weather Information</h5>
                        <div id="historicalWeatherInfo"></div>
                    </div>
                </div>

                <!-- Nearby Attractions Card -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nearby Attractions</h5>
                        <div id="nearbyAttractions"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Google Maps API -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeUOWcoif1SDM3L9EuNkn5qHs070bKQPQ&callback=getData"></script>

    <!-- OpenWeatherMap API -->
    <script>
        const openWeatherMapApiKey = "cae0de8f8001bb6a51ff2848923f6f3a";

        function getWeather(latitude, longitude) {
            const apiUrl = `https://api.openweathermap.org/data/2.5/weather?lat=${latitude}&lon=${longitude}&appid=${openWeatherMapApiKey}`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    // Convert temperature from Kelvin to Celsius
                    const temperatureCelsius = data.main.temp - 273.15;

                    // Display weather information
                    const weatherInfo = document.getElementById("weatherInfo");
                    weatherInfo.innerHTML = `
                        Temperature: ${temperatureCelsius.toFixed(2)} &#8451;<br>
                        Weather: ${data.weather[0].description}
                    `;
                })
                .catch(error => console.error("Error fetching weather data:", error));
        }
    </script>

    <!-- Visual Crossing Weather API -->
    <script>
        const visualCrossingApiKey = "CAAK4QQ5853YH38R56S7JY3JT";

        function getHistoricalWeather(latitude, longitude, date) {
            const apiUrl = `https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/${latitude},${longitude}/${date}?unitGroup=us&key=${visualCrossingApiKey}`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.days && data.days.length > 0) {
                        displayHistoricalWeather(data.days[0]);
                    } else {
                        console.error('Error fetching historical weather data:', data);
                    }
                })
                .catch(error => console.error('Error fetching historical weather data:', error));
        }

        function displayHistoricalWeather(weatherData) {
            const historicalWeatherInfo = document.getElementById("historicalWeatherInfo");
            historicalWeatherInfo.innerHTML = `
                Date: ${weatherData.datetime}<br>
                Temperature: ${weatherData.tempmax} °F (Max), ${weatherData.tempmin} °F (Min)<br>
                Weather: ${weatherData.conditions}
            `;
        }
    </script>

    <!-- Nearby Attractions API -->
    <script>
        function getNearbyAttractions(latitude, longitude) {
            // Use any nearby attractions API if available
            // Example: You can use the Google Places API for this purpose
            // Refer to the Google Places API documentation: https://developers.google.com/maps/documentation/places/web-service/intro

            // For demonstration purposes, let's assume an array of nearby attractions
            const nearbyAttractions = [
                "Attraction 1",
                "Attraction 2",
                "Attraction 3",
                // ... add more attractions as needed
            ];

            // Display nearby attractions
            const nearbyAttractionsInfo = document.getElementById("nearbyAttractions");
            nearbyAttractionsInfo.innerHTML = nearbyAttractions.map(attraction => `${attraction}<br>`).join('');
        }
    </script>

    <!-- ... (Previous code) -->

    <script type="text/javascript">
        var map;
        var marker;

        function getData() {
            // Default location (you can modify this)
            var defaultLocation = { latitude: 37.7749, longitude: -122.4194 };
            init_map(defaultLocation);
        }

        function init_map(data) {
            var map_options = {
                zoom: 6,
                center: new google.maps.LatLng(data.latitude, data.longitude)
            };
            map = new google.maps.Map(document.getElementById("map"), map_options);
            marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(data.latitude, data.longitude)
            });

            // Update locations dropdown on page load
            updateLocations();
        }

        // Function to search for a location
        function searchLocation() {
            var locationInput = document.getElementById("locationInput").value;
            var dateInput = document.getElementById("dateInput").value;

            // Set coordinates based on the selected location
            var coordinates;
            switch (locationInput) {
                case "Leavesden, Watford, England":
                    coordinates = { latitude: 51.691874, longitude: -0.417917 };
                    break;
                case "Durham, England":
                    coordinates = { latitude: 54.7753, longitude: -1.5849 };
                    break;
                case "Oxford’s Bodleian Libraries":
                    coordinates = { latitude: 51.754816, longitude: -1.254367 };
                    break;
                // ... (Your existing switch cases)
                default:
                    coordinates = { latitude: 37.7749, longitude: -122.4194 }; // Default coordinates
            }

            // Load map with new location
            map.setCenter(new google.maps.LatLng(coordinates.latitude, coordinates.longitude));
            marker.setPosition(new google.maps.LatLng(coordinates.latitude, coordinates.longitude));

            // Fetch and display weather information
            getWeather(coordinates.latitude, coordinates.longitude);

            // Get historical weather information
            getHistoricalWeather(coordinates.latitude, coordinates.longitude, dateInput);
            
            // Get nearby attractions
            getNearbyAttractions(coordinates.latitude, coordinates.longitude);
        }

        // Function to update locations dropdown based on selected movie
        function updateLocations() {
            var movieSelect = document.getElementById("movieSelect");
            var locationInput = document.getElementById("locationInput");

            // Clear previous options
            locationInput.innerHTML = "";

            // Add locations based on the selected movie
            switch (movieSelect.value) {
                case "harryPotter":
                    addOption(locationInput, "Leavesden, Watford, England");
                    addOption(locationInput, "Durham, England");
                    addOption(locationInput, "Oxford’s Bodleian Libraries");
                    // ... (Your existing switch cases)
                    break;
                case "spiderMan":
                    addOption(locationInput, "15 W 81st St");
                    addOption(locationInput, "36 Fuller Pl (Peter's house)");
                    addOption(locationInput, "Alexander Hamilton U.S. Custom House");
                    // ... (Your existing switch cases)
                    break;
                case "trainToBusan":
                    addOption(locationInput, "Daejeon Station (대전역)");
                    addOption(locationInput, "Dongdaegu Station (동대구역)");
                    addOption(locationInput, "Seoul (서울특별시)");
                    // ... (Your existing switch cases)
                    break;
                default:
                    addOption(locationInput, "Leavesden, Watford, England"); // Default option
            }
        }

        // Helper function to add option to dropdown
        function addOption(select, value) {
            var option = document.createElement("option");
            option.value = value;
            option.text = value;
            select.add(option);
        }
    </script>

</body>
</html>
