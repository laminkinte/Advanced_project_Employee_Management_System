<?php
session_start();
include 'config.php';

// Check if the user is logged in as an employee
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header('Location: dashboard.php');
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the required fields are set
    if (!empty($_POST['leave_date']) && !empty($_POST['reason'])) {
        $leave_date = $_POST['leave_date'];
        $reason = $_POST['reason'];
        $user_id = $_SESSION['user_id'];

        // Prepare the SQL statement
        $stmt = $conn->prepare('INSERT INTO leaves (user_id, leave_date, reason) VALUES (?, ?, ?)');
        $stmt->bind_param('iss', $user_id, $leave_date, $reason);
        
        if ($stmt->execute()) {
            echo "Leave request submitted!";
        } else {
            echo "Error: " . $stmt->error; // Display the error message if the query fails
        }
    } else {
        echo "Please fill in all fields."; // Show the error message if fields are empty
    }
}
?>

<!-- HTML Apply for Leave Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Apply for Leave</title>
</head>
<body>
<div class="container mt-5">
    <h1>Apply for Leave</h1>
    <form method="POST">
        <div class="form-group">
            <label for="leave_date">Leave Date</label>
            <input type="date" name="leave_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="reason">Reason</label>
            <textarea name="reason" class="form-control" placeholder="Reason for leave" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Apply for Leave</button>
    </form>
</div>
</body>
</html>
