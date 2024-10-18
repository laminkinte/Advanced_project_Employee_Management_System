<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

include 'config.php';

// Fetch leave requests
$result = $conn->query("SELECT leaves.*, users.username FROM leaves JOIN users ON leaves.user_id = users.id");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $leave_id = $_POST['leave_id'];
    $stmt = $conn->prepare('UPDATE leaves SET status = ? WHERE id = ?');
    $stmt->bind_param('si', $status, $leave_id);
    $stmt->execute();
}

?>

<!-- Manage Leaves (Admin) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Leaves</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Manage Leave Requests</h1>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>User</th>
                <th>Leave Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($leave = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $leave['username']; ?></td>
                <td><?php echo $leave['leave_date']; ?></td>
                <td><?php echo $leave['reason']; ?></td>
                <td><?php echo $leave['status']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="leave_id" value="<?php echo $leave['id']; ?>">
                        <select name="status">
                            <option value="approved" <?php echo $leave['status'] == 'approved' ? 'selected' : ''; ?>>Approve</option>
                            <option value="rejected" <?php echo $leave['status'] == 'rejected' ? 'selected' : ''; ?>>Reject</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
