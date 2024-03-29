<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "dbconnect.php";

// Check if movieID is set in the URL
if (isset($_GET['movieID'])) {
    $movieID = $_GET['movieID'];

    $query = "SELECT m.*, l.locationName 
              FROM movie m 
              LEFT JOIN location l ON m.movieID = l.movieID
              WHERE m.movieID = $movieID";

    $result = mysqli_query($conn, $query) or die("Select Query Failed.");

    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($rows);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "No Movie Found for the given ID.", "status" => false));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Movie ID is not set.", "status" => false));
}

?>
