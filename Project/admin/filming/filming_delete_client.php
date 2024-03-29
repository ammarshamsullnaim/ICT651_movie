<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Movie</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['movieID'])) {
                $movieID = $_POST['movieID'];
                
                // Assuming you have an API endpoint for deleting a movie
                $deleteApiUrl = "http://localhost/Project/admin/filming/filming_delete_api.php";

                $data = array('movieID' => $movieID);

                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($data),
                    ),
                );

                $context  = stream_context_create($options);
                $result = file_get_contents($deleteApiUrl, false, $context);

                if ($result !== false) {
                    echo '<div class="alert alert-success" role="alert">Movie deleted successfully!</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error deleting movie. Please try again.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Movie ID not provided.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Invalid request method.</div>';
        }
        ?>
        <a class="btn btn-secondary mt-3" href="http://localhost/Project/admin/filming/filming_list_client.php">Back to Movie List</a>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
