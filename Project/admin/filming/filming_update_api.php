<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization");

$data = json_decode(file_get_contents("php://input"), true);
echo '<p>Receiving data from movie client to movie update API: ';
var_dump($data);
echo '</p>';

$movieID = $data["movieID"];
$movieName = $data["movieName"];
$genre = $data["genre"];
$releaseDate = $data["releaseDate"];
$director = $data["director"];

require_once "../../dbconnect.php";

// Begin the transaction
mysqli_begin_transaction($conn);

try {
    // Update Movie Query
    $queryMovie = "UPDATE movie
                   SET movieName = '$movieName', 
                       genre = '$genre', 
                       releaseDate = '$releaseDate', 
                       director = '$director' 
                   WHERE movieID = $movieID";

    // Execute Movie Update Query
    $resultMovie = mysqli_query($conn, $queryMovie);
    if (!$resultMovie) {
        throw new Exception("Update Movie Query Failed: " . mysqli_error($conn));
    }

    // Commit the transaction
    mysqli_commit($conn);

    // Check affected rows
    if (mysqli_affected_rows($conn) > 0) {
        http_response_code(200);
        echo json_encode(array("message" => mysqli_affected_rows($conn) . " Movie Updated Successfully", "status" => true));
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Failed Movie Not Updated", "status" => false));
    }
} catch (Exception $e) {
    // An error occurred, rollback the transaction
    mysqli_rollback($conn);

    http_response_code(500);
    echo json_encode(array("message" => $e->getMessage(), "status" => false));
} finally {
    // Close the connection
    mysqli_close($conn);
}
?>
