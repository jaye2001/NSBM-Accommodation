<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details - NSBM Accommodation Finder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">

    <link href="css/main.css" rel="stylesheet">
</head>
<body>

<div class="flex-wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">NSBM Accommodations</a>
            <!-- Navigation Items -->
        </div>
    </nav>

    <div class="details-section">
        <div class="container">

        <select class="form-control mb-3" id="propertySelector">
            <option value="">Select a Property</option>
            <!-- Dynamically populate this dropdown with properties -->
        </select>

            <h2 class="mb-4">Property Name</h2>
            <!-- Image Gallery or Carousel -->
            <div class="image-gallery">
                <img src="path/to/property-image.jpg" alt="Property Image" class="img-fluid">
                <!-- Optionally add more images -->
            </div>
            <!-- Property Details -->
            <p><strong>Description:</strong> </p>
            <p><strong>Price:</strong> </p>
            <p><strong>Location:</strong></p>
            
            <!-- Map Placeholder -->
            <div id="map"></div>
            <!-- Reservation Button -->
            <button type="button" class="btn btn-primary mt-3">Reserve Property</button>
        </div>
    </div>

    <footer class="footer bg-dark text-white pt-4 pb-4">
        <div class="container text-center">
            <p>© 2024 NSBM Green University Accommodation Finder. All rights reserved.</p>
        </div>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Google Maps API Integration -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
<script>
function initMap() {
    var propertyLocation = {lat: -34.397, lng: 150.644}; // Placeholder coordinates
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: propertyLocation
    });
    var marker = new google.maps.Marker({
        position: propertyLocation,
        map: map
    });
}
</script>
</body>
</html>
