<?php
include_once 'php/utils/db.php';
include_once 'php/utils/constants.php';

session_start();
$web_constants = new Constants();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'landlord') {
    header('Location: login.php');
    exit;
}

try {
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] == 'accept') {
            try {
                $stmt = $pdo->prepare("UPDATE reservations SET status = 'accepted' WHERE reservation_id = :reservation_id");
                $stmt->bindParam(':reservation_id', $_POST['reservation_id']);
                $stmt->execute();
                // Redirect to prevent form resubmission
                header("Location: ".$_SERVER['PHP_SELF']);
                exit;
            } catch (PDOException $e) {
                die("Database error: " . $e->getMessage());
            }
        } else if (isset($_POST['action']) && $_POST['action'] == 'declined') {
            try {
                $stmt = $pdo->prepare("UPDATE reservations SET status = 'declined' WHERE reservation_id = :reservation_id");
                $stmt->bindParam(':reservation_id', $_POST['reservation_id']);
                $stmt->execute();
                // Redirect to prevent form resubmission
                header("Location: ".$_SERVER['PHP_SELF']);
                exit;
            } catch (PDOException $e) {
                die("Database error: " . $e->getMessage());
            }
        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        // Fetch properties from the database
        // $stmt = $pdo->prepare("SELECT r.*, u.name AS student_name, u.email AS student_email, u.phone AS student_phone FROM reservations r JOIN users u ON r.student_id = u.user_id WHERE r.status = 'approved' ORDER BY r.created_at DESC");
        $stmt = $pdo->prepare("SELECT r.*, p.title AS property_title, u.name AS student_name, u.email AS student_email, r.created_at AS request_date, u.phone AS student_phone FROM reservations r LEFT JOIN users u ON r.student_id = u.user_id JOIN properties p ON r.property_id = p.property_id WHERE p.landlord_id = :landlord_id ORDER BY r.created_at DESC");
        $stmt->bindParam(':landlord_id', $_SESSION['user_id']);
        $stmt->execute();
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

?>



<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Requests - NSBM Accommodation Finder</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">

    <link href="css/main.css" rel="stylesheet">

</head>
<body>

<div class="flex-wrapper">
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
                        <a class="nav-link" href="landlordsDashboard.php">Dashboard <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="landlordAddProperty.php">Add Properties</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="landlordManageProperty.php">Manage Properties</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="landrodsResReq.php">Reservation Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $web_constants->get_link('logout'); ?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Requests Section -->
    <div class="requests-section">
        <div class="container">
            <h2>Reservation Requests</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Property Title</th>
                            <th scope="col">Request Date</th>
                            <th scope="col">Student Phone</th>
                            <th scope="col">Student Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample Request Row -->
                        <?php
                        if (!empty($reservations)) {
                            foreach ($reservations as $reservation)
                        ?>
                        <tr>
                            <th scope="row"><?php echo $reservation['reservation_id']; ?></th>
                            <td><?php echo $reservation['student_name']; ?></td>
                            <td><?php echo $reservation['property_title']; ?></td>
                            <td><?php echo $reservation['request_date']; ?></td>
                            <td><?php echo $reservation['student_phone']; ?></td>
                            <td><?php echo $reservation['student_email']; ?></td>
                            <td><?php echo $reservation['status']; ?></td>
                            <td>
                            <?php
                            if ($reservation['status'] != 'accepted'){ 
                            ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="reservation_id" value="<?php echo $reservation['reservation_id']; ?>">
                                <input type="hidden" name="action" value="accept">
                                <button type="submit" class="btn btn-success btn-sm">Accept</button>
                            </form>
                            <?php
                            }
                            if ($reservation['status'] != 'declined'){
                            ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="reservation_id" value="<?php echo $reservation['reservation_id']; ?>">
                                <input type="hidden" name="action" value="declined">
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                            <?php
                            }
                            ?>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <!-- Add more rows here based on actual data -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark text-white pt-4 pb-4">
        <div class="container text-center">
            <p>© 2024 NSBM Green University Accommodation Finder. All rights reserved.</p>
        </div>
    </footer>
</div>

<!-- Bootstrap and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
