<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mental_health_db"; // change this if your database name is different

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
