<?php
include_once 'php/utils/db.php';
include_once 'php/utils/constants.php';

session_start();
$web_constants = new Constants();
?>

<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landlord Dashboard - NSBM Accommodation Finder</title>
  
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="css/adminDash.css" rel="stylesheet">

   

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

    <!-- Dashboard Content -->
    <div class="container content">
        <h2 class="my-4">Landlord Dashboard</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <i class="fas fa-building icon"></i>
                        <span class="card-title">Listed Properties</span>
                        <p class="card-text">5</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <i class="fas fa-calendar-alt icon"></i>
                        <span class="card-title">Reservations</span>
                        <p class="card-text">2</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
    <div class="row">
        <!-- Main content -->
        <div class="container">
  <div class="row">
    <div class="col-md-12">
    </div>
  </div>
  <div class="row">
        <div class="col-md-4">
            <a href="landlordsDashboard.php" class="card text-dark bg-light mb-3 text-decoration-none">
                <div class="card-body">
                <h3 class="title">Dashboard</h3>
            <p></p><br><br>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="landlordAddProperty.php" class="card text-dark bg-light mb-3 text-decoration-none">
                <div class="card-body">
                <h3 class="title">Add Properties</h3>
            <p></p><br><br>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="landlordManageProperty.php" class="card text-dark bg-light mb-3 text-decoration-none">
                <div class="card-body">
                <h3 class="title">Manage Properties</h3>
            <p></p><br><br>
                </div>
            </a>
        </div>
 </div>   
    <div class="row">
    <div class="col-md-4">
            <a href="landrodsResReq.php" class="card text-dark bg-light mb-3 text-decoration-none">
                <div class="card-body">
                <h3 class="title">Reservation Requests</h3>
            <p></p><br><br>
                </div>
            </a>
        </div>


    </div>   

  
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
