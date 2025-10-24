<?php
// Database configuration - update if your MySQL uses a password
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'mental_health_db';

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}
?>