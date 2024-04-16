<?php
include_once 'php/utils/constants.php';

$web_constants = new Constants();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - NSBM Accommodations Finder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link href="css/main.css" rel="stylesheet">
    <style>
        .about-us-section {
            padding: 50px 0;
        }
        .jumbotron-custom {
            padding: 2rem 1rem;
            background-color: #f8f9fa;
            border-radius: 0.3rem;
        }
        .team-member {
            margin-top: 30px;
        }
        .team-photo {
            max-width: 200px;
            border-radius: 50%;
            margin-bottom: 15px;
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">NSBM Accommodations</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    <<a class="nav-item nav-link active" href="<?php echo $web_constants->get_link('home'); ?>">Home</a>
                    <a class="nav-item nav-link" href="StudentView.php">Find Accommodation</a>
                    <a class="nav-item nav-link" href="Articleviewpage.php">Articles</a>
                    <a class="nav-item nav-link" href="AboutUs.php">About</a>
                    <a class="nav-item nav-link" href="ContactUs.php">Contact</a>
                    <a href="auth/login.php" class="login-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                    </a>
                    <a class="nav-item nav-link" href="auth/login.php">&nbsp &nbsp Sign In</a>

                </div>
            </div>
        </div>
    </nav>
<div class="jumbotron jumbotron-fluid jumbotron-custom">
    <div class="container">
        <h1 class="display-4 text-center">About Us</h1>
        <p class="lead text-center">Learn more about NSBM Accommodations Finder and our team.</p>
    </div>
</div>

<div class="container about-us-section">
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card mission-vision bg-light">
                <div class="card-body">
                    <h2 class="card-title">Our Mission</h2>
                    <p class="card-text">At NSBM Accommodations Finder, we strive to connect students with their perfect home away from home. We believe that the right environment is key to academic success and personal growth.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card mission-vision bg-light">
                <div class="card-body">
                    <h2 class="card-title">Our Vision</h2>
                    <p class="card-text">To be the leading accommodations service for students by providing reliable, secure, and student-friendly housing options near NSBM Green University.</p>
                </div>
            </div>
        </div>
    </div>
    
    <h2 class="text-center mt-4">Meet the Team</h2>
    <div class="row text-center">
        
        <div class="col-md-4 team-member">
            <div class="card">
                <
                <div class="card-body">
                    <h5 class="card-title">Jayasanka Ariyaratne</h5>
                    <p class="card-text">10898415</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 team-member">
            <div class="card">
           
                <div class="card-body">
                    <h5 class="card-title">Nidula Jayasinghe</h5>
                    <p class="card-text">10898495</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 team-member">
            <div class="card">
                <!-- <img src="path-to-team-member-photo.jpg" class="team-photo img-fluid mx-auto d-block" alt="Team Member Name"> -->
                <div class="card-body">
                    <h5 class="card-title">Sithil Pathirana</h5>
                    <p class="card-text">10898584</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row text-center">
        <!-- Team member cards -->
        <div class="col-md-4 team-member">
            <div class="card">
                <!-- <img src="https://icons8.com/icon/23493/person" class="team-photo img-fluid mx-auto d-block" alt="Team Member Name"> -->
                <div class="card-body">
                    <h5 class="card-title">Thathsarani Dhalanjala</h5>
                    <p class="card-text">10898442</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 team-member">
            <div class="card">
                <!-- <img src="path-to-team-member-photo.jpg" class="team-photo img-fluid mx-auto d-block" alt="Team Member Name"> -->
                <div class="card-body">
                    <h5 class="card-title">Chamodi Kaveesha</h5>
                    <p class="card-text">10899722</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 team-member">
            <div class="card">
                <!-- <img src="path-to-team-member-photo.jpg" class="team-photo img-fluid mx-auto d-block" alt="Team Member Name"> -->
                <div class="card-body">
                    <h5 class="card-title">Isindu Rajapaksha</h5>
                    <p class="card-text">10898623</p>
                </div>
            </div>
        </div>
    </div>
</div>



<footer class="footer bg-dark text-white pt-4 pb-4">
        <div class="container text-center">
            <p>© 2024 NSBM Green University Accommodation Finder. All rights reserved.</p>
        </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
