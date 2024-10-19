<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role']; // Assume you're also collecting the role
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Check if email already exists
    $email_check_query = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $email_check_query->bind_param('s', $email);
    $email_check_query->execute();
    $result = $email_check_query->get_result();

    if ($result->num_rows > 0) {
        echo "Error: Email already exists. Please use a different email.";
    } else {
        // If the email does not exist, proceed with the insertion
        $insert_query = $conn->prepare("INSERT INTO users (username, email, role, password) VALUES (?, ?, ?, ?)");
        $insert_query->bind_param('ssss', $username, $email, $role, $password); // Adjust parameters accordingly

        if ($insert_query->execute()) {
            echo "Employee added successfully!";
        } else {
            echo "Error: " . $insert_query->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Add Employee</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" name="role" required>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Employee</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
