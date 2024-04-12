<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Management - NSBM Accommodation Finder</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    
    <link href="css/main.css" rel="stylesheet">

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
                    <li class="nav-item">
                        <a class="nav-link" href="landlord_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="manage_properties.php">Manage Properties <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reservation_requests.php">Reservation Requests</a>
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
            <form action="php/landlordAddProperty.php" method="POST">
                <!-- Property Title -->
                <div class="form-group">
                    <label for="propertyTitle">Title</label>
                    <input type="text" class="form-control" id="propertyTitle" placeholder="Enter property title">
                </div>
                <!-- Property Description -->
                <div class="form-group">
                    <label for="propertyDescription">Description</label>
                    <textarea class="form-control" id="propertyDescription" rows="3" placeholder="Enter property description"></textarea>
                </div>
                <!-- Property Price -->
                <div class="form-group">
                    <label for="propertyPrice">Rental Price (per month)</label>
                    <input type="number" class="form-control" id="propertyPrice" placeholder="Enter price">
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
                <label for="propertyLocation">Add Images</label>
                    <input type="file" class="form-control-file" id="propertyImage" name="propertyImage[]" multiple>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Add Property</button>
            </form>
        </div>
    </div>

    <!-- Properties Section -->
    <div class="properties-section">
        <div class="container">
            <h2>Your Properties</h2>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Location</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                   
                    <tr>
                        <th scope="row"></th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="btn btn-info btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                    <!-- Add more properties here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark text-white pt-4 pb-4">
        <div class="container text-center">
            <p>© 2024 NSBM Green University Accommodation Finder. All rights reserved.</p>
        </div>
    </footer>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7ngQlbbaL_qjsvJQp02PFTXc_gO916s8&callback=initMap&libraries=&v=weekly" async defer></script>

<script src="js/landlordMap.js"></script>
<!-- Bootstrap and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
