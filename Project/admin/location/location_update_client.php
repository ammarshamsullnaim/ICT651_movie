<?php 
if (isset($_GET['id'])) {
    $locationID = $_GET['id'];
    $url = "http://localhost/Project/admin/location/location_detail_api.php?id=" . $locationID;

    $client = curl_init($url);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($client);

    // Check for cURL errors
    if (curl_errno($client)) {
        echo "Error fetching location details: " . curl_error($client);
        exit();
    }

    // Attempt to decode the response as JSON
    $result = json_decode($response, true); // Change to associative array

    // Check for JSON decoding errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Error decoding JSON: " . json_last_error_msg();
        exit();
    }

    // Display the actual response for debugging
    echo "Actual Response:<br>";
    var_dump($response);

    // Check if the result is an array and has the expected properties
    if (is_array($result) && isset($result['status'])) {
        if ($result['status']) {
            // Movie found, display details and update form
            echo "ID : " . $result['locationID']; 
            echo "<br>Location Name : " . $result['locationName']; 
            ?>

            <form method="POST" action="http://localhost/Project/admin/location/location_update_api.php">
                <br>
                Location Name: <br>
                <input type="text" name="locationName" value="<?php echo $result['locationName'] ?>">
                <br>
                <input type="hidden" name="locationID" value="<?php echo $result['locationID'] ?>">
                <input type="submit" name="submit" value="Submit">
            </form>

            <?php
            if (isset($_POST['submit'])) {
                // Handle form submission
                $updateData = array(
                    'locationID' => $_POST['locationID'],
                    'locationName' => $_POST['locationName'],
                    // Add other fields as needed
                );

                $updateUrl = "http://localhost/Project/admin/location/location_update_api.php";
                $updateClient = curl_init($updateUrl);

                curl_setopt($updateClient, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($updateClient, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($updateClient, CURLOPT_POSTFIELDS, json_encode($updateData));
                curl_setopt($updateClient, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

                $updateResponse = curl_exec($updateClient);

                if (curl_errno($updateClient)) {
                    echo "Error updating location: " . curl_error($updateClient);
                } else {
                    $updateResult = json_decode($updateResponse, true);
                    if ($updateResult && isset($updateResult['status']) && $updateResult['status']) {
                        // Successful update, redirect to location_list_client.php
                        header('Location: http://localhost/Project/admin/location/location_list_client.php');
                        exit();
                    } else {
                        // Display error message
                        echo "Error updating location: " . ($updateResult['message'] ?? 'Unknown error');
                    }
                }

                curl_close($updateClient);
            }
        } else {
            // Movie not found, display an appropriate message
            echo "Error: " . $result['message'];
        }
    } else {
        echo "Error: Unexpected response format.";
    }

    curl_close($client);
} else {
    echo 'Invalid request.';
}
?>
