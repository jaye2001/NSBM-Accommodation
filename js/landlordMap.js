function initMap() {
  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        // Position from geolocation
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        createMap(pos);
      },
      function () {
        // Geolocation service failed, use default location (NSBM)
        const nsbm = { lat: 6.8201287, lng: 80.0384185 }; // Use NSBM's lat and lng
        createMap(nsbm);
        handleLocationError(true, nsbm);
      }
    );
  } else {
    // Browser doesn't support Geolocation, use default location (NSBM)
    const nsbm = { lat: 6.8201287, lng: 80.0384185 }; // Use NSBM's lat and lng
    createMap(nsbm);
    handleLocationError(false, nsbm);
  }
}

function createMap(position) {
  // The map, centered at the given position
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 15,
    center: position,
  });
  // The marker, positioned at the given location
  const marker = new google.maps.Marker({
    position: position,
    map: map,
    draggable: true, // Make the marker draggable
  });

  document.getElementById("lat").value = marker.getPosition().lat();
  document.getElementById("lng").value = marker.getPosition().lng();

  // Add a listener for the drag event on the marker
  google.maps.event.addListener(marker, "dragend", function () {
    const lat = marker.getPosition().lat();
    const lng = marker.getPosition().lng();

    // Update hidden form fields or use coordinates as needed
    document.getElementById("lat").value = lat;
    document.getElementById("lng").value = lng;
  });
}

function handleLocationError(browserHasGeolocation, pos) {
  alert(
    browserHasGeolocation
      ? "Error: The Geolocation service failed. Using default location."
      : "Error: Your browser doesn't support geolocation. Using default location."
  );
}

function errorCallback(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      alert("User denied the request for Geolocation.");
      break;
    case error.POSITION_UNAVAILABLE:
      alert("Location information is unavailable.");
      break;
    case error.TIMEOUT:
      alert("The request to get user location timed out.");
      break;
    case error.UNKNOWN_ERROR:
      alert("An unknown error occurred.");
      break;
  }
}
