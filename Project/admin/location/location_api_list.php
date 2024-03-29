<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "../../dbconnect.php";

$query = "SELECT l.locationID, l.locationName, l.movieID, m.movieName
          FROM location l
          LEFT JOIN movie m ON l.movieID = m.movieID";

$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Database error: " . mysqli_error($conn), "status" => false));
    exit();
}

$count = mysqli_num_rows($result);

if ($count > 0) {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    http_response_code(200);
    echo json_encode($rows);
} else {
    http_response_code(404); // Not Found
    echo json_encode(array("message" => "No Locations Found.", "status" => false));
}

// Close the database connection
mysqli_close($conn);
?>
