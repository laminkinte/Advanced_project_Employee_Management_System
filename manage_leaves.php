<?php
include 'config.php';
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit();
}

$leave_requests = $conn->query("SELECT * FROM leaves WHERE status = 'pending'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $leave_id = $_POST['leave_id'];
    $action = $_POST['action'];
    
    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE leaves SET status = 'approved' WHERE id = ?");
    } else {
        $stmt = $conn->prepare("UPDATE leaves SET status = 'rejected' WHERE id = ?");
    }
    $stmt->bind_param('i', $leave_id);
    $stmt->execute();
    
    header('Location: manage_leaves.php');
}
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
    <h2 class="text-center">Manage Leave Requests</h2>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Reason</th>
                <th>From</th>
                <th>To</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($leave = $leave_requests->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $leave['employee_name']; ?></td>
                    <td><?php echo $leave['reason']; ?></td>
                    <td><?php echo $leave['from_date']; ?></td>
                    <td><?php echo $leave['to_date']; ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="leave_id" value="<?php echo $leave['id']; ?>">
                            <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
                            <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
