<?php
require_once "../../dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $locationName = isset($_POST['locationName']) ? htmlspecialchars($_POST['locationName']) : null;
    $movieID = isset($_POST['movieID']) ? intval($_POST['movieID']) : null;

    if ($locationName && $movieID) {
        // Insert the new location into your database with the associated movieID
        $sql = "INSERT INTO location (locationName, movieID) VALUES ('$locationName', $movieID)";

        // Execute the query
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Location added successfully
            echo json_encode(['status' => 'success', 'message' => 'Location added successfully']);
        } else {
            // Error adding location
            echo json_encode(['status' => 'error', 'message' => 'Error adding location: ' . mysqli_error($conn)]);
        }
    } else {
        // Invalid input
        echo json_encode(['status' => 'error', 'message' => 'Invalid input or missing movieID']);
    }
} else {
    // Invalid request method
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
