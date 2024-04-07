<?php
include_once 'php/utils/constants.php';

session_start();

$web_constants = new Constants();

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'landlord'){
        header('Location: '.$web_constants->get_link('login'));
        exit(401);
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    include_once 'php/utils/db.php';

    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'landlord'){
        header('Location: '.$web_constants->get_link('login'));
        exit(401);
    }

    // Create a new PDO instance
    try {
        $db_obj = new DBConnection();
        $db_obj->connect();
        $pdo = $db_obj->get_conn();
            
        // Sanitize and validate input
        // $test = $_POST['propertyTitle'];
        // if(!$test){
        //     echo "<script>showalert('Fields cannot be empty') </script>";
        //     exit();
        // }
        $propertyTitle = filter_input(INPUT_POST, 'propertyTitle', FILTER_SANITIZE_STRING);
        $propertyDescription = filter_input(INPUT_POST, 'propertyDescription', FILTER_SANITIZE_STRING);
        $propertyPrice = filter_input(INPUT_POST, 'propertyPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $latitude = filter_input(INPUT_POST, 'lat', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $longitude = filter_input(INPUT_POST, 'lng', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $location_link = 'https://www.google.com/maps/@'.$latitude.','.$longitude.',13z?entry=ttu';
        if (isset($_FILES["propertyImage"]) && $_FILES["propertyImage"]["error"] == UPLOAD_ERR_OK) { 
            $file_name = $_FILES["propertyImage"]["name"]; 
            $file_tmp_name = $_FILES["propertyImage"]["tmp_name"]; 
            $file_content = file_get_contents($file_tmp_name); 
        } else { 
            echo "
            <script>
            showErrors('*Error uploading image.');
            </script>
            "; 
        }


        if(!$propertyTitle || !$propertyDescription || !$propertyPrice || !$latitude || !$longitude){
            echo "<script> showalert('Fields cannot be empty'); </script>";
            exit();
        }


        // Assuming you're using a session to store the landlord's user ID
        $landlordId = $_SESSION['user_id']; // The logged-in landlord's ID
        // Image handling and upload logic should go here...
        // For now, we'll just use a placeholder
        $imagePath = 'path/to/uploaded/image.jpg';

        // SQL query to insert property data into the database
        $sql = "INSERT INTO properties (landlord_id, title, description, price, location, latitude, longitude, image) VALUES (:landlord_id, :title, :description, :price, :location, :latitude, :longitude, :image)";
        $stmt = $pdo->prepare($sql);
        // $stmt->execute([$landlordId, $propertyTitle, $propertyDescription, $propertyPrice, $latitude, $longitude, $imagePath]);
        $stmt->bindParam(':landlord_id', $landlordId);
        $stmt->bindParam(':title', $propertyTitle);
        $stmt->bindParam(':description', $propertyDescription);
        $stmt->bindParam(':price', $propertyPrice);
        $stmt->bindParam(':location', $location_link);
        $stmt->bindParam(':latitude', $latitude);
        $stmt->bindParam(':longitude', $longitude);
        $stmt->bindParam(':image',$file_content, PDO::PARAM_LOB);
        // $stmt->bindParam(':image', $imagePath);
        $stmt->execute();

        echo "<script>showalert('Property added successfully')</script>";
    } catch(PDOException $e) {
        echo "<script>showalert('Connection failed: ".htmlspecialchars($e->getMessage())."')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Management - NSBM Accommodation Finder</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    
    <link href="css/main.css" rel="stylesheet">
    <script>
        function showalert(message){
            alert(message);
        }
        </script>


</head>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7ngQlbbaL_qjsvJQp02PFTXc_gO916s8&callback=initMap&libraries=&v=weekly" async defer></script>
<body onload='initMap()'>

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

    <!-- Form Section -->
    <div class="form-section">
        <div class="container">
            <h2>Add New Property</h2>
            <!-- <form action="php/landlordAddProperty.php" method="POST"> -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                <!-- Property Title -->
                <div class="form-group">
                    <label for="propertyTitle">Title</label>
                    <input type="text" class="form-control" name="propertyTitle" placeholder="Enter property title">
                </div>
                <!-- Property Description -->
                <div class="form-group">
                    <label for="propertyDescription">Description</label>
                    <textarea class="form-control" name="propertyDescription" rows="3" placeholder="Enter property description"></textarea>
                </div>
                <!-- Property Price -->
                <div class="form-group">
                    <label for="propertyPrice">Rental Price (per month)</label>
                    <input type="number" class="form-control" name="propertyPrice" placeholder="Enter price">
                </div>
                <!-- Property Location -->
                <div class="form-group">
                    <label for="propertyLocation">Location</label>
                    <input type="hidden" id="lat" name="lat">
                    <input type="hidden" id="lng" name="lng">

                    <!-- Map Container -->
                    <div id="map"></div>

                </div>
                <!-- Property Images -->
                <div class="form-group">
                <label for="propertyImage">Add Images</label>
                    <input type="file" class="form-control-file" id="propertyImage" name="propertyImage" multiple>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary" >Add Property</button>
            </form>
        </div>
    </div>

   

    <!-- Footer -->
    <footer class="footer bg-dark text-white pt-4 pb-4">
        <div class="container text-center">
            <p>© 2024 NSBM Green University Accommodation Finder. All rights reserved.</p>
            </div>
    </footer>
</div>

<script src="js/landlordMap.js"></script>
<!-- Bootstrap and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<?php

?>
</body>
</html>
