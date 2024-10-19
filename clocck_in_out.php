<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'employee') {
    header('Location: dashboard.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$date = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'clock_in') {
        $stmt = $conn->prepare("INSERT INTO attendance (user_id, clock_in, date) VALUES (?, NOW(), ?)");
        $stmt->bind_param('is', $user_id, $date);
        $stmt->execute();
        $message = "Clocked in successfully.";
    } elseif ($action == 'clock_out') {
        $stmt = $conn->prepare("UPDATE attendance SET clock_out = NOW() WHERE user_id = ? AND date = ? AND clock_out IS NULL");
        $stmt->bind_param('is', $user_id, $date);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $message = "Clocked out successfully.";
        } else {
            $message = "You haven't clocked in yet.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Clock In/Out</title>
</head>
<body>
<div class="container mt-5">
    <h2>Clock In/Out</h2>
    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="POST">
        <button type="submit" name="action" value="clock_in" class="btn btn-success">Clock In</button>
        <button type="submit" name="action" value="clock_out" class="btn btn-danger">Clock Out</button>
    </form>
</div>
</body>
</html>
