<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "hubdb";

// Create connection
$conn = mysqli_connect($server, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Error: " . mysqli_connect_error()); // Display error message if connection fails
} 
// else {
//     echo "Connected successfully"; // Print success message when connected
// }
?>
