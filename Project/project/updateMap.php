<?php
include("dbconnect.php");

if (isset($_GET['locationId'])) {
    $locationId = $_GET['locationId'];
    $locationData = getLocationData($locationId);

    if ($locationData) {
        // Return the location data as JSON
        header('Content-Type: application/json');
        echo json_encode($locationData);
    } else {
        echo "Error retrieving location data.";
    }
} else {
    echo "Location ID not provided.";
}

mysqli_close($conn);
?>