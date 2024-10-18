<?php
$host = 'localhost';       // Host
$dbname = 'employee_management'; // Database name
$username = 'root';        // MySQL username
$password = 'Yh3@Wp7#Vc9&Lm1!';            // MySQL password (default is empty in XAMPP)

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
