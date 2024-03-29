<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Movie Dashboard</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 56px; /* Adjust this value based on your fixed navbar height */
        }
    </style>
</head>
<body>

<?php
$url = "http://localhost/project/indexapi.php";

$client = curl_init($url);
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($client);

$result = json_decode($response, true); // Use true to get an associative array

if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON data: ' . json_last_error_msg());
}

// Display JSON response
echo '<pre>';
echo 'JSON Response:<br>';
echo json_encode($result, JSON_PRETTY_PRINT);
echo '</pre>';

// Display HTML table with Bootstrap styling
echo '<table class="table table-bordered table-striped">';
echo "<tr><th>Movie ID</th><th>Movie Name</th><th>Genre</th><th>Release Date</th><th>Director</th><th>Action</th></tr>";
if (is_array($result)) {
    foreach ($result as $movie) {
        echo "<tr>";
        echo "<td>" . $movie['movieID'] . "</td>";
        echo "<td>" . $movie['movieName'] . "</td>";
        echo "<td>" . $movie['genre'] . "</td>";
        echo "<td>" . $movie['releaseDate'] . "</td>";
        echo "<td>" . $movie['director'] . "</td>";

        // Improve Details Link Styling
        echo "<td>
                <a href='http://localhost/project/indexdetailclient.php?movieID=" . $movie['movieID'] . "' class='btn btn-info btn-sm'>Details</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No data available</td></tr>";
}
echo "</table>";
?>

<!-- Navigation Bar 2 with Bootstrap styling and fixed-top class -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">Movie Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Add Bootstrap JS and Popper.js scripts at the end of the body -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
