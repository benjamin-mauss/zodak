<?php

$servername = "localhost";
$username = "root";
$password = "";
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


// Create connection
$conn = new mysqli($servername, $username, $password, "zodak");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
