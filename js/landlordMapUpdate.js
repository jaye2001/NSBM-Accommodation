function initMap(modalId) {
  const mapContainer = document.getElementById("map_" + modalId);
  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        // Position from geolocation
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        createMap(pos, modalId);
      },
      function () {
        // Geolocation service failed, use default location (NSBM)
        const nsbm = { lat: 6.8201287, lng: 80.0384185 }; // Use NSBM's lat and lng
        createMap(nsbm, modalId);
        handleLocationError(true, nsbm);
      }
    );
  } else {
    // Browser doesn't support Geolocation, use default location (NSBM)
    const nsbm = { lat: 6.8201287, lng: 80.0384185 }; // Use NSBM's lat and lng
    createMap(nsbm, modalId);
    handleLocationError(false, nsbm);
  }
}

function createMap(position, modalId) {
  // The map, centered at the given position
  const map = new google.maps.Map(document.getElementById("map_" + modalId), {
    zoom: 15,
    center: position,
  });
  // The marker, positioned at the given location
  const marker = new google.maps.Marker({
    position: position,
    map: map,
    draggable: true, // Make the marker draggable
  });

  document.getElementById("lat_" + modalId).value = marker.getPosition().lat();
  document.getElementById("lng_" + modalId).value = marker.getPosition().lng();

  // Add a listener for the drag event on the marker
  google.maps.event.addListener(marker, "dragend", function () {
    const lat = marker.getPosition().lat();
    const lng = marker.getPosition().lng();

    // Update hidden form fields or use coordinates as needed
    document.getElementById("lat_" + modalId).value = lat;
    document.getElementById("lng_" + modalId).value = lng;
  });
}

function handleLocationError(browserHasGeolocation, pos) {
  alert(
    browserHasGeolocation
      ? "Error: The Geolocation service failed. Using default location."
      : "Error: Your browser doesn't support geolocation. Using default location."
  );
}
