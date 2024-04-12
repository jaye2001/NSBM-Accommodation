<?php
include_once 'php/utils/constants.php';
include_once 'php/utils/db.php';

session_start(); // Start the session.

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'landlord'){
    header('Location: ' . $web_constants->get_link('login'));
    exit;
}

$landlord_id = $_SESSION ['user_id'];
$web_constants = new Constants();
$properties = []; // Initialize an empty array to hold property data

try{
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    // Create a connection to the database
    try {
        
        $stmt = $pdo->prepare("SELECT * FROM properties WHERE landlord_id=:landlord_id");
        $stmt->bindParam(':landlord_id', $landlord_id, PDO::PARAM_INT);
        $stmt->execute();
        // Fetch all rows as an associative array
        $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        die("Could not connect to the database $dbname :" . $e->getMessage());
    }
} else if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['_action']) && $_POST['_action'] == 'DELETE') {
        if (!isset($_GET['id'])) {
            echo "<script>alert('Property ID not provided.');</script>";
            exit;
        }
        
        try {
            $property_id = $_GET['id'];
            $stmt = $pdo->prepare("DELETE FROM properties WHERE property_id = :property_id");
            $stmt->bindParam(':property_id', $property_id);
            $stmt->execute();
            header('Location: '.$_SERVER['PHP_SELF']);
        } catch (PDOException $e) {
            die("Could not connect to the database $dbname :" . $e->getMessage());
        }
    } else if(isset($_POST['_action']) && $_POST['_action'] == 'EDIT') {
        if (!isset($_GET['id'])) {
            echo "<script>alert('Property ID not provided.');</script>";
            exit;
        }
        
        try {
            $property_id = $_GET['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $userType = $_POST['userType'];
    
            $stmt = $pdo->prepare("UPDATE properties SET name=:name, email=:email, phone=:phone, user_type=:userType  WHERE user_id = :user_id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':userType', $userType);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            header('Location: '.$_SERVER['PHP_SELF']);
        } catch (PDOException $e) {
            die("Could not connect to the database $dbname :" . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin</title>
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

    <br>

    <div class="container">
    <!-- User List -->
    <div class="user-list-section">
        <h4>Your Properties List</h4>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <!-- <th scope="col">Landlord Name</th> -->
                        <th scope="col">Property Title</th>
                        <th scope="col">Uploaded Date</th>
                        <th scope="col">Active Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (count($properties) > 0) {
                    foreach($properties as $accommodation) {
                        $modalId = "viewModal" . $accommodation['property_id'];
                ?>
                    <tr>
                        <th scope="row"><?php echo htmlspecialchars($accommodation['property_id']); ?></th>
                        <!-- <td><?php echo htmlspecialchars($accommodation['landlord_name']); ?></td> -->
                        <td><?php echo htmlspecialchars($accommodation['title']); ?></td>
                        <td><?php echo htmlspecialchars($accommodation['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($accommodation['status']); ?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo $modalId; ?>">Edit</button>
                            <form style="display: inline;" method="POST" action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $accommodation['property_id'] ?>">
                                <input type="hidden" name="_action" value="DELETE">
                                <input class="btn btn-danger btn-sm" type="submit" value="Delete"/>
                            </form>
                        </td>
                    </tr>
                    <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $modalId; ?>Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="<?php echo $modalId; ?>Label">Edit details for: <?php echo htmlspecialchars($accommodation['title']); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $accommodation['property_id']; ?>">
                                        <div class="form-group">
                                            <p>Property ID: <?php echo htmlspecialchars($accommodation['property_id']); ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($accommodation['title']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description">
                                                <?php echo htmlspecialchars($accommodation['description']); ?>
                                            </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="price" class="form-control" id="price" name="price" type="number" value="<?php echo htmlspecialchars($accommodation['price']); ?>">
                                        </div>
                                        <input type="hidden" name="_action" value="EDIT">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>