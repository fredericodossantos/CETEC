<?php
// Database connection variables
$host = "localhost";
$username = "root";
$password = "";
$dbName = "sipam_db";

// Create a connection
$connection = mysqli_connect($host, $username, $password, $dbName);

// Check if the connection was successful
if (!$connection) {
    die("Failed to connect to the database: " . mysqli_connect_error());
}

// Set the character set to UTF-8
mysqli_set_charset($connection, "utf8");
?>
