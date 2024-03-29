<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Location</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Add Location</h1>

        <?php
        // Assuming you pass the movie ID through the URL
        $movieID = isset($_GET['id']) ? $_GET['id'] : null;
        ?>

        <form method="post" action="add_location_api.php">
            <!-- Include a hidden input field to pass the movie ID -->
            <input type="hidden" name="movieID" value="<?php echo $movieID; ?>">

            <div class="form-group">
                <label for="locationName">Location Name:</label>
                <input type="text" class="form-control" id="locationName" name="locationName" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Location</button>
        </form>

        <a class="btn btn-secondary mt-3" href="filming_list_client.php">Back to Movie List</a>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
