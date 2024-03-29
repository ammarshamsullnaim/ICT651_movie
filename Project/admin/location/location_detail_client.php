<?php
if (isset($_GET['id'])) {
    $locationID = $_GET['id'];
    $url = "http://localhost/Project/admin/location/location_detail_api.php?id=" . $locationID;

    $client = curl_init($url);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($client);

    // Check for cURL errors
    if (curl_errno($client)) {
        echo "Error fetching location details: " . curl_error($client);
        exit();
    }

    // Attempt to decode the response as JSON
    $result = json_decode($response, true); // Change to associative array

    // Check for JSON decoding errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Error decoding JSON: " . json_last_error_msg();
        exit();
    }

    // Display the actual response for debugging
    echo "Actual Response:<br>";
    var_dump($response);

    // Check if the result is an array and has the expected properties
    if (is_array($result) && isset($result['status'])) {
        if ($result['status']) {
            // Movie found, display details and update form
            echo "ID : " . $result['locationID']; 
            echo "<br>Location Name : " . $result['locationName']; 
            
            if (isset($result['locations']) && is_array($result['locations']) && count($result['locations']) > 0) {
                echo "<br>Related Movies: ";
                foreach ($result['locations'] as $location) {
                    echo $location['locationName'] . ", ";
                }
            } else {
                echo "<br>No related movies found.";
            }

            // Add the update form or any other details as needed
        } else {
            // Movie not found, display an appropriate message
            echo "Error: " . $result['message'];
        }
    } else {
        // Unexpected response format
        echo "Error: Unexpected response format.";
    }

    curl_close($client);
} else {
    echo 'Invalid request.';
}
?>
