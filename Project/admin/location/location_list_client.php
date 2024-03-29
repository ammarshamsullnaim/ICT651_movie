<h1>Location List</h1>

<?php
$url = "http://localhost/Project/admin/location/location_api_list.php";

$client = curl_init($url);
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($client);

// Check for cURL errors
if (curl_errno($client)) {
    echo "Error fetching location list: " . curl_error($client);
    exit(); // Stop execution if there's a cURL error
}

$result = json_decode($response, true); // Change to associative array

// Check for JSON decoding errors
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Error decoding JSON: " . json_last_error_msg();
    echo "<br>";
    echo "Response received: " . $response;
    exit(); // Stop execution if there's a JSON decoding error
}

// Check if $result is not null before proceeding
if (!is_null($result)) {
    echo '<a href="http://localhost/Project/admin/location/location_create_client.php">Add New Location</a>';
    echo "<br><br>";
    echo '<table border="1">';
    echo "<tr><th>ID</th><th>Location Name</th><th>Movie Name</th><th colspan='2'>Action</th></tr>";
    foreach ($result as $location) {
        echo "<tr>";
        echo "<td>" . $location['locationID'] . "</td>";
        echo "<td>" . $location['locationName'] . "</td>";
        echo "<td>" . $location['movieName'] . "</td>";
        echo "<td><a href='http://localhost/Project/admin/location/location_update_client.php?id=" . $location['locationID'] . "'>Update</a></td>";
        echo "<td><a href='http://localhost/Project/admin/location/location_delete_client.php?id=" . $location['locationID'] . "'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No locations found.";
}

curl_close($client);
?>
