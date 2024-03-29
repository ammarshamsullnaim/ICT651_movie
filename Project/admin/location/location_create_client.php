<h1>Create Location Form</h1>
<form method="POST">
    <br>
    Location Name: <input type="text" name="location_name" required>
    <br>
    Filming: 
    <select name="filming_id" required>
        <?php
        // Fetch movies from the database
        $filmingUrl = "http://localhost/Project/admin/filming/filming_api_list.php";
        $filmingJson = @file_get_contents($filmingUrl);

        if ($filmingJson !== false) {
            $filming = json_decode($filmingJson, true);

            // Check if decoding was successful
            if ($filming !== null && json_last_error() === JSON_ERROR_NONE && isset($filming['status']) && $filming['status']) {
                foreach ($filming['data'] as $filmingData) {
                    echo '<option value="' . $filmingData['filmingID'] . '">' . $filmingData['filmingName'] . '</option>';
                }
            } else {
                echo '<option value="" disabled>Error decoding filming JSON: ' . json_last_error_msg() . '</option>';
            }
        } else {
            echo '<option value="" disabled>Error fetching filming: ' . error_get_last()['message'] . '</option>';
        }
        ?>
    </select>
    <br>
    <input type="submit" name="submit" value="Submit">
</form>

<?php
if (isset($_POST['submit'])) {
    // Specify the URL ($url) where the JSON data will be sent
    $url = "http://localhost/Project/admin/location/location_create_api.php"; // Change to the correct path

    // Initiate a new cURL resource using curl_init()
    $ch = curl_init($url);

    // Setup request to send JSON via POST
    $data = array(
        'location_name' => $_POST['location_name'],
        'filming_id' => $_POST['filming_id'],
    );

    // Setup data in PHP array and encode into a JSON string using json_encode()
    $payload = json_encode($data);

    // Attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    // Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    // Return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the POST request
    $result = curl_exec($ch);

    // Close cURL resource
    curl_close($ch);

    echo '<p>Receiving data from location client to location create API: ';
    var_dump($result);
    echo '</p>';

    // Redirect to location_list_client.php
    header('Location: http://localhost/Project/admin/location/location_list_client.php'); // Change to the correct path
    exit();
}
?>
