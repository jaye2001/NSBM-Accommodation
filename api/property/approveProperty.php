<?php
include_once '../../php/utils/db.php';
include_once '../../php/utils/constants.php';

session_start();

$web_constants = new Constants();
if (empty($_SESSION['user_type']) && $_SESSION['user_type'] != 'warden'){
  exit(401);
}

try{
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_GET['id']) && !empty($_POST['status'])) {
    $property_id = $_GET['id'];
    if ($_POST['status'] == 'Approve') $property_status = 'approved';
    else $property_status = 'rejected'; 

    $stmt = $pdo->prepare("UPDATE properties SET status = :property_status WHERE property_id = :property_id");
    $stmt->bindParam(':property_status', $property_status);
    $stmt->bindParam(':property_id', $property_id);
    $stmt->execute();

    header('Location: '.$web_constants->get_link('warden_approve'));
} else {
    // Invalid request.
    // header('Location: '.$web_constants->get_link('login'));
    exit(401);
}


?>