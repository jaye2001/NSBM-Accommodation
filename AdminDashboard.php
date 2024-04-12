<?php
// Error reporting setup for development. Should be adjusted or removed for production use.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database utility file
include_once 'php/utils/db.php';
include_once 'php/utils/constants.php';

// Create a new instance of the Constants class
$web_constants = new Constants();

// Start the session.
session_start();

// Check if the user is logged in, otherwise, redirect to login page or display an error message.
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or display an error message.
    // In a real-world application, consider a more secure method for redirection.
    exit('Unauthorized access.');
}

// Initialize the database connection.
$db_obj = new DBConnection();
$db_obj->connect();
$pdo = $db_obj->get_conn();

try {
    // Retrieve the count of users.
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $userCount = $result['count'];
    
    // Retrieve the count of properties.
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM properties");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $propertyCount = $result['count'];
    
    // Retrieve the count of reservations.
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM reservations");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $reservationCount = $result['count'];
} catch (PDOException $e) {
    // In a real-world application, consider logging this error instead of displaying it directly.
    die("Database error: " . $e->getMessage());
}

// HTML and PHP mixed content follows.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NSBM Accommodation Finder</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="css/adminDash.css" rel="stylesheet">
</head>
<body>

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
                    <a class="nav-link" href="<?php echo $web_constants->get_link('logout'); ?>">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container content">
        <h2 class="my-4">Admin Dashboard</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <i class="fas fa-users icon"></i>
                        <span class="card-title">Users</span>
                        <p class="card-text"><?php echo $userCount; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <i class="fas fa-building icon"></i>
                        <span class="card-title">Properties</span>
                        <p class="card-text"><?php echo $propertyCount; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <i class="fas fa-calendar-alt icon"></i>
                        <span class="card-title">Reservations</span>
                        <p class="card-text"><?php echo $reservationCount; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
    <div class="row">
        <!-- Main content -->
        <div class="container">
  <div class="row">
    <div class="col-md-12">
    </div>
  </div>
  <div class="row">
        <div class="col-md-4">
            <a href="AdminDashboard.php" class="card text-dark bg-light mb-3 text-decoration-none">
                <div class="card-body">
                <h3 class="title">Dashboard</h3>
            <p></p><br><br>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="AdminAddUser.php" class="card text-dark bg-light mb-3 text-decoration-none">
                <div class="card-body">
                <h3 class="title">Add Users</h3>
            <p></p><br><br>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="AdminUserManage.php" class="card text-dark bg-light mb-3 text-decoration-none">
                <div class="card-body">
                <h3 class="title">User Account Manage</h3>
            <p></p><br><br>
                </div>
            </a>
        </div>
 </div>   
    <div class="row">
    <div class="col-md-4">
            <a href="AdminAddArticle.php" class="card text-dark bg-light mb-3 text-decoration-none">
                <div class="card-body">
                <h3 class="title">Post Articles</h3>
            <p></p><br><br>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="Articleviewpage.php" class="card text-dark bg-light mb-3 text-decoration-none">
                <div class="card-body">
                <h3 class="title">View Articles</h3>
            <p></p><br><br>
                </div>
            </a>
        </div>

        <!-- <div class="col-md-4">
            <a href="http://www.example.com" class="card text-dark bg-light mb-3 text-decoration-none">
                <div class="card-body">
                <h3 class="title">Purple Tile</h3>
            <p>Short, sweet data point goes here.</p>
                </div>
            </a>
        </div> -->
    </div>   

  
</div>
    </div>
</div>




    <!-- Footer -->
    <div class="footer">
        © 2024 NSBM Green University Accommodation Finder. All rights reserved.
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
