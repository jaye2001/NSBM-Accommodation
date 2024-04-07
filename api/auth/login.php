<?php
include_once 'utils/db.php';
include_once 'utils/constants.php';

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
                header('Location: '.$web_constants->get_link('student_search'));
                break;
            case 'warden':
                header('Location: '.$web_constants->get_link('warden_ad_view'));
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
} else {
    // Invalid request.
    header('Location: '.$web_constants->get_link('login'));
    exit;
}
?>
