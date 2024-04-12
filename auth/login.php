<?php
include_once '../php/utils/db.php';
include_once '../php/utils/constants.php';

session_start(); // Start the session.

$web_constants = new Constants();
// Try connecting to the database.
try {
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['userEmail']) && !empty($_POST['userPassword'])) {
    $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
    $password = $_POST['userPassword'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Authentication success. Redirect based on user type.
        $is_valid_user_type = TRUE;
        switch ($user['user_type']) {
            case 'student':
                header('Location: '.$web_constants->get_link('home'));
                break;
            case 'warden':
                header('Location: '.$web_constants->get_link('warden_dashboard'));
                break;
            case 'landlord':
                header('Location: '.$web_constants->get_link('landlord_dashboard'));
                break;
            case 'admin':
                header('Location: '.$web_constants->get_link('admin_dashboard'));
                break;
            default:
                // Handle unexpected user type.
                $is_valid_user_type = FALSE;
                echo "<script>alert('Unexpected user type. Please contact support.'); window.location.href='login.php';</script>";
                break;
        }
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_type'] = $user['user_type'];
        exit;
    } else {
        // Authentication failed.
        echo "<script>alert('This account is incorrect. Please try again.'); window.location.href='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NSBM Accommodation Finder</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
 
    <link href="<?php echo $web_constants->get_link('login_css') ?>" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $web_constants->get_link('home'); ?>"> &nbsp &nbsp   NSBM Accommodations Finder &nbsp</a>
    </div>
</nav>
<br><br><br>
<div class="container">
    <h2 class="login-title">Login</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
            <label for="userEmail">Email</label>
            <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="userPassword">Password</label>
            <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
</div>


<div class="text-center mt-4" style="position: absolute; top: 550px; left: 50%; transform: translateX(-50%);">
    <p>If you don't have an account and you are a Landlord or Student, sign up from here:</p>
    <a href="signup.php" class="btn btn-outline-primary">Sign Up</a>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
