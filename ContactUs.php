<?php
include_once 'php/utils/constants.php';

$web_constants = new Constants();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - NSBM Accommodations Finder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <style>
        .contact-section {
            padding: 50px 0;
        }
        .contact-details,
        .contact-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        .contact-details {
            margin-bottom: 30px;
        }
        .map-container {
            height: 400px;
            margin-bottom: 30px;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
        }
        /* Additional styling for icons and spacing */
        .icon-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .icon-container i {
            font-size: 1.5rem;
            color: #007bff;
            margin-right: 10px;
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
                    <a class="nav-item nav-link active" href="<?php echo $web_constants->get_link('home'); ?>">Home</a>
                    <a class="nav-item nav-link" href="search.php">Find Accommodation</a>
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

<div class="container contact-section">
    <h1 class="text-center mb-5">Contact Us</h1>
    <div class="row justify-content-center">
        <!-- Contact details column -->
        <div class="col-md-5 contact-details">
            <div class="icon-container">
                <i class="fas fa-map-marker-alt"></i>
                <p>
                    NSBM Green University,<br>
                    Mahenwatte, Pitipana,<br>
                    Homagama, Sri Lanka.
                </p>
            </div>
            <div class="icon-container">
                <i class="fas fa-phone"></i>
                <p>+94 11 0000000</p>
            </div>
            <div class="icon-container">
                <i class="fas fa-envelope"></i>
                <p>infonsbmAcc@nsbm.ac.lk</p>
            </div>
        </div>

        <!-- Contact form column -->
        <div class="col-md-5 contact-form">
            <form>
                <div class="form-group">
                    <input type="text" class="form-control" id="inputName" placeholder="Your Name">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="inputEmail" placeholder="Your Email">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="inputSubject" placeholder="Subject">
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="inputMessage" rows="5" placeholder="Your Message Here"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Send Message</button>
            </form>
        </div>
    </div>

    <!-- Map container -->
    <div class="map-container">
        <iframe
            src="https://www.google.com/maps?q=NSBM+Green+University&output=embed"
            frameborder="0"
            style="border:0; width: 100%; height: 100%;"
            allowfullscreen=""
            aria-hidden="false"
            tabindex="0">
        </iframe>
    </div>
</div>

<footer class="footer bg-dark text-white pt-4 pb-4">
        <div class="container text-center">
            <p>© 2024 NSBM Green University Accommodation Finder. All rights reserved.</p>
        </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://kit.fontawesome.com/yourkit.js"></script>
</body>
</html>
