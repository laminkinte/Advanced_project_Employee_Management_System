<?php
include 'config.php';
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit();
}

if (isset($_GET['id'])) {
    $leave_id = $_GET['id'];
    $conn->query("UPDATE leaves SET status = 'approved' WHERE id = $leave_id");
    header('Location: manage_leaves.php');
    exit();
}
