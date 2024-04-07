<?php
include_once 'php/utils/db.php';

session_start(); // Start the session.

try {
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
    
    // Fetch properties from the database
    $stmt = $pdo->prepare("SELECT * FROM properties WHERE status = 'approved' ORDER BY created_at DESC");
    $stmt->execute();
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Accommodation - NSBM Accommodation Finder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">

    <link href="css/main.css" rel="stylesheet">

    <style>
        #map {
                height: 00px; /* Fixed pixel value */
                /* OR */
                height: 55vh; /* 50% of the viewport height */
            }

    </style>
</head>
<body>

<div class="flex-wrapper">
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
                        <a class="nav-link" href="WardenAdView.php">View Ads</a>
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

    <div class="container mt-5">
    <h1>Accommodations Near By NSBM</h1>
    <br>
    <div class="row">
        <?php if (empty($properties)): ?>
            <div class="col-12">
                <p>No properties found.</p>
            </div>
        <?php else: ?>
            <?php foreach ($properties as $property): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($property['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($property['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($property['title']); ?></h5>
                            <p class="card-text truncate">
                                <?php echo htmlspecialchars(substr($property['description'], 0, 100)); ?>
                            </p>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#propertyModal<?php echo $property['id']; ?>">
                                View More
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="propertyModal<?php echo $property['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="propertyModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="propertyModalLabel"><?php echo htmlspecialchars($property['title']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="<?php echo htmlspecialchars($property['image_path']); ?>" class="img-fluid mb-2" alt="<?php echo htmlspecialchars($property['title']); ?>">
                                <p><?php echo htmlspecialchars($property['description']); ?></p>
                                <p>Location: <?php echo htmlspecialchars($property['location']); ?></p>
                                <p>Price: <?php echo htmlspecialchars($property['price']); ?></p>
                                <!-- Add any more details you want to show in the modal here -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Modal -->

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>


    <footer class="footer bg-dark text-white pt-4 pb-4">
        <div class="container text-center">
            <p>© 2024 NSBM Green University Accommodation Finder. All rights reserved.</p>
        </div>
    </footer>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7ngQlbbaL_qjsvJQp02PFTXc_gO916s8&callback=initMap&libraries=&v=weekly" async defer></script>

<script src="js/studviewmap.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Include mapping library, e.g., Google Maps API script here -->
</body>
</html>
