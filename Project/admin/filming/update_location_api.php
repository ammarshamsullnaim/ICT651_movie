<?php
header('Content-Type: application/json');
require_once "../../dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the location update logic here
    $locationID = $_POST['locationID'];
    $newLocationName = $_POST['locationName'];

    // Example: Perform the update operation using $locationID and $newLocationName
    // Replace this with your actual update logic (e.g., database update)
    $updateSql = "UPDATE location SET locationName='" . $conn->real_escape_string($newLocationName) . "' WHERE locationID='" . $conn->real_escape_string($locationID) . "'";

    if ($conn->query($updateSql) === true) {
        $response = ['status' => 'success', 'message' => 'Location updated successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Error updating location: ' . $conn->error];
    }
} else {
    // Invalid request method
    $response = ['status' => 'error', 'message' => 'Invalid request method'];
}

// Close the database connection
$conn->close();

echo json_encode($response);
?>
