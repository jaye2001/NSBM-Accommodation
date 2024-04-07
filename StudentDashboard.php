<?php
include_once 'php/utils/db.php';

session_start(); // Start the session.

try {
    // Assuming you have a class DBConnection that connects to the database
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
    
    // Fetch properties from the database
    $stmt = $pdo->prepare("SELECT * FROM properties WHERE status = 'pending' ORDER BY created_at DESC");
    $stmt->execute();
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link href="css/main.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">NSBM Accommodations Finder</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="StudentDashboard.php">Student Dashboard <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="StudentView.php">Find Accommodation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="my_reservations.php">My Reservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="account_settings.php">Account Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>



<div class="container mt-5">
    <h1>Welcome</h1>
    <br>
    <div class="row">
        <!-- Ensure that properties have data -->
        <?php if (empty($properties)): ?>
            <div class="col-12">
                <p>No properties found.</p>
            </div>
        <?php else: ?>
            <?php foreach ($properties as $property): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($property['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($property['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($property['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($property['description']); ?></p>
                            <p class="card-text">Location: <?php echo htmlspecialchars($property['location']); ?></p>
                            <p class="card-text">Price: <?php echo htmlspecialchars($property['price']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



