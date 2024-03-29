<?php
header('Content-Type: application/json');
require_once "../../dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the location deletion logic here
    $locationID = $_POST['locationID'];

    // Example: Perform the delete operation using $locationID
    // Replace this with your actual delete logic (e.g., database delete)
    $deleteSql = "DELETE FROM location WHERE locationID='" . $conn->real_escape_string($locationID) . "'";

    if ($conn->query($deleteSql) === true) {
        $response = ['success' => true, 'message' => 'Location deleted successfully'];
    } else {
        $response = ['success' => false, 'message' => 'Error deleting location: ' . $conn->error];
    }
} else {
    // Invalid request method
    $response = ['success' => false, 'message' => 'Invalid request method'];
}

// Close the database connection
$conn->close();

echo json_encode($response);
?>
