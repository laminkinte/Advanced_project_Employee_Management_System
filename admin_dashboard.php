<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}
include 'config.php';

// Fetch employees
$result = $conn->query("SELECT * FROM employees");
?>

<!-- Admin Panel (Bootstrap) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Admin Dashboard</h1>
    <a href="add_employee.php" class="btn btn-success">Add Employee</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($employee = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $employee['id']; ?></td>
                <td><?php echo $employee['name']; ?></td>
                <td><?php echo $employee['email']; ?></td>
                <td><?php echo $employee['phone']; ?></td>
                <td><?php echo $employee['department']; ?></td>
                <td>
                    <a href="edit_employee.php?id=<?php echo $employee['id']; ?>" class="btn btn-primary">Edit</a>
                    <a href="delete_employee.php?id=<?php echo $employee['id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
