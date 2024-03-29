<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Detail</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 56px; /* Adjust based on the height of your navbar */
        }

        .container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        .actions {
            display: flex;
            justify-content: center;
        }

        .actions button {
            margin: 5px;
        }
    </style>
</head>
<body>
    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="filming_list_client.php">Movie Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Add your navbar items here if needed -->
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Movie Detail</h1>

        <?php
        if (isset($_GET['id'])) {
            $movieID = $_GET['id'];
            $url = "http://localhost/Project/admin/filming/filming_detail_api.php?id=" . $movieID;

            $client = curl_init($url);
            curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($client);
            $result = json_decode($response);

            if (!empty($result)) {
                echo '<table class="table table-bordered">';
                echo "<thead><tr><th>Movie ID</th><th>Movie Name</th><th>Genre</th><th>Release Date</th><th>Director</th><th>Location ID</th><th>Location Name</th><th>Actions</th></tr></thead>";
                echo "<tbody>";

                foreach ($result as $movie) {
                    echo "<tr>";
                    echo "<td>" . $movie->movieID . "</td>";
                    echo "<td>" . $movie->movieName . "</td>";
                    echo "<td>" . $movie->genre . "</td>";
                    echo "<td>" . $movie->releaseDate . "</td>";
                    echo "<td>" . $movie->director . "</td>";
                
                    // Check if locationID and locationName properties exist before accessing them
                    $locationID = isset($movie->locationID) ? $movie->locationID : "N/A";
                    $locationName = isset($movie->locationName) ? $movie->locationName : "N/A";
                
                    echo "<td>" . $locationID . "</td>";
                    echo "<td>" . $locationName . "</td>";
                
                    // Add an "Update" button with a JavaScript onclick event
                    echo '<td class="actions">';
                    echo '<button class="btn btn-primary" onclick="updateLocation(' . $locationID . ', \'' . $locationName . '\')">Update Location</button>';
                
                    // Add delete button for location
                    echo '<form method="post" action="delete_location_api.php" onsubmit="return confirm(\'Are you sure you want to delete this location?\');">';
                    echo '<input type="hidden" name="locationID" value="' . htmlspecialchars($locationID) . '">';
                    echo '<button type="submit" class="btn btn-danger">Delete Location</button>';
                    echo '</form>';
                
                    // Add delete button for movie
                    // Add this block for the movie delete button
                    echo '<form method="post" action="filming_delete_api.php" onsubmit="return confirm(\'Are you sure you want to delete this movie?\');">';
                    echo '<input type="hidden" name="movieID" value="' . htmlspecialchars($movieID) . '">';
                    echo '<button type="submit" class="btn btn-danger">Delete Movie</button>';
                    echo '</form>';

                
                    echo '</td>';
                    echo "</tr>";
                }           

                echo "</tbody>";
                echo "</table>";

                // Add Location Button based on movieID
                echo '<a class="btn btn-success mt-3" href="http://localhost/Project/admin/filming/add_location_client.php?id=' . $movieID . '">Add Location</a>';
            } else {
                echo "<p class='text-danger'>Movie not found</p>";
            }

            // Display JSON response
            echo '<h2>JSON Response:</h2>';
            echo '<pre>';
            echo json_encode($result, JSON_PRETTY_PRINT);
            echo '</pre>';

            echo '<a class="btn btn-secondary mt-3" href="http://localhost/Project/admin/filming/filming_list_client.php">Back to Movie List</a>';
        } else {
            echo "<p class='text-danger'>Error: Movie ID not provided.</p>";
        }
        ?>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function updateLocation(locationID, locationName) {
            window.location.href = "http://localhost/Project/admin/filming/update_location_client.php?locationID=" + locationID + "&locationName=" + encodeURIComponent(locationName);
        }
    </script>
</body>
</html>
