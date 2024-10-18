<?php
session_start();
include 'config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'employee'; // Default role for new users

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['profile_picture']['tmp_name'];
        $file_name = $_FILES['profile_picture']['name'];
        $upload_file_dir = 'uploads/';
        $dest_path = $upload_file_dir . $file_name;

        // Move the file to the uploads directory
        if (!file_exists($upload_file_dir)) {
            mkdir($upload_file_dir, 0777, true); // Create directory if it doesn't exist
        }

        if (move_uploaded_file($file_tmp_path, $dest_path)) {
            // Insert user data into the database
            $stmt = $conn->prepare('INSERT INTO users (username, password, role, profile_picture) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $username, $hashed_password, $role, $dest_path);

            if ($stmt->execute()) {
                header('Location: login.php'); // Redirect to login page after successful signup
                exit();
            } else {
                $error_message = 'Error creating account. Please try again.';
            }
        } else {
            $error_message = 'Error uploading file.';
        }
    } else {
        $error_message = 'No file uploaded or there was an upload error.';
    }
}
?>

<!-- HTML Sign-Up Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Sign Up</h2>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
    <p class="mt-3">Already have an account? <a href="login.php">Login here</a>.</p>
</div>
</body>
</html>
