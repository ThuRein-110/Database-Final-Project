<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "visa_db";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if(!$conn){
    die("Connection Failed: ". mysqli_connect_error());
}
?> 

