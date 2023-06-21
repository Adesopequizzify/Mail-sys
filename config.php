<?php
// Database configuration
$dbHost = "pld110.truehost.cloud";  // Replace with your database host
$dbUsername = "quizwift_muiz";  // Replace with your database username
$dbPassword = "Adeniyi20#";  // Replace with your database password
$dbName = "quizwift_contact_form";  // Replace with your database name

// Create a database connection
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
