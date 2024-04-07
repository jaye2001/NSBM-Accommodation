<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Accommodation - NSBM Accommodation Finder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">

    <link href="css/main.css" rel="stylesheet">

    <style>
        #map {
                height: 00px; /* Fixed pixel value */
                /* OR */
                height: 55vh; /* 50% of the viewport height */
            }

    </style>
</head>
<body>

<div class="flex-wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">NSBM Accommodations</a>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    <a class="nav-item nav-link" href="student_dashboard.php">Home</a>
                    <a class="nav-item nav-link active" href="find_accommodation.php">Find Accommodation <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="<?php echo $web_constants->get_link('logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="search-section">
        <div class="container">
            <h2>Search for Accommodation</h2>
            <form>
                <div class="form-row align-items-end">
                    <div class="col-md-3 mb-3">
                        <label for="priceRangeFilter">Price Range</label>
                        <select class="form-control" id="priceRangeFilter">
                            <option value="">Select</option>
                            <option value="1">Below 10000 LKR</option>
                            <option value="2">10000 - 15000 LKR</option>
                            <option value="3">Above 15000 LKR</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="results-section">
        <div class="container">
            <h3>Search Results</h3> 
            <div id="map"></div>
        </div>

    </div>


    <footer class="footer bg-dark text-white pt-4 pb-4">
        <div class="container text-center">
            <p>© 2024 NSBM Green University Accommodation Finder. All rights reserved.</p>
        </div>
    </footer>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7ngQlbbaL_qjsvJQp02PFTXc_gO916s8&callback=initMap&libraries=&v=weekly" async defer></script>

<script src="js/studviewmap.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Include mapping library, e.g., Google Maps API script here -->
</body>
</html>
