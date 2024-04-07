<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection 
    include_once 'utils/db.php';

    // Create a new PDO instance
    try {
            $db_obj = new DBConnection();
            $db_obj->connect();
            $pdo = $db_obj->get_conn();
            
        // Sanitize and validate input
        $propertyTitle = filter_input(INPUT_POST, 'propertyTitle', FILTER_SANITIZE_STRING);
        $propertyDescription = filter_input(INPUT_POST, 'propertyDescription', FILTER_SANITIZE_STRING);
        $propertyPrice = filter_input(INPUT_POST, 'propertyPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $latitude = filter_input(INPUT_POST, 'lat', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $longitude = filter_input(INPUT_POST, 'lng', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Assuming you're using a session to store the landlord's user ID
        session_start();
        $landlordId = $_SESSION['user_id']; // The logged-in landlord's ID

        // Image handling and upload logic should go here...
        // For now, we'll just use a placeholder
        $imagePath = 'path/to/uploaded/image.jpg';

        // SQL query to insert property data into the database
        $sql = "INSERT INTO properties (landlord_id, title, description, price, latitude, longitude, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$landlordId, $propertyTitle, $propertyDescription, $propertyPrice, $latitude, $longitude, $imagePath]);

        echo 'Property added successfully.';
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
