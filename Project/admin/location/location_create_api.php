<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "../../dbconnect.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data)) {
    $location_name = $data["location_name"];
    $movie_id = $data["movie_id"];

    // Sanitize input to prevent SQL injection
    $location_name = mysqli_real_escape_string($conn, $location_name);
    $movie_id = mysqli_real_escape_string($conn, $movie_id);

    $query = "INSERT INTO location (locationName, movieID) 
              VALUES ('$location_name', '$movie_id')";
    
    $result = mysqli_query($conn, $query);

    if ($result) {
        http_response_code(201);
        echo json_encode(array("message" => "Location Created Successfully", "status" => true));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Failed to Create Location", "status" => false));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid Data", "status" => false));
}

mysqli_close($conn);

?>
