<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Locations</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeUOWcoif1SDM3L9EuNkn5qHs070bKQPQ&callback=initMap" async defer></script>
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <?php
            include("dbconnect.php");

            // Fetch movie data for dropdown
            $movieQuery = "SELECT movieID, title FROM movie";
            $movieResult = mysqli_query($conn, $movieQuery);

            if ($movieResult) {
                ?>
                <h1>Movie Locations</h1>
                <form>
                    <div class="form-group">
                        <label for="movieSelect">Select a Movie:</label>
                        <select class="form-control" id="movieSelect" onchange="changeMovie()">
                            <?php
                            while ($movieRow = mysqli_fetch_assoc($movieResult)) {
                                echo "<option value='{$movieRow['movieID']}'>{$movieRow['title']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="showMap()">Show Map</button>
                </form>
                <div id="map"></div>

                <script>
                    var map;
                    var markers = [];

                    // Initialize Google Map
                    function initMap() {
                        map = new google.maps.Map(document.getElementById('map'), {
                            center: {lat: 0, lng: 0},
                            zoom: 2
                        });
                    }

                    // Update map markers when the movie selection changes
                    function changeMovie() {
                    var selectedMovieId = document.getElementById("movieSelect").value;

                    // Check if selectedMovieId is not empty
                    if (selectedMovieId !== "") {
                        var updateUrl = "updateMap.php?locationId=" + selectedMovieId;

                        // Fetch updated data using AJAX
                        fetch(updateUrl)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Clear existing markers
                                markers.forEach(marker => marker.setMap(null));
                                markers = [];

                                // Check if data is not empty
                                if (data && data.length > 0) {
                                    // Add new markers
                                    data.forEach(location => {
                                        var marker = new google.maps.Marker({
                                            position: {lat: parseFloat(location.latitude), lng: parseFloat(location.longitude)},
                                            map: map,
                                            title: location.title + " - " + location.location_name
                                        });
                                        markers.push(marker);
                                    });
                                } else {
                                    console.error('No data received or empty data array.');
                                }
                            })
                            .catch(error => console.error('Error updating map:', error));
                    } else {
                        alert("Please select a movie first.");
                    }
                }


                    // Function to show the map when the "Show Map" button is clicked
                    function showMap() {
                        console.log("Show Map button clicked");
                        var selectedMovieId = document.getElementById("movieSelect").value;
                        console.log("Selected Movie ID: " + selectedMovieId);

                        if (selectedMovieId !== "") {
                            changeMovie();
                        } else {
                            alert("Please select a movie first.");
                        }
                    }
                </script>

                <?php
            } else {
                echo "Error executing query: " . mysqli_error($conn);
            }

            // Free movie result set
            mysqli_free_result($movieResult);

            // Close the connection when done
            mysqli_close($conn);
            ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
