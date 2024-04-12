<?php
include_once 'php/utils/constants.php';
include_once 'php/utils/db.php';

session_start(); // Start the session.

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin'){
    header('Location: ' . $web_constants->get_link('login'));
    exit;
}

$web_constants = new Constants();
$users = []; 

try {
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    try {
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        // Fetch all rows as an associative array
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        die("Could not connect to the database $dbname :" . $e->getMessage());
    }
} else if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['_action']) && $_POST['_action'] == 'DELETE') {
        if (!isset($_GET['id'])) {
            echo "<script>alert('User ID not provided.');</script>";
            exit;
        }
        
        try {
            $user_id = $_GET['id'];
            $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            header('Location: '.$_SERVER['PHP_SELF']);
        } catch (PDOException $e) {
            die("Could not connect to the database $dbname :" . $e->getMessage());
        }
    } else if (isset($_POST['_action']) && $_POST['_action'] == 'SUSPEND'){
        if (!isset($_GET['id'])) {
            echo "<script>alert('User ID not provided.');</script>";
            exit;
        }
        
        try {
            $user_id = $_GET['id'];
            $status = 'suspended';
            $stmt = $pdo->prepare("UPDATE users SET status=:status WHERE user_id = :user_id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            header('Location: '.$_SERVER['PHP_SELF']);
        } catch (PDOException $e) {
            die("Could not connect to the database $dbname :" . $e->getMessage());
        }
    }  else if(isset($_POST['_action']) && $_POST['_action'] == 'EDIT') {
        if (!isset($_GET['id'])) {
            echo "<script>alert('User ID not provided.');</script>";
            exit;
        }
        
        try {
            $user_id = $_GET['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $status = $_POST['status'];
            $userType = $_POST['userType'];
    
            $stmt = $pdo->prepare("UPDATE users SET name=:name, email=:email, phone=:phone, status=:status, user_type=:userType  WHERE user_id = :user_id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':status', $status);
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
 <!-- Nav Bar -->
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
    <br>
    <div class="container">
    <h2>User Management</h2>

    <!-- Sorting and Searching Form -->
    <div class="row mb-4">
        <div class="col">
            <select class="form-control" id="userTypeFilter">
                <option value="">Select User Type</option>
                <option value="landlord">Landlord</option>
                <option value="warden">Warden</option>
                <option value="student">Student</option>
            </select>
        </div>
        <div class="col">
            <input type="text" class="form-control" id="userNameSearch" placeholder="Search by name">
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-primary">Search</button>
        </div>
    </div>

    <!-- User List -->
    <!-- ...existing user list table code... -->
</div>

<br>
<div class="container">
    <!-- User List -->
    <div class="user-list-section">
        <h4>User List</h4>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Type</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Row -->
                    <?php

                    if (count($users) > 0) {
                        foreach($users as $user) {
                            $modalId = "viewModal" . $user['user_id'];
                            echo '<tr>';
                            echo '<th scope="row">'.$user['user_id'].'</th>';
                            echo '<td>'.$user['user_type'].'</td>';
                            echo '<td>'.$user['name'].'</td>';
                            echo '<td>'.$user['email'].'</td>';
                            echo '<td>';
                            echo '<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#'.$modalId.'">Edit</button>';
                            echo '<form style="display: inline;" method="POST" action="'.$_SERVER['PHP_SELF'].'?id='.$user['user_id'].'">';
                            echo '<input type="hidden" name="_action" value="SUSPEND">';
                            echo '<input class="btn btn-warning btn-sm" type="submit" value="Suspend"/>';
                            echo '</form>';
                            echo '<form style="display: inline;" method="POST" action="'.$_SERVER['PHP_SELF'].'?id='.$user['user_id'].'">';
                            echo '<input type="hidden" name="_action" value="DELETE">';
                            echo '<input class="btn btn-danger btn-sm" type="submit" value="Delete"/>';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                            ?>
                            <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $modalId; ?>Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="<?php echo $modalId; ?>Label">Edit details for: <?php echo htmlspecialchars($user['name']); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $user['user_id']; ?>">
                                        <div class="form-group">
                                            <p>User ID: <?php echo htmlspecialchars($user['user_id']); ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" type="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone number</label>
                                            <input type="phone" class="form-control" id="phone" name="phone" type="tel" value="<?php echo htmlspecialchars($user['phone']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="userType">User Type</label>
                                            <select class="form-control" id="userType" name="userType">
                                                <option value="landlord" <?php if($user['user_type'] == 'landlord') echo 'selected'; ?>>Landlord</option>
                                                <option value="warden" <?php if($user['user_type'] == 'warden') echo 'selected'; ?>>Warden</option>
                                                <option value="student" <?php if($user['user_type'] == 'student') echo 'selected'; ?>>Student</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="active" <?php if($user['status'] == 'active') echo 'selected'; ?>>Active</option>
                                                <option value="suspended" <?php if($user['status'] == 'suspended') echo 'selected'; ?>>Suspended</option>
                                            </select>
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
                    <!-- Dynamically generate user rows here -->
                </tbody>
            </table>
        </div>
    </div>

</div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
