
<?php
// Replace these variables with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filming";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to safely escape and quote a value for a SQL statement
function quote($value, $conn) {
    return "'" . $conn->real_escape_string($value) . "'";
}
?>
