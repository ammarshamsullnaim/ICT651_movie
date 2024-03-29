<?php 
if (isset($_GET['id'])) {
    $movieID = $_GET['id'];
    $url = "http://localhost/Project/admin/filming/filming_detail_api.php?id=" . $movieID;

    $client = curl_init($url);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($client);
    $result = json_decode($response);
    
    echo "ID : " . $result[0]->movieID; 
    echo "<br>Movie Name : " . $result[0]->movieName; 
    echo "<br>Genre : " . $result[0]->genre; 
    echo "<br>Release Date : " . $result[0]->releaseDate; 
    echo "<br>Director : " . $result[0]->director; 
    ?>

    <form method="POST">
        <br>
        Movie Name: <br>
        <input type="text" name="movieName" value="<?php echo $result[0]->movieName ?>">
        <br>
        Genre : <br>
        <input type="text" name="genre" value="<?php echo $result[0]->genre ?>">
        <br>
        Release Date : <br>
        <input type="text" name="releaseDate" value="<?php echo $result[0]->releaseDate ?>">
        <br>
        Director : <br>
        <input type="text" name="director" value="<?php echo $result[0]->director ?>">
        <br>
        <input type="hidden" name="movieID" value="<?php echo $result[0]->movieID ?>">
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $url = "http://localhost/Project/admin/filming/filming_update_api.php";

        // Create a new cURL resource
        $ch = curl_init($url);

        // Setup request to send JSON via POST
        $data = array(
            'movieID' => $_POST['movieID'],
            'movieName' => $_POST['movieName'],
            'genre' => $_POST['genre'],
            'releaseDate' => $_POST['releaseDate'],
            'director' => $_POST['director']
        );
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
        echo '<p>Receiving data from movie client to movie update API: ';
        var_dump($result);
        echo '</p>';
        
        // Redirect back to filming_list_client.php
        header('Location: http://localhost/Project/admin/filming/filming_list_client.php');
        exit();
    }
} else {
    echo 'Invalid request.';
}
?>
