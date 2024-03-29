<?php
require_once '../../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['movieID'])) {
        $movieID = $_POST['movieID'];

        try {
            // Perform the deletion in your database
            $sql = "DELETE FROM movie WHERE movieID = ?";
            $stmt = $conn->prepare($sql);

            // Check if the statement is not null before proceeding
            if ($stmt !== false) {
                // Bind parameters and execute the statement
                $stmt->bind_param('i', $movieID);
                $stmt->execute();

                // Check if the deletion was successful
                if ($stmt->affected_rows > 0) {
                    // Provide a JSON response
                    $response = array('success' => true, 'message' => 'Movie deleted successfully');
                } else {
                    $response = array('success' => false, 'message' => 'Movie not found or already deleted');
                }

                // Close the statement
                $stmt->close();
            } else {
                throw new Exception('Error preparing the statement');
            }
        } catch (Exception $e) {
            $response = array('success' => false, 'message' => 'Error deleting movie');
        }
    } else {
        $response = array('success' => false, 'message' => 'Movie ID not provided');
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid request method');
}

// Close the database connection
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
