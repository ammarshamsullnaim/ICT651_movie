<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "../../dbconnect.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data)) {
    $movie_name = $data["movie_name"];
    $genre = $data["genre"];
    $release_date = $data["release_date"];
    $director = $data["director"];

    // Sanitize input to prevent SQL injection
    $movie_name = mysqli_real_escape_string($conn, $movie_name);
    $genre = mysqli_real_escape_string($conn, $genre);
    $release_date = mysqli_real_escape_string($conn, $release_date);
    $director = mysqli_real_escape_string($conn, $director);

    $query = "INSERT INTO movie (movieName, genre, releaseDate, director) 
              VALUES ('$movie_name', '$genre', '$release_date', '$director')";
    
    $result = mysqli_query($conn, $query);

    if ($result) {
        http_response_code(201);
        echo json_encode(array("message" => "Movie Created Successfully", "status" => true));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Failed to Create Movie", "status" => false));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid Data", "status" => false));
}

mysqli_close($conn);

?>
