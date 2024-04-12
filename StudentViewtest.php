<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Find Accommodation - NSBM Accommodation Finder</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" />
  <style>
    #map {
      height: 400px;
      width: 100%;
    }
  </style>
</head>
<body>
  <!-- Navigation bar and other content -->

  <div id="map"></div>

  <script>
    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: { lat: -34.397, lng: 150.644 } // Update this to the center of your locations
      });

      <?php foreach ($properties as $property): ?>
        var contentString = '<div class="card" style="width: 18rem;">' +
          '<img src="data:image/jpeg;base64,' + '<?php echo base64_encode($property['image']); ?>' + '" class="card-img-top" alt="...">' +
          '<div class="card-body">' +
          '<h5 class="card-title"><?php echo $property['title']; ?></h5>' +
          '<p class="card-text"><?php echo $property['description']; ?></p>' +
          '<p class="card-text">Price: <?php echo $property['price']; ?></p>' +
          '</div>' +
          '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });

        var marker = new google.maps.Marker({
          position: { lat: <?php echo $property['latitude']; ?>, lng: <?php echo $property['longitude']; ?> },
          map: map,
          title: '<?php echo $property['title']; ?>'
        });

        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
      <?php endforeach; ?>
    }
  </script>

  <!-- Replace the value of the key parameter with your own API key. -->
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7ngQlbbaL_qjsvJQp02PFTXc_gO916s8&callback=initMap&libraries=&v=weekly">
  </script>

  <!-- Include jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
