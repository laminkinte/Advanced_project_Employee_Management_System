<?php
include 'config.php';
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit();
}

// Fetch attendance data and join with users table to get employee names
$attendance_query = $conn->query("
    SELECT u.username AS employee_name, a.date, a.clock_in AS time_in, a.clock_out AS time_out 
    FROM attendance a 
    JOIN users u ON a.user_id = u.id
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Employee Attendance</h2>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $attendance_query->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['time_in']); ?></td>
                    <td><?php echo htmlspecialchars($row['time_out']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
