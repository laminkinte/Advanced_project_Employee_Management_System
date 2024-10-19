<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Fetch user data
$user_query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_query->bind_param('i', $user_id);
$user_query->execute();
$user = $user_query->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Employee Management System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="profile.php">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Main Dashboard Content -->
<div class="container mt-5">
    <div class="text-center">
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <h3>Your role: <?php echo ucfirst($role); ?></h3>
    </div>

    <div class="row mt-4">
        <!-- Admin Dashboard -->
        <?php if ($role == 'admin'): ?>
            <div class="col-md-4">
                <div class="card shadow-lg text-center">
                    <div class="card-body">
                        <h5 class="card-title">Add Employee</h5>
                        <p class="card-text">Add new employees to the system.</p>
                        <a href="add_employee.php" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-lg text-center">
                    <div class="card-body">
                        <h5 class="card-title">Manage Leaves</h5>
                        <p class="card-text">Review and approve employee leave requests.</p>
                        <a href="manage_leaves.php" class="btn btn-success">Go</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-lg text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Attendance</h5>
                        <p class="card-text">Monitor and track employee attendance records.</p>
                        <a href="view_attendance.php" class="btn btn-warning">Go</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4">
                <div class="card shadow-lg text-center">
                    <div class="card-body">
                        <h5 class="card-title">Generate Reports</h5>
                        <p class="card-text">Generate detailed employee reports.</p>
                        <a href="generate_reports.php" class="btn btn-info">Go</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4">
                <div class="card shadow-lg text-center">
                    <div class="card-body">
                        <h5 class="card-title">Manage Employees</h5>
                        <p class="card-text">Update or remove employee details.</p>
                        <a href="manage_employees.php" class="btn btn-danger">Go</a>
                    </div>
                </div>
            </div>

        <!-- Employee Dashboard -->
        <?php elseif ($role == 'employee'): ?>
            <div class="col-md-4">
                <div class="card shadow-lg text-center">
                    <div class="card-body">
                        <h5 class="card-title">Apply for Leave</h5>
                        <p class="card-text">Submit your leave requests for approval.</p>
                        <a href="apply_leave.php" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-lg text-center">
                    <div class="card-body">
                        <h5 class="card-title">Clock In/Out</h5>
                        <p class="card-text">Record your work time.</p>
                        <a href="clock_in_out.php" class="btn btn-success">Go</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-lg text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Leave Status</h5>
                        <p class="card-text">Check the status of your leave applications.</p>
                        <a href="view_leaves.php" class="btn btn-warning">Go</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4">
                <div class="card shadow-lg text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Work Schedule</h5>
                        <p class="card-text">View your upcoming work schedule.</p>
                        <a href="view_schedule.php" class="btn btn-info">Go</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<footer class="text-center mt-5">
    <p>&copy; <?php echo date('Y'); ?> Employee Management System</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
