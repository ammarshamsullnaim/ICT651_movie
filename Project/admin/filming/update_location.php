<?php
require "database.php";

// Check if required parameters are present
if (isset($_GET['email']) && isset($_GET['latitude']) && isset($_GET['longitude'])) {
    $email = $_GET['email'];
    $latitude = $_GET['latitude'];
    $longitude = $_GET['longitude'];

    // Create a new instance of the database class
    $db = new DataBase();
    $db->dbConnect();

    // Update user location in the database
    $db->updateUserLocation($email, $latitude, $longitude);

    // Close the database connection
    mysqli_close($db->connect);
} else {
    // Required parameters are missing
    echo "Missing parameters";
}
?>
