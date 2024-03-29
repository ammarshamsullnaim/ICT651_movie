<form method="POST">
    ISBN : <input name = "ISBN" type = "text"> <br><br>
    <input name="submit" type="submit">

<?php
$ISBN = "";
if (isset($_POST["submit"])) {
    $ISBN = $_POST["ISBN"];
}

$url = "http://localhost/ict651/books/" . $ISBN;
echo $url;

$client = curl_init ($url);
curl_setopt ($client, CURLOPT_RETURNTRANSFER, true) ;
$response = curl_exec($client);

//var_dump ($response) ;

$result = json_decode($response);
echo "<br>";
echo "<br>";
//var_dumb($result);

echo "<br>";
echo "ISBN: " . $result->ISBN;
echo "<br>Title: " . $result->title; 
echo "<br>Price: RM " . $result->price;
?>