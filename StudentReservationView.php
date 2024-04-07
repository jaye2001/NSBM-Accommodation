<?php
include_once 'php/utils/constants.php';
include_once 'php/utils/db.php';

session_start(); // Start the session.

$web_constants = new Constants();
$reservations = []; // Initialize an empty array to hold property data

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'student'){
    // Create a connection to the database
    $student_id = $_SESSION['user_id'];
    try {
        $db_obj = new DBConnection();
        $db_obj->connect();
        $pdo = $db_obj->get_conn();
        
        $stmt = $pdo->prepare("SELECT r.*, p.*, r.status AS request_status, r.created_at AS request_date FROM reservations r LEFT JOIN properties p ON r.property_id = p.property_id WHERE r.student_id = :user_id ORDER BY r.created_at DESC");
        $stmt->bindParam(':user_id', $student_id);        
        $stmt->execute();
        // Fetch all rows as an associative array
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        die("Could not connect to the database $dbname :" . $e->getMessage());
    }
} else {
    // Redirect to login page
    header('Location: ' . $web_constants->get_link('login'));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warden Approved - NSBM Accommodation Finder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">NSBM Accommodations Finder</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link " href="<?php echo $web_constants->get_link('home'); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="StudentDashboard.php">Student Dashboard <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="StudentView.php">Find Accommodation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="StudentReservationView.php">My Reservations</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="account_settings.php">Account Settings</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $web_constants->get_link('logout'); ?>">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-5">
    <h2>Student Reservation</h2>
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Property ID</th>
                <th scope="col">Property Title</th>
                <th scope="col">Location</th>
                <th scope="col">Price</th>
                <th scope="col">Requested Date</th>
                <th scope="col">Approval Status</th>
                <th scope="col">Description</th>

            </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($reservations)){
            foreach ($reservations as $reservation) {
        ?>
            <tr>
                <th><?php echo $reservation['reservation_id']; ?></th>
                <td><?php echo $reservation['title']; ?></td>
                <td><a href="<?php echo $reservation['location']; ?>">Show on map</a></td>
                <td><?php echo $reservation['price']; ?></td>
                <td><?php echo $reservation['request_date']; ?></td>
                <td><?php echo $reservation['request_status']; ?></td>
                <td><?php echo htmlspecialchars(substr($reservation['description'], 0, 100)); ?></td>
            </tr>
        <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
