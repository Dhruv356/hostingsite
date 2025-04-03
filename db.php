<?php
$host = "localhost";  // Change this if your database is on another server
$user = "root";       // Database username
$pass = "";           // Database password (leave empty if no password)
$dbname = "website_db"; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
