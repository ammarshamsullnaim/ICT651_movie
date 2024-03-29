<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Location</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="#">Movie Dashboard</a>
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

    <div class="container mt-5">
        <h1>Update Location</h1>

        <?php
        require_once "../../dbconnect.php";

        if (isset($_GET['locationID'])) {
            $locationID = $_GET['locationID'];

            // Fetch the current locationName from your data source
            $query = "SELECT locationName FROM location WHERE locationID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $locationID);
            $stmt->execute();
            $stmt->bind_result($currentLocationName);
            $stmt->fetch();
            $stmt->close();

            echo '<form method="post" action="update_location_api.php">';
            echo '<input type="hidden" name="locationID" value="' . htmlspecialchars($locationID) . '">';
            
            // Display the current locationName
            echo '<div class="form-group">';
            echo '<label for="currentLocationName">Current Location Name:</label>';
            echo '<input type="text" class="form-control" id="currentLocationName" name="currentLocationName" value="' . htmlspecialchars($currentLocationName) . '" readonly>';
            echo '</div>';
            
            // Input field for the new locationName
            echo '<div class="form-group">';
            echo '<label for="locationName">New Location Name:</label>';
            echo '<input type="text" class="form-control" id="locationName" name="locationName" value="">';
            echo '</div>';
            
            // Submit button
            echo '<button type="submit" class="btn btn-primary">Update Location</button>';
            echo '</form>';

            // Add delete button
        } else {
            echo '<p>Error: Location ID not provided.</p>';
        }
        ?>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function deleteLocation(locationID) {
            // Add your logic for handling location deletion
            // You can use AJAX to send a request to your delete API endpoint
            // and handle the response accordingly
            // Example:
            // $.post("delete_location_api.php", { locationID: locationID }, function(response) {
            //     // Handle the response
            //     console.log(response);
            // });
        }
    </script>
</body>
</html>
