<?php
session_start();
if ($_SESSION['role'] != 'employee') {
    header('Location: login.php');
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave_date = $_POST['leave_date'];
    $reason = $_POST['reason'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare('INSERT INTO leaves (user_id, leave_date, reason) VALUES (?, ?, ?)');
    $stmt->bind_param('iss', $user_id, $leave_date, $reason);
    $stmt->execute();
    echo "Leave request submitted!";
}
?>

<form method="POST">
    <input type="date" name="leave_date" required>
    <textarea name="reason" placeholder="Reason for leave" required></textarea>
    <button type="submit">Apply for Leave</button>
</form>
