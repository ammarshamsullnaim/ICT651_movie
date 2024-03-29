<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "../../dbconnect.php";

$movieID = $_GET['id'];

$query = "SELECT m.*, l.locationID, l.locationName
          FROM movie m
          LEFT JOIN location l ON m.movieID = l.movieID
          WHERE m.movieID=" . $movieID;

$result = mysqli_query($conn, $query) or die("Select Query Failed.");

$count = mysqli_num_rows($result);

if ($count > 0) { 
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    http_response_code(200);
    echo json_encode($rows);
} else { 
    http_response_code(400);
    echo json_encode(array("message" => "No Movie Found.", "status" => false));
}

?>
