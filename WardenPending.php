<?php
include_once 'php/utils/constants.php';
include_once 'php/utils/db.php';

session_start(); // Start the session.

$web_constants = new Constants();
$properties = []; // Initialize an empty array to hold property data

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'warden'){
    // Create a connection to the database
    try {
        $db_obj = new DBConnection();
        $db_obj->connect();
        $pdo = $db_obj->get_conn();
        
        $stmt = $pdo->prepare("SELECT * FROM properties WHERE status='pending'");
        $stmt->execute();
        // Fetch all rows as an associative array
        $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
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
    <title>Warden Pending - NSBM Accommodation Finder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navigation Bar -->
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
    <h2>Warden Accommodation Approval</h2>
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Location</th>
                <th scope="col">Price</th>
                <th scope="col">Published Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
                if (count($properties) > 0) {
                    foreach($properties as $accommodation) {
                        // Unique ID for each modal for linking
                        $modalId = "viewModal" . $accommodation['property_id'];
                        echo "<tr>";
                        echo "<th scope='row'>" . htmlspecialchars($accommodation['property_id']) . "</th>";
                        echo "<td>" . htmlspecialchars($accommodation['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($accommodation['location']) . "</td>";
                        echo "<td>" . htmlspecialchars($accommodation['price']) . "</td>";
                        echo "<td>" . htmlspecialchars($accommodation['created_at']) . "</td>";
                        echo "<td>";
                        // This is the 'View' button at line 83 that will now trigger the modal
                        echo "<button class='btn btn-info btn-sm' data-toggle='modal' data-target='#".$modalId."'>View</button> ";
                        echo "<form action='".$web_constants->get_link('approve_property')."?id=".$accommodation['property_id']."' method='POST'>";
                        echo "<input class='btn btn-success btn-sm' type='submit' name='status' value='Approve' /> ";
                        echo "<input   class='btn btn-danger btn-sm' type='submit' name='status' value='Reject' />";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";

                        // Modal code for the 'View' button
                        ?>
                        <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $modalId; ?>Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="<?php echo $modalId; ?>Label"><?php echo htmlspecialchars($accommodation['title']); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Display your advertisement content here -->
                                        <img src="<?php echo htmlspecialchars($accommodation['image_path']); ?>" class="img-fluid" alt="Property Image">
                                        <p>Location: <?php echo htmlspecialchars($accommodation['location']); ?></p>
                                        <p>Price: <?php echo htmlspecialchars($accommodation['price']); ?></p>
                                        <p>Description: <?php echo htmlspecialchars($accommodation['description']); ?></p>
                                        <!-- Include more details as needed -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>No pending properties to display.</td></tr>";
                }
            ?>
            
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
