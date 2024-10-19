<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'employee') {
    header('Location: dashboard.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$schedule_query = $conn->prepare("SELECT * FROM schedules WHERE user_id = ?");
$schedule_query->bind_param('i', $user_id);
$schedule_query->execute();
$schedule_result = $schedule_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>View Work Schedule</title>
</head>
<body>
<div class="container mt-5">
    <h2>Your Work Schedule</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Date</th>
                <th>Work Shift</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $schedule_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['schedule_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['work_shift']); ?></td>
                </tr>
            <?php endwhile; ?>
            <?php if ($schedule_result->num_rows == 0): ?>
                <tr><td colspan="2" class="text-center">No work schedule found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
