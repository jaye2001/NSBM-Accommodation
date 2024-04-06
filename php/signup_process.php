<?php
include_once './utils/db.php';

// Create a connection to the database
try {
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Check for a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input values
    $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_STRING);
    
    // Validate inputs (basic validation)
    if (!$userType || !$name || !$email || !$password || !$phone)  {
        // Handle error - in production, redirect or provide a meaningful error message
        die('Please fill in all required fields.');
    }
    
    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        // Prepare SQL statement to insert a new user
        $stmt = $pdo->prepare("INSERT INTO users (user_type, name, email, password, phone) VALUES (:userType, :name, :email, :password, :phone)");
        
        // Bind parameters
        $stmt->bindParam(':userType', $userType);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':phone', $phone);
        
        // Execute the statement
        $stmt->execute();
        
        // Redirect or inform the user of successful registration
        echo 'Registration successful. <a href="login.php">Login here</a>';
    } catch (PDOException $e) {
        // Handle SQL errors (e.g., duplicate email)
        die('Registration failed: ' . $e->getMessage());
    }
} else {
    // Not a POST request, redirect to the sign-up page or show an error
    header('Location: signup.php');
    exit;
}
?>
