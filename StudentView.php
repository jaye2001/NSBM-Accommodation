<!DOCTYPE html>
<html lang="en" style="height: 100%">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Find Accommodation - NSBM Accommodation Finder</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css"
    />

    <link href="css/main.css" rel="stylesheet" />

    <style>
      #map {
        height: 400px; /* Fixed pixel value */
        /* OR */
        height: 55vh; /* 50% of the viewport height */
      }
    </style>
  </head>
  <body>
  <?php
include_once 'php/utils/db.php';
include_once 'php/utils/constants.php';

// session_start(); 
// $type = $_SESSION['user_type'];

session_start();

$web_constants = new Constants();

try {
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
    
    $stmt = $pdo->prepare("SELECT * FROM properties");
    $stmt->execute();
    // Fetch all rows as an associative array
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
   // $result = $stmt->get_result();
    $markers = array();
    foreach ($properties as $row) {
        $markers[] = array(
            'id' => $row['property_id'],
            'location' => array($row['latitude'], $row['longitude'])
        );
    }

    if (isset($_GET['id'])){
        $prid = $_GET['id'];

        $stmt = $pdo->prepare("SELECT * FROM properties where property_id = :property");
        $stmt->bindParam(':property', $prid);
    $stmt->execute();
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
        if (count($properties) > 0) {
          foreach($properties as $accommodation) {
            //$modalId = "viewModal" . $accommodation['article_id'];
            $imageData = $accommodation['image'];
            $imageDataEncoded = base64_encode($imageData);
            $imageSrc = 'data:image/jpeg;base64,' . $imageDataEncoded;
            //$words = explode(' ', $accommodation['content']);
          //$excerpt = implode(' ', array_slice($words, 0, 30));
          //$excerpt .= (count($words) > 30) ? '...' : '';
          }
    } }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      if(isset($_SESSION['user_id'])){

      // Reserve the property
      $stmt = $pdo->prepare("INSERT INTO reservations (student_id, property_id) VALUES (:student_id, :property_id)");
      $stmt->bindParam(':student_id', $_SESSION['user_id']);
      $stmt->bindParam(':property_id', $_POST['property_id']);
      $stmt->execute();
      echo "<script>alert('Property reserved successfully.');</script>";
      }
      else{
        header('Location: ' . $web_constants->get_link('login'));
         exit;
      }
  }

} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>

    <div class="flex-wrapper">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
          <a class="navbar-brand" href="#">NSBM Accommodations Finder</a>
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">

            <li class="nav-item">
                    <a class="nav-link " href="<?php echo $web_constants->get_link('home'); ?>">Home</a>
                </li>
              <li class="nav-item ">
                <a class="nav-link" href="StudentDashboard.php"
                  >Student Dashboard <span class="sr-only">(current)</span></a
                >
              </li>
              <li class="nav-item">
                <a class="nav-link" href="StudentView.php"
                  >Find Accommodation</a
                >
              </li>
              <li class="nav-item">
                <a class="nav-link" href="StudentReservationView.php"
                  >My Reservations</a
                >
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

      <br>

      <div class="results-section">
        <div class="container">
          <h3>Search Results</h3>
          <div id="map"></div>
        </div>
      </div>

      <script>
        function initMap() {
            var mapProp = {
                center: { lat: 6.825079, lng: 80.027289 },
                zoom: 14
            };
            var map = new google.maps.Map(document.getElementById("map"), mapProp);

            <?php
                foreach ($markers as $marker) {
                    $latitude = $marker['location'][0];
                    $longitude = $marker['location'][1];
                ?>
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
                    map: map, // <-- Remove the colon here
                    title: '<?php echo $marker['id']; ?>' // Set the title to the id value
                });

                marker.addListener('click', function () {
                    window.location.href = "StudentView.php?id=" + this.getTitle(); // Use this.getTitle() instead of marker.getTitle()
                });
            <?php } ?>
        }
      </script>

<?php if (isset($_GET['id'])){ ?>
  <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card custom-card">
                <div class="card-header">
                    <h3 class="text-center">Property Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="<?php echo $imageSrc; ?>" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                            <h5><?php echo htmlspecialchars($accommodation['title']); ?></h5>
                            <hr>
                            <p><?php echo htmlspecialchars($accommodation['description']); ?></p>
                            
                            <div class="text-left">
                                <h5>Price: <?php echo htmlspecialchars($accommodation['price']); ?></h5>
                            </div>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                    <input type="hidden" name="property_id" value="<?php echo $accommodation['property_id']; ?>">
                                    <button type="submit" class="btn btn-primary">Reserve</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
      <footer class="footer bg-dark text-white pt-4 pb-4">
        <div class="container text-center">
          <p>
            © 2024 NSBM Green University Accommodation Finder. All rights
            reserved.
          </p>
        </div>
      </footer>
    </div>

    <script
      async
      defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7ngQlbbaL_qjsvJQp02PFTXc_gO916s8&callback=initMap&libraries=&v=weekly"
      async
      defer
    ></script>

    <!-- <script src="js/studviewmap.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Include mapping library, e.g., Google Maps API script here -->
  </body>
</html>