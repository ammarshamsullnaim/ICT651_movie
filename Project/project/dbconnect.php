<?php

$DBhost = "localhost";
$DBuser = "root";
$DBpassword = "";
$DBname = "magicmap";

$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to get data based on selected location
function getLocationData($locationId)
{
    global $conn;

    $locationId = mysqli_real_escape_string($conn, $locationId);

    $query = "SELECT * FROM location WHERE location_id = '$locationId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $data;
    } else {
        return false;
    }
}
?>
