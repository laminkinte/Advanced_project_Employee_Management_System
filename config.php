<?php
$servername = "localhost";
$username = "root";
$password = "Yh3@Wp7#Vc9&Lm1!";  // The provided password
$dbname = "employee_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
