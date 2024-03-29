<?php
header("Content-Type:application/json");

$ISBN = '';

if(isset($_GET['ISBN']) && $_GET['ISBN'] == '2233344'){
    $ISBN = $_GET['ISBN'];
    $title = "Java Programming";
    $price = 55;
}
else{
    $ISBN = "None";
    $title = "None";
    $price = 0;
}

$response ['ISBN'] = $ISBN;
$response ['title'] = $title;
$response ['price'] = $price;

$result = json_encode($response);

echo $result;