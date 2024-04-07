<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSBM Green University Accommodation Finder</title>
  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link href="css/main.css" rel="stylesheet">


    <style>
 .login-icon {
    position: absolute;
    top: 16px; /* Adjust the value to place it at the cursor location */
    right: 375px; /* Adjust the value to place it at the cursor location */
    fill: #ffffff; /* Change the color if needed */
    display: inline-block;
    width: 25px; /* New size */
    height: 25px; /* New size */
  }

  .login-icon svg {
    display: block;
    width: 100%;
    height: 100%;
    fill: #ffffff;
  }
  
</style>
<?php
include_once 'php/utils/db.php';
include_once 'php/utils/constants.php';

session_start(); 
$type = $_SESSION['user_type'];



$web_constants = new Constants();

try {
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
    
    $stmt = $pdo->prepare("SELECT * FROM articles ORDER BY created_at DESC LIMIT 3");
    $stmt->execute();
    // Fetch all rows as an associative array
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
    ?>
</head>
<body>

<div class="flex-wrapper">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">NSBM Accommodations</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    <a class="nav-item nav-link active" href="<?php echo $web_constants->get_link('home'); ?>">Home</a>
                    <a class="nav-item nav-link" href="StudentDashboard.php">Student Dashboard</a>
                    <a class="nav-item nav-link" href="StudentView.php">Find Accommodation</a>
                    <a class="nav-item nav-link" href="Articleviewpage.php">Articles</a>
                    <a class="nav-item nav-link" href="AboutUs.php">About</a>
                    <a class="nav-item nav-link" href="ContactUs.php">Contact</a>
                    <a href="auth/login.php" class="login-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                    </a>
                    <?php if (!isset($_SESSION['user_id'])){ ?>
                    <a class="nav-item nav-link" href="auth/login.php">&nbsp &nbsp Sign In</a>
                        <?php } ?>
                    <?php if (isset($_SESSION['user_id'])){ ?>
                    <a class="nav-item nav-link" href="<?php echo $web_constants->get_link('logout'); ?>">&nbsp &nbsp Logout</a>
                        <?php } ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="jumbotron jumbotron-fluid" style="background-image: url('images/Hostel-1.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; color: white; min-height: 900px;">
        <div class="container text-center">
            <br><br><br>
            <h1 class="display-4">Welcome to NSBM Accommodation Finder</h1>
            <h2 class="lead">Helping you find the perfect place to stay near campus.</h3> <br>
            <a href="StudentView.php" class="btn btn-hero">Start Searching</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Why Choose Us?</h5>
                        <p class="card-text">Find accommodations tailored to your needs, close to NSBM Green University, with features and amenities that make student life easier and more enjoyable.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">How It Works</h5>
                        <p class="card-text">Search listings, view detailed information, and reserve your accommodation—all in a few clicks. It's that simple!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Trusted Landlords</h5>
                        <p class="card-text">All listings are verified and approved by the warden, ensuring you find a safe and reliable place to stay.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center" style = "margin-top: 50px;">
        <h1>ARTICLES</h1>
      </div>
    <div style="margin: 100px; margin-top:20px;" id = "allcard" class="d-flex justify-content-center">
    <div class="card-deck container d-flex justify-content-center" >
        <?php 
        if (count($properties) > 0) {
          foreach($properties as $accommodation) {
            $modalId = "viewModal" . $accommodation['article_id'];
            $imageData = $accommodation['image'];
            $imageDataEncoded = base64_encode($imageData);
            $imageSrc = 'data:image/jpeg;base64,' . $imageDataEncoded;
            $words = explode(' ', $accommodation['content']);
          $excerpt = implode(' ', array_slice($words, 0, 30));
          $excerpt .= (count($words) > 30) ? '...' : '';
          
            
            if ($rowCount % 3 === 0) { // Start a new row every three articles
                echo '<div class="row" style="margin-top: 20px;">';
            } ?>
        <!-- <div class="row" style = "margin-top: 20px;"> -->
        <div class="card col-6 col-md-4 col-lg-12 col-xl-12" style="background-color: white; width: 350px;">
            <img
              class="card-img-top"
              src="<?php echo $imageSrc; ?>"
              alt="Card image cap"
              style="width: 300px; height: 180px;"
            />
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($accommodation['title']);   ?></h5>
              <p class="card-text" style = "word-wrap: break-word; ">
              <?php echo htmlspecialchars($excerpt); ?>
              </p>
              <script>myfunction()</script>

            </div>
            <?php
            echo "<button class='btn btn-info btn-sm' style = 'margin-bottom:20px;' data-toggle='modal' data-target='#".$modalId."'>Read More</button> "; ?>
            <div class="card-footer">
              <small class="text-muted">Last updated <?php echo htmlspecialchars($accommodation['updated_at']);   ?></small>
            </div>
          </div>
          <?php 
        $rowCount++; // Increment row count
            if ($rowCount % 3 === 0 || $rowCount === count($properties)) { // Close the row if it contains three articles or it's the last row
                echo '</div>';
            }
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
                        <img src="<?php echo $imageSrc; ?>" class="img-fluid" alt="Property Image">
                        <p style = "margin-top:20px;">Description: <?php echo htmlspecialchars($accommodation['content']); ?></p>
                        <!-- Include more details as needed -->
                    </div>
                    <div class="modal-footer">
                      <?php if ($type == "admin"){ ?>
                        <a href="Articleviewpage.php?param1=delete&param2=<?php echo $accommodation['article_id']; ?>" class="btn btn-secondary active" role="button" aria-pressed="true">DELETE</a>
                        <?php } ?>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
                    }
                } 

           
            ?>
            <div style="display: flex; justify-content: flex-start; margin-top: 20px;">
            <a href="Articleviewpage.php"><button type="button" class="btn btn-primary btn-sm" >View more</button></a>
            
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
