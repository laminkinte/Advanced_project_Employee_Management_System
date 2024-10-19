<?php
include 'config.php';
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit();
}

// Logic for generating reports here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Generate Employee Reports</h2>
    <!-- Form or button to generate reports -->
    <form action="generate_report_action.php" method="POST">
        <div class="form-group">
            <label for="report_type">Select Report Type</label>
            <select name="report_type" class="form-control" id="report_type">
                <option value="attendance">Attendance Report</option>
                <option value="leave">Leave Report</option>
                <option value="performance">Performance Report</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>
</div>
</body>
</html>
