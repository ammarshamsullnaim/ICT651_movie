<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie List</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding-top: 56px; /* Adjust based on the height of your navbar */
        }

        .navbar {
            background-color: #007bff; /* Bootstrap primary color */
        }

        .navbar a {
            color: white;
            padding: 14px 16px;
            text-decoration: none;
            text-align: center;
        }

        .navbar a:hover {
            background-color: #0056b3; /* Darker shade for hover effect */
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand" href="http://localhost/project/logout.php">Logout</a>
    </nav>

    <div class="container">
        <h1>Movie List</h1>

        <?php
        $url = "http://localhost/Project/admin/filming/filming_api_list.php";

        $client = curl_init($url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($client);

        // Check for cURL errors
        if (curl_errno($client)) {
            echo "Error fetching movie list: " . curl_error($client);
            exit(); // Stop execution if there's a cURL error
        }

        $result = json_decode($response);

        // Check for JSON decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Error decoding JSON: " . json_last_error_msg();
            echo "<br>";
            echo "Response received: " . $response;
            exit(); // Stop execution if there's a JSON decoding error
        }

        // Display JSON response
        echo '<h2>JSON Response:</h2>';
        echo '<pre>';
        echo json_encode($result, JSON_PRETTY_PRINT);
        echo '</pre>';

        // Check if $result is not null before proceeding
        if (!is_null($result)) {
            echo '<a href="http://localhost/Project/admin/filming/filming_create_client.php" class="btn btn-primary">Add New Movie</a>';
            echo "<br><br>";
            echo '<table class="table">';
            echo "<thead><tr><th>ID</th><th>Movie Name</th><th>Genre</th><th>Release Date</th><th>Director</th><th colspan='3'>Action</th></tr></thead><tbody>";
            foreach ($result as $x => $val) {
                echo "<tr>";
                echo "<td>" . $result[$x]->movieID . "</td>";
                echo "<td>" . $result[$x]->movieName . "</td>";
                echo "<td>" . $result[$x]->genre . "</td>";
                echo "<td>" . $result[$x]->releaseDate . "</td>";
                echo "<td>" . $result[$x]->director . "</td>";
                echo "<td><a href='http://localhost/Project/admin/filming/filming_detail_client.php?id=" . $result[$x]->movieID . "' class='btn btn-info'>Detail</a></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "No movies found.";
        }

        curl_close($client);
        ?>
    </div>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
