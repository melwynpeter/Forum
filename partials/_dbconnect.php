<?php
// Script to Connect to the Database
// Creating a Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "idiscuss";

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn){
    die("Database not Connected successfully" . mysqli_connect_error() . "<br>");
}
else{
    echo "Database Connected successfully <br>";
}
?>