<?php
$servername = "db"; // This should match the service name in your docker-compose file
$username = "laravel";
$password = "12345678";
$dbname = "laravellogin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
