<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Movie Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Create Movie Form</h1>
    <form method="POST">
        <div class="form-group">
            <label for="movie_name">Movie Name:</label>
            <input type="text" class="form-control" id="movie_name" name="movie_name" required>
        </div>
        <div class="form-group">
            <label for="genre">Genre:</label>
            <input type="text" class="form-control" id="genre" name="genre" required>
        </div>
        <div class="form-group">
            <label for="release_date">Release Date:</label>
            <input type="date" class="form-control" id="release_date" name="release_date" required>
        </div>
        <div class="form-group">
            <label for="director">Director:</label>
            <input type="text" class="form-control" id="director" name="director" required>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        // Specify the URL ($url) where the JSON data will be sent
        $url = "http://localhost/Project/admin/filming/filming_create_api.php"; // Change to the correct path

        // Initiate a new cURL resource using curl_init()
        $ch = curl_init($url);

        // Setup request to send JSON via POST
        $data = array(
            'movie_name' => $_POST['movie_name'],
            'genre' => $_POST['genre'],
            'release_date' => $_POST['release_date'],
            'director' => $_POST['director'],
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

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo "Error sending request: " . curl_error($ch);
        } else {
            // Decode the JSON response
            $decodedResult = json_decode($result);

            // Display the JSON response
            echo '<p class="mt-3">Response from movie create API:</p>';
            echo '<pre class="mt-2">' . json_encode($decodedResult, JSON_PRETTY_PRINT) . '</pre>';
        }

        // Close cURL resource
        curl_close($ch);
    }
    ?>
</div>

<!-- Include Bootstrap JS and Popper.js scripts at the end of the body -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
