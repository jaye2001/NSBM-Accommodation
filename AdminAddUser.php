<?php
include_once 'php/utils/db.php';
include_once 'php/utils/constants.php';

session_start();

$web_constants = new Constants();

// Initialize database connection
$db_obj = new DBConnection();
$db_obj->connect();
$pdo = $db_obj->get_conn();

// Function to handle user insertion
function addUser($pdo, $userType, $userName, $userEmail, $phoneNumber, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (user_type, name, email, phone, password) VALUES (:type, :name, :email, :phone, :password)");
        $stmt->bindParam(':type', $userType);
        $stmt->bindParam(':name', $userName);
        $stmt->bindParam(':email', $userEmail);
        $stmt->bindParam(':phone', $phoneNumber);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        // Log error and/or handle error feedback
        echo $e->getMessage();
        return false;
    }
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userType = $_POST['userType'] ?? '';
    $userName = $_POST['userName'] ?? '';
    $userEmail = $_POST['userEmail'] ?? '';
    $phoneNumber = $_POST['phoneNumber'] ?? '';
    $password = $_POST['password'] ?? '';

    $allowedUserTypes = ['landlord', 'warden', 'student', 'admin'];
    if (!in_array($userType, $allowedUserTypes)) {
        echo "<script>alert('Invalid user type.');</script>";
        exit;
    }

    // Validate and sanitize input data here
    // ...

    // Add user if validation passes
    if (addUser($pdo, $userType, $userName, $userEmail, $phoneNumber, $password)) {
        echo "<script>alert('User added successfully.');</script>";
    } else {
        echo "<script>alert('Failed to add user.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">

    <link href="css/main.css" rel="stylesheet">
</head>
<body>
 <!-- Nav Bar -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="AdminDashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="AdminAddUser.php"> Add Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="AdminUserManage.php">Manage User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="AdminAddArticle.php">Post Article</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="auth/<?php echo $web_constants->get_link('logout'); ?>">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

<br>
<div class="container">
    <h2>User Management</h2>
    <br>

    <!-- Add User Form -->
    <div class="add-user-section">
        <h4>Add New User</h4>
        <form method="POST">
            <div class="form-group">
                <label for="userType">User Type</label>
                <select class="form-control" id="userType" name="userType">
                    <option value="landlord">Landlord</option>
                    <option value="warden">Warden</option>
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="userName">Name</label>
                <input type="text" class="form-control" id="userName" name="userName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="userEmail">Email</label>
                <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="userEmail">Phone number</label>
                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter phone number">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            </div>
            <!-- Additional fields as needed -->
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>

    <br><br>
    
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
