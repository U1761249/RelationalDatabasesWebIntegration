<?php

$dbSource = "localhost";
$dbDatabase = "u1761249";
$dbUsername = "u1761249";
$dbPassword = "IilJUeNgiLJ8";

$conn = mysqli_connect($dbSource, $dbUsername, $dbPassword, $dbDatabase);

if (!$conn){
    die("Connection failed:".mysqli_connect_error());
}
?>