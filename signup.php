<?php
include 'config.php';
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit();
}

// Fetch leave requests data
$leave_requests = $conn->query("SELECT l.*, u.username FROM leaves l JOIN users u ON l.user_id = u.id");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leaves</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Manage Leaves</h2>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Leave Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $leave_requests->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['leave_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['reason']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <a href="approve_leave.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Approve</a>
                        <a href="deny_leave.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Deny</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

