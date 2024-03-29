<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization");

// Decode JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);
$locationID = $data["locationID"]; // Use locationID instead of movieID

// Include the database connection file
require_once "../../dbconnect.php";

// Sanitize input to prevent SQL injection
$locationID = mysqli_real_escape_string($conn, $locationID);

// Check if the location exists
$checkQuery = "SELECT * FROM location WHERE locationID = '$locationID'";
$checkResult = mysqli_query($conn, $checkQuery);

if (!$checkResult) {
    die(json_encode(array("message" => "Error checking location existence: " . mysqli_error($conn), "status" => false)));
}

if (mysqli_num_rows($checkResult) > 0) {
    // Location exists, delete the location
    $deleteLocationQuery = "DELETE FROM location WHERE locationID = '$locationID'";
    $deleteLocationResult = mysqli_query($conn, $deleteLocationQuery);

    if (!$deleteLocationResult) {
        die(json_encode(array("message" => "Error deleting location: " . mysqli_error($conn), "status" => false)));
    }

    echo json_encode(array("message" => "Location deleted successfully", "status" => true));
} else {
    echo json_encode(array("message" => "Failed to delete location. Location not found.", "status" => false));
}

// Close the database connection
mysqli_close($conn);
?>
