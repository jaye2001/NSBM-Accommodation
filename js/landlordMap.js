function initMap() {
    // The location of an initial position
    const nsbm = { lat: -34.397, lng: 150.644 }; // Use NSBM's lat and lng
    // The map, centered at the initial position
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: nsbm,
    });
    // The marker, positioned at the initial position
    const marker = new google.maps.Marker({
        position: nsbm,
        map: map,
        draggable: true // Make the marker draggable
    });

    // Add a listener for the drag event on the marker
    google.maps.event.addListener(marker, 'dragend', function() {
        const lat = marker.getPosition().lat();
        const lng = marker.getPosition().lng();

        // Now you can use these coordinates to save in your database
        // Example: Fill hidden form fields with these values
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
    });
}