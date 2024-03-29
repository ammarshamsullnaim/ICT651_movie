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
    $movieData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $locationData[] = array(
            "locationID" => $row['locationID'],
            "locationName" => $row['locationName']
        );
        unset($row['locationID']);
        unset($row['locationName']);
        $movieData = $row; // Assuming there's only one row for a movie
    }
    
    // Add the location data to the movie data
    $movieData['locations'] = $locationData;

    http_response_code(200);
    echo json_encode($movieData);
} else { 
    http_response_code(400);
    echo json_encode(array("message" => "No Movie Found.", "status" => false));
}

?>
