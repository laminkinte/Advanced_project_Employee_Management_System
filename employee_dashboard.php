
<?php
session_start();
if ($_SESSION['role'] != 'employee') {
    header('Location: login.php');
    exit();
}

include 'config.php';
$user_id = $_SESSION['user_id'];

// Clock In and Clock Out functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $date = date('Y-m-d');

    if ($action == 'clock_in') {
        $conn->query("INSERT INTO attendance (user_id, clock_in, date) VALUES ($user_id, NOW(), '$date')");
    } else if ($action == 'clock_out') {
        $conn->query("UPDATE attendance SET clock_out = NOW() WHERE user_id = $user_id AND date = '$date'");
    }
}

// Fetch attendance records
$result = $conn->query("SELECT * FROM attendance WHERE user_id = $user_id ORDER BY date DESC");
?>

<!-- Employee Dashboard (Bootstrap) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Employee Dashboard</h1>
    <form method="POST">
        <button type="submit" name="action" value="clock_in" class="btn btn-success">Clock In</button>
        <button type="submit" name="action" value="clock_out" class="btn btn-danger">Clock Out</button>
    </form>

    <h2 class="mt-4">Attendance Records</h2>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Date</th>
                <th>Clock In</th>
                <th>Clock Out</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($attendance = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $attendance['date']; ?></td>
                <td><?php echo $attendance['clock_in'] ? date('H:i:s', strtotime($attendance['clock_in'])) : 'N/A'; ?></td>
                <td><?php echo $attendance['clock_out'] ? date('H:i:s', strtotime($attendance['clock_out'])) : 'N/A'; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
