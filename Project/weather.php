

<?php

if (isset($_GET['lat']) && isset($_GET['lng'])) {
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];

    // Replace 'YOUR_API_KEY' with your actual OpenWeatherMap API key
    $apiKey = 'cae0de8f8001bb6a51ff2848923f6f3a';
    $apiUrl = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lng}&units=metric&appid={$apiKey}";

    // Fetch weather data
    $weatherData = file_get_contents($apiUrl);

    // Check if data was fetched successfully
    if ($weatherData !== false) {
        // Output the JSON response
        header('Content-Type: application/json');
        echo $weatherData;
    } else {
        // Output an error message
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Unable to fetch weather information.']);
    }
} else {
    // Output an error message if latitude and longitude are not provided
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Latitude and longitude are required.']);
}

?>
