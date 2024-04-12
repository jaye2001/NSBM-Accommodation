<?php
include_once '../php/utils/db.php';
// Validators
include_once '../php/utils/validators/emailValidator.php';
include_once '../php/utils/validators/nameValidator.php';
include_once '../php/utils/validators/phoneValidator.php';

// Create a connection to the database
try {
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :".$e->getMessage());
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

    $is_valid_name = name_validator($name);
    $is_valid_email = email_validator($email);
    $is_valid_phone = phone_number_validator($phone);
    
    if (!$is_valid_name || !$is_valid_email || !$is_valid_phone) {
        
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
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - NSBM Accommodation Finder</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
 
    <link href="css/signup.css" rel="stylesheet">
    <?php 
    if (!$is_valid_email)$error = "Invalid email address";
    else if (!$is_valid_name)$error = "Invalid name";
    else if (!$is_valid_phone)$error = "Invalid phone number";

    if (isset($error)) echo "<script>alert('".$error."');</script>"; 
    ?>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $web_constants->get_link('home'); ?>"> &nbsp &nbsp   NSBM Accommodations Finder &nbsp</a>
    </div>
</nav>
<br><br><br>
<div class="container shadow mt-5">
    <h2 class="sign-up-title">Sign Up</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-group">
            <label for="userType">I am a:</label>
            <select class="form-control" id="userType" name="userType" required>
                <option value="landlord">Landlord</option>
                <option value="student">Student</option>

            </select>
        </div>
        <div class="form-group">
            <label for="userName">Name</label>
            <input type="text" class="form-control" id="userName" name="userName" placeholder="Enter Name" required>
        </div>
        <div class="form-group">
            <label for="userEmail">Email</label>
            <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Enter Email" required>
        </div>
        
        <div class="form-group">
             <label for="phoneNumber">Phone Number</label>
            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter phone number" required>
        </div>

        <div class="form-group">
            <label for="userPassword">Password</label>
            <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Enter Password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
    </form>
</div>

<script src="js/signup.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
