<?php
if (isset($_GET['id'])) {
    $locationID = $_GET['id'];
    $url = "http://localhost/Project/admin/location/location_detail_api.php?id=" . $locationID;

    $client = curl_init($url);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($client);
    $result = json_decode($response);

    // Check if the response indicates success
    if ($result && isset($result->status) && $result->status) {
        echo '<form method="POST">';
        echo '<p>Are you sure you want to delete the location "' . $result->data->locationName . '"?</p>';
        echo '<input type="hidden" name="locationID" value="' . $result->data->locationID . '">';
        echo '<input type="submit" name="delete" value="Delete">';
        echo '</form>';
    } else {
        // Display a specific message for "Location not found" case
        if ($result && isset($result->message) && $result->message === "Location not found.") {
            echo '<p>Error: Location not found.</p>';
        } else {
            echo '<p>Error: ' . ($result->message ?? 'Unknown error') . '</p>';
        }
    }

    curl_close($client);  // Close cURL resource here

    if (isset($_POST['delete'])) {
        $url = "http://localhost/Project/admin/location/location_delete_api.php";

        // Create a new cURL resource
        $ch = curl_init($url);

        // Setup request to send JSON via POST
        $data = array(
            'locationID' => $locationID  // Use the original location ID from the URL
        );
        $payload = json_encode($data);

        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Execute the POST request
        $delete_result = curl_exec($ch);

        // Close cURL resource
        curl_close($ch);

        $delete_result = json_decode($delete_result);

        echo '<p>Response from location delete API: ' . $delete_result->message;
        echo '</p>';

        if ($delete_result->status) {
            // Redirect back to location_list_client.php
            header('Location: http://localhost/Project/admin/location/location_list_client.php');
            exit();
        }
    }
} else {
    echo "Error: Invalid request.";
}
?>
