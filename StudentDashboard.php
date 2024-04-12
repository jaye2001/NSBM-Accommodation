<?php
include_once 'php/utils/db.php';
include_once 'php/utils/constants.php';

$web_constants = new Constants();

session_start(); // Start the session.

if (!isset($_SESSION['user_id']) || ($_SESSION['user_type'] !== 'student' && $_SESSION['user_type'] !== 'warden')) {
    header('Location: ' . $web_constants->get_link('login'));
         exit;
}

try {
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Reserve the property
        $stmt = $pdo->prepare("INSERT INTO reservations (student_id, property_id) VALUES (:student_id, :property_id)");
        $stmt->bindParam(':student_id', $_SESSION['user_id']);
        $stmt->bindParam(':property_id', $_POST['property_id']);
        $stmt->execute();
        echo "<script>alert('Property reserved successfully.'); window.location.href='StudentReservationView.php';</script>";
    } else if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        // Fetch properties from the database
        $stmt = $pdo->prepare("SELECT * FROM properties WHERE status = 'approved' ORDER BY created_at DESC");
        $stmt->execute();
        $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - NSBM Accommodations Finder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <style>
        /* Add your custom CSS here */
        .truncate {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body>

<?php if ($_SESSION['user_type'] == 'student') {
                                    # code...?>

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

<?php } elseif($_SESSION['user_type'] == 'warden'){ ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">NSBM Accommodations</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="WardenDashboard.php">Dashboard <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="StudentDashboard.php">View Ads</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="WardenPending.php">Ad Approve</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="WardenApprove.php">Approved List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="WardenRejected.php">Rejected List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $web_constants->get_link('logout'); ?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php } ?>

<div class="container mt-5">
    <h1>Accommodations Near By NSBM</h1>
    <br>
    <div class="row">
        <?php if (empty($properties)) { ?>
            <div class="col-12">
                <p>No properties found.</p>
            </div>
        <?php } else { ?>
            <?php 
                foreach ($properties as $property){
                    $imageData = $property['image'];
                    $imageDataEncoded = base64_encode($imageData);
                    $imageSrc = 'data:image/jpeg;base64,' . $imageDataEncoded;
             ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="<?php echo $imageSrc ?>" class="card-img-top" alt="<?php echo htmlspecialchars($property['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($property['title']); ?></h5>
                            <p class="card-text truncate">
                                <?php echo htmlspecialchars(substr($property['description'], 0, 100)); ?>
                            </p>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#propertyModal<?php echo $property['property_id']; ?>">
                                View More
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="propertyModal<?php echo $property['property_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="propertyModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="propertyModalLabel"><?php echo htmlspecialchars($property['title']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="<?php echo $imageSrc; ?>" class="img-fluid mb-2" alt="<?php echo htmlspecialchars($property['title']); ?>">
                                <p><?php echo htmlspecialchars($property['description']); ?></p>
                                <p>Location: <?php echo htmlspecialchars($property['location']); ?></p>
                                <p>Price: <?php echo htmlspecialchars($property['price']); ?></p>
                                <!-- Add any more details you want to show in the modal here -->
                                <!-- Add submit button -->
                                <?php if ($_SESSION['user_type'] == 'student') {
                                    # code...?>
                                
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                    <input type="hidden" name="property_id" value="<?php echo $property['property_id']; ?>">
                                    <button type="submit" class="btn btn-primary">Reserve</button>
                                </form>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Modal -->

            <?php 
            } 
        }
            ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>













